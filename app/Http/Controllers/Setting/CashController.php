<?php

namespace App\Http\Controllers\Setting;

use App\Http\Controllers\Controller;
use App\Models\Cash;
use Illuminate\Http\Request;

class CashController extends Controller
{
    private $paginate = 25;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $cashes = Cash::paginate($this->paginate);
        // view
        return view('admin.cash.index', compact('cashes'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.cash.create');
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
            'cash_name'         => 'required|string',
            'balance'           => 'required|numeric',
            'note'              => 'nullable'
        ]);

        $data['balance'] = $data['balance'] ?? 0;

        // insert
        Cash::create($data);

        // view
        return redirect()->back()->withSuccess('Cash created successfully.');
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
        $cash = Cash::findOrFail($id);
        // view
        return view('admin.cash.edit', compact('cash'));
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
        $cash = Cash::findOrFail($id);

        // validation
        $data = $request->validate([
            'cash_name'         => 'required|string',
            'balance'           => 'required|numeric',
            'note'              => 'nullable'
        ]);

        $data['balance'] = $data['balance'] ?? 0;
        // update
        $cash->update($data);
        // view with message
        return redirect()->route('cash.index')->with('success', 'Cash updated successfully.');
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
        $cash = Cash::findOrFail($id);

        // view with message and delete
        if ($cash->delete()) {
            return redirect()->route('cash.index')->withSuccess('Cash deleted successfully.');
        } else {
            return back()->withErrors('Failed to delete cash.');
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
        //get all trashes services
        $cashes = Cash::onlyTrashed()->paginate($this->paginate);

        // view
        return view('admin.cash.trash', compact('cashes'));
    }

    /**
     *
     */
    public function restore($id)
    {
        // restore by id
        Cash::withTrashed()->find($id)->restore();

        // view
        return redirect()->back()->withSuccess('Cash restore successfully.');
    }

    /**
     *
     */
    public function permanentDelete($id)
    {
        // Permanent delete by id
        Cash::withTrashed()->find($id)->forceDelete();

        // view
        return redirect()->back()->withSuccess('Cash deleted permanently.');
    }

    /**
     *
     */
    public function restoreOrDelete(Request $request)
    {
        if ($request->cashes != null) {
            if ($request->restore) {
                foreach ($request->cashes as $cash) {
                    Cash::withTrashed()->find($cash)->restore();
                }

                // view
                return redirect()->back()->withSuccess('Cashes restored successfully.');
            } else {
                foreach ($request->cashes as $cash) {
                    Cash::withTrashed()->find($cash)->forceDelete();
                }

                // view
                return redirect()->back()->withSuccess('Cashes deleted permanently.');
            }
        }

        return back()->withErrors('No cash(s) has been selected.');
    }
}
