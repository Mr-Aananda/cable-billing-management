@section('title', 'Customer details')

<x-app-layout>
    <!-- Start Menu-->
    <div class="widget mt-3">
        <div class="widget-body">

            <div class="d-flex align-items-center flex-wrap">
                <nav aria-label="breadcrumb">
                    {{ Breadcrumbs::render('customer details',$customer) }}
                </nav>

                <div class="ms-md-auto ms-0 btn-group">

                    <!-- header icon -->
                    <a href="{{ route('customer.index') }}" title="Go back" class="print-none btn btn-sm btn-primary ms-auto">
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
                        <h4 class="main-title">Customer details</h4>
                        <p><small>All the details below.</small></p>
                    </div>
                </div>

            </div>
           <div class="widget-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3 row">
                            <div class="col-4">
                                <dt for="name" class="mt-1 form-label">Customer created </dt>
                            </div>

                            <div class="col-6">
                                <dd class="fst-italic text-muted fw-bold">{{ $customer->created_at->format("Y-m-d")}}</dd>
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <div class="col-4">
                                <dt for="name" class="mt-1 form-label">Customer name </dt>
                            </div>

                            <div class="col-6">
                                <dd class="fst-italic text-muted fw-bold">{{ $customer->name}}</dd>
                            </div>
                        </div>

                        <div class="mb-3 row">
                            <div class="col-4">
                                <dt for="mobile" class="mt-1 form-label">Mobile no</dt>
                            </div>

                            <div class="col-6">
                                <dd class="fst-italic text-muted">{{ $customer->mobile_no}}</dd>
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <div class="col-4">
                                <dt for="mobile" class="mt-1 form-label">Balance</dt>
                            </div>

                            <div class="col-6">
                                <dd class="fst-italic text-muted">
                                    {{ number_format(abs($customer->balance), 2) }}
                                    <span class="{{ $customer->balance >= 0 ? 'text-success' : 'text-danger' }}">{{ $customer->balance >= 0 ? '(Rec)' : '(Pay)' }}</span>
                                </dd>
                            </div>
                        </div>

                        <div class="mb-3 row">
                            <div class="col-4">
                                <dt for="area" class="mt-1 form-label">Area</dt>
                            </div>

                            <div class="col-6">
                                <dd class="fst-italic text-muted">{{ $customer->area->name ?? "Not found"}}</dd>
                            </div>
                        </div>

                        <div class="mb-3 row">
                            <div class="col-4">
                                <dt for="mobile" class="mt-1 form-label">Cable ID</dt>
                            </div>

                            <div class="col-6">
                                <dd class="fst-italic text-muted fw-bold">
                                    @foreach ($customer->sales as $sale )
                                        <span>{{$sale->cable_id}}</span>
                                    @endforeach
                                </dd>
                            </div>
                        </div>

                        @if ($customer->address !== null)
                        <div class="mb-3 row">
                            <div class="col-4">
                                <dt for="address" class="mt-1 form-label">Address </dt>
                            </div>

                            <div class="col-6">
                                <dd class="fst-italic text-muted">{{ $customer->address }}</dd>
                            </div>
                        </div>
                        @endif

                        @if ($customer->description !== null)
                        <div class="mb-3 row">
                            <div class="col-4">
                                <dt for="description" class="mt-1 form-label">Description </dt>
                            </div>

                            <div class="col-6">
                                <dd class="fst-italic text-muted">{{ $customer->description }}</dd>
                            </div>
                        </div>
                        @endif
                    </div>
                     <div class="col-md-5">
                        <fieldset>
                            <legend class="text-muted">
                                Rechage details
                            </legend>
                            @foreach ($customer->sales as $sale )
                            <dl class="mb-1 row">
                                <dt class="col-sm-4 fw-normal">Package: </dt>
                                <dd class="col-sm-6 text-muted">
                                    <p class="fw-bold">{{ $sale->package->name ?? "No packages take yet"}}</p>
                                </dd>
                            </dl>

                            <dl class="mb-1 row">
                                <dt class="col-sm-4 fw-normal">Status: </dt>
                                <dd class="col-sm-6 text-muted">
                                    @if($sale->status == 'active')
                                        <span class="badge bg-success">{{ ucwords($sale->status) }}</span>
                                    @elseif($sale->status == 'inactive')
                                        <span class="badge bg-danger">{{ ucwords($sale->status) }}</span>
                                    @elseif($sale->status == 'disconnected')
                                        <span class="badge bg-secondary">{{ ucwords($sale->status) }}</span>
                                    @else
                                        No Package
                                    @endif
                                </dd>
                            </dl>
                            <dl class="mb-1 row">
                                @php
                                    $date1 = new DateTime($sale->active_date);
                                    $date2 = new DateTime($sale->expire_date);
                                    $today = new DateTime();

                                    $countableDays = $today->diff($date2);
                                @endphp
                                <dt class="col-sm-4 fw-normal">Active days left: </dt>
                                <dd class="col-sm-6 text-muted">
                                    <p>
                                        <span class="fw-bold {{$date2 > $today ? "text-success" : "text-danger"}}">{{ $date2 > $today ? $countableDays->format("%a days") : "0 days"}}</span>
                                    </p>
                                </dd>
                            </dl>

                            <dl class="mb-1 row">
                                <dt class="col-sm-4 fw-normal">Last recharge date: </dt>
                                <dd class="col-sm-6 text-muted">
                                    <p class="fw-bold">{{ $sale->active_date ? $sale->active_date->format("F j, Y") : $sale->date->format("F j, Y")}}</p>
                                </dd>
                            </dl>

                            <dl class="mb-1 row">
                                <dt class="col-sm-4 fw-normal">Expired date: </dt>
                                <dd class="col-sm-6 text-muted">
                                    <p class="fw-bold">{{ $sale->expire_date ? $sale->expire_date->format("F j, Y") : '' }} </p>
                                </dd>
                            </dl>

                            @endforeach
                        </fieldset>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End basic form with icon ================================ -->

</x-app-layout>

