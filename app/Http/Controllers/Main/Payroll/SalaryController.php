<?php

namespace App\Http\Controllers\Main\Payroll;

use App\Http\Controllers\Controller;
use App\Models\Advance;
use App\Models\AdvancePaids;
use App\Models\Cash;
use App\Models\Employee;
use App\Models\Salary;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SalaryController extends Controller
{
    private $salary;
    private $errors = false;
    private $messages;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // return request()->all();
        $previous_month = Carbon::now()->subMonth()->format('Y-m') . '-01';
        $request_month = Carbon::parse(\request()->salary_month)->format('Y-m-d');
        $salary_month = \request()->search ? $request_month : $previous_month;
        $month = \request()->search ? Carbon::parse(\request()->salary_month)->format('F Y') : Carbon::today()->subMonth()->format('F Y');
        $employees = Employee::with(['salaries' => function ($query) use ($salary_month) {
            $query->where('salary_month', $salary_month);
        }])->get();

        // foreach ($employees as $employee) {
        //    if ($employee->salaries->count() > 0) {
        //         return $hello = $employee->salaries->last()['id'];
        //    }
        // }
        $route_name = 'payroll-salary.index'; // for dynamic search

        return view('admin.payroll.salary.index', compact('employees', 'month', 'route_name'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $employees = Employee::all();
        $cashes = Cash::all();
        return view('admin.payroll.salary.create',compact('employees', 'cashes'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function salaryPay($id, Request $request)
    {
        $employees = Employee::all();
        $cashes = Cash::all();
        $month = $request->input('month');
        return view('admin.payroll.salary.create', compact('employees', 'cashes', 'month'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // return $request->all();
        $salaryMonth = Carbon::createFromFormat('Y-m', $request->salary_month)->startOfMonth()->toDateString();
        $exits = Salary::where('employee_id', $request->employee_id)->where('salary_month', $salaryMonth)->first();
        if ($exits) {
            $this->errors = true;
            $this->messages = 'Salary already given.';
        }
        DB::transaction(function () use ($request) {
            //Validation
            $data = $request->validate([
                'employee_id'               => 'required|integer',
                'salary_month'              => 'required|date',
                'given_date'                => 'required|date',
                'cash_id'                   => 'required',
                'payment_type'              => 'required|string',
                'note'                      => 'nullable'
            ]);

            $data['salary_no'] = str_pad(Salary::max('id') + 1, 8, 0, STR_PAD_LEFT);
            $data['salary_month']= date('Y-m-d H:i:s', strtotime($request->salary_month));
            $salary = Salary::create($data);

            $this->salary  = $salary;

            // validation salary details
             $request->validate([

                'basic_salary' => 'required|numeric',
                'bonus' => 'nullable|numeric|min:1',
                'advance_paid_amount' => 'required|numeric',
                'deduction' => 'nullable',
            ]);
            // find requested user
            $employee = Employee::find($request->employee_id);

            $advance_paid_amount = $request->advance_paid_amount;

            $this->saveSalaryDetails($request, $salary);

            $this->cashUpdate($request);

            // if has advanced salaries
            if ($advance_paid_amount > 0) {
                // get advanced salaries where is paid is 0 or false
                $advancedSalaries = $employee->advances->filter(function ($item) {
                        return !$item->is_paid;
                    });

                foreach ($advancedSalaries as  $details) {
                    // if installment amount is smaller than first advances salaries due
                    if ($advance_paid_amount < $details->total_due) {
                        $details->advancePaids()->create([
                            'salary_id'                 => $salary->id,
                            'advance_paid_amount' => $advance_paid_amount,
                        ]);
                        break;
                    } else {
                        // if installment amount is bigger than first advances salaries due
                        $details->advancePaids()->create([
                            'salary_id'                 => $salary->id,
                            'advance_paid_amount' => $details->total_due,
                        ]);
                        // if installment amount & advanced due amount is equal then is_paid is 1 or true
                        $details->is_paid = true;
                        $details->save(); // save installment paid details
                        // then intallment amount is subtract paid amount
                        $advance_paid_amount = $advance_paid_amount - $details->total_due;
                    }
                }
            }

        });

        if ($this->errors) {
            return redirect()->back()->withErrors($this->messages);
        } else {
            return redirect()->route('payroll-salary.show', $this->salary->id)->withSuccess('Salary given successfully.');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $salary = Salary::with('details','advancePaid')->find($id);

        $salary["basic_salary"] = $salary->details->where('purpose', 'basic_salary')->first();
        $salary["bonus"] = $salary->details->where('purpose', 'bonus')->first();
        $salary["deduction"] = $salary->details->where('purpose', 'deduction')->first();

        $basic = $salary["basic_salary"] ? $salary['basic_salary']->amount :0;
        $bonus = $salary["bonus"] ? $salary['bonus']->amount :0;
        $deduction = $salary["deduction"] ? $salary['deduction']->amount :0;

        // $total_salary = ($basic+$bonus) - ($deduction + $salary->advance_paid_amount);
        $total_salary = ($basic+$bonus) - $deduction;

        return view('admin.payroll.salary.show',compact('salary','total_salary'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $oldSalary = Salary::with('details','employee')->findOrFail($id);
        // $salaryMonth = date('F Y', strtotime($oldSalary->salary_month));
        $month =  Carbon::parse($oldSalary->salary_month)->format('Y-m');
        $oldSalary["basic_salary"] = $oldSalary->details->where('purpose', 'basic_salary')->first() ?? "";
        $oldSalary["bonus"] = $oldSalary->details->where('purpose', 'bonus')->first() ?? "";
        $oldSalary["deduction"] = $oldSalary->details->where('purpose', 'deduction')->first() ?? "";
        $employees = Employee::all();
        $cashes = Cash::all();
        return view('admin.payroll.salary.edit',compact('oldSalary', 'employees', 'cashes', 'month'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $exits = Salary::where('employee_id', $request->employee_id)->where('salary_month', $request->salary_month)->first();
        if ($exits) {
            $this->errors = true;
            $this->messages = 'Salary already given.';
        }
        DB::transaction(function () use ($request,$id) {
            $oldSalary = Salary::AddTotalSalaryPaidAmount()->findOrFail($id);

            //Validation
            $data = $request->validate([
                'employee_id'               => 'required|integer',
                'salary_month'              => 'required|date',
                'given_date'                => 'required|date',
                'cash_id'                   => 'required',
                'payment_type'              => 'required|string',
                'note'                      => 'nullable'
            ]);

            $data['salary_no'] = str_pad(Salary::max('id') + 1, 8, 0, STR_PAD_LEFT);
            $data['salary_month'] = date('Y-m-d H:i:s', strtotime($request->salary_month));
            $oldSalary->update($data);

            $this->salary  = $oldSalary;

            $this->updatePreviousSalaryDetail($oldSalary);


            // validation salary details
            $request->validate([

                'basic_salary' => 'required|numeric',
                'bonus' => 'nullable|numeric|min:1',
                'advance_paid_amount' => 'required|numeric',
                'deductions' => 'nullable',
            ]);
            // find requested user
            $employee = Employee::find($request->employee_id);

            $advance_paid_amount = $request->advance_paid_amount;

            $this->saveSalaryDetails($request, $oldSalary);

            $this->cashUpdate($request);


            // if has advanced salaries
            if ($advance_paid_amount > 0) {
                // get advanced salaries where is paid is 0 or false
                $advancedSalaries = $employee->advances->filter(function ($item) {
                    return !$item->is_paid;
                });

                foreach ($advancedSalaries as  $details) {
                    // if advance paid amount is smaller than first advances salaries due
                    if ($advance_paid_amount < $details->total_due) {
                        $details->advancePaids()->update([
                            'salary_id'           => $oldSalary->id,
                            'advance_paid_amount' => $advance_paid_amount,
                        ]);
                        break;
                    } else {
                        // if advance paid amount is bigger than first advances salaries due
                        $details->advancePaids()->update([
                            'salary_id'           => $oldSalary->id,
                            'advance_paid_amount' => $details->total_due,
                        ]);
                        // if advance paid amount & advanced due amount is equal then is_paid is 1 or true
                        $details->is_paid = true;
                        $details->update(); // save advance paid amount paid details
                        // then advance paid amount is subtract paid amount
                        $advance_paid_amount = $advance_paid_amount - $details->total_due;
                    }
                }
            }
        });

        if ($this->errors) {
            return redirect()->back()->withErrors($this->messages);
        } else {
            return redirect()->route('payroll-salary.show', $this->salary->id)->withSuccess('Salary updated successfully.');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // return $oldSalary = Salary::with('advancePaid.advance')->AddTotalSalaryPaidAmount()->findOrFail($id);

        DB::transaction(function () use ($id) {
            $oldSalary = Salary::AddTotalSalaryPaidAmount()->findOrFail($id);
//          <!-- update previous record -->
            $this->updatePreviousSalaryDetail($oldSalary);
//          <!-- update previous record -->

            $this->salary = $oldSalary->delete();

        });

        if ($this->salary) {
            return redirect()->back()->withSuccess('Salary deleted successfully.');
        }
    }

    /**
     * save salary details
     * @param $request
     * @return void
     */
    public function saveSalaryDetails($request, $salary)
    {
        // if it has basic salary then save it
        if ($request->basic_salary) {
            $salary_details = [
                'purpose' => 'basic_salary',
                'amount' => $request->basic_salary,
            ];
            $salary->details()->create($salary_details);
        }
        // if it has bonus then save it
        if ($request->bonus) {
            $salary_details = [
                'purpose' => 'bonus',
                'amount' => $request->bonus,
            ];
            $salary->details()->create($salary_details);
        }
        // if it has deduction then save it
        if ($request->deduction) {
            $salary_details = [
                'purpose' => 'deduction',
                'amount' => $request->deduction,
            ];
            $salary->details()->create($salary_details);
        }
    }

    public function updatePreviousSalaryDetail($oldSalary)
    {
        $oldSalary["basic_salary"] = $oldSalary->details->where('purpose', 'basic_salary')->first();
        $oldSalary["bonus"] = $oldSalary->details->where('purpose', 'bonus')->first();
        $oldSalary["deduction"] = $oldSalary->details->where('purpose', 'deduction')->first();

        $oldBasic = $oldSalary["basic_salary"] ? $oldSalary['basic_salary']->amount : 0;
        $oldBonus = $oldSalary["bonus"] ? $oldSalary['bonus']->amount : 0;
        $oldDeduction = $oldSalary["deduction"] ? $oldSalary['deduction']->amount : 0;


        $total = ($oldBasic + $oldBonus) - ($oldDeduction + $oldSalary->advance_paid_amount);

        if ($oldSalary->cash_id) {
            Cash::findOrFail($oldSalary->cash_id)->increment('balance',$total );
        }

        if ($oldSalary->advancePaid) {
            $oldSalary->advancePaid->advance()->update([
                'is_paid' => false
            ]);
        }

        if ($oldSalary->advancePaid) {
           $oldSalary->advancePaid->delete();
        }
        $oldSalary->details()->delete();
    }

    /**
     * update cash  balance when salary create or update
     * @param $request
     * @return void
     */
    public function cashUpdate($request)
    {
        $total_amount = ($request->basic_salary + $request->bonus) - ($request->advance_paid_amount + $request->deduction);

        if ($request->payment_type == 'cash') {
            Cash::findOrFail($request->cash_id)->decrement('balance', $total_amount);
        }
    }

}
