<?php

namespace App\Http\Controllers\Main;

use App\Http\Controllers\Controller;
use App\Models\Area;
use App\Models\Customer;
use App\Models\Package;
use App\Models\Sale;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class CustomerController extends Controller
{
    private $paginate = 25;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index()
    {
        $customers_query = Customer::query();
        $route_name = 'customer.index'; // for dynamic search
        $areas=Area::all();


        // search by customer name
        if (request('customer_name')) {
            $customers_query->where('name', 'like', '%' . request('customer_name') . '%');
        }

        // search by area name
        if (request('area_id')) {
            $customers_query->where('area_id', request()->area_id);
        }

        // search by mobile no
        if (request('mobile_no')) {
            $customers_query->where('mobile_no', request()->mobile_no);
        }
        // search by cable id
        if (request('cable_id')) {
            $customers_query->whereHas('sales', function($query){
                $query->where('cable_id', 'like', '%' . request('cable_id') . '%');
            });
        }
        // search by status
        if (request('status')) {
            $customers_query->whereHas('sales', function ($query) {
                $query->where('status', request('status'));
            });
        }

        // get all customer data
        $customers = $customers_query->with('sales')->orderBy('name')->paginate($this->paginate);

        return view('admin.customer.index', compact('customers','areas', 'route_name'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $areas = Area::all();
        $packages = Package::all();
        return view('admin.customer.create',compact('areas','packages'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
    //    return $request->all();
        // validation
        $data = $request->validate([
            'name'               => 'required|string',
            'mobile_no'          => 'required|string',
            'package_id'         => 'required|integer',
            'status'             => 'required|string|in:active,inactive,disconnected',
            'date'               => 'required|date',
            // 'expire_date'        => 'required|date',
            'expire_date' => Rule::requiredIf(function () use ($request) {
                return in_array($request->status, ['active', 'inactive']);
            }) . '|nullable|date',
            'cable_id'           => 'required|unique:sales,cable_id',
            'area_id'            => 'required|integer',
            'balance'            => 'nullable|numeric',
            'address'            => 'nullable',
            'description'        => 'nullable',
        ]);

        DB::transaction(function () use($request , $data) {

            $data['balance'] = $request->balance ?? 0;
            if ($request->balance_status) {
                $data['balance'] = $request->balance ?? 0;
            } else {
                $data['balance'] = -1 * $request->balance ?? 0;
            }
            // insert
            $customer = Customer::create($data);

            $customer_id = $customer->id;

            // Conditionally assign values for the active_date and expire_date fields
            if ($request->status === 'active' || $request->status === 'inactive') {
                $activeDate = $request->date;
                $expireDate = $request->expire_date;
            } else {
                $activeDate = null;
                $expireDate = null;
            }
            // Conditionally assign the value for the status field
            if ($request->status === 'active' || $request->status === 'inactive') {

                $status = $request->date <= $request->expire_date ? 'active' : 'inactive';

                if (date('Y-m-d') > $request->expire_date) {
                    $status = 'inactive';
                }
            } else {
                $status = $request->status;
            }

            Sale::create([
                'date'              => $request->date,
                'active_date'       => $activeDate,
                'expire_date'       => $expireDate,
                'customer_id'       => $customer_id,
                'package_id'        => $request->package_id,
                'cable_id'          => $request->cable_id,
                'status'            => $status,
                'user_id'           => Auth::id(),
            ]);

        });
        // view
        return redirect()->back()->withSuccess('Customer create successfully.');
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
        $customer = Customer::findOrFail($id);

        // view
        return view('admin.customer.show', compact('customer'));
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
        $customer = Customer::findOrFail($id);
        $areas = Area::all();
        $packages = Package::all();

        // view
        return view('admin.customer.edit', compact('customer', 'areas','packages'));
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
    //   return  $request->all();
    // return $status = $request->date >= $request->expire_date ? 'active' : 'inactive';
        // get the specified resource
        $customer = Customer::findOrFail($id);
        $saleId = $customer->sales->first()->id;

        // validation
        $data = $request->validate([
            'name'               => 'required|string',
            'mobile_no'          => 'required|string|',
            'package_id'         => 'required|integer',
            'status'             => 'required|string|in:active,inactive,disconnected',
            'date'               => 'required|date',
            // 'expire_date'        => 'required|date',
            'expire_date' => Rule::requiredIf(function () use ($request) {
                return in_array($request->status, ['active', 'inactive']);
            }) . '|nullable|date',
            'cable_id'           => 'required|unique:sales,cable_id,'.$saleId,
            'area_id'            => 'required|integer',
            'balance'            => 'nullable|numeric',
            'address'            => 'nullable',
            'description'        => 'nullable',
        ]);
        DB::transaction(function () use ($request, $data,$customer) {
            $data['balance'] = $request->balance ?? 0;
            if ($request->balance_status) {
                $data['balance'] = $request->balance ?? 0;
            } else {
                $data['balance'] = -1 * $request->balance ?? 0;
            }
            // insert
            $customer->update($data);

            // Conditionally assign values for the active_date and expire_date fields
            if ($request->status === 'active' || $request->status === 'inactive') {
                $activeDate = $request->date;
                $expireDate = $request->expire_date;
            } else {
                $activeDate = null;
                $expireDate = null;
            }
            // Conditionally assign the value for the status field
            if ($request->status === 'active' || $request->status === 'inactive') {

                $status = $request->date <= $request->expire_date ? 'active' : 'inactive';

                if(date('Y-m-d') > $request->expire_date) {
                    $status = 'inactive';
                }

            }else{
                $status = $request->status;
            }

            $customer->sales->first()->update([
                'date'              => $request->date,
                'active_date'       => $activeDate,
                'expire_date'       => $expireDate,
                'customer_id'       => $customer->id,
                'package_id'        => $request->package_id,
                'cable_id'          => $request->cable_id,
                'status'            => $status,
                'user_id'           => Auth::id(),
            ]);
        });
        // view with message
        return redirect()->route('customer.index')->with('success', 'Customer updated successfully.');
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
        $customer = Customer::findOrFail($id);
        // view with message and delete
        if ($customer->delete()) {
            return redirect()->route('customer.index')->withSuccess('Customer deleted successfully.');
        } else {
            return back()->withErrors('Failed to delete customer.');
        }
    }

    // All Trashes function
    /**
     * Display a listing of the trashed resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function trash()
    {
        $customers_query = Customer::query();
        $route_name = 'customer.trash'; // for dynamic search
        $areas = Area::all();

        // search by customer name
        if (request('customer_name')) {
            $customers_query->where('name', 'like', '%' . request('customer_name') . '%');
        }
        // search by area name
        if (request('area_id')) {
            $customers_query->where('area_id', request()->area_id);
        }
        // search by mobile no
        if (request('mobile_no')) {
            $customers_query->where('mobile_no', request()->mobile_no);
        }
        // get all customer data
        $customers = $customers_query->onlyTrashed()->paginate($this->paginate);

        return view('admin.customer.trash', compact('customers', 'areas', 'route_name'));
    }

    /**
     *
     */
    public function restore($id)
    {
        // restore by id
        Customer::withTrashed()->find($id)->restore();

        // view
        return redirect()->back()->withSuccess('Customer restore successfully.');
    }

    /**
     *
     */
    public function permanentDelete($id)
    {
        // Permanent delete by id
        Customer::withTrashed()->find($id)->forceDelete();

        // view
        return redirect()->back()->withSuccess('Customer deleted permanently.');
    }

    /**
     *
     */
    public function restoreOrDelete(Request $request)
    {
        if ($request->customers != null) {
            if ($request->restore) {
                foreach ($request->customers as $customer) {
                    Customer::withTrashed()->find($customer)->restore();
                }

                // view
                return redirect()->back()->withSuccess('Customers restored successfully.');
            } else {
                foreach ($request->customers as $customer) {
                    Customer::withTrashed()->find($customer)->forceDelete();
                }

                // view
                return redirect()->back()->withSuccess('Customers deleted permanently.');
            }
        }

        return back()->withErrors('No customer has been selected.');
    }
}
