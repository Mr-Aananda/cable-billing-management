@section('title', 'Edit product')

<x-app-layout>
    <!-- Start Menu-->
    <div class="widget mt-3">
        <div class="widget-body">

            <div class="d-flex align-items-center flex-wrap">
                <nav aria-label="breadcrumb">
                    {{ Breadcrumbs::render('product edit',$product) }}
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
                        <h4 class="main-title">Edit old product</h4>
                        <p><small>Can edit <strong>product</strong> from here.</small></p>
                    </div>
                </div>

            </div>
            <div class="widget-body">

                <form action="{{ route('product.update', $product->id) }}" method="POST">
                      @csrf
                      @method('PATCH')

                     <!-- Product name start -->
                    <div class="mb-3 row">
                        <div class="col-2">
                            <label for="name" class="mt-1 form-label required">Product name</label>
                        </div>

                        <div class="col-5">
                            <input type="text" name="name" value="{{ old('name',$product->name)}}" class="form-control @error('name') is-invalid @enderror"  id="name" placeholder="Characters only" required>

                            <!-- error -->
                            @error('name')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                    </div>
                     <!-- Product name end -->

                    <!-- Product model start -->
                    <div class="mb-3 row">
                        <div class="col-2">
                            <label for="model" class="mt-1 form-label">Model</label>
                        </div>

                        <div class="col-5">
                            <input type="text" name="model" value="{{ old('model',$product->model)}}" class="form-control @error('model') is-invalid @enderror"  id="model" placeholder="Enter model">

                            <!-- error -->
                            @error('model')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                    </div>
                     <!-- Product model end -->

                    <!-- Product purchase price start -->
                    <div class="mb-3 row">
                        <div class="col-2">
                            <label for="purchase-price" class="mt-1 form-label required">Purchase price</label>
                        </div>

                        <div class="col-5">
                            <input type="number" name="purchase_price" value="{{ old('purchase_price',$product->purchase_price)}}" class="form-control @error('purchase_price') is-invalid @enderror"  id="purchase-price" min="0" placeholder="0.00" required>

                            <!-- error -->
                            @error('purchase_price')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                    </div>
                    <!-- Product purchase price end -->

                     <!-- Product sale price start -->
                    <div class="mb-3 row">
                        <div class="col-2">
                            <label for="sale-price" class="mt-1 form-label required">Sale price</label>
                        </div>

                        <div class="col-5">
                            <input type="number" name="sale_price" value="{{ old('sale_price',$product->sale_price)}}" class="form-control @error('sale_price') is-invalid @enderror"  id="sale-price" min="0" placeholder="0.00" required>

                            <!-- error -->
                            @error('sale_price')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                    </div>
                    <!-- Product sale price end -->

                    <!-- Product stock alert start -->
                    <div class="mb-3 row">
                        <div class="col-2">
                            <label for="stock-alert" class="mt-1 form-label">Stock alert</label>
                        </div>

                        <div class="col-5">
                            <input type="number" name="stock_alert" value="{{ old('stock_alert',$product->stock_alert)}}" class="form-control @error('stock_alert') is-invalid @enderror"  id="stock-alert" min="0" placeholder="0.00">

                            <!-- error -->
                            @error('stock_alert')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                    </div>
                    <!-- Product stock alert end -->

                    <!-- Product description start -->
                    <div class="mb-3 row">
                        <div class="col-2">
                            <label for="description" class="mt-1 form-label">Discription</label>
                        </div>

                        <div class="col-5">
                            <textarea name="description" class="form-control @error('description') is-invalid @enderror" id="description" rows="3"
                                placeholder="Optional">{{ old('description',$product->description)}}</textarea>

                                <!-- error -->
                            @error('description')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                    </div>
                     <!-- Product description end -->

                     <!--  Buttton start -->
                    <div class="mb-3 row">
                        <div class="col-2">
                            <label class="mt-1 form-label">&nbsp;</label>
                        </div>

                        <div class="col-10">
                            <button type="reset" class="btn btn-warning me-2">
                                <i class="bi bi-trash"></i>
                                <span class="p-1">Reset</span>
                            </button>

                            <button type="submit" class="btn btn-success">
                                <i class="bi bi-check-circle"></i>
                                <span class="p-1">Update</span>
                            </button>
                        </div>
                    </div>
                    <!--  Buttton end -->

                </form>

            </div>
        </div>
    </div>

</x-app-layout>

