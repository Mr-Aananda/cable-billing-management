<?php

namespace App\Http\Controllers\Main;

use App\Http\Controllers\Controller;
use App\Models\Cash;
use App\Models\Customer;
use App\Models\CustomerDueManage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CustomerDueManageController extends Controller
{
    private $paginate = 25;
    private $due_manage;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $customerDues_query = CustomerDueManage::query();
        $route_name = 'customer-due-manage.index'; // for dynamic search

        if (request()->search) {

            // set date
            $date = [];

            // set date
            if (request()->form_date != null) {
                $date[] = date(request()->form_date);

                if (request()->to_date != null) {
                    $date[] = date(request()->to_date);
                } else {
                    if (request()->form_date != null) {
                        $date[] = date('Y-m-d');
                    }
                }

                if (count($date) > 0) {
                    $customerDues_query = $customerDues_query->whereBetween('date', $date);
                }
            }
        }

        if (request('name')) {
            $customerDues_query->whereHas('customer', function ($query) {
                $query->where('name', 'like', '%' . request('name') . '%');
            });
        }

        if (request('mobile_no')) {
            $customerDues_query->whereHas('customer', function ($query) {
                $query->where('mobile_no',  request('mobile_no'));
            });
        }

        // get all customers data
        $customerDues = $customerDues_query->latest()->paginate($this->paginate);
        $customers = Customer::all();

        return view('admin.due-manage.customer.index', compact('customerDues', 'route_name', 'customers'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $customers = Customer::all();
        $cashes  = Cash::all();
        return view('admin.due-manage.customer.create', compact('customers', 'cashes'));
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
            'customer_id'       => 'required',
            'date'              => 'required|date',
            'payment_type'      => 'required|string',
            'amount'            => 'required|numeric|min:0',
            'adjustment'        => 'nullable|numeric|min:0',
            'cash_id'           => 'required',
            'note'              => 'nullable'
        ]);


        DB::transaction(function () use ($request, $data) {
            $data['amount'] = $request->amount ?? 0;
            $data['adjustment'] = $request->adjustment ?? 0;

            if ($request->balance_status) {
                $data['amount'] = $request->amount ?? 0;
            } else {
                $data['amount'] = -1 * $request->amount ?? 0;
            }

            //Insert
            $this->due_manage = CustomerDueManage::create($data);
            $due_manage = $this->due_manage;

            $this->updatePaymentDetails($request, $due_manage);
        });

        if ($this->due_manage) {
            return redirect()->back()->withSuccess('Customer due manage created successfully.');
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
        // get the specified resource
        $customerDue = CustomerDueManage::with('customer')->findOrFail($id);
        $customers = Customer::all();
        $cashes  = Cash::all();

        // view
        return view('admin.due-manage.customer.edit', compact('customerDue', 'customers', 'cashes'));
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
        $old_due_damage = CustomerDueManage::findOrFail($id);

        // validation
        $data = $request->validate([
            'customer_id'       => 'required',
            'date'              => 'required|date',
            'payment_type'      => 'required|string',
            'amount'            => 'required|numeric|min:0',
            'adjustment'        => 'nullable|numeric|min:0',
            'cash_id'           => 'required',
            'note'              => 'nullable'
        ]);

        DB::transaction(function () use ($request, $data, $old_due_damage) {
            $data['amount'] = $request->amount ?? 0;
            $data['adjustment'] = $request->adjustment ?? 0;

            if ($request->balance_status) {
                $data['amount'] = $request->amount ?? 0;
            } else {
                $data['amount'] = -1 * $request->amount ?? 0;
            }

            $this->updateOldPaymentDetails($old_due_damage);

            // insert
            $old_due_damage->update($data);
            $this->due_manage = $old_due_damage;

            $this->updatePaymentDetails($request, $old_due_damage);
        });

        // view with message
        return redirect()->route('customer-due-manage.index')->with('success', 'Customer due manage updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $customerDue = CustomerDueManage::findOrFail($id);
        $this->updateOldPaymentDetails($customerDue);
        $customerDue->delete();
        return redirect()->back()->with('success', 'Due manage delete successfully!');
    }

    /**
     * update due manage party balance,
     * update due manage cash or bank balance,
     * @param $request
     * @param $due_manage
     * @return void
     */
    public function updatePaymentDetails($request, $due_manage)
    {


        $total_balance = $request->amount + $request->adjustment;

        if ($request->balance_status) {
            $due_manage->customer()->decrement('balance', $total_balance);
        } else {
            $due_manage->customer()->increment('balance', $total_balance);
        }

        if ($request->cash_id) {
            $due_manage->cash()->increment('balance', $due_manage->amount);
        }
    }

    /**
     * update due manage party balance,
     * update due manage cash or bank balance,
     * @param $request
     * @param $due_manage
     * @return void
     */
    public function updateOldPaymentDetails($old_due_damage)
    {
        if ($old_due_damage->amount <= 0) {
            $total_balance = $old_due_damage->amount - $old_due_damage->adjustment;
        } else {
            $total_balance = $old_due_damage->amount + $old_due_damage->adjustment;
        }

        $old_due_damage->customer()->increment('balance', $total_balance);


        if ($old_due_damage->cash_id) {
            $old_due_damage->cash()->decrement('balance', $old_due_damage->amount);
        }
    }
}
