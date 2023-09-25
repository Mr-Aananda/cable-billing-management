@section('title', 'Loan details')

<x-app-layout>
    <!-- Start Menu-->
    <div class="widget mt-3">
        <div class="widget-body">

            <div class="d-flex align-items-center flex-wrap">
                <nav aria-label="breadcrumb">
                    {{ Breadcrumbs::render('loan details',$loan) }}
                </nav>

                <div class="ms-md-auto ms-0">

                    <!-- header icon -->

                    <a href="{{ route('payroll-loan.show',$loan->id) }}" class="btn btn-sm  btn-primary" title="Reload page">
                        <x-icons.refresh/>
                    </a>
                    <a href="{{ route('payroll-loan.index') }}" title="Go back" class="print-none btn btn-sm btn-primary ms-auto">
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
                        <h3>Installment details</h3>
                        <small>About {{count($loan->loanInstallments)}} results found</small>
                    </div>
                    <div class="ms-auto print-none">
                        <a type="button" class="btn btn-sm btn-secondary" onclick="printable('print-widget')">
                            <x-icons.print/>
                        </a>
                    </div>
                </div>

            </div>
            <!-- End widget head =========================== -->

            <div class="widget-body">
                <div class="text-muted">
                    <h5 class="mb-2">Employee name : <span class="fw-bold fs-5">{{$loan->employee->name}}</span></h5>
                    <h5 >Mobile no : <span class="fw-bold fs-5">{{$loan->employee->mobile}}</span> </h5>
                </div>
                <h2 class="text-center text-muted print-none">Installments
                        <a href="{{ route('loan.paid', $loan->id) }}" class="btn btn-sm btn-primary {{$loan->due > 0 ? 'disabled' : '' }}" title="Installment">
                        <x-icons.money/>
                    </a>
                </h2>

            <!-- Start Table ============================================== -->

                <div class="table-responsive">
                    <table class="table custom table-hover action-hover sm">
                        <thead>
                            <tr>
                                <th scope="col">SL</th>
                                <th scope="col">Date</th>
                                <th scope="col" class="text-end">Paid</th>
                                <th scope="col" class="print-none text-end">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($loan->loanInstallments as $installment)
                            <tr>
                                <th scope="row">{{ $loop->iteration }}.</th>
                                 <td>{{ $installment->date}}</td>
                                <td class="text-end">{{ number_format($installment->amount, 2) }}</td>
                                <td class="print-none text-end">

                                    <a href="{{route('loan-installment.edit',$installment->id)}}" title="Update"  class="btn btn-sm btn-outline-primary">
                                        <x-icons.edit/>
                                    </a>

                                    <a href="#" class="btn btn-sm btn-outline-danger" title="Trash" onclick="if(confirm('Are you sure want to delete?')) { document.getElementById('installment-delete-{{ $installment->id }}').submit() } return false ">
                                        <x-icons.delete/>
                                    </a>

                                    <form action="{{ route('loan-installment.destroy', $installment->id) }}" method="post" class="d-none" id="installment-delete-{{ $installment->id }}">
                                        @csrf
                                        @method('DELETE')
                                    </form>
                                </td>
                            </tr>

                            @empty
                            <tr>
                                <th colspan="5">Installment list is empty.</th>
                            </tr>

                            @endforelse

                        </tbody>
                         <tfoot>
                            <tr>
                                <th class="text-end" colspan="2">Total </th>
                                <th class="text-end">{{ number_format($loan->loanInstallments->sum('amount'), 2) }}</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            <!-- End Table ============================================== -->
      </div>

</x-app-layout>
