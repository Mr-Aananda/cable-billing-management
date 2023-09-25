<?php

namespace App\Http\Controllers\Setting;

use App\Http\Controllers\Controller;
use App\Models\Area;
use Illuminate\Http\Request;

class AreaController extends Controller
{
    private $paginate = 25;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $areas_query = Area::query();
        $route_name = 'area.index'; // for dynamic search

        // search by area name
        if (request('name')) {
            $areas_query->where('name', 'like', '%' . request('name') . '%');
        }

        // get all area data
        $areas = $areas_query->paginate($this->paginate);

        return view('admin.area.index', compact('areas', 'route_name'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.area.create');
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
            'description'        => 'nullable',
        ]);

        // insert
        Area::create($data);
        // view
        return redirect()->back()->withSuccess('Area create successfully.');
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
        $area = Area::findOrFail($id);

        // view
        return view('admin.area.edit', compact('area'));
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
        $area = Area::findOrFail($id);

        // validation
        $data = $request->validate([
            'name'               => 'required|string',
            'description'        => 'nullable',
        ]);

        // update
        $area->update($data);

        // view with message
        return redirect()->route('area.index')->with('success', 'Area updated successfully.');
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
        $area = Area::findOrFail($id);

        // view with message and delete
        if ($area->delete()) {
            return redirect()->route('area.index')->withSuccess('Area deleted successfully.');
        } else {
            return back()->withErrors('Failed to delete area.');
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
        $areas_query = Area::query();
        $route_name = 'area.trash'; // for dynamic search

        // search by area name
        if (request('name')) {
            $areas_query->where('name', 'like', '%' . request('name') . '%');
        }

        // get all area data
        $areas = $areas_query->onlyTrashed()->paginate($this->paginate);

        return view('admin.area.trash', compact('areas', 'route_name'));
    }

    /**
     *
     */
    public function restore($id)
    {
        // restore by id
        Area::withTrashed()->find($id)->restore();

        // view
        return redirect()->back()->withSuccess('Area restore successfully.');
    }

    /**
     *
     */
    public function permanentDelete($id)
    {
        // Permanent delete by id
        Area::withTrashed()->find($id)->forceDelete();

        // view
        return redirect()->back()->withSuccess('Area deleted permanently.');
    }

    /**
     *
     */
    public function restoreOrDelete(Request $request)
    {
        if ($request->areas != null) {
            if ($request->restore) {
                foreach ($request->areas as $area) {
                    Area::withTrashed()->find($area)->restore();
                }

                // view
                return redirect()->back()->withSuccess('Areas restored successfully.');
            } else {
                foreach ($request->areas as $area) {
                    Area::withTrashed()->find($area)->forceDelete();
                }

                // view
                return redirect()->back()->withSuccess('Areas deleted permanently.');
            }
        }

        return back()->withErrors('No areas has been selected.');
    }
}
