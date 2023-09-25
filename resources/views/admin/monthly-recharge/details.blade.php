@section('title', 'Customer recharge history')
<x-app-layout>
    <!-- Start Menu-->
    <div class="widget mt-3">
        <div class="widget-body">
            <div class="d-flex align-items-center flex-wrap">
                <nav aria-label="breadcrumb">
                    {{ Breadcrumbs::render('customer recharge details',$package_customer) }}
                </nav>
                <div class="ms-md-auto ms-0 btn-group">
                    <a href="{{ route('monthly-recharge.index') }}" title="Go back" class="print-none btn btn-sm btn-primary ms-auto">
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
                        <h4 class="main-title">Customer recharge history</h4>
                        <p><small>All the details below.</small></p>
                    </div>
                </div>
            </div>

            <div class="widget-body">
                <div class="row">
                    <div class="col-md-5">
                        <fieldset>
                            <legend class="text-muted">
                                Customer Details
                            </legend>
                            <dl class="mb-1 row">
                                <dt class="col-sm-4 fw-normal">Customer name: </dt>
                                <dd class="col-sm-6 text-muted">
                                    <p>
                                        <span class="fw-bold">{{ $package_customer->customer->name ?? '' }}</span>
                                    </p>
                                </dd>
                            </dl>
                            <dl class="mb-1 row">
                                <dt class="col-sm-4 fw-normal">Cable ID: </dt>
                                <dd class="col-sm-6 text-muted">
                                    <p class="fw-bold">{{ $package_customer->cable_id ?? '' }}</p>
                                </dd>
                            </dl>

                            <dl class="mb-1 row">
                                <dt class="col-sm-4 fw-normal">Mobile no: </dt>
                                <dd class="col-sm-6 text-muted">
                                    <p class="fw-bold">{{ $package_customer->customer->mobile_no  ?? '' }}</p>
                                </dd>
                            </dl>
                            <dl class="mb-1 row">
                                <dt class="col-sm-4 fw-normal">Area name: </dt>
                                <dd class="col-sm-6 text-muted">
                                    <p class="fw-bold">{{ $package_customer->customer->area->name  ?? '' }}</p>
                                </dd>
                            </dl>
                        </fieldset>
                    </div>

                    <div class="col-md-5">
                        <fieldset>
                            <legend class="text-muted">
                                Rechage details
                            </legend>
                             <dl class="mb-1 row">
                                <dt class="col-sm-4 fw-normal">Package name: </dt>
                                <dd class="col-sm-6 text-muted">
                                    <p class="fw-bold">{{ $package_customer->package->name  ?? '' }}</p>
                                </dd>
                            </dl>
                            <dl class="mb-1 row">
                                <dt class="col-sm-4 fw-normal">Status: </dt>
                                {{-- <dd class="col-sm-6 text-muted">
                                    @if($package_customer->status == 'active')
                                        <span class="badge bg-success">{{ ucwords($package_customer->status) }}</span>
                                    @elseif($package_customer->status == 'inactive')
                                        <span class="badge bg-danger">{{ ucwords($package_customer->status) }}</span>
                                    @elseif($package_customer->status == 'disconnected')
                                        <span class="badge bg-secondary">{{ ucwords($package_customer->status) }}</span>
                                    @else
                                        No Package
                                    @endif
                                </dd> --}}
                                <dd class="col-sm-6 text-muted">
                                    @if($package_customer->expire_date >= date('Y-m-d'))
                                        <span class="badge bg-success">Active</span>
                                    @elseif($package_customer->expire_date < date('Y-m-d'))
                                        <span class="badge bg-danger">Inactive</span>
                                    @elseif($package_customer->expire_date == null)
                                        <span class="badge bg-secondary">Disconnected</span>
                                    @else
                                        No Package
                                    @endif
                                </dd>
                            </dl>
                            <dl class="mb-1 row">
                                @php
                                    $date1 = new DateTime($package_customer->active_date);
                                    $date2 = new DateTime($package_customer->expire_date);
                                    $today = new DateTime();

                                   $daysLeft = $today->diff($date2);

                                @endphp
                                <dt class="col-sm-4 fw-normal">Active days left: </dt>
                                <dd class="col-sm-6 text-muted">
                                    <p>
                                        <span class="fw-bold {{$date2 >= $today ? "text-success" : "text-danger"}}">{{ $date2 >= $today ? $daysLeft->format("%a days") : "0 days"}}</span>
                                    </p>
                                </dd>
                            </dl>

                            <dl class="mb-1 row">
                                <dt class="col-sm-4 fw-normal">Last recharge date: </dt>
                                <dd class="col-sm-6 text-muted">
                                    <p class="fw-bold">{{ $package_customer->active_date ? $package_customer->active_date->format("F j, Y") : $package_customer->date->format("F j, Y")}}</p>
                                </dd>
                            </dl>

                            <dl class="mb-1 row">
                                <dt class="col-sm-4 fw-normal">Expired date: </dt>
                                <dd class="col-sm-6 text-muted">
                                    <p class="fw-bold">{{ $package_customer->expire_date ? $package_customer->expire_date->format("F j, Y") : '' }} </p>
                                </dd>
                            </dl>
                        </fieldset>
                    </div>

                </div>

            </div>
        </div>
    </div>
</x-app-layout>

