<?php

namespace App\Http\Controllers\Main\Expense;

use App\Http\Controllers\Controller;
use App\Models\ExpenseCategory;
use Illuminate\Http\Request;

class CategoryController extends Controller
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
        $categories_query = ExpenseCategory::query();
        $route_name = 'expense-category.index'; // for dynamic search

        // search by category name
        if (request('name')) {
            $categories_query->where('name', 'like', '%' . request('name') . '%');
        }
        // get all categories data
        $categories = $categories_query->withCount('expenseSubcategories')->paginate($this->paginate);

        //view
        return view('admin.expense.category.index', compact('categories', 'route_name'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.expense.category.create');
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
            'note'              => 'nullable'
        ]);

        // insert
        ExpenseCategory::create($data);

        // view
        return redirect()->back()->withSuccess('Category created successfully.');
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
        $category = ExpenseCategory::findOrFail($id);
        // view
        return view('admin.expense.category.edit', compact('category'));
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
        $category = ExpenseCategory::findOrFail($id);

        // validation
        $data = $request->validate([
            'name'              => 'required|string',
            'note'              => 'nullable'
        ]);

        // update
        $category->update($data);

        // view with message
        return redirect()->route('expense-category.index')->with('success', 'Category updated successfully.');
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
        $category = ExpenseCategory::findOrFail($id);

        // view with message and delete
        if ($category->delete()) {
            return redirect()->route('expense-category.index')->withSuccess('Category deleted successfully.');
        } else {
            return back()->withErrors('Failed to delete category.');
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
        //category query
        $categories_query = ExpenseCategory::query();
        $route_name = 'expense-category.trash'; // for dynamic search

        // Search by category name
        if (request('name')) {
            $categories_query->where('name', 'like', '%' . request('name') . '%');
        }
        //get all trashes categories
        $categories = $categories_query->onlyTrashed()->paginate($this->paginate);

        // view
        return view('admin.expense.category.trash', compact('categories', 'route_name'));
    }

    /**
     *
     */
    public function restore($id)
    {
        // restore by id
        ExpenseCategory::withTrashed()->find($id)->restore();

        // view
        return redirect()->back()->withSuccess('Category restore successfully.');
    }

    /**
     *
     */
    public function permanentDelete($id)
    {
        // Permanent delete by id
        ExpenseCategory::withTrashed()->find($id)->forceDelete();

        // view
        return redirect()->back()->withSuccess('Category deleted permanently.');
    }

    /**
     *
     */
    public function restoreOrDelete(Request $request)
    {
        if ($request->categories != null) {
            if ($request->restore) {
                foreach ($request->categories as $category) {
                    ExpenseCategory::withTrashed()->find($category)->restore();
                }

                // view
                return redirect()->back()->withSuccess('Categories restored successfully.');
            } else {
                foreach ($request->categories as $category) {
                    ExpenseCategory::withTrashed()->find($category)->forceDelete();
                }

                // view
                return redirect()->back()->withSuccess('Categories deleted permanently.');
            }
        }

        return back()->withErrors('No category(s) has been selected.');
    }
}
