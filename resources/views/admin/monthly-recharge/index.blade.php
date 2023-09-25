@section('title', 'Monthly recharge')

<x-app-layout>
     <!-- Start Menu-->
    <div class="widget mt-3">
        <div class="widget-body">

            <div class="d-flex align-items-center flex-wrap">
                <nav aria-label="breadcrumb">
                    {{ Breadcrumbs::render('all inactive customers') }}
                </nav>

                <div class="ms-md-auto ms-0">
                    <a href="#search" class="btn btn-sm btn-primary" title="Search" data-bs-toggle="collapse" role="button" aria-expanded="false">
                        <x-icons.search/>
                    </a>
                    <a href="{{ route('monthly-recharge.index') }}" class="btn btn-sm btn-primary" title="Reload page">
                        <x-icons.refresh/>
                    </a>

                </div>
            </div>

        </div>
    </div>
    <!-- End Menu-->
    <!-- Start Search-->
    @include('admin.monthly-recharge.search')
    <!-- End Search-->

        <div class="widget mt-3" id="print-widget">

            <!-- Start print header =========================== -->
            @include('layouts.partials.printHead')
            <!-- End print header =========================== -->

            <!-- Start widget head =========================== -->
            <div class="widget-head">
                <div class="d-flex align-items-center flex-wrap">
                    <div>
                        <h3> Customers list</h3>
                        <small>About {{count($package_customers)}} results found</small>
                    </div>
                    <div class="btn-group ms-auto print-none">
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
                                    <th scope="col">Cable ID</th>
                                    <th scope="col">Previous Exp date</th>
                                    <th scope="col">Recharge date</th>
                                    <th scope="col">Expire date</th>
                                    <th scope="col">&nbsp;</th>
                                    <th scope="col" class="print-none text-end">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($package_customers as $package_customer)
                                <form action="{{ route('monthly-recharge.active',$package_customer->id) }}" method="POST">
                                @csrf
                                <tr>
                                    <th scope="row">{{ $package_customers->firstItem() + $loop->index }}.</th>
                                    <td>{{$package_customer->customer?->name}}</td>
                                    <td>{{$package_customer->cable_id}}</td>
                                    <td>{{ $package_customer->expire_date ? $package_customer->expire_date->format('d-M-Y') : '' }}</td>
                                    <td>
                                        <input
                                        type="date"
                                        name="active_date"
                                        {{-- value="{{$package_customer->expire_date >= date('Y-m-d')? $package_customer->expire_date->format('Y-m-d'):date('Y-m-d') }}" --}}
                                        value="{{ date('Y-m-d') }}"
                                        class="form-control"
                                        id="active_date"
                                        {{-- {{$package_customer->expire_date >= date('Y-m-d')? 'readonly' : ""}} --}}
                                        required>
                                    </td>
                                    <td>
                                        <input
                                        type="date"
                                        name="expire_date"
                                        {{-- value="{{ $package_customer->expire_date >= date('Y-m-d')?
                                                $package_customer->expire_date->format('Y-m-d') :
                                                date('Y-m-d', strtotime('+29 days')) }}" --}}
                                        value="{{ $package_customer->expire_date >= date('Y-m-d')?
                                                $package_customer->expire_date->format('Y-m-d'):
                                                 date('Y-m-d', strtotime('+1 month')) }}"
                                        class="form-control" id="expire_date" >
                                    </td>
                                    <td>
                                         <select name="cash_id" class="form-select " id="cash-id" required>
                                            @foreach ($cashes as $cash)
                                                <option value="{{ $cash->id }}">{{ $cash->cash_name }}</option>
                                            @endforeach
                                        </select>

                                    <td class="print-none text-end">
                                        <a href="{{route('monthly-recharge.details',$package_customer->id)}}" target="__blank" title="Details" class="btn btn-sm btn-outline-info">
                                            <x-icons.detail/>
                                        </a>
                                       {{-- @if ($package_customer->status == 'active')
                                         <a href="{{route('monthly-recharge.edit',$package_customer->id)}}" title="Update"  class="btn btn-sm btn-outline-primary">
                                            <x-icons.edit/>
                                        </a>
                                       @endif --}}
                                        @if ($package_customer->expire_date > date('Y-m-d'))
                                         <a href="{{route('monthly-recharge.edit',$package_customer->id)}}" title="Update"  class="btn btn-sm btn-outline-primary">
                                            <x-icons.edit/>
                                        </a>
                                       @endif
                                        <button class="btn btn-sm ms-3 text-decoration-none {{$package_customer->expire_date < date('Y-m-d') ? "btn-danger":"btn-success"}}" title="toActive" onclick="return confirm('Want to change status!')">
                                            <i class="bi bi-arrow-right"></i>
                                            {{$package_customer->expire_date < date('Y-m-d') ? "To Active":"Add recharge"}}
                                        </button>
                                    </td>
                                </tr>
                                </form>

                                    @empty
                                    <tr>
                                        <th colspan="8">Monthly recharge list is empty.</th>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <!-- End Table -->

             <!-- paginate -->
                <div class="container-fluid mt-3 mb-3">
                    <nav>
                        {{-- {{ $package_customers->withQueryString()->links() }} --}}
                        {{ $package_customers->appends(['perPage' => $package_customers->perPage()])->links() }}
                    </nav>
                </div>
            <!-- pagination end -->
        </div>

    @push('scripts')
    @endpush

    @push('styles')

        <link href="https://cdn.jsdelivr.net/npm/tom-select@2.1.0/dist/css/tom-select.css" rel="stylesheet">

    @endpush


    @push('scripts')
       <script src="https://cdn.jsdelivr.net/npm/tom-select@2.1.0/dist/js/tom-select.complete.min.js"></script>

        <script>
            new TomSelect("#select-name",{
                create: true,
                sortField: {
                    field: "text",
                    direction: "asc"
                }
            });
        </script>

        <script>
            new TomSelect("#select-area",{
                create: true,
                sortField: {
                    field: "text",
                    direction: "asc"
                }
            });
        </script>
    @endpush

</x-app-layout>
