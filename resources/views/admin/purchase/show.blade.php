@section('title', 'Purchase details')

<x-app-layout>
      <!-- Start Menu-->
    <div class="widget mt-3">
        <div class="widget-body">

            <div class="d-flex align-items-center flex-wrap">
                <nav aria-label="breadcrumb">
                    {{ Breadcrumbs::render('purchase details',$purchase) }}
                </nav>

                <div class="ms-md-auto ms-0">
                    <a href="{{ route('purchase.create') }}" class="btn btn-sm btn-primary" title="Create new">
                        <x-icons.create/>
                    </a>
                    <a href="{{ route('purchase.show', $purchase->id) }}" class="btn btn-sm  btn-primary" title="Reload page">
                        <x-icons.refresh/>
                    </a>
                </div>
            </div>

        </div>
    </div>
    <!-- End Menu-->

        <div class="widget mt-3" id="print-widget">

            <!-- Start print header =========================== -->
            @include('layouts.partials.printHead')
            <!-- End print header =========================== -->

            <!-- Start widget head =========================== -->
            <div class="widget-head">
                <div class="d-flex align-items-center flex-wrap">
                    <div>
                        <h3>Purchase Details</h3>
                        {{-- <small>About {{count($purchases)}} results found</small> --}}
                    </div>
                    <div class="ms-auto print-none">
                        <a type="button" class="btn btn-sm btn-secondary" onclick="printable('print-widget')">
                            <x-icons.print/>
                        </a>
                    </div>
                </div>

            </div>
            <!-- End widget head =========================== -->

            <div class="widget-body">
                <div class="row">
                    <p class="col-4 mb-2"><span style="font-size: larger">Name:</span> {{ $purchase->supplier->name}}</p>
                    <p class="col-4 mb-2"><span style="font-size: larger">Voucher no:</span> {{ $purchase->voucher_no}}</p>
                    <p class="col-4 mb-2"><span style="font-size: larger">Mobile:</span> {{ $purchase->supplier->mobile_no}}</p>
                    <p class="col-4"><span style="font-size: larger">Date:</span> {{ $purchase->date->format('d M, Y')}}</p>
                </div>
                <hr>
                <div class="table-responsive">
                    <table class="table table-bordered custom table-hover action-hover sm">
                        <thead>
                            <tr>
                                <th scope="col">SL</th>
                                <th scope="col">Product name</th>
                                <th scope="col" class="text-end">Quantity</th>
                                <th scope="col" class="text-end">Price (BDT)</th>
                                <th scope="col" class="text-end">Total (BDT)</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($purchase->productPurchases as $product )
                            <tr>
                                <th>{{$loop->index+1}}</th>
                                <td>{{$product->product->name}}</td>
                                <td class="text-end">{{$product->quantity}} ({{$product->qty_type}})</td>
                                <td class="text-end">{{$product->purchase_price}}</td>
                                <td class="text-end">{{number_format($product->purchase_price * $product->quantity,2)}}</td>
                            </tr>
                            @endforeach
                            <tr>
                                <td colspan="3" rowspan="9" class="align-middle"></td>
                            </tr>
                            <tr>
                                <td>Total</td>
                                <td class="text-end">
                                    {{ number_format($purchase->subtotal,2)}}
                                </td>
                            </tr>
                            <tr>
                                <td>Discount</td>
                                <td class="text-end">
                                    {{ number_format($purchase->total_discount,2)}}
                                </td>
                            </tr>
                            <tr>
                                <td>Previous Balance</td>
                                <td class="text-end">
                                    {{ number_format(abs($purchase->previous_balance),2)}} {{$purchase->previous_balance <= 0 ? '(Pay)':'(Rec)'}}
                                </td>
                            </tr>
                            <tr>
                                <td>Grand Total</td>
                                <td class="text-end">
                                    {{ number_format($purchase->grand_total - $purchase->previous_balance,2) }}
                                </td>
                            </tr>
                            <tr>
                                <td>Paid</td>
                                <td class="text-end">
                                    {{ number_format($purchase->total_paid,2) }}
                                </td>
                            </tr>
                            <tr>
                                <td>Due</td>
                                <td class="text-end">
                                    {{ number_format(abs(($purchase->grand_total - $purchase->previous_balance) - $purchase->total_paid) ,2) }}
                                    {{ ($purchase->grand_total - $purchase->previous_balance) - $purchase->total_paid >= 0 ? '(Pay)' : '(Rec)' }}
                                </td>
                            </tr>


                        </tbody>

                    </table>
                </div>
            </div>
        </div>

</x-app-layout>
