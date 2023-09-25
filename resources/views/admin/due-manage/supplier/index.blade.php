@section('title', 'Supplier Due manage')

<x-app-layout>

    <!-- Start Menu-->
    <div class="widget mt-3">
        <div class="widget-body">

            <div class="d-flex align-items-center flex-wrap">
                <nav aria-label="breadcrumb">
                    {{ Breadcrumbs::render('all suppliers due payment') }}
                </nav>

                <div class="ms-md-auto ms-0">

                    <a href="#search" class="btn btn-sm btn-primary" title="Search" data-bs-toggle="collapse" role="button" aria-expanded="false">
                        <x-icons.search/>
                    </a>

                    <a href="{{ route('supplier-due-manage.create') }}" class="btn btn-sm btn-primary" title="Create new">
                        <x-icons.create/>
                    </a>
                     <a href="{{ route('supplier-due-manage.index') }}" class="btn btn-sm  btn-primary" title="Reload page">
                        <x-icons.refresh/>
                    </a>
                    {{-- <a href="{{ route('supplier-due-manage.trash') }}" class="btn btn-sm btn-primary" title="Trash">
                        <x-icons.trash/>
                    </a> --}}

                </div>
            </div>

        </div>
    </div>
    <!-- End Menu-->

    <!-- Start Search-->
    @include('admin.due-manage.supplier.search')
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
                    <small>About {{count($supplierDues)}} results found</small>

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
                        @forelse ($supplierDues as $supplierDue )
                        <tr>
                            <th scope="row">{{ $supplierDues->firstItem() + $loop->index }}.</th>
                            <td>{{$supplierDue->supplier->name}}</td>
                            <td>{{$supplierDue->supplier->mobile_no}}</td>
                            <td>{{$supplierDue->amount > 0 ? 'Recieve':'Paid'}}</td>
                            <td class="text-end">
                                {{ number_format(abs($supplierDue->amount), 2) }}
                            </td>

                            <td class="print-none text-end">
                                {{-- <a href="{{route('supplier.show',$supplier->id)}}" title="View" class="btn btn-sm btn-outline-info">
                                    <x-icons.detail/>
                                </a> --}}
                                <a href="{{route('supplier-due-manage.edit',$supplierDue->id)}}" title="Update"  class="btn btn-sm btn-outline-primary">
                                    <x-icons.edit/>
                                </a>

                                <a href="#" class="btn btn-sm btn-outline-danger" title="Trash" onclick="if(confirm('Are you sure want to delete?')) { document.getElementById('supplierDue-delete-{{ $supplierDue->id }}').submit() } return false ">
                                    <x-icons.delete/>
                                </a>

                                <form action="{{ route('supplier-due-manage.destroy', $supplierDue->id) }}" method="post" class="d-none" id="supplierDue-delete-{{ $supplierDue->id }}">
                                    @csrf
                                    @method('DELETE')
                                </form>
                            </td>
                        </tr>

                        @empty
                        <tr>
                            <th colspan="5">Supplier due manage is empty.</th>
                        </tr>

                        @endforelse

                    </tbody>
                </table>
            </div>
        <!-- End Table ============================================== -->

            <!-- paginate -->
            <div class="container-fluid mt-3 mb-5">
                <nav>
                    {{ $supplierDues->withQueryString()->links() }}
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
