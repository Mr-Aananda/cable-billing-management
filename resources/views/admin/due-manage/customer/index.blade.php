@section('title', 'Customer due manage')

<x-app-layout>

    <!-- Start Menu-->
    <div class="widget mt-3">
        <div class="widget-body">

            <div class="d-flex align-items-center flex-wrap">
                <nav aria-label="breadcrumb">
                    {{ Breadcrumbs::render('all customers due payment') }}
                </nav>

                <div class="ms-md-auto ms-0">

                    <a href="#search" class="btn btn-sm btn-primary" title="Search" data-bs-toggle="collapse" role="button" aria-expanded="false">
                        <x-icons.search/>
                    </a>

                    <a href="{{ route('customer-due-manage.create') }}" class="btn btn-sm btn-primary" title="Create new">
                        <x-icons.create/>
                    </a>
                    <a href="{{ route('customer-due-manage.index') }}" class="btn btn-sm  btn-primary" title="Reload page">
                        <x-icons.refresh/>
                    </a>
                    {{-- <a href="{{ route('customer-due-manage.trash') }}" class="btn btn-sm btn-primary" title="Trash">
                        <x-icons.trash/>
                    </a> --}}

                </div>
            </div>

        </div>
    </div>
    <!-- End Menu-->

    <!-- Start Search-->
    @include('admin.due-manage.customer.search')
    <!-- End Search-->

    <div class="widget mt-3" id="print-widget">

        <!-- Start print header =========================== -->
        @include('layouts.partials.printHead')
        <!-- End print header =========================== -->

        <!-- Start widget head =========================== -->
        <div class="widget-head">
            <div class="d-flex align-items-center flex-wrap">
                <div>
                    <h3>All records</h3>
                    <small>About {{count($customerDues)}} results found</small>

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
                            <th scope="col">Name</th>
                            <th scope="col">Mobile no</th>
                            <th scope="col">Type</th>
                            <th scope="col" class="text-end">Amount</th>
                            <th scope="col" class="print-none text-end">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($customerDues as $customerDue )
                        <tr>
                            <th scope="row">{{ $customerDues->firstItem() + $loop->index }}.</th>
                            <td>{{$customerDue->customer->name}}</td>
                            <td>{{$customerDue->customer->mobile_no}}</td>
                            <td>{{$customerDue->amount >= 0 ? 'Recieve':'Paid'}}</td>
                            <td class="text-end">
                                {{ number_format(abs($customerDue->amount), 2) }}
                            </td>

                            <td class="print-none text-end">
                                {{-- <a href="{{route('supplier.show',$supplier->id)}}" title="View" class="btn btn-sm btn-outline-info">
                                    <x-icons.detail/>
                                </a> --}}
                                <a href="{{route('customer-due-manage.edit',$customerDue->id)}}" title="Update"  class="btn btn-sm btn-outline-primary">
                                    <x-icons.edit/>
                                </a>

                                <a href="#" class="btn btn-sm btn-outline-danger" title="Trash" onclick="if(confirm('Are you sure want to delete?')) { document.getElementById('customerDue-delete-{{ $customerDue->id }}').submit() } return false ">
                                    <x-icons.delete/>
                                </a>

                                <form action="{{ route('customer-due-manage.destroy', $customerDue->id) }}" method="post" class="d-none" id="customerDue-delete-{{ $customerDue->id }}">
                                    @csrf
                                    @method('DELETE')
                                </form>
                            </td>
                        </tr>

                        @empty
                        <tr>
                            <th colspan="5">Customer due manage is empty.</th>
                        </tr>

                        @endforelse

                    </tbody>
                </table>
            </div>
        <!-- End Table ============================================== -->

            <!-- paginate -->
            <div class="container-fluid mt-3 mb-5">
                <nav>
                    {{ $customerDues->withQueryString()->links() }}
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
            new TomSelect("#select-name",{
                create: true,
                sortField: {
                    field: "text",
                    direction: "asc"
                }
            });
        </script>
    @endpush

</x-app-layout>
