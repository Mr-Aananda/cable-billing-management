<?php

namespace App\Http\Controllers\Setting;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class EmployeeController extends Controller
{
    private $paginate = 25;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // employee query
        $employees_query = Employee::query();
        $route_name = 'employee.index'; // for dynamic search

        // search by employee name
        if (request('name')) {
            $employees_query->where('name', 'like', '%' . request('name') . '%');
        }
        // get all services data
        $employees = $employees_query->paginate($this->paginate);

        //view
        return view('admin.employee.index', compact('employees', 'route_name'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //view
        return view('admin.employee.create');
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
            'name'              => 'required|string',
            'mobile'            => 'required|digits:11',
            'image'             => 'nullable|mimes:jpeg,png,jpg,svg|max:2048',
            'nid_number'        => 'nullable|digits:16',
            'basic_salary'      => 'nullable|numeric|min:0',
            'address'           => 'nullable',
            'note'              => 'nullable'
        ]);

        $data['basic_salary'] = $data['basic_salary'] ?? 0;

        //file upload
        if ($request->hasFile('image')) {

            $data['image'] = $request->image->store('images/employee_images');
        }

        // insert
        Employee::create($data);

        // view
        return redirect()->back()->withSuccess('Employee created successfully.');
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
        $employee = Employee::findOrFail($id);
        // view
        return view('admin.employee.show', compact('employee'));
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
        $employee = Employee::findOrFail($id);
        // view
        return view('admin.employee.edit', compact('employee'));
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
        $employee = Employee::findOrFail($id);

        // validation
        $data = $request->validate([
            'name'              => 'required|string',
            'mobile'            => 'required|digits:11',
            'image'             => 'nullable|mimes:jpeg,png,jpg,svg|max:2048',
            'nid_number'        => 'nullable|digits:16',
            'basic_salary'      => 'nullable|numeric|min:0',
            'address'           => 'nullable',
            'note'              => 'nullable'
        ]);

        //file upload
        if ($request->hasFile('image')) {
            Storage::delete($employee->image);

            $data['image'] = $request->image->store('images/employee_images');
        }

        // update
        $employee->update($data);

        // view with message
        return redirect()->route('employee.index')->with('success', 'Employee updated successfully.');
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
        $employee = Employee::findOrFail($id);

        // view with message and delete
        if ($employee->delete()) {
            return redirect()->route('employee.index')->withSuccess('Employee deleted successfully.');
        } else {
            return back()->withErrors('Failed to delete employee.');
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
        // employee query
        $employees_query = Employee::query();
        $route_name = 'employee.trash'; // for dynamic search

        // search by employee name
        if (request('name')) {
            $employees_query->where('name', 'like', '%' . request('name') . '%');
        }
        // get all services data
        $employees = $employees_query->onlyTrashed()->paginate($this->paginate);

        //view
        return view('admin.employee.trash', compact('employees', 'route_name'));
    }

    /**
     *
     */
    public function restore($id)
    {
        // restore by id
        Employee::withTrashed()->find($id)->restore();

        // view
        return redirect()->back()->withSuccess('Employee restore successfully.');
    }

    /**
     *
     */
    public function permanentDelete($id)
    {
        // Permanent delete by id
        Employee::withTrashed()->find($id)->forceDelete();

        // view
        return redirect()->back()->withSuccess('Employee deleted permanently.');
    }

    /**
     *
     */
    public function restoreOrDelete(Request $request)
    {
        if ($request->employees != null) {
            if ($request->restore) {
                foreach ($request->employees as $employee) {
                    Employee::withTrashed()->find($employee)->restore();
                }

                // view
                return redirect()->back()->withSuccess('Employees restored successfully.');
            } else {
                foreach ($request->employees as $employee) {
                    Employee::withTrashed()->find($employee)->forceDelete();
                }

                // view
                return redirect()->back()->withSuccess('Employees deleted permanently.');
            }
        }

        return back()->withErrors('No employee(s) has been selected.');
    }

}
