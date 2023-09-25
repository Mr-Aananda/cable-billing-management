<?php

namespace App\Http\Controllers\Main;

use App\Http\Controllers\Controller;
use App\Models\Supplier;
use Illuminate\Http\Request;

class SupplierController extends Controller
{
    private $paginate = 25;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $suppliers_query = Supplier::query();
        $route_name = 'supplier.index'; // for dynamic search

        // search by supplier name
        if (request('name')) {
            $suppliers_query->where('name', 'like', '%' . request('name') . '%');
        }

        // search by mobile no
        if (request('mobile_no')) {
            $suppliers_query->where('mobile_no', request()->mobile_no);
        }

        // get all suppliers data
        $suppliers = $suppliers_query->latest()->paginate($this->paginate);

        return view('admin.supplier.index', compact('suppliers','route_name'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.supplier.create');
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
            'name'               => 'required|string',
            'mobile_no'          => 'required|string|unique:suppliers,mobile_no',
            'balance'            => 'nullable|numeric',
            'address'            => 'nullable',
            'description'        => 'nullable',
        ]);

        $data['balance'] = $request->balance ?? 0;

        if ($request->balance_status) {
            $data['balance'] = $request->balance ?? 0;
        } else {
            $data['balance'] = -1 * $request->balance ?? 0;
        }
        // insert
        Supplier::create($data);

        // view
        return redirect()->back()->withSuccess('Supplier create successfully.');
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
        $supplier = Supplier::findOrFail($id);


        // view
        return view('admin.supplier.edit', compact('supplier'));
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
        $supplier = Supplier::findOrFail($id);

        // validation
        $data = $request->validate([
            'name'               => 'required|string',
            'mobile_no'          => 'required|string|unique:suppliers,mobile_no,' . $id,  //check for exits or not
            'balance'            => 'nullable|numeric',
            'address'            => 'nullable',
            'description'        => 'nullable',
        ]);

        if ($request->balance_status) {
            $data['balance'] = $request->balance ?? 0;
        } else {
            $data['balance'] = -1 * $request->balance ?? 0;
        }

        // insert
        $supplier->update($data);

        // view with message
        return redirect()->route('supplier.index')->with('success', 'Supplier updated successfully.');
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
        $supplier = Supplier::findOrFail($id);

        // view with message and delete
        if ($supplier->delete()) {
            return redirect()->route('supplier.index')->withSuccess('Supplier deleted successfully.');
        } else {
            return back()->withErrors('Failed to delete supplier.');
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
        $suppliers_query = Supplier::query();
        $route_name = 'supplier.trash'; // for dynamic search

        // search by supplier name
        if (request('name')) {
            $suppliers_query->where('name', 'like', '%' . request('name') . '%');
        }

        // search by mobile no
        if (request('mobile_no')) {
            $suppliers_query->where('mobile_no', request()->mobile_no);
        }

        // get all suppliers data
        $suppliers = $suppliers_query->onlyTrashed()->paginate($this->paginate);

        return view('admin.supplier.trash', compact('suppliers', 'route_name'));
    }

    /**
     *
     */
    public function restore($id)
    {
        // restore by id
        Supplier::withTrashed()->find($id)->restore();

        // view
        return redirect()->back()->withSuccess('Supplier restore successfully.');
    }

    /**
     *
     */
    public function permanentDelete($id)
    {
        // Permanent delete by id
        Supplier::withTrashed()->find($id)->forceDelete();

        // view
        return redirect()->back()->withSuccess('Supplier deleted permanently.');
    }

    /**
     *
     */
    public function restoreOrDelete(Request $request)
    {
        if ($request->suppliers != null) {
            if ($request->restore) {
                foreach ($request->suppliers as $supplier) {
                    Supplier::withTrashed()->find($supplier)->restore();
                }

                // view
                return redirect()->back()->withSuccess('Suppliers restored successfully.');
            } else {
                foreach ($request->suppliers as $supplier) {
                    Supplier::withTrashed()->find($supplier)->forceDelete();
                }

                // view
                return redirect()->back()->withSuccess('Suppliers deleted permanently.');
            }
        }

        return back()->withErrors('No supplier has been selected.');
    }
}
