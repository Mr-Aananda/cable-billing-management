<?php

namespace App\Http\Controllers\Main\Expense;

use App\Http\Controllers\Controller;
use App\Models\Cash;
use App\Models\Expense;
use App\Models\ExpenseCategory;
use App\Models\ExpenseSubcategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ExpenseController extends Controller
{
    private $paginate = 25;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //expense query
        $expenses_query = Expense::with('expenseCategory');
        $route_name = 'expense.index'; // for dynamic search

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
                    $expenses_query = $expenses_query->whereBetween('date', $date);
                }
            }
        }

        if (request('name')) {
            $expenses_query->whereHas('expenseCategory', function ($query) {
                $query->where('name', 'like', '%' . request('name') . '%');
            });
        }

        // get data
        $categories = ExpenseCategory::orderBy('name')->get();
        $subcategories = ExpenseSubcategory::orderBy('name')->get();

        $expenses = $expenses_query->paginate($this->paginate);

        return view('admin.expense.index', compact('expenses', 'route_name', 'categories', 'subcategories'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = ExpenseCategory::all();
        $cashes = Cash::all();
        return view('admin.expense.create', compact('categories', 'cashes'));
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
            "date"                      => 'required',
            "expense_category_id"       => 'required',
            "expense_subcategory_id"    => 'required',
            "amount"                    => 'required|numeric|min:0',
            'cash_id'                   => 'required',
            'payment_type'              => 'required',
            "note"                      => 'nullable',
        ]);
        DB::transaction(function () use($data,$request) {
            //Insert
            Expense::create($data);
            //Update cash
            $this->cashUpdate($request);

        });
        // view
        return redirect()->back()->withSuccess('Expense create successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $expense = Expense::findOrFail($id);
        return view('admin.expense.show', compact('expense'));
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
        $expense = Expense::findOrFail($id);

        $cashes = Cash::all();
        $categories = ExpenseCategory::all();

        // foreach ($categories as $key => $category) {
        //     $category['is_selected'] = false;
        // }

        //view
        return view('admin.expense.edit', compact('expense', 'categories', 'cashes'));
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
        $expense = Expense::findOrFail($id);

        // validation
        $data = $request->validate([
            "date"                      => 'required',
            "expense_category_id"       => 'required',
            "expense_subcategory_id"    => 'required',
            "amount"                    => 'required|numeric|min:0',
            'cash_id'                   => 'required',
            'payment_type'              => 'required',
            "note"                      => 'nullable',
        ]);
        DB::transaction(function () use($data, $expense, $request) {
            //Update old cash
            $this->oldCashUpdate($expense);

            // update
            $expense->update($data);
            //Update cash
            $this->cashUpdate($request);

        });


        // view with message
        return redirect()->route('expense.index')->with('success', 'Expense has been updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // delete
        $expense = Expense::findOrFail($id);
        //Update old cash
        $this->oldCashUpdate($expense);

        // view
        if ($expense->delete()) {
            return redirect()->route('expense.index')->withSuccess('Expense deleted successfully.');
        } else {
            return back()->withErrors('Failed to delete expense.');
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
        //expense query
        $expenses_query = Expense::with('expenseCategory');
        $route_name = 'expense.trash'; // for dynamic search

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
                    $expenses_query = $expenses_query->whereBetween('date', $date);
                }
            }
        }


        if (request('name')) {
            $expenses_query->whereHas('expenseCategory', function ($query) {
                $query->where('name', 'like', '%' . request('name') . '%');
            });
        }

        // get data
        $categories = ExpenseCategory::orderBy('name')->get();

        $expenses = $expenses_query->onlyTrashed()->paginate($this->paginate);

        return view('admin.expense.trash', compact('expenses', 'route_name', 'categories'));
    }

    /**
     *
     */
    public function restore($id)
    {
        // restore by id
        Expense::withTrashed()->find($id)->restore();

        // view
        return redirect()->back()->withSuccess('Expense restore successfully.');
    }

    /**
     *
     */
    public function permanentDelete($id)
    {
        // Permanent delete by id
        Expense::withTrashed()->find($id)->forceDelete();

        // view
        return redirect()->back()->withSuccess('Expense deleted permanently.');
    }

    /**
     *
     */
    public function restoreOrDelete(Request $request)
    {
        if ($request->expenses != null) {
            if ($request->restore) {
                foreach ($request->expenses as $expense) {
                    Expense::withTrashed()->find($expense)->restore();
                }

                // view
                return redirect()->back()->withSuccess('Expenses restored successfully.');
            } else {
                foreach ($request->expenses as $expense) {
                    Expense::withTrashed()->find($expense)->forceDelete();
                }

                // view
                return redirect()->back()->withSuccess('Expenses deleted permanently.');
            }
        }

        return back()->withErrors('No expense(s) has been selected.');
    }


    /**
     * update cash or bank balance when sale create or update
     * @param $request
     * @return void
     */
    public function cashUpdate($request)
    {
        if ($request->payment_type == 'cash') {
            Cash::findOrFail($request->cash_id)->decrement('balance', $request->amount);
        }
    }

    /**
     * update bank or cash balance when sale is deleted or updated
     * @param $sale
     * @return void
     */
    public function oldCashUpdate($expense)
    {
        if ($expense->payment_type == 'cash') {
            $expense->cash()->increment('balance', $expense->amount);
        }
    }
}
