@section('title', 'Areas')

<x-app-layout>
   <!-- Start Menu-->
    <div class="widget mt-3">
        <div class="widget-body">

            <div class="d-flex align-items-center flex-wrap">
                <nav aria-label="breadcrumb">
                    {{ Breadcrumbs::render('all areas') }}
                </nav>

                <div class="ms-md-auto ms-0">

                    <a href="#search" class="btn btn-sm btn-primary" title="Search" data-bs-toggle="collapse" role="button" aria-expanded="false">
                        <x-icons.search/>
                    </a>

                    <a href="{{ route('area.create') }}" class="btn btn-sm btn-primary" title="Create new">
                        <x-icons.create/>
                    </a>
                    <a href="{{ route('area.index') }}" class="btn btn-sm  btn-primary" title="Reload page">
                        <x-icons.refresh/>
                    </a>
                        <a href="{{ route('area.trash') }}" class="btn btn-sm btn-primary" title="Trash">
                        <x-icons.trash/>
                    </a>

                </div>
            </div>

        </div>
    </div>
    <!-- End Menu-->
    @include('admin.area.search')

    <div class="widget mt-3" id="print-widget">

        <!-- Start print header =========================== -->
        @include('layouts.partials.printHead')
        <!-- End print header =========================== -->

        <!-- Start widget head =========================== -->
        <div class="widget-head">
            <div class="d-flex align-items-center flex-wrap">
                <div>
                    <h3>All records</h3>
                    <small>About {{count($areas)}} results found</small>

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
                            <th scope="col">Description</th>
                            <th scope="col" class="print-none text-end">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($areas as $area )
                        <tr>
                            <th scope="row">{{ $areas->firstItem() + $loop->index }}.</th>
                            <td>{{$area->name}}</td>
                            <td>{{$area->description}}</td>
                            <td class="print-none text-end">

                                <a href="{{route('area.edit',$area->id)}}" title="Update"  class="btn btn-sm btn-outline-primary">
                                    <x-icons.edit/>
                                </a>

                                <a href="#" class="btn btn-sm btn-outline-danger" title="Trash" onclick="if(confirm('Are you sure want to delete?')) { document.getElementById('area-delete-{{ $area->id }}').submit() } return false ">
                                    <x-icons.delete/>
                                </a>

                                <form action="{{ route('area.destroy', $area->id) }}" method="post" class="d-none" id="area-delete-{{ $area->id }}">
                                    @csrf
                                    @method('DELETE')
                                </form>
                            </td>
                        </tr>

                        @empty
                        <tr>
                            <th colspan="5">Area list is empty.</th>
                        </tr>

                        @endforelse

                    </tbody>
                </table>
            </div>
        <!-- End Table ============================================== -->

            <!-- paginate -->
            <div class="container-fluid mt-3 mb-5">
                <nav>
                    {{ $areas->withQueryString()->links() }}
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
