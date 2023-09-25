<?php

namespace App\Http\Controllers\Main\Expense;

use App\Http\Controllers\Controller;
use App\Models\ExpenseCategory;
use App\Models\ExpenseSubcategory;
use Illuminate\Http\Request;

class SubCategoryController extends Controller
{
    private $paginate = 25;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // category query
        $subCategories_query = ExpenseSubcategory::query();
        $route_name = 'expense-subcategory.index'; // for dynamic search

        // search by category name
        if (request('name')) {
            $subCategories_query->where('name', 'like', '%' . request('name') . '%');
        }

        if (request('category_id')) {
            $subCategories_query->where('expense_category_id',request()->category_id);
        }

        $categories = ExpenseCategory::orderBy('name')->get();
        // get all categories data
        $subCategories = $subCategories_query->withCount('expenses')->paginate($this->paginate);

        //view
        return view('admin.expense.subCategory.index', compact('subCategories', 'route_name', 'categories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = ExpenseCategory::all();

        //view
        return view('admin.expense.subCategory.create', compact('categories'));
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
            'expense_category_id'       => 'required',
            'name'                      => 'required|string',
            'note'                      => 'nullable'
        ]);
        //Insert
        ExpenseSubcategory::create($data);
        // view
        return redirect()->back()->withSuccess('Subcategory create successfully.');
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
        $subcategory = ExpenseSubcategory::findOrFail($id);
        $categories = ExpenseCategory::all();
        // view
        return view('admin.expense.subCategory.edit', compact('subcategory', 'categories'));
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
        $subcategory = ExpenseSubcategory::findOrFail($id);

        // validation
        $data = $request->validate([
            'expense_category_id'           => 'required',
            'name'                          => 'required|string',
            'note'                          => 'nullable'
        ]);

        // update
        $subcategory->update($data);

        // view with message
        return redirect()->route('expense-subcategory.index')->with('success', 'Subcategory updated successfully.');
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
        $subcategory = ExpenseSubcategory::findOrFail($id);

        // view with message and delete
        if ($subcategory->delete()) {
            return redirect()->route('expense-subcategory.index')->withSuccess('Subcategory deleted successfully.');
        } else {
            return back()->withErrors('Failed to delete subcategory.');
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
        //subcategory query
        $subCategories_query = ExpenseSubcategory::query();
        $route_name = 'expense-subcategory.trash'; // for dynamic search

        // Search by subcategory name
        if (request('name')) {
            $subCategories_query->where('name', 'like', '%' . request('name') . '%');
        }
        // Search by subcategory name
        if (request('category_id')) {
            $subCategories_query->where('expense_category_id', request()->category_id);
        }

        $categories = ExpenseCategory::orderBy('name')->get();
        //get all trashes subcategory
        $subcategories = $subCategories_query->onlyTrashed()->paginate($this->paginate);

        // view
        return view('admin.expense.subCategory.trash', compact('subcategories', 'route_name', 'categories'));
    }

    /**
     *
     */
    public function restore($id)
    {
        // restore by id
        ExpenseSubcategory::withTrashed()->find($id)->restore();

        // view
        return redirect()->back()->withSuccess('Subcategory restore successfully.');
    }

    /**
     *
     */
    public function permanentDelete($id)
    {
        // Permanent delete by id
        ExpenseSubcategory::withTrashed()->find($id)->forceDelete();

        // view
        return redirect()->back()->withSuccess('Subcategory deleted permanently.');
    }

    /**
     *
     */
    public function restoreOrDelete(Request $request)
    {
        if ($request->subcategories != null) {
            if ($request->restore) {
                foreach ($request->subcategories as $subcategory) {
                    ExpenseSubcategory::withTrashed()->find($subcategory)->restore();
                }

                // view
                return redirect()->back()->withSuccess('Subcategories restored successfully.');
            } else {
                foreach ($request->subcategories as $subcategory) {
                    ExpenseSubcategory::withTrashed()->find($subcategory)->forceDelete();
                }

                // view
                return redirect()->back()->withSuccess('Subcategories deleted permanently.');
            }
        }

        return back()->withErrors('No subcategory(s) has been selected.');
    }


    /**
     *
     * react component method for add subcategories by category
     *
     */

    public function getSubcategoriesById()
    {
        // request()->all();
        return ExpenseSubcategory::where('expense_category_id', '=', request()->category_id)->get();
    }
}
