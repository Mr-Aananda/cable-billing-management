<?php

namespace App\Http\Controllers\Setting;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Stock;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    private $paginate = 25;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products_query = Product::query();
        $route_name = 'product.index'; // for dynamic search

        // search by package name
        if (request('name')) {
            $products_query->where('name', 'like', '%' . request('name') . '%');
        }

        // get all products data
        $products = $products_query->with('stock')->paginate($this->paginate);

        return view('admin.product.index', compact('products', 'route_name'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.product.create');
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
            'name'                      => 'required|string',
            'model'                     => 'nullable|string',
            'purchase_price'            => 'required|numeric',
            'sale_price'                => 'required|numeric',
            'stock_alert'               => 'nullable|numeric',
            'description'               => 'nullable',
        ]);

      DB::transaction(function () use($request,$data) {
            $data['stock_alert'] = $request->stock_alert ?? 0.00;

            // insert
            $product = Product::create($data);

            $product_id = $product->id;

            Stock::create([
                'product_id'                => $product_id,
                'quantity'                  => 0,
                'purchase_price'            => $product->purchase_price,
            ]);
      });

        // view
        return redirect()->back()->withSuccess('Product create successfully.');
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
        $product = Product::findOrFail($id);
        // view
        return view('admin.product.show', compact('product'));
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
        $product = Product::findOrFail($id);
        // view
        return view('admin.product.edit', compact('product'));
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

        // validation
        $data = $request->validate([
            'name'                      => 'required|string',
            'model'                     => 'nullable|string',
            'purchase_price'            => 'required|numeric',
            'sale_price'                => 'required|numeric',
            'stock_alert'               => 'nullable|numeric',
            'description'               => 'nullable',
        ]);

        DB::transaction(function () use ($request, $data,$id) {
            // get the specified resource
            $product = Product::findOrFail($id);

            $data['stock_alert'] = $request->stock_alert ?? 0.00;

            // update
            $product->update($data);

        });

        // view with message
        return redirect()->route('product.index')->with('success', 'Product updated successfully.');
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
        $product = Product::findOrFail($id);

        // view with message and delete
        if ($product->delete()) {
            return redirect()->route('product.index')->withSuccess('Product deleted successfully.');
        } else {
            return back()->withErrors('Failed to delete product.');
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
        $products_query = Product::query();
        $route_name = 'product.trash'; // for dynamic search

        // search by product name
        if (request('name')) {
            $products_query->where('name', 'like', '%' . request('name') . '%');
        }

        // get all products data
        $products = $products_query->onlyTrashed()->paginate($this->paginate);

        return view('admin.product.trash', compact('products', 'route_name'));
    }

    /**
     *
     */
    public function restore($id)
    {
        // restore by id
        Product::withTrashed()->find($id)->restore();

        // view
        return redirect()->back()->withSuccess('Product restore successfully.');
    }

    /**
     *
     */
    public function permanentDelete($id)
    {
        // Permanent delete by id
        Product::withTrashed()->find($id)->forceDelete();

        // view
        return redirect()->back()->withSuccess('Product deleted permanently.');
    }

    /**
     *
     */
    public function restoreOrDelete(Request $request)
    {
        if ($request->products != null) {
            if ($request->restore) {
                foreach ($request->products as $product) {
                    Product::withTrashed()->find($product)->restore();
                }

                // view
                return redirect()->back()->withSuccess('Products restored successfully.');
            } else {
                foreach ($request->products as $product) {
                    Product::withTrashed()->find($product)->forceDelete();
                }

                // view
                return redirect()->back()->withSuccess('Products deleted permanently.');
            }
        }

        return back()->withErrors('No products has been selected.');
    }
}
