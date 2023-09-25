@section('title', 'Edit sale')

<x-app-layout>
     <!-- Start Menu-->
    <div class="widget mt-3">
        <div class="widget-body">

            <div class="d-flex align-items-center flex-wrap">
                <nav aria-label="breadcrumb">
                    {{ Breadcrumbs::render('sale edit',$sale) }}
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
                        <h4 class="main-title">Edit old sale</h4>
                        <p><small>Can edit <strong>sale</strong> from here.</small></p>
                    </div>
                </div>

            </div>
            <div class="widget-body">

                <form action="{{ route('sale.update', $sale->id) }}" method="POST">
                      @csrf
                      @method('PATCH')

                      <!-- React component start -->
                    <div
                    data-packages = "{{$packages}}"
                    data-products = "{{$products}}"
                    data-customers = "{{$customers}}"
                    data-areas = "{{$areas}}"
                    data-cashes = "{{$cashes}}"
                    data-discount-types="{{ json_encode($discountTypes,true) }}"
                    data-errors="{{ $errors ?? [] }}"
                    data-sale="{{$sale ?? ''}}"
                    data-date="{{$sale->date->format('Y-m-d')}}"
                    data-active-date="{{$sale->active_date ? $sale->active_date->format('Y-m-d'):''}}"
                    data-expire-date="{{$sale->expire_date ? $sale->expire_date->format('Y-m-d'):'' }}"
                    {{-- data-edit-payment-type = "{{$sale->payments[0]->payment_type ?? ""}}"
                    data-edit-total-paid = "{{$sale->payments[0]->total_paid ?? ""}}"
                    data-edit-cash-id = "{{$sale->payments[0]->cash_id ?? ""}}" --}}
                    id="sale-create">

                    </div>


                     <!--  Buttton start -->
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

