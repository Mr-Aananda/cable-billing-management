@section('title', 'Stock')

<x-app-layout>
   <!-- Start Menu-->
    <div class="widget mt-3">
        <div class="widget-body">

            <div class="d-flex align-items-center flex-wrap">
                <nav aria-label="breadcrumb">
                    {{ Breadcrumbs::render('stock') }}
                </nav>

                <div class="ms-md-auto ms-0">

                    <a href="#search" class="btn btn-sm btn-primary" title="Search" data-bs-toggle="collapse" role="button" aria-expanded="false">
                        <x-icons.search/>
                    </a>
                    <a href="{{ route('stock.index') }}" class="btn btn-sm btn-primary" title="Reload page">
                        <x-icons.refresh/>
                    </a>

                </div>
            </div>

        </div>
    </div>
    <!-- End Menu-->
    @include('admin.stock.search')

    <div class="widget mt-3" id="print-widget">

        <!-- Start print header =========================== -->
        @include('layouts.partials.printHead')
        <!-- End print header =========================== -->

        <!-- Start widget head =========================== -->
        <div class="widget-head">
            <div class="d-flex align-items-center flex-wrap">
                <div>
                    <h3>All records</h3>
                    <small>About {{count($products)}} results found</small>

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

        <!-- Start Table ============================================== -->

            <div class="table-responsive">
                <table class="table custom table-hover action-hover sm table-bordered">
                    <thead>
                        <tr>
                            <th scope="col">SL</th>
                            <th scope="col">Name</th>
                            <th scope="col">Model</th>
                            <th scope="col" class="text-end">Quantity</th>
                            <th scope="col" class="text-end">Purchase price</th>
                            {{-- <th scope="col" class="text-end">Average price</th> --}}
                            <th scope="col" class="text-end">Sale price</th>
                            {{-- <th scope="col" class="text-end">Total purchase price</th> --}}
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($products as $product )
                        <tr>
                            <th scope="row" class="{{$product->quantity <= $product->stock_alert ? 'table-danger':''}}">{{ $products->firstItem() + $loop->index }}.</th>
                            <td class="{{$product->quantity <= $product->stock_alert ? 'table-danger':''}}">{{$product->name}}</td>
                            <td class="{{$product->quantity <= $product->stock_alert ? 'table-danger':''}}">{{$product->model}}</td>
                            <td class="text-end {{$product->quantity <= $product->stock_alert ? 'table-danger':''}}">{{$product->quantity ?? 0}}</td>
                            <td class="text-end {{$product->quantity <= $product->stock_alert ? 'table-danger':''}}">{{$product->purchase_price ?? 0}}</td>
                            {{-- <td class="text-end {{$product->quantity <= $product->stock_alert ? 'table-danger':''}}">{{$product->Average_price ?? 0}}</td> --}}
                            <td class="text-end {{$product->quantity <= $product->stock_alert ? 'table-danger':''}}">{{$product->sale_price ?? 0}}</td>
                            {{-- <td class="fw-bold text-end {{$product->quantity <= $product->stock_alert ? 'table-danger':''}}">{{number_format($product->total_purchase_price ?? 0,2)}}</td> --}}
                        </tr>

                        @empty
                        <tr>
                            <th colspan="5">Stock list is empty.</th>
                        </tr>

                        @endforelse

                    </tbody>
                </table>
            </div>
        <!-- End Table ============================================== -->

            <!-- paginate -->
            <div class="container-fluid mt-3 mb-5">
                <nav>
                    {{ $products->withQueryString()->links() }}
                </nav>
            </div>
            <!-- pagination end -->
    </div>

    @push('styles')

        <link href="https://cdn.jsdelivr.net/npm/tom-select@2.1.0/dist/css/tom-select.css" rel="stylesheet">

    @endpush


    @push('scripts')
       <script src="https://cdn.jsdelivr.net/npm/tom-select@2.1.0/dist/js/tom-select.complete.min.js"></script>

        <script>
            new TomSelect("#select-beast",{
                create: true,
                sortField: {
                    field: "text",
                    direction: "asc"
                }
            });
        </script>
    @endpush

</x-app-layout>
