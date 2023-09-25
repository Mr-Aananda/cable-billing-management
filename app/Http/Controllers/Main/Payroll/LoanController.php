<?php

namespace App\Http\Controllers\Main\Payroll;

use App\Http\Controllers\Controller;
use App\Models\Cash;
use App\Models\Employee;
use App\Models\Loan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LoanController extends Controller
{
    private $paginate = 25;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $loans = Loan::query()
            ->withCount('loanInstallments')
            ->addPaid()
            ->addDue()
            ->paginate($this->paginate);
        return view('admin.payroll.loan.index', compact('loans'));
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
        return view("admin.payroll.loan.create", compact('employees', 'cashes'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //Validation
        $data = $request->validate([
            'date'             => 'required|date',
            'employee_id'      => 'required',
            'amount'           => 'required|numeric|min:0',
            'expire_date'      => 'required|date',
            'cash_id'          => 'required',
            'payment_type'     => 'required|string',
            'note'             => 'nullable'
        ]);
        DB::transaction(function () use($data,$request) {

            //Insert
            Loan::create($data);
            //Update cash
            $this->cashUpdate($request);

        });

        // view
        return redirect()->back()->withSuccess('Loan given successfully.');
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
        $loan = Loan::findOrFail($id);

        return view('admin.payroll.loan.show', compact('loan'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function loanPaid($id)
    {
        // get the specified resource
        $loan = Loan::findOrFail($id);
        $cashes = Cash::all();
        return view('admin.payroll.loan.loan-paid', compact('loan', 'cashes'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        // get the specified resource
        $loan = Loan::findOrFail($id);
        $employees = Employee::all();
        $cashes = Cash::all();

        return view('admin.payroll.loan.edit', compact('employees', 'cashes', 'loan'));
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
        // get the specified resource
        $loan = Loan::findOrFail($id);

        // validation
        $data = $request->validate([
            'date'             => 'required|date',
            'employee_id'      => 'required',
            'amount'           => 'required|numeric|min:0',
            'expire_date'      => 'required|date',
            'cash_id'          => 'required',
            'payment_type'     => 'required|string',
            'note'             => 'nullable'
        ]);
        DB::transaction(function () use($loan,$data,$request) {
            //Update old cash
            $this->oldCashUpdate($loan);
            // update
            $loan->update($data);
            //Cash update
            $this->cashUpdate($request);

        });

        // view with message
        return redirect()->route('payroll-loan.index')->with('success', 'Loan has been updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // delete
        $loan = Loan::findOrFail($id);
        //Update old cash
        $this->oldCashUpdate($loan);

        // view
        if ($loan->delete()) {
            return redirect()->route('payroll-loan.index')->withSuccess('Loan deleted successfully.');
        } else {
            return back()->withErrors('Failed to delete loan.');
        }
    }


    /**
     * update cash  balance when loan create or update
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
     * update  cash balance when loan is deleted or updated
     * @param $sale
     * @return void
     */
    public function oldCashUpdate($loan)
    {
        if ($loan->payment_type == 'cash') {
            $loan->cash()->increment('balance', $loan->amount);
        }
    }
}
