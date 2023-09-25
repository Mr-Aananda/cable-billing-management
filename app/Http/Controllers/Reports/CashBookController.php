<?php

namespace App\Http\Controllers\Reports;

use App\Http\Controllers\Controller;
use App\Models\Cash;
use App\Models\ClosingBalance;
use App\Models\CustomerDueManage;
use App\Models\Expense;
use App\Models\MonthlyRecharge;
use App\Models\Purchase;
use App\Models\Sale;
use App\Models\SupplierDueManage;
use Illuminate\Http\Request;

class CashBookController extends Controller
{
    /**
     * show cash book details
     *
     */
    public function index()
    {
        $date = date('Y-m-d');
        $data = $this->cashBookData($date);
        return view('admin.reports.cash-book.index', compact('data'));
    }

    public function cashBookDateData(Request $request)
    {
        $date = $request->date;
        $data = $this->cashBookData($date);
        return view('admin.reports.cash-book.index', compact('data'));
    }

    public function cashBookData($date)
    {

        $opening_date = "2022-01-01";
        $previous_day = date('Y-m-d', strtotime($date . ' - 1 days'));

        $data['opening_balance'] = ClosingBalance::where('date', $previous_day)->first();
        if (!$data['opening_balance']) {
            $data['opening_balance'] = ClosingBalance::whereBetween('date', [$opening_date, $previous_day])->get()->last();
        }
        // for income
        $data['sales'] = Sale::with('customer')->where('total_paid', '>', 0)->whereDate('date', $date)->get();
        $data['total_sale'] = $data['sales']->sum('total_paid');
        $data['due_receives'] = CustomerDueManage::with('customer')->whereDate('date', $date)->where('amount', '>', 0)->get();
        $data['total_due_receive'] = $data['due_receives']->sum('amount');
        $data['monthly_recharge'] = MonthlyRecharge::with('customer')->whereDate('date', $date)->where('amount', '>', 0)->get();
        $data['total_monthly_recharge'] = $data['monthly_recharge']->sum('amount');

        //For expense
        $data['expenses'] = Expense::with('expenseSubcategory.expenseCategory')->whereDate('date', $date)->get();
        $data['total_expense'] = $data['expenses']->sum('amount');
        $data['purchases'] = Purchase::with('supplier')->where('total_paid', '>', 0)->whereDate('date', $date)->get();
        $data['total_purchase'] = $data['purchases']->sum('total_paid');
        $data['due_payments'] = SupplierDueManage::with('supplier')->whereDate('date', $date)->where('amount', '<', 0)->get();
        $data['total_due_payment'] = $data['due_payments']->sum('amount');
        $data['closing_balance'] = Cash::all()->sum('balance');

        return $data;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function closingBalanceStore(Request $request)
    {
        // return $request->all();
        // validation
        $data = $request->validate([
            'date'              => 'required|string',
            'balance'            => 'required|numeric',
        ]);

        $data['balance'] = $request->balance ?? 0;

        if (ClosingBalance::where('date', '=', $request->date)->exists()) {

            return Redirect()->back()->withInput()->withErrors('This date data already exist !');
        }
        else {
            // insert
            ClosingBalance::create($data);
            // view
            return redirect()->back()->withSuccess('Closing balance created successfully.');
        }
    }
}
