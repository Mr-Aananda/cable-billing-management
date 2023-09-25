@section('title', 'Create sale')

<x-app-layout>
     <!-- Start Menu-->
    <div class="widget mt-3">
        <div class="widget-body">

            <div class="d-flex align-items-center flex-wrap">
                <nav aria-label="breadcrumb">
                    {{ Breadcrumbs::render('sale create') }}
                </nav>

                <div class="ms-md-auto ms-0">

                    <!-- header icon -->
                    <a href="{{ route('sale.index') }}" title="Go back" class="print-none btn btn-sm btn-primary ms-auto">
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
                        <h4 class="main-title">Create new sale</h4>
                        <p><small>Can create <strong>sale</strong> from here.</small></p>
                    </div>
                </div>

            </div>
            <div class="widget-body">

                <form action="{{ route('sale.store') }}" method="POST" enctype="multipart/form-data">
                      @csrf
                    <!-- React component start -->
                    <div
                        data-packages = "{{$packages}}"
                        data-products = "{{$products}}"
                        data-customers = "{{$customers}}"
                        data-areas = "{{$areas}}"
                        data-cashes = "{{$cashes}}"
                        data-discount-types="{{ json_encode($discountTypes,true) }}"
                        data-errors="{{ $errors ?? [] }}"
                        data-sale="{{json_encode('')}}"
                        id="sale-create">
                    </div>



                    <!-- Button start -->
                    <div class="mb-3 row">
                        {{-- <div class="col-2">
                            <label class="mt-1 form-label">&nbsp;</label>
                        </div> --}}

                        <div class="col-10">
                            <button type="reset" class="btn btn-warning me-2">
                                <i class="bi bi-trash"></i>
                                <span class="p-1">Reset</span>
                            </button>

                            <button type="submit" class="btn btn-success">
                                <i class="bi bi-check-circle"></i>
                                <span class="p-1">Create & Save</span>
                            </button>
                        </div>
                    </div>
                    <!-- Button end -->
                </form>
            </div>
        </div>
    </div>
</x-app-layout>

