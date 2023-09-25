@section('title', 'Advanced salaries')

<x-app-layout>
    <!-- Start Menu-->
    <div class="widget mt-3">
        <div class="widget-body">

            <div class="d-flex align-items-center flex-wrap">
                <nav aria-label="breadcrumb">
                    {{ Breadcrumbs::render('all advanced') }}
                </nav>

                <div class="ms-md-auto ms-0">

                    {{-- <a href="#search" class="btn btn-sm btn-outline-secondary" title="Search" data-bs-toggle="collapse" role="button" aria-expanded="false">
                        <x-icons.search/>
                    </a> --}}

                    <a href="{{ route('payroll-advanced.create') }}" class="btn btn-sm btn-primary" title="Create new">
                        <x-icons.create/>
                    </a>
                    <a href="{{ route('payroll-advanced.index') }}" class="btn btn-sm  btn-primary" title="Reload page">
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
                        <h3>All records</h3>
                        <small>About {{count($employees)}} results found</small>

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
                    <table class="table custom table-hover action-hover sm">
                        <thead>
                            <tr>
                                <th scope="col">SL</th>
                                <th scope="col">Employee name</th>
                                <th scope="col">Phone no</th>
                                <th scope="col" class="text-end">Advanced</th>
                                <th scope="col" class="text-end">Pay</th>
                                <th scope="col" class="print-none text-end">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($employees as $employee )
                            <tr>
                                <th scope="row">{{ $employees->firstItem() + $loop->index }}.</th>
                                    <td>{{ $employee->name }}</td>
                                    <td>{{ $employee->mobile}}</td>
                                    <td class="text-end">{{ number_format($employee->advances->sum('amount'), 2) }}</td>
                                    @php
                                        $total_pay = 0;
                                    @endphp
                                    <td class="text-end">
                                        @foreach($employee->advances as $advance)
                                            @php
                                                $total_pay += $advance->advancePaids->sum('advance_paid_amount')
                                            @endphp
                                        @endforeach

                                        {{ number_format($total_pay, 2) }}
                                    </td>
                                <td class="print-none text-end">

                                    <a href="{{route('payroll-advanced.show',$employee->id)}}" title="View" class="btn btn-sm btn-outline-info">
                                        <x-icons.detail/>
                                    </a>

                                </td>
                            </tr>

                            @empty
                            <tr>
                                <th colspan="6">Advanced salary list is empty.</th>
                            </tr>

                            @endforelse

                        </tbody>
                    </table>
                </div>
            <!-- End Table ============================================== -->

             <!-- paginate -->
                <div class="container-fluid mt-3 mb-5">
                    <nav>
                        {{ $employees->withQueryString()->links() }}
                    </nav>
                </div>
                <!-- pagination end -->
      </div>

</x-app-layout>
