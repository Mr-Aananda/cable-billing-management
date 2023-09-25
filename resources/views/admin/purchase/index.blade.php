@section('title', 'Purchases')

<x-app-layout>
      <!-- Start Menu-->
    <div class="widget mt-3">
        <div class="widget-body">

            <div class="d-flex align-items-center flex-wrap">
                <nav aria-label="breadcrumb">
                    {{ Breadcrumbs::render('all purchases') }}
                </nav>

                <div class="ms-md-auto ms-0">

                    <a href="#search" class="btn btn-sm btn-primary" title="Search" data-bs-toggle="collapse" role="button" aria-expanded="false">
                        <x-icons.search/>
                    </a>

                    <a href="{{ route('purchase.create') }}" class="btn btn-sm btn-primary" title="Create new">
                        <x-icons.create/>
                    </a>
                    <a href="{{ route('purchase.index') }}" class="btn btn-sm  btn-primary" title="Reload page">
                        <x-icons.refresh/>
                    </a>
                </div>
            </div>

        </div>
    </div>
    <!-- End Menu-->

    @include('admin.purchase.search')

        <div class="widget mt-3" id="print-widget">

            <!-- Start print header =========================== -->
            @include('layouts.partials.printHead')
            <!-- End print header =========================== -->

            <!-- Start widget head =========================== -->
            <div class="widget-head">
                <div class="d-flex align-items-center flex-wrap">
                    <div>
                        <h3>All records</h3>
                        <small>About {{count($purchases)}} results found</small>
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

            <!-- Start Table ============================================== -->

                <div class="table-responsive">
                    <table class="table table-bordered custom table-hover action-hover sm">
                        <thead>
                            <tr>
                                <th scope="col">SL</th>
                                <th scope="col">Date</th>
                                <th scope="col">Voucher no</th>
                                <th scope="col">Supplier name</th>
                                <th scope="col">Mobile no</th>
                                <th scope="col" class="text-end">Total</th>
                                <th scope="col" class="text-end">Paid</th>

                                <th scope="col" class="print-none text-end">Actions</th>
                            </tr>
                        </thead>
                        <tbody>

                            @php
                                $_subtotal= 0;
                                $_grandTotal= 0;
                                $_totalPaid= 0;
                            @endphp

                            @forelse ($purchases as $purchase )
                                @php

                                    $_subtotal      += $purchase->subtotal;
                                    $_grandTotal    += $purchase->grand_total;
                                    $_totalPaid     += $purchase->total_paid;

                                @endphp
                            <tr>
                                <th scope="row">{{ $purchases->firstItem() + $loop->index }}.</th>
                                <td>{{$purchase->date->format('d M , Y')}}</td>
                                <td>{{$purchase->voucher_no}}</td>
                                <td>{{$purchase->supplier->name ?? ""}}</td>
                                <td>{{$purchase->supplier->mobile_no ?? ""}}</td>
                                <td class="text-end">{{number_format($purchase->grand_total,2)}}</td>
                                <td class="text-end">{{number_format($purchase->total_paid,2)}}</td>
                                <td class="print-none text-end">

                                    <a href="{{route('purchase.show',$purchase->id)}}" title="View" class="btn btn-sm btn-outline-info">
                                        <x-icons.receipt/>
                                    </a>

                                    <a href="{{route('purchase.edit',$purchase->id)}}" title="Update"  class="btn btn-sm btn-outline-primary">
                                        <x-icons.edit/>
                                    </a>

                                   <a href="#" class="btn btn-sm btn-outline-danger" title="Trash" onclick="if(confirm('Are you sure want to delete?')) { document.getElementById('purchase-delete-{{ $purchase->id }}').submit() } return false ">
                                        <x-icons.delete/>
                                    </a>

                                    <form action="{{ route('purchase.destroy', $purchase->id) }}" method="post" class="d-none" id="purchase-delete-{{ $purchase->id }}">
                                        @csrf
                                        @method('DELETE')
                                    </form>
                                </td>
                            </tr>

                            @empty
                            <tr>
                                <th colspan="6">Purchases list is empty.</th>
                            </tr>

                            @endforelse

                        </tbody>

                         <tfoot>
                            <tr>
                                <th class="text-end" colspan="5">Total </th>
                                <th class="text-end">{{ number_format ($_grandTotal,2) }} </th>
                                <th class="text-end">{{ number_format ($_totalPaid,2) }} </th>

                                <th colspan="2">&nbsp;</th>
                            </tr>
                        </tfoot>

                    </table>
                </div>
            <!-- End Table ============================================== -->

            <!-- paginate -->
                <div class="container-fluid mt-3 mb-5">
                    <nav>
                        {{ $purchases->withQueryString()->links() }}
                    </nav>
                </div>
            <!-- pagination end -->
      </div>
      @push('styles')

        <link href="https://cdn.jsdelivr.net/npm/tom-select@2.1.0/dist/css/tom-select.css" rel="stylesheet">

    @endpush


    @push('scripts')
       <script src="https://cdn.jsdelivr.net/npm/tom-select@2.1.0/dist/js/tom-select.complete.min.js"></script>

        <script>
            new TomSelect("#select-beast",{
                create: true,
                sortField: {
                    field: "text",
                    direction: "asc"
                }
            });
        </script>
    @endpush

</x-app-layout>
