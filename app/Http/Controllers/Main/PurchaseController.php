<?php

namespace App\Http\Controllers\Main;

use App\Http\Controllers\Controller;
use App\Models\Cash;
use App\Models\Product;
use App\Models\Purchase;
use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class PurchaseController extends Controller
{
    private $paginate = 25;
    private $purchase;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $purchases_query = Purchase::query();

        $route_name = 'purchase.index'; // for dynamic search

        $suppliers = Supplier::orderBy('name')->get();

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
                    $purchases_query = $purchases_query->whereBetween('date', $date);
                }
            }
        }

        if (request('name')) {
            $purchases_query->whereHas('supplier', function ($query) {
                $query->where('name', 'like', '%' . request('name') . '%');
            });
        }

        if (request('mobile_no')) {
            $purchases_query->whereHas('supplier', function ($query) {
                $query->where('mobile_no',  request('mobile_no'));
            });
        }

        if (request('voucher_no')) {
            $purchases_query->where('voucher_no', 'like', '%' . request('voucher_no') . '%');
        }


        $purchases = $purchases_query->with('supplier', 'products')->latest()->paginate($this->paginate);

        return view('admin.purchase.index', compact('purchases', 'route_name', 'suppliers'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $suppliers = Supplier::all();
        $products = Product::all();
        $discountTypes = config('cable.discountType');
        $cashes = Cash::all();
        return view('admin.purchase.create',compact('suppliers', 'products', 'discountTypes', 'cashes'));
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
        $data = $request->validate([
            'date'                => 'required|date',
            'supplier_id'         => 'required|integer',
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

        DB::transaction(function () use($request,$data) {

            // insert
            $previous_balance = 0;
            if ($request->balance_status) {
                $previous_balance = $request->previous_balance;
            } else {
                $previous_balance = (-1 * $request->previous_balance);
            }

            $totalDue = -1 * $request->due;

            $data['voucher_no'] = 'Voucher'.'-' . str_pad(Purchase::max('id') + 1, 8, '0', STR_PAD_LEFT);
            $data['due'] = $totalDue;
            $data['discount'] = $request->discount?? 0;
            $data['previous_balance'] = $previous_balance;
            $data['user_id'] = Auth::user()->id;

            $this->purchase= Purchase::create($data);

            // get supplier
            $supplier = Supplier::findOrFail($request->supplier_id);

            $purchase = $this->purchase;
            // update supplier balance
            $this->updateSupplierBalance($request,$totalDue, $supplier);
            //Update cash
            $this->cashUpdate($request);

            // validation
             $request->validate([
                    'product_ids'          => 'nullable|array',
                    'product_id.*'         => 'bail|required|integer|exists:products,id',
                    'quantities'           => 'nullable|array',
                    'quantity.*'           => 'bail|required|numeric|min:0',
                    'qty_types'            => 'nullable|array',
                    'qty_type.*'           => 'bail|required|string',
                    'purchase_prices'      => 'nullable|array',
                    'purchase_price.*'     => 'bail|required|numeric|min:0',
                ]);


                //Update or save product details on stock
                $this->saveProductDetailsOnStock($request);

            //Insert products
            if ($request->product_ids != null) {
                $final_array = [];
                for ($i = 0; $i < count($request->product_ids); $i++) {
                    $product = Product::find($request->product_ids[$i]);
                    $final_array[$request->product_ids[$i]] = [
                        'purchase_price' => $request->purchase_prices[$i],
                        'quantity'       => $request->quantities[$i],
                        'qty_type'       => $request->qty_types[$i],
                        'sale_price'     => $product->sale_price ?? 0,
                        'created_at'     => now(),
                        'updated_at'     => now(),
                    ];
                }

                $purchase->products()->attach($final_array);
            }

        });

        // view
        if ($this->purchase) {
            return redirect()->route('purchase.show',$this->purchase->id);
        } else {
            return back()->withErrors('Failed to create purchase.');
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

         $purchase = Purchase::with('productPurchases')->findOrFail($id);
        // view
        return view('admin.purchase.show', compact('purchase'));
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
        $purchase = Purchase::with('supplier', 'productPurchases.product')->findOrFail($id);

        $products = Product::all();
        $suppliers = Supplier::all();
        $discountTypes = config('cable.discountType');
        $cashes = Cash::all();

        return view('admin.purchase.edit', compact( 'products', 'suppliers', 'discountTypes', 'cashes', 'purchase'));
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
        // return $oldPurchase = Purchase::findOrFail($id);

        // validation
        $data = $request->validate([
            'date'                => 'required|date',
            'supplier_id'         => 'required|integer',
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

        DB::transaction(function () use ($request, $data,$id) {

            // get the specified resource
            $oldPurchase = Purchase::findOrFail($id);

            // <!-- update previous record -->
            $this->updateProductDetailsOnStock($oldPurchase);
            $this->oldCashUpdate($oldPurchase);
            $this->updateOldSupplierBalance($oldPurchase);
            // <!-- update previous record -->

            // insert
            $previous_balance = 0;
            if ($request->balance_status) {
                $previous_balance = $request->previous_balance;
            } else {
                $previous_balance = (-1 * $request->previous_balance);
            }

            $totalDue = -1 * $request->due;

            $data['voucher_no'] = 'Voucher' . '-' . str_pad(Purchase::max('id') + 1, 8, '0', STR_PAD_LEFT);
            $data['due'] = $totalDue;
            $data['discount'] = $request->discount ?? 0;
            $data['previous_balance'] = $previous_balance;
            $data['user_id'] = Auth::user()->id;

            //update purchase
            $oldPurchase->update($data);

            // get supplier
            $supplier = Supplier::findOrFail($request->supplier_id);

            $this->updateSupplierBalance($request, $totalDue, $supplier);

            $this->cashUpdate($request);

            $this->purchase= $oldPurchase;

            // validation
            $request->validate([
                'product_ids'          => 'nullable|array',
                'product_id.*'         => 'bail|required|integer|exists:products,id',

                'quantities'           => 'nullable|array',
                'quantity.*'           => 'bail|required|numeric|min:0',

                'qty_types'            => 'nullable|array',
                'qty_type.*'           => 'bail|required|string',

                'purchase_prices'      => 'nullable|array',
                'purchase_price.*'     => 'bail|required|numeric|min:0',
            ]);

            $this->saveProductDetailsOnStock($request,
                $oldPurchase
            );

            //Insert products
            if ($request->product_ids != null) {
                $final_array = [];
                for ($i = 0; $i < count($request->product_ids); $i++) {
                    $product = Product::find($request->product_ids[$i]);
                    $final_array[$request->product_ids[$i]] = [
                        'purchase_price' => $request->purchase_prices[$i],
                        'quantity'       => $request->quantities[$i],
                        'qty_type'       => $request->qty_types[$i],
                        'sale_price'     => $product->sale_price ?? 0,
                        'created_at'     => now(),
                        'updated_at'     => now(),
                    ];
                }

                $oldPurchase->products()->sync($final_array);
            }
        });

        // view
        if ($this->purchase) {
            return redirect()->route('purchase.show',$this->purchase->id);
        } else {
            return back()->withErrors('Failed to update purchase.');
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

        // return $oldPurchase = Purchase::with('productPurchases')->findOrFail($id);

        DB::transaction(function () use ($id) {
            // get the specified resource
            $oldPurchase = Purchase::findOrFail($id);

            //   <!-- update previous record -->
            $this->updateProductDetailsOnStock($oldPurchase);
            $this->oldCashUpdate($oldPurchase);
            $this->updateOldSupplierBalance($oldPurchase);
            //  <!-- update previous record -->

           $oldPurchase->delete();
        });

        return redirect()
            ->back()
            ->with('success', 'Purchase delete successfully');
    }

    /**
     * update supplier balance when purchase create or delete
     * @param $request
     * @param $supplier
     * @return void
     */
    public function updateSupplierBalance($request,$totalDue, $supplier)
    {
        if ($totalDue) {
            $supplier->balance = $totalDue;
        }
        else {
            $supplier->balance = $request->due;
        }
        $supplier->save();
    }

    /**
     * update cash or bank balance for purchase paid amount
     * @param $request
     * @return void
     */
    public function cashUpdate($request)
    {
        if ($request->payment_type === 'cash') {
            Cash::findOrFail($request->cash_id)->decrement('balance', $request->total_paid);
        }
    }

    /**
     * save purchase details
     * @param $request
     * @param $purchase
     * @return void
     */
    public function saveProductDetailsOnStock($request)
    {
        if ($request->product_ids != null) {
            // $final_array = [];
            for ($i = 0; $i < count($request->product_ids); $i++) {
                $_product = Product::find($request->product_ids[$i]);




                    $oldProduct = $_product->stock->where('purchase_price', $request->purchase_prices[$i])->first();
                    // dd($oldQuantity);

                    if($oldProduct) {
                        $total_quantity = $oldProduct->quantity + $request->quantities[$i];
                        $oldProduct->update([
                            'quantity' => $total_quantity,
                            // 'purchase_price' => $_product->purchase_price,
                        ]);
                    }else{
                        $_product->stock()->create([
                            'quantity'          => $request->quantities[$i],
                            'purchase_price'    => $request->purchase_prices[$i],
                        ]);

                    }


                //update previous purchase price in product start
                $product_data = [
                    'purchase_price' => $request->purchase_prices[$i]
                ];
                $_product->update($product_data);



                //update previous purchase price in product end

                // //get exists quantity
                // $previous_quantity = $_product->stock->quantity;
                // // dd($previous_quantity);
                // // get total quantity
                // $_total_quantity = $_product->stock->quantity + $request->quantities[$i];
                // // dd($_total_quantity);
                // // get percentage of previous quantity
                // $percentage_of_previous_quantity = ($previous_quantity * 100) / $_total_quantity;
                // // dd($percentage_of_previous_quantity);
                // // get percentage of present quantity
                // $percentage_of_present_quantity = ($request->quantities[$i] * 100) / $_total_quantity;
                // // dd($percentage_of_present_quantity);

                // // get previous stock percentage price
                // $previous_average_purchase_price = $percentage_of_previous_quantity * ($_product->stock->average_purchase_price / 100);

                // // get present stock percentage price
                // $present_average_purchase_price = $percentage_of_present_quantity * ($request->purchase_prices[$i] / 100);

                // // total quantity purchase price
                // $total_price = $previous_average_purchase_price + $present_average_purchase_price;
                // // dd($total_price);

                // $_product->stock()->update([
                //     'quantity' => $previous_quantity + $request->quantities[$i],
                //     'average_purchase_price' => $total_price,
                // ]);
            }
        }

    }




    /**
     * update bank or cash balance when sale is deleted or updated
     * @param $sale
     * @return void
     */
    public function oldCashUpdate($purchase)
    {
        if ($purchase->payment_type == 'cash') {
            $purchase->cash()->increment('balance', $purchase->total_paid);
        }
    }

    /**
     * update sale old customer balance when sale update or delete
     * @param $sale
     * @return void
     */
    public function updateOldSupplierBalance($purchase)
    {
        $total_due = $purchase->grand_total - $purchase->total_paid;
        $purchase->supplier()->increment('balance', $total_due);
    }


    /**
     * update old purchase quantity in warehouse
     * @param $old_purchase
     * @return void
     */
    public function updateProductDetailsOnStock($oldPurchase)
    {
        if (count($oldPurchase->productPurchases) > 0) {
            foreach ($oldPurchase->productPurchases as $productPurchase) {
                $_quantity = $productPurchase->quantity;
                // dd($_quantity);

                // get product
                $_product = Product::findOrFail($productPurchase->product_id);
                // dd($product);

                $oldProduct = $_product->stock->where('purchase_price', $productPurchase->purchase_price)->first();
                // dd($oldQuantity);

                $previous_quantity = $oldProduct->quantity - $_quantity;

                // dd($previous_quantity);

                $oldProduct->update([
                    'quantity' => $previous_quantity,
                ]);

                $productPurchase->delete();

            }
        }

    }

}
