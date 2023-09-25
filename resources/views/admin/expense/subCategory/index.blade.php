@section('title', 'Expense-Subcategories')

<x-app-layout>
     <!-- Start Menu-->
    <div class="widget mt-3">
        <div class="widget-body">

            <div class="d-flex align-items-center flex-wrap">
                <nav aria-label="breadcrumb">
                    {{ Breadcrumbs::render('all subcategories') }}
                </nav>

                <div class="ms-md-auto ms-0">

                    <a href="#search" class="btn btn-sm btn-primary" title="Search" data-bs-toggle="collapse" role="button" aria-expanded="false">
                        <x-icons.search/>
                    </a>

                    <a href="{{ route('expense-subcategory.create') }}" class="btn btn-sm btn-primary" title="Create new">
                        <x-icons.create/>
                    </a>
                    <a href="{{ route('expense-subcategory.index') }}" class="btn btn-sm  btn-primary" title="Reload page">
                        <x-icons.refresh/>
                    </a>
                        <a href="{{ route('expense-subcategory.trash') }}" class="btn btn-sm btn-primary" title="Trash">
                        <x-icons.trash/>
                    </a>

                </div>
            </div>

        </div>
    </div>
    <!-- End Menu-->
    @include('admin.expense.subCategory.search')

        <div class="widget mt-3" id="print-widget">

            <!-- Start print header =========================== -->
            @include('layouts.partials.printHead')
            <!-- End print header =========================== -->

            <!-- Start widget head =========================== -->
            <div class="widget-head">
                <div class="d-flex align-items-center flex-wrap">
                    <div>
                        <h3>All records</h3>
                        <small>About {{count($subCategories)}} results found</small>
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
                                <th scope="col">Name</th>
                                <th scope="col">Category</th>
                                <th scope="col">Note</th>
                                <th scope="col" class="print-none text-end">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($subCategories as $subcategory )
                            <tr>
                                <th scope="row">{{ $subCategories->firstItem() + $loop->index }}.</th>
                                <td>{{$subcategory->name}}</td>
                                <td>{{$subcategory->expenseCategory->name}}</td>
                                <td>{{$subcategory->note}}</td>
                                <td class="print-none text-end">

                                    <a href="{{route('expense-subcategory.edit',$subcategory->id)}}" title="Update"  class="btn btn-sm btn-outline-primary">
                                        <x-icons.edit/>
                                    </a>

                                    <a href="#" class="btn btn-sm btn-outline-danger @if ($subcategory->expenses_count) disabled @endif" title="Trash" onclick="if(confirm('Are you sure want to delete?')) { document.getElementById('subcategory-delete-{{ $subcategory->id }}').submit() } return false ">
                                        <x-icons.delete/>
                                    </a>

                                    <form action="{{ route('expense-subcategory.destroy', $subcategory->id) }}" method="post" class="d-none" id="subcategory-delete-{{ $subcategory->id }}">
                                        @csrf
                                        @method('DELETE')
                                    </form>
                                </td>
                            </tr>

                            @empty
                            <tr>
                                <th colspan="5">Subcategory list is empty.</th>
                            </tr>

                            @endforelse

                        </tbody>
                    </table>
                </div>
            <!-- End Table ============================================== -->

             <!-- paginate -->
                <div class="container-fluid mt-3 mb-5">
                    <nav>
                        {{ $subCategories->withQueryString()->links() }}
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
            new TomSelect("#select-category",{
                create: true,
                sortField: {
                    field: "text",
                    direction: "asc"
                }
            });

        </script>
    @endpush

</x-app-layout>
