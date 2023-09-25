@section('title', 'Advanced details')

<x-app-layout>
     <!-- Start Menu-->
    <div class="widget mt-3">
        <div class="widget-body">

            <div class="d-flex align-items-center flex-wrap">
                <nav aria-label="breadcrumb">
                    {{ Breadcrumbs::render('advanced details',$advanced_for_breadcrump) }}
                </nav>

                <div class="ms-md-auto ms-0 print-none">

                    <!-- header icon -->
                     <a href="{{ route('payroll-advanced.index') }}" class="btn btn-sm  btn-primary" title="Reload page">
                        <x-icons.refresh/>
                    </a>

                    {{-- <a href="{{ route('advanced.trash') }}" class="btn btn-sm btn-primary" title="Trash">
                        <x-icons.trash/>
                    </a> --}}
                        <a href="{{ route('payroll-advanced.index') }}" title="Go back" class="btn btn-sm btn-primary ms-auto">
                        <x-icons.back/>
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
                        <h3>Advanced details</h3>
                        <small>About {{count($advance_details)}} results found</small>

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
                <div class="text-muted">
                    <h5 class="mb-2">Employee name : <span class="fw-bold fs-5">{{$employee->name}}</span></h5>
                    <h5 >Mobile no : <span class="fw-bold fs-5">{{$employee->mobile}}</span> </h5>
                </div>

            <!-- Start Table ============================================== -->

                <div class="table-responsive">
                    <table class="table custom table-hover action-hover sm">
                        <thead>
                            <tr>
                                <th scope="col">SL</th>
                                <th scope="col">Date</th>
                                <th scope="col" class="text-end">Advanced</th>
                                <th scope="col" class="text-end">Pay</th>
                                <th scope="col" class="print-none text-end">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                             @php
                                 $total_pay = 0;
                             @endphp
                            @forelse ($advance_details as $advance_detail )
                            <tr>
                                <th scope="row">{{ $loop->iteration }}.</th>
                                <td>{{ $advance_detail->date->format('d M-Y') }}</td>
                                <td class="text-end">{{ number_format($advance_detail->amount, 2) }}</td>
                                <td class="text-end">{{ number_format($advance_detail->advancePaids->sum('advance_paid_amount'), 2) }}</td>
                                @php
                                    $total_pay += $advance_detail->advancePaids->sum('advance_paid_amount');
                                @endphp
                                <td class="print-none text-end">
                                    @if ($advance_detail->is_paid != true)
                                        <a href="{{route('payroll-advanced.edit',$advance_detail->id)}}" title="Update"  class="btn btn-sm btn-outline-primary">
                                            <x-icons.edit/>
                                        </a>

                                        <a href="#" class="btn btn-sm btn-outline-danger" title="Trash" onclick="if(confirm('Are you sure want to delete?')) { document.getElementById('advance_detail-delete-{{ $advance_detail->id }}').submit() } return false ">
                                            <x-icons.delete/>
                                        </a>

                                        <form action="{{ route('payroll-advanced.destroy', $advance_detail->id) }}" method="post" class="d-none" id="advance_detail-delete-{{ $advance_detail->id }}">
                                            @csrf
                                            @method('DELETE')
                                        </form>

                                    @endif
                                </td>
                            </tr>

                            @empty
                            <tr>
                                <th colspan="5">Advanced details list is empty.</th>
                            </tr>

                            @endforelse

                        </tbody>
                         <tfoot>
                            <tr>
                                <th class="text-end" colspan="2">Total </th>
                                <th class="text-end">{{ number_format($advance_details->sum('amount'), 2) }}</th>
                                <th class="text-end">{{ number_format($total_pay, 2) }}</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            <!-- End Table ============================================== -->

             <!-- paginate -->

                <!-- pagination end -->
      </div>

</x-app-layout>
