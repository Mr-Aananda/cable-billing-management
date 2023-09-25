<?php

namespace App\Http\Controllers\Main\Payroll;

use App\Http\Controllers\Controller;
use App\Models\Advance;
use App\Models\Cash;
use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdvancedController extends Controller
{
    private $paginate = 25;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // $advances = Advance::paginate($this->paginate);
        // $employees = Employee::whereHas('advances')->paginate($this->paginate);
        $employees = Employee::whereHas('advances', function ($query) {
            $query->where('is_paid', '!=', true);
        })
            ->with(['advances' => function ($query) {
                $query->where('is_paid', '!=', true);
            }])
            ->paginate($this->paginate);
        // view
        return view('admin.payroll.advanced.index', compact('employees'));
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
        return view("admin.payroll.advanced.create", compact('employees', 'cashes'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // validation
        $data = $request->validate([
            'date'                      => 'required|date',
            'employee_id'               => 'required',
            'amount'                    => 'required|numeric|min:0',
            'cash_id'                   => 'required',
            'payment_type'              => 'required|string',
            'note'                      => 'nullable'
        ]);

        $employee = Employee::find($request->employee_id);
        $salaryAmount = $employee->basic_salary;
        $untilTakenAdvance = $employee->total_advance_due;

        if ($salaryAmount < $untilTakenAdvance + $request->amount) {
            return redirect()->back()->withErrors(['error' => 'Cannot take advance.']);
        }
        DB::transaction(function () use($data,$request) {
            // insert
            Advance::create($data);
            //Update cash
            $this->cashUpdate($request);

        });
        // view
        return redirect()->back()->withSuccess('Advance create successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // get the specified resource
        $advance_details = Advance::where('employee_id',$id)->get();
        $employee = Employee::where('id', $advance_details->first()->employee_id)->first();

        $advanced_for_breadcrump = Advance::where('employee_id', $id)->first();
        // view
        return view("admin.payroll.advanced.show", compact('advance_details', 'employee', 'advanced_for_breadcrump'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $advance_detail = Advance::findOrFail($id);
        $employees = Employee::all();
        $cashes = Cash::all();

        return view("admin.payroll.advanced.edit", compact('employees', 'cashes', 'advance_detail'));
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
        $advance_detail = Advance::findOrFail($id);
        // return $request->all();
        $data = $request->validate([
            'date'                      => 'required|date',
            'employee_id'               => 'required',
            'amount'                    => 'required|numeric|min:0',
            'cash_id'                   => 'required',
            'payment_type'              => 'required|string',
            'note'                      => 'nullable'
        ]);

        DB::transaction(function () use ($data, $request, $advance_detail) {
            //update old cash
            $this->oldCashUpdate($advance_detail);
            //Update data
            $advance_detail->update($data);
            //Update cash
            $this->cashUpdate($request);
        });


        // view with message
        return redirect()->route('payroll-advanced.show', $advance_detail->employee_id)->with('success', 'Advanced salary has been updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // get the specified resource
        $advance_detail = Advance::findOrFail($id);
        //update old cash
        $this->oldCashUpdate($advance_detail);

        // view with message and delete
        if ($advance_detail->delete()) {
            return redirect()->route('payroll-advanced.index')->withSuccess('Advanced deleted successfully.');
        } else {
            return back()->withErrors('Failed to delete advanced.');
        }
    }

    /**
     * update cash  balance when advance create or update
     * @param $request
     * @return void
     */
    public function cashUpdate($request)
    {
        if ($request->payment_type == 'cash') {
            Cash::findOrFail($request->cash_id)->decrement('balance', $request->amount);
        }
    }

    /**
     * update  cash balance when advance is deleted or updated
     * @param $sale
     * @return void
     */
    public function oldCashUpdate($advance_detail)
    {
        if ($advance_detail->payment_type == 'cash') {
            $advance_detail->cash()->increment('balance', $advance_detail->amount);
        }
    }
}
