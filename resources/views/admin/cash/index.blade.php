@section('title', 'Cashes')

<x-app-layout>
    <!-- Start Menu-->
    <div class="widget mt-3">
        <div class="widget-body">

            <div class="d-flex align-items-center flex-wrap">
                <nav aria-label="breadcrumb">
                    {{ Breadcrumbs::render('all cashes') }}
                </nav>

                <div class="ms-md-auto ms-0">

                    {{-- <a href="#search" class="btn btn-sm btn-primary" title="Search" data-bs-toggle="collapse" role="button" aria-expanded="false">
                        <x-icons.search/>
                    </a> --}}

                    <a href="{{ route('cash.create') }}" class="btn btn-sm btn-primary" title="Create new">
                        <x-icons.create/>
                    </a>
                    <a href="{{ route('cash.index') }}" class="btn btn-sm  btn-primary" title="Reload page">
                        <x-icons.refresh/>
                    </a>
                    <a href="{{ route('cash.trash') }}" class="btn btn-sm btn-primary" title="Trash">
                        <x-icons.trash/>
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
                        <small>About {{count($cashes)}} results found</small>
                        <!-- <img src="assets/images/logos/logo_with_name.svg"  alt=""> -->
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
                                <th scope="col">Cash name</th>
                                <th scope="col">Balance</th>
                                <th scope="col">Note</th>
                                <th scope="col" class="print-none text-end">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($cashes as $cash )
                            <tr>
                                <th scope="row">{{ $cashes->firstItem() + $loop->index }}.</th>
                                <td>{{$cash->cash_name}}</td>
                                <td>{{$cash->balance}}</td>
                                <td>{{$cash->note}}</td>
                                <td class="print-none text-end">

                                    <a href="{{route('cash.edit',$cash->id)}}" title="Update"  class="btn btn-sm btn-outline-primary">
                                        <x-icons.edit/>
                                    </a>

                                    <a href="#" class="btn btn-sm btn-outline-danger" title="Trash" onclick="if(confirm('Are you sure want to delete?')) { document.getElementById('cash-delete-{{ $cash->id }}').submit() } return false ">
                                        <x-icons.delete/>
                                    </a>

                                    <form action="{{ route('cash.destroy', $cash->id) }}" method="post" class="d-none" id="cash-delete-{{ $cash->id }}">
                                        @csrf
                                        @method('DELETE')
                                    </form>
                                </td>
                            </tr>

                            @empty
                            <tr>
                                <th colspan="5">Cash list is empty.</th>
                            </tr>

                            @endforelse

                        </tbody>
                    </table>
                </div>
            <!-- End Table ============================================== -->

             <!-- paginate -->
                <div class="container-fluid mt-3 mb-5">
                    <nav>
                        {{ $cashes->withQueryString()->links() }}
                    </nav>
                </div>
                <!-- pagination end -->
        </div>

</x-app-layout>