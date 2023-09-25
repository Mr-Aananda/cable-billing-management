<?php

namespace App\Http\Controllers\Main\Payroll;

use App\Http\Controllers\Controller;
use App\Models\Cash;
use App\Models\LoanInstallment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LoanInstallmentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
        $data = $request->validate([
            'loan_id'           => 'required|integer',
            'date'              => 'required|date',
            'amount'            => 'required|numeric',
            'cash_id'           => 'required|integer',
            'payment_type'      => 'required|string',
            'note'              => 'nullable',
        ]);
        DB::transaction(function () use($data,$request) {
            //Insert data
            LoanInstallment::create($data);
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
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $loanInstallment = LoanInstallment::findOrFail($id);
        $cashes = Cash::all();
        return view('admin.payroll.loan-installment.edit', compact('loanInstallment', 'cashes'));
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
        $loanInstallment = LoanInstallment::findOrFail($id);

        // validation
        $data = $request->validate([
            'date'              => 'required|date',
            'amount'            => 'required|numeric',
            'cash_id'           => 'required|integer',
            'payment_type'      => 'required|string',
            'note'              => 'nullable',
        ]);

        DB::transaction(function () use ($loanInstallment,$data,$request) {
            //Old cash update
            $this->oldCashUpdate($loanInstallment);
            // update
            $loanInstallment->update($data);

            $this->cashUpdate($request);

        });

        // view with message
        return redirect()->back()->with('success', 'Loan has been updated successfully.');
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
        $loanInstallment = LoanInstallment::findOrFail($id);
        //Old cash update
        $this->oldCashUpdate($loanInstallment);

        // view
        if ($loanInstallment->delete()) {
            return redirect()->back()->withSuccess('Loan installment deleted successfully.');
        } else {
            return back()->withErrors('Failed to delete installment.');
        }
    }

    /**
     * update cash  balance when loanInstallment create or update
     * @param $request
     * @return void
     */
    public function cashUpdate($request)
    {
        if ($request->payment_type == 'cash') {
            Cash::findOrFail($request->cash_id)->increment('balance', $request->amount);
        }
    }

    /**
     * update  cash balance when loanInstallment is deleted or updated
     * @param $sale
     * @return void
     */
    public function oldCashUpdate($loanInstallment)
    {
        if ($loanInstallment->payment_type == 'cash') {
            $loanInstallment->cash()->decrement('balance', $loanInstallment->amount);
        }
    }
}
