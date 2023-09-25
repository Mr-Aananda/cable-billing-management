@section('title', 'Product details')

<x-app-layout>
    <!-- Start Menu-->
    <div class="widget mt-3">
        <div class="widget-body">

            <div class="d-flex align-items-center flex-wrap">
                <nav aria-label="breadcrumb">
                    {{ Breadcrumbs::render('product details',$product) }}
                </nav>

                <div class="ms-md-auto ms-0 btn-group">

                    <!-- header icon -->
                    <a href="{{ route('product.index') }}" title="Go back" class="print-none btn btn-sm btn-primary ms-auto">
                        <x-icons.back/>
                    </a>

                </div>
            </div>

        </div>
    </div>
    <!-- End Menu-->

    <div class="col-md-12">
        <div class="widget mt-3">
            <div class="widget-head">
                <div class="d-flex align-items-center flex-wrap">
                    <div class="mt-0">
                        <h4 class="main-title">Product details</h4>
                        <p><small>All the details below.</small></p>
                    </div>
                </div>

            </div>
            <div class="widget-body">
                <div class="mb-3 row">
                    <div class="col-2">
                        <dt for="name" class="mt-1 form-label">Product name </dt>
                    </div>

                    <div class="col-6">
                        <dd class="fst-italic text-muted fw-bold">{{ $product->name}}</dd>
                    </div>
                </div>

                <div class="mb-3 row">
                    <div class="col-2">
                        <dt for="model" class="mt-1 form-label">Model</dt>
                    </div>

                    <div class="col-6">
                        <dd class="fst-italic text-muted">{{ $product->model ?? "None" }}</dd>
                    </div>
                </div>

                <div class="mb-3 row">
                    <div class="col-2">
                        <dt for="purchase-price" class="mt-1 form-label">Purchase price </dt>
                    </div>

                    <div class="col-6">
                        <dd class="fst-italic text-muted">{{ $product->purchase_price }}</dd>
                    </div>
                </div>

                <div class="mb-3 row">
                    <div class="col-2">
                        <dt for="sale-price" class="mt-1 form-label">Sale price </dt>
                    </div>

                    <div class="col-6">
                        <dd class="fst-italic text-muted">{{ $product->sale_price }}</dd>
                    </div>
                </div>

                  <div class="mb-3 row">
                    <div class="col-2">
                        <dt for="stock-alert" class="mt-1 form-label">Stock alert </dt>
                    </div>

                    <div class="col-6">
                        <dd class="fst-italic text-muted">{{ $product->stock_alert }}</dd>
                    </div>
                </div>

                @if ($product->description !== null)
                <div class="mb-3 row">
                        <div class="col-2">
                            <dt for="description" class="mt-1 form-label">Description </dt>
                        </div>

                        <div class="col-6">
                            <dd class="fst-italic text-muted">{{ $product->description }}</dd>
                        </div>
                </div>
                @endif
            </div>
        </div>
    </div>
    <!-- End basic form with icon ================================ -->

</x-app-layout>

