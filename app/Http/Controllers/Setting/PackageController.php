<?php

namespace App\Http\Controllers\Setting;

use App\Http\Controllers\Controller;
use App\Models\Package;
use Illuminate\Http\Request;

class PackageController extends Controller
{
    private $paginate = 25;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $packages_query = Package::query();
        $route_name = 'package.index'; // for dynamic search

        // search by package name
        if (request('name')) {
            $packages_query->where('name', 'like', '%' . request('name') . '%');
        }

        // get all packages data
        $packages = $packages_query->paginate($this->paginate);

        return view('admin.package.index', compact('packages', 'route_name'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.package.create');
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
            'price'              => 'required|numeric',
            'cost'               => 'nullable|numeric',
            'description'        => 'nullable',
        ]);

        $data['cost'] = $request->cost ?? 0.00;

        // insert
        Package::create($data);
        // view
        return redirect()->back()->withSuccess('Package create successfully.');
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
        $package = Package::findOrFail($id);

        // view
        return view('admin.package.edit', compact('package'));
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
        $package = Package::findOrFail($id);

        // validation
        $data = $request->validate([
            'name'               => 'required|string',
            'price'              => 'required|numeric',
            'cost'               => 'nullable|numeric',
            'description'        => 'nullable',
        ]);

        $data['cost'] = $request->cost ?? 0;

        // update
        $package->update($data);

        // view with message
        return redirect()->route('package.index')->with('success', 'Package updated successfully.');
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
        $package = Package::findOrFail($id);

        // view with message and delete
        if ($package->delete()) {
            return redirect()->route('package.index')->withSuccess('Package deleted successfully.');
        } else {
            return back()->withErrors('Failed to delete package.');
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
        $packages_query = Package::query();
        $route_name = 'package.trash'; // for dynamic search

        // search by package name
        if (request('name')) {
            $packages_query->where('name', 'like', '%' . request('name') . '%');
        }

        // get all packages data
        $packages = $packages_query->onlyTrashed()->paginate($this->paginate);

        return view('admin.package.trash', compact('packages', 'route_name'));
    }

    /**
     *
     */
    public function restore($id)
    {
        // restore by id
        Package::withTrashed()->find($id)->restore();

        // view
        return redirect()->back()->withSuccess('Package restore successfully.');
    }

    /**
     *
     */
    public function permanentDelete($id)
    {
        // Permanent delete by id
        Package::withTrashed()->find($id)->forceDelete();

        // view
        return redirect()->back()->withSuccess('Package deleted permanently.');
    }

    /**
     *
     */
    public function restoreOrDelete(Request $request)
    {
        if ($request->packages != null) {
            if ($request->restore) {
                foreach ($request->packages as $package) {
                    Package::withTrashed()->find($package)->restore();
                }

                // view
                return redirect()->back()->withSuccess('Packages restored successfully.');
            } else {
                foreach ($request->packages as $package) {
                    Package::withTrashed()->find($package)->forceDelete();
                }

                // view
                return redirect()->back()->withSuccess('Packages deleted permanently.');
            }
        }

        return back()->withErrors('No packages has been selected.');
    }
}
