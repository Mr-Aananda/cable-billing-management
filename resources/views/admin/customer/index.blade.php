@section('title', 'Customers')

<x-app-layout>

    <!-- Start Menu-->
    <div class="widget mt-3">
        <div class="widget-body">

            <div class="d-flex align-items-center flex-wrap">
                <nav aria-label="breadcrumb">
                    {{ Breadcrumbs::render('all customers') }}
                </nav>

                <div class="ms-md-auto ms-0">
                    <a href="#search" class="btn btn-sm btn-primary" title="Search" data-bs-toggle="collapse" role="button" aria-expanded="false">
                        <x-icons.search/>
                    </a>

                    <a href="{{ route('customer.create') }}" class="btn btn-sm btn-primary" title="Create new">
                        <x-icons.create/>
                    </a>
                    <a href="{{ route('customer.index') }}" class="btn btn-sm  btn-primary" title="Reload page">
                        <x-icons.refresh/>
                    </a>
                        <a href="{{ route('customer.trash') }}" class="btn btn-sm btn-primary" title="Trash">
                        <x-icons.trash/>
                    </a>
                </div>
            </div>

        </div>
    </div>
    <!-- End Menu-->

    <!-- Start Search-->
    @include('admin.customer.search')
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
                    <small>About {{count($customers)}} results found</small>

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
                            {{-- <th scope="col">Mobile no</th> --}}
                            <th scope="col">Cable ID</th>
                            <th scope="col">Balance</th>
                            {{-- <th scope="col">Package</th> --}}
                            <th scope="col">Area</th>
                            <th scope="col">Status</th>
                            <th scope="col" class="print-none text-end">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($customers as $customer )
                        <tr>
                            <th scope="row">{{ $customers->firstItem() + $loop->index }}.</th>
                            <td>{{$customer->name}}</td>
                            {{-- <td>{{$customer->mobile_no}}</td> --}}
                            <td>
                                @foreach ($customer->sales as $sale )
                                    {{$sale->cable_id}}
                                    @if(! $loop->last)
                                     ,
                                    @endif
                                 @endforeach
                            </td>
                            <td>
                                {{ number_format(abs($customer->balance), 2) }}
                                <span class="{{ $customer->balance >= 0 ? 'text-success' : 'text-danger' }}">{{ $customer->balance >= 0 ? '(Rec)' : '(Pay)' }}</span>
                            </td>
                            {{-- <td>{{$customer->package->name ?? "not found"}}</td> --}}
                            <td>{{$customer->area->name ?? "not found"}}</td>
                            <td>
                                @foreach ($customer->sales as $sale )
                                    {{-- @if($sale->status == 'active')
                                        <span class="badge bg-success">{{ ucwords($sale->status) }}</span>
                                    @elseif($sale->status == 'inactive')
                                        <span class="badge bg-danger">{{ ucwords($sale->status) }}</span>
                                    @elseif($sale->status == 'disconnected')
                                        <span class="badge bg-secondary">{{ ucwords($sale->status) }}</span>
                                    @elseif($sale->status == null)
                                        <span>No packages take yet</span>
                                    @else
                                        <span></span>
                                    @endif --}}

                                    @if($sale->expire_date >= date('Y-m-d'))
                                        <span class="badge bg-success">Active</span>
                                    @elseif($sale->expire_date < date('Y-m-d'))
                                        <span class="badge bg-danger">Inactive</span>
                                    @elseif($sale->expire_date == null)
                                        <span class="badge bg-secondary">Disconnected</span>
                                    @else
                                        No packages take yet
                                    @endif
                                @endforeach
                            </td>
                            <td class="print-none text-end">
                                <a href="{{route('customer.show',$customer->id)}}" title="View" class="btn btn-sm btn-outline-info">
                                    <x-icons.detail/>
                                </a>
                                <a href="{{route('customer.edit',$customer->id)}}" title="Update"  class="btn btn-sm btn-outline-primary">
                                    <x-icons.edit/>
                                </a>

                                <a href="#" class="btn btn-sm btn-outline-danger" title="Trash" onclick="if(confirm('Are you sure want to delete?')) { document.getElementById('customer-delete-{{ $customer->id }}').submit() } return false ">
                                    <x-icons.delete/>
                                </a>

                                <form action="{{ route('customer.destroy', $customer->id) }}" method="post" class="d-none" id="customer-delete-{{ $customer->id }}">
                                    @csrf
                                    @method('DELETE')
                                </form>
                            </td>
                        </tr>

                        @empty
                        <tr>
                            <th colspan="6">Customer list is empty.</th>
                        </tr>

                        @endforelse

                    </tbody>
                </table>
            </div>
        <!-- End Table ============================================== -->

            <!-- paginate -->
            <div class="container-fluid mt-3 mb-5">
                <nav>
                    {{ $customers->withQueryString()->links() }}
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
