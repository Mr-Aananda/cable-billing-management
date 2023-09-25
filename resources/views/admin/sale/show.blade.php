@section('title', 'Sale details')

<x-app-layout>
      <!-- Start Menu-->
    <div class="widget mt-3">
        <div class="widget-body">

            <div class="d-flex align-items-center flex-wrap">
                <nav aria-label="breadcrumb">
                    {{ Breadcrumbs::render('sale details',$sale) }}
                </nav>

                <div class="ms-md-auto ms-0">
                    <a href="{{ route('sale.create') }}" class="btn btn-sm btn-primary" title="Create new">
                        <x-icons.create/>
                    </a>
                     <a href="{{ route('sale.show',$sale->id) }}" class="btn btn-sm  btn-primary" title="Reload page">
                          <x-icons.refresh/>
                    </a>
                    <a href="{{route('sale.edit',$sale->id)}}" title="Update"  class="btn btn-sm btn-primary">
                        <x-icons.edit/>
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
                        <h3>Sale Details</h3>
                        {{-- <small>About {{count($sales)}} results found</small> --}}
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
                    <p class="col-4 mb-2"><span style="font-size: larger">Name:</span> {{ $sale->customer->name}}</p>
                    <p class="col-4 mb-2"><span style="font-size: larger">Cable ID:</span> {{ $sale->cable_id}}</p>
                    <p class="col-4 mb-2"><span style="font-size: larger">Mobile:</span> {{ $sale->customer->mobile_no}}</p>
                    <p class="col-4"><span style="font-size: larger">Date:</span> {{ $sale->date->format('d M, Y')}}</p>
                </div>
                <hr>
                <div class="table-responsive">

                    @if ($sale->package)
                    <table class="table table-bordered table-hover sm">
                        <thead>
                            <tr>
                                <th>Package name</th>
                                <th>Months</th>
                                <th scope="col" class="text-end">Price (BDT)</th>
                                <th scope="col" class="text-end">Total (BDT)</th>
                            </tr>

                        </thead>
                        <tbody>
                        @php
                            //calculate month and package price
                            $date1 = \Carbon\Carbon::parse($sale->active_date);
                            $date2 = \Carbon\Carbon::parse($sale->expire_date);
                            $countableMonth = $date2->diffInMonths($date1);
                            $totalPackagePrice = $countableMonth > 0 ?  $countableMonth * $sale->package_price : 1 * $sale->package_price;
                        @endphp
                            <tr>
                                <td>{{$sale->package->name}}</td>
                                <td>{{$countableMonth}}</td>
                                <td class="text-end">{{$sale->package_price}}</td>
                                <td class="text-end">{{number_format($totalPackagePrice,2)}}</td>
                            </tr>

                        </tbody>

                    </table>

                    @endif

                    @if (count($sale->productSales) > 0)
                    <table class="table table-bordered table-hover sm">
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
                            @foreach ($sale->productSales as $product )
                            <tr>
                                <th>{{$loop->index+1}}</th>
                                <td>{{$product->product->name}}</td>
                                <td class="text-end">{{$product->quantity}} ({{$product->qty_type}})</td>
                                <td class="text-end">{{$product->sale_price}}</td>
                                <td class="text-end">{{number_format($product->sale_price * $product->quantity,2)}}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    @endif

                    <table class="table table-bordered  table-hover sm">
                        <tbody>
                             {{-- <tr>
                                <td colspan="3" rowspan="9" class="align-middle"></td>
                            </tr> --}}
                            <tr>
                                <td >Total</td>
                                <td class="text-end">
                                    {{ number_format($sale->total_product_price + ($totalPackagePrice ?? 0),2)}}
                                </td>
                            </tr>
                            <tr>
                                <td>Discount</td>
                                <td class="text-end">
                                    {{ number_format($sale->total_discount,2)}}
                                </td>
                            </tr>
                            <tr>
                                <td>Previous Balance</td>
                                <td class="text-end">
                                    {{ number_format(abs($sale->previous_balance),2)}} {{$sale->previous_balance >= 0 ? '(Rec)':'(Pay)'}}
                                </td>
                            </tr>
                            <tr>
                                <td>Grand Total</td>
                                <td class="text-end">
                                    {{ number_format(($sale->grand_total) - $sale->previous_balance,2) }}
                                </td>
                            </tr>
                            <tr>
                                <td>Paid</td>
                                <td class="text-end">
                                    {{ number_format($sale->total_paid,2) }}
                                </td>
                            </tr>
                            <tr>
                                <td>Due</td>
                                <td class="text-end">
                                    {{ number_format(abs((($sale->grand_total) - $sale->previous_balance) - $sale->total_paid) ,2) }}
                                    {{ (($sale->grand_total) - $sale->previous_balance) - $sale->total_paid >= 0 ? '(Rec)' : '(Pay)' }}
                                </td>
                            </tr>

                        </tbody>

                    </table>
                </div>
            </div>
        </div>

</x-app-layout>
