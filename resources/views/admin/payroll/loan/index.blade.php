@section('title', 'Loans')

<x-app-layout>
    <!-- Start Menu-->
    <div class="widget mt-3">
        <div class="widget-body">

            <div class="d-flex align-items-center flex-wrap">
                <nav aria-label="breadcrumb">
                    {{ Breadcrumbs::render('all loan') }}
                </nav>
                <div class="ms-md-auto ms-0">

                    {{-- <a href="#search" class="btn btn-sm btn-outline-secondary" title="Search" data-bs-toggle="collapse" role="button" aria-expanded="false">
                        <x-icons.search/>
                    </a> --}}

                    <a href="{{ route('payroll-loan.create') }}" class="btn btn-sm btn-primary" title="Create new">
                        <x-icons.create/>
                    </a>
                    <a href="{{ route('payroll-loan.index') }}" class="btn btn-sm  btn-primary" title="Reload page">
                        <x-icons.refresh/>
                    </a>
                    {{-- <a href="{{ route('loan.trash') }}" class="btn btn-sm btn-primary" title="Trash">
                        <x-icons.trash/>
                    </a> --}}

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
                        <small>About {{count($loans)}} results found</small>

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
                                <th scope="col">Date</th>
                                <th scope="col">Employee name</th>
                                <th scope="col">Phone no</th>
                                <th scope="col">Amount</th>
                                <th scope="col">Paid</th>
                                <th scope="col">Due</th>
                                <th scope="col">Expire date</th>
                                <th scope="col" class="print-none text-end">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($loans as $loan )
                            <tr>
                                <th scope="row">{{ $loans->firstItem() + $loop->index }}.</th>
                                <td>{{ $loan->date->format('d M-Y') }}</td>
                                <td>{{ $loan->employee->name }}</td>
                                <td>{{ $loan->employee->mobile  }}</td>
                                <td>
                                    {{ number_format(abs($loan->amount),2)  }}
                                        <span class="{{ $loan->amount < 0 ? 'text-success' : 'text-danger' }}">
                                            ({{ $loan->amount < 0 ? "Rec" : "Pay" }})
                                        </span>
                                </td>
                                <td>{{ number_format(abs($loan->paid), 2) }}</td>
                                <td class="{{$loan->due > 0 ? 'text-danger' : '' }}">{{ number_format(abs($loan->due), 2) }}</td>
                                <td>{{  $loan->expire_date->format('d M-Y')   }}</td>
                                <td class="print-none text-end">

                                    <a href="{{route('payroll-loan.show',$loan->id)}}" title="View" class="btn btn-sm btn-outline-info">
                                        <x-icons.detail/>
                                    </a>

                                    <a href="{{route('loan.paid', $loan->id)}}" title="View" class="btn btn-sm btn-outline-success {{$loan->due > 0 ? '' : 'disabled' }}">
                                        <x-icons.money/>
                                    </a>

                                    <a href="{{route('payroll-loan.edit',$loan->id)}}" title="Update"  class="btn btn-sm btn-outline-primary">
                                        <x-icons.edit/>
                                    </a>

                                    <a href="#" class="btn btn-sm btn-outline-danger {{ $loan->loan_installments_count > 0 ? 'disabled' : '' }}" title="Trash" onclick="if(confirm('Are you sure want to delete?')) { document.getElementById('loan-delete-{{ $loan->id }}').submit() } return false ">
                                        <x-icons.delete/>
                                    </a>

                                    <form action="{{ route('payroll-loan.destroy', $loan->id) }}" method="post" class="d-none" id="loan-delete-{{ $loan->id }}">
                                        @csrf
                                        @method('DELETE')
                                    </form>
                                </td>
                            </tr>

                            @empty
                            <tr>
                                <th colspan="9">Loan list is empty.</th>
                            </tr>

                            @endforelse

                        </tbody>
                    </table>
                </div>
            <!-- End Table ============================================== -->

             <!-- paginate -->
                <div class="container-fluid mt-3 mb-5">
                    <nav>
                        {{ $loans->withQueryString()->links() }}
                    </nav>
                </div>
                <!-- pagination end -->
      </div>

</x-app-layout>
