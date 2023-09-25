<?php

namespace App\Http\Controllers\Main;

use App\Http\Controllers\Controller;
use App\Models\Area;
use App\Models\Cash;
use App\Models\Customer;
use App\Models\Package;
use App\Models\Product;
use App\Models\Sale;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class SaleController extends Controller
{
    private $paginate = 25;
    private $sale;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $sales_query = Sale::query();

        $route_name = 'sale.index'; // for dynamic search

        $customers = Customer::orderBy('name')->get();

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
                    $sales_query = $sales_query->whereBetween('date', $date);
                }
            }
        }

        if (request('name')) {
            $sales_query->whereHas('customer', function ($query) {
                $query->where('name', 'like', '%' . request('name') . '%');
            });
        }

        if (request('mobile_no')) {
            $sales_query->whereHas('customer', function ($query) {
                $query->where('mobile_no',  request('mobile_no'));
            });
        }

        if(request('cable_id')){
            $sales_query->where('cable_id', 'like', '%' . request('cable_id') . '%');
        }


    //  $sales = $sales_query->with('customer', 'products', 'payments')->latest()->paginate($this->paginate);
        $sales = $sales_query->with('customer', 'products')->whereNot('subtotal',0)->latest()->paginate($this->paginate);

        return view('admin.sale.index', compact('sales', 'route_name', 'customers'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $packages = Package::all();
        $products = Product::with('stock')->get();
        $customers = Customer::all();
        $discountTypes = config('cable.discountType');
        $areas = Area::all();
        $cashes = Cash::all();

        return view('admin.sale.create',compact('packages','products', 'customers', 'discountTypes', 'areas', 'cashes'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // return $request->all();

        // validation
       $request->validate([
            'date'                => 'required|date',
            'expire_date'         => $request->package_id ? 'required|date': 'nullable|date',
            'cable_id'            => 'required|string|unique:sales,cable_id',
            'package_id'          => 'nullable|integer',
            'name'                => 'nullable|string',
            'mobile_no'           => 'nullable|string|unique:customers,mobile_no',
            'balance'             => 'nullable|numeric',
            'area_id'             => 'nullable|integer',
            'subtotal'            => 'required|numeric',
            'discount'            => 'nullable|numeric',
            'discount_type'       => 'nullable|string',
            'payment_type'        => 'required|string',
            'total_paid'          => 'required|numeric|min:0',
            'due'                 => 'required|numeric',
            'cash_id'             => 'nullable|integer',
            'previous_balance'    => 'nullable|numeric',
            'note'                => 'nullable|string',
        ]);

        DB::transaction(function () use($request) {

            if ($request->oldOrNewCustomer == 'oldCustomer') {
                $customer = Customer::find($request->customer_id);
            } else {
                $customer = Customer::create([
                    'name'          => $request->name,
                    'mobile_no'     => $request->mobile_no,
                    'area_id'       => $request->area_id,
                    'address'       => $request->address,
                ]);
            }
            $customer_id = $customer->id;

            //Balance Payable or Recieveable maintain start
            $previous_balance = 0;
            if ($request->balance_status) {
                $previous_balance = $request->previous_balance;
            } else {
                $previous_balance = (-1 * $request->previous_balance);
            }
            //Balance Payable or Recieveable maintain end

            // dd($data['previous_balance']);

            // Conditionally assign the value for the status field
            if ($request->package_id) {

                $status = $request->date <= $request->expire_date ? 'active' : 'inactive';

                if (date('Y-m-d') > $request->expire_date) {
                    $status = 'inactive';
                }
            } else {
                $status = null;
            }

                $this->sale = Sale::create([
                    'customer_id'       => $customer_id,
                    'date'              => $request->date,
                    'cable_id'          => $request->cable_id,
                    'invoice_no'        => 'Invoice-' . str_pad(Sale::max('id') + 1, 8, 0, STR_PAD_LEFT) ?? null,
                    //If pacakge is availabe
                    'package_id'        => $request->package_id ?? null,
                    'active_date'       => $request->package_id ? $request->date : null,
                    // 'expire_date'       => $request->package_id ?$expire_date : null,
                    'expire_date'       => $request->package_id ? $request->expire_date : null,
                    //If pacakge is availabe
                    'subtotal'          => $request->subtotal ? $request->subtotal : 0,
                    'discount'          => $request->discount ? $request->discount : 0,
                    'discount_type'     => $request->discount_type,
                    'payment_type'      => $request->payment_type,
                    'total_paid'        => $request->total_paid ? $request->total_paid : 0,
                    'due'               => $request->due ? $request->due : 0,
                    'previous_balance'  => $previous_balance,
                    'cash_id'           => $request->cash_id,
                    'status'            => $request->package_id ? $status : null,
                    'user_id'           => Auth::id(),
                    'note'              => $request->note,
                ]);

            $sale = $this->sale;

            //Update customer balance
            $this->updateCustomerBalance($request, $customer);
            //update Main cash
            $this->cashUpdate($request);

            //Validation for product
            $request->validate([
                'product_ids'           => 'nullable|array',
                'product_id.*'          => 'bail|required|integer|exists:products,id',
                'quantities'            => 'nullable|array',
                'quantity.*'            => 'bail|required|numeric|min:0',
                'qty_types'             => 'nullable|array',
                'qty_type.*'            => 'bail|required|string',
                'sale_prices'           => 'nullable|array',
                'sale_price.*'          => 'bail|required|numeric|min:0',
                'old_purchase_prices'   => 'nullable|array',
                'old_purchase_price.*'  => 'bail|required|numeric|min:0',
            ]);

            //update stock
            $this->updateStock($request);

            // Insert Product
          if ($request->product_ids != null) {
                $final_array = [];
                for ($i = 0; $i < count($request->product_ids); $i++) {
                    $product = Product::find($request->product_ids[$i]);
                    $final_array[$request->product_ids[$i]] = [
                        'sale_price'    => $request->sale_prices[$i],
                        'purchase_price'=> $request->old_purchase_prices[$i],
                        'quantity'      => $request->quantities[$i],
                        'qty_type'      => $request->qty_types[$i],
                        'created_at'     => now(),
                        'updated_at'     => now(),
                    ];
                }

                $sale->products()->attach($final_array);
          }

        });
        // view
        if ($this->sale) {
            return redirect()->route('sale.show',$this->sale->id);
        } else {
            return back()->withErrors('Failed to create sale.');
        }
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

        $sale = Sale::with('productSales')->findOrFail($id);
        // view
        return view('admin.sale.show', compact('sale'));
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
         $sale = Sale::with('customer','productSales.product')->findOrFail($id);

        // return $products = $sale->productSales;

        $packages = Package::all();
        $products = Product::with('stock')->get();
        $customers = Customer::all();
        $discountTypes = config('cable.discountType');
        $areas = Area::all();
        $cashes = Cash::all();
        return view('admin.sale.edit', compact('packages', 'products', 'customers', 'discountTypes', 'areas', 'cashes', 'sale'));
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
        // return $request->all();
        // get the specified resource
         $oldSale = Sale::findOrFail($id);
          // validation
        $request->validate([
            'date'                => 'required|date',
            'expire_date'         => $request->package_id ? 'required|date': 'nullable|date',
            'cable_id'            => 'required|string|unique:sales,cable_id,'.$id,
            'package_id'          => 'nullable|integer',
            'name'                => 'nullable|string',
            'mobile_no'           => 'nullable|string|unique:customers,mobile_no,'. $oldSale->customer_id,
            'balance'             => 'nullable|numeric',
            'area_id'             => 'nullable|integer',
            'subtotal'            => 'required|numeric',
            'discount'            => 'nullable|numeric',
            'discount_type'       => 'nullable|string',
            'payment_type'        => 'required|string',
            'total_paid'          => 'required|numeric|min:0',
            'due'                 => 'required|numeric',
            'cash_id'             => 'nullable|integer',
            'previous_balance'    => 'nullable|numeric',
            'note'                => 'nullable|string',
        ]);

        DB::transaction(function () use($request, $oldSale) {

            // <!-- update previous record -->
            $this->oldCashUpdate($oldSale);
            $this->updateOldCustomerBalance($oldSale);
            $this->UpdateOldStock($oldSale);
            // <!-- update previous record -->

            if ($request->oldOrNewCustomer == 'oldCustomer') {
                $customer = Customer::find($request->customer_id);
            } else {
                $customer = Customer::firstOrCreate([
                    'name'          => $request->name,
                    'mobile_no'     => $request->mobile_no,
                    'area_id'       => $request->area_id,
                    'address'       => $request->address,
                ]);
            }
            $customer_id = $customer->id;

            $previous_balance = 0;
            if ($request->balance_status) {
                $previous_balance = $request->previous_balance;
            } else {
                $previous_balance = (-1 * $request->previous_balance);
            }

            // Conditionally assign the value for the status field
            if ($request->package_id) {

                $status = $request->date <= $request->expire_date ? 'active' : 'inactive';

                if (date('Y-m-d') > $request->expire_date) {
                    $status = 'inactive';
                }
            } else {
                $status = null;
            }


                $oldSale->update([
                    'customer_id'       => $customer_id,
                    'date'              => $request->date,
                    'cable_id'          => $request->cable_id,
                    'invoice_no'        => 'Invoice-' . str_pad(Sale::max('id') + 1, 8, 0, STR_PAD_LEFT) ?? null,
                    //If pacakge is availabe
                    'package_id'        => $request->package_id ?? null,
                    'active_date'       => $request->package_id ? $request->date : null,
                    // 'expire_date'       => $request->package_id ? $expire_date : null,
                    'expire_date'       => $request->package_id ? $request->expire_date : null,
                    //If pacakge is availabe
                    'subtotal'          => $request->subtotal ? $request->subtotal : 0,
                    'discount'          => $request->discount ? $request->discount : 0,
                    'discount_type'     => $request->discount_type,
                    'payment_type'      => $request->payment_type,
                    'total_paid'        => $request->total_paid ? $request->total_paid : 0,
                    'due'               => $request->due ? $request->due : 0,
                    'previous_balance'  => $previous_balance,
                    'cash_id'           => $request->cash_id,
                    'status'            => $request->package_id ? $status : null,
                    'user_id'           => Auth::id(),
                    'note'              => $request->note,
                ]);

            $this->sale = $oldSale;

            //Update customer balance
            $this->updateCustomerBalance($request, $customer);
            //update main cash
            $this->cashUpdate($request);

            //Validation for product
            $request->validate([
                'product_ids'           => 'nullable|array',
                'product_id.*'          => 'bail|required|integer|exists:products,id',
                'quantities'            => 'nullable|array',
                'quantity.*'            => 'bail|required|numeric|min:0',
                'qty_types'             => 'nullable|array',
                'qty_type.*'            => 'bail|required|string',
                'sale_prices'           => 'nullable|array',
                'sale_price.*'          => 'bail|required|numeric|min:0',
                'old_purchase_prices'   => 'nullable|array',
                'old_purchase_price.*'  => 'bail|required|numeric|min:0',
            ]);

            //update stock
            $this->updateStock($request);

          if ($request->product_ids != null) {
                $final_array = [];
                for ($i = 0; $i < count($request->product_ids); $i++) {
                    $product = Product::find($request->product_ids[$i]);
                    $final_array[$request->product_ids[$i]] = [
                        'sale_price'    => $request->sale_prices[$i],
                        'purchase_price'=> $request->old_purchase_prices[$i],
                        'quantity'      => $request->quantities[$i],
                        'qty_type'      => $request->qty_types[$i],
                        'created_at'     => now(),
                        'updated_at'     => now(),
                    ];
                }
                // dd($oldSale);
                $oldSale->products()->sync($final_array);

          }
        });
        // view
        if ($this->sale) {
            return redirect()->route('sale.show', $this->sale->id);
        } else {
            return back()->withErrors('Failed to update sale.');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

        // view with message and delete

        DB::transaction(function () use ($id) {
            // get the specified resource
            $oldSale = Sale::findOrFail($id);

            //   <!-- update previous record -->
            $this->oldCashUpdate($oldSale);
            $this->updateOldCustomerBalance($oldSale);
            $this->UpdateOldStock($oldSale);
            //  <!-- update previous record -->

            $this->sale = $oldSale->delete();
        });

        if ($this->sale) {
            return redirect()->back()->withSuccess('Sale deleted successfully.');
        } else {
            return back()->withErrors('Failed to delete sale.');
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
        $sales_query = Sale::query();

        $route_name = 'sale.trash'; // for dynamic search

        $customers = Customer::orderBy('name')->get();

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
                    $sales_query = $sales_query->whereBetween('date', $date);
                }
            }
        }

        if (request('name')) {
            $sales_query->whereHas('customer', function ($query) {
                $query->where('name', 'like', '%' . request('name') . '%');
            });
        }

        if (request('mobile_no')) {
            $sales_query->whereHas('customer', function ($query) {
                $query->where('mobile_no',  request('mobile_no'));
            });
        }

        if (request('cable_id')) {
            $sales_query->where('cable_id', 'like', '%' . request('cable_id') . '%');
        }


        $sales = $sales_query->onlyTrashed()->paginate($this->paginate);

        return view('admin.sale.trash', compact('sales', 'route_name', 'customers'));
    }

    /**
     *
     */
    public function restore($id)
    {
        // restore by id
        Sale::withTrashed()->find($id)->restore();

        // view
        return redirect()->back()->withSuccess('Sale restore successfully.');
    }

    /**
     *
     */
    public function permanentDelete($id)
    {
        // Permanent delete by id
        Sale::withTrashed()->find($id)->forceDelete();

        // view
        return redirect()->back()->withSuccess('Sale deleted permanently.');
    }

    /**
     *
     */
    public function restoreOrDelete(Request $request)
    {
        if ($request->sales != null) {
            if ($request->restore) {
                foreach ($request->sales as $sale) {
                    Sale::withTrashed()->find($sale)->restore();
                }

                // view
                return redirect()->back()->withSuccess('Sales restored successfully.');
            } else {
                foreach ($request->sales as $sale) {
                    Sale::withTrashed()->find($sale)->forceDelete();
                }

                // view
                return redirect()->back()->withSuccess('Sales deleted permanently.');
            }
        }

        return back()->withErrors('No sale has been selected.');
    }




    /**
     * update customer balance when sale create or delete
     * @param $request
     * @param $customer
     * @return void
     */
    public function updateCustomerBalance($request, $customer)
    {
        if ($request->due) {
            $customer->balance = $request->due;
        }
        $customer->save();
    }

    /**
     * update cash or bank balance when sale create or update
     * @param $request
     * @return void
     */
    public function cashUpdate($request)
    {
        if ($request->payment_type == 'cash') {
            Cash::findOrFail($request->cash_id)->increment('balance', $request->total_paid);
        }
    }

    /**
     * save purchase details
     * @param $request
     * @param $purchase
     * @return void
     */
    public function updateStock($request)
    {
        if ($request->product_ids != null) {
            // $final_array = [];
            for ($i = 0; $i < count($request->product_ids); $i++) {
                $_product = Product::find($request->product_ids[$i]);


                $oldProduct = $_product->stock->where('purchase_price', $request->old_purchase_prices[$i])->first();
                // dd($oldQuantity);

                if ($oldProduct) {
                    $total_quantity = $oldProduct->quantity - $request->quantities[$i];
                    $oldProduct->update([
                        'quantity' => $total_quantity,
                        // 'purchase_price' => $_product->purchase_price,
                    ]);
                }
            }
        }
    }



    /**
     * update bank or cash balance when sale is deleted or updated
     * @param $sale
     * @return void
     */
    public function oldCashUpdate($sale)
    {
        if ($sale->payment_type == 'cash') {
            $sale->cash()->decrement('balance', $sale->total_paid);
        }
    }

    /**
     * update sale old customer balance when sale update or delete
     * @param $sale
     * @return void
     */
    public function updateOldCustomerBalance($sale)
    {
        $total_due = $sale->grand_total - $sale->total_paid;
        $sale->customer()->decrement('balance', $total_due);
    }



    /**
     * update old purchase quantity in warehouse
     * @param $old_purchase
     * @return void
     */
    public function updateOldStock($oldSale)
    {
        if (count($oldSale->productSales) > 0) {
            foreach ($oldSale->productSales as $productSale) {
                $_quantity = $productSale->quantity;
                // dd($_quantity);

                // get product
                $_product = Product::findOrFail($productSale->product_id);
                // dd($product);

                $oldProduct = $_product->stock->where('purchase_price', $productSale->purchase_price)->first();
                // dd($oldQuantity);

                $previous_quantity = $oldProduct->quantity + $_quantity;

                // dd($previous_quantity);

                $oldProduct->update([
                    'quantity' => $previous_quantity,
                ]);

                $productSale->delete();
            }
        }
    }


}
