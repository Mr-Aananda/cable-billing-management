@section('title', 'Employees')

<x-app-layout>
   <!-- Start Menu-->
    <div class="widget mt-3">
        <div class="widget-body">

            <div class="d-flex align-items-center flex-wrap">
                <nav aria-label="breadcrumb">
                    {{ Breadcrumbs::render('all employees') }}
                </nav>

                <div class="ms-md-auto ms-0">

                    <a href="#search" class="btn btn-sm btn-primary" title="Search" data-bs-toggle="collapse" role="button" aria-expanded="false">
                        <x-icons.search/>
                    </a>

                    <a href="{{ route('employee.create') }}" class="btn btn-sm btn-primary" title="Create new">
                        <x-icons.create/>
                    </a>
                    <a href="{{ route('employee.index') }}" class="btn btn-sm  btn-primary" title="Reload page">
                        <x-icons.refresh/>
                    </a>
                        <a href="{{ route('employee.trash') }}" class="btn btn-sm btn-primary" title="Trash">
                        <x-icons.trash/>
                    </a>

                </div>
            </div>

        </div>
    </div>
    <!-- End Menu-->

    @include('admin.employee.search')

        <div class="widget mt-3" id="print-widget">

            <!-- Start print header =========================== -->
            @include('layouts.partials.printHead')
            <!-- End print header =========================== -->

            <!-- Start widget head =========================== -->
            <div class="widget-head">
                <div class="d-flex align-items-center flex-wrap">
                    <div>
                        <h3>All records</h3>
                        <small>About {{count($employees)}} results found</small>

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
                                <th scope="col">Basic salary</th>
                                <th scope="col">Address</th>
                                <th scope="col" class="print-none text-end">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($employees as $employee )
                            <tr>
                                <th scope="row">{{ $employees->firstItem() + $loop->index }}.</th>
                                <td>{{$employee->name}}</td>
                                <td>{{$employee->mobile}}</td>
                                <td>{{$employee->basic_salary}}</td>
                                <td>{{$employee->address}}</td>
                                <td class="print-none text-end">
                                    <a href="{{route('employee.show',$employee->id)}}" title="View" class="btn btn-sm btn-outline-info">
                                        <x-icons.detail/>
                                    </a>

                                    <a href="{{route('employee.edit',$employee->id)}}" title="Update"  class="btn btn-sm btn-outline-primary">
                                        <x-icons.edit/>
                                    </a>

                                    <a href="#" class="btn btn-sm btn-outline-danger" title="Trash" onclick="if(confirm('Are you sure want to delete?')) { document.getElementById('employee-delete-{{ $employee->id }}').submit() } return false ">
                                        <x-icons.delete/>
                                    </a>

                                    <form action="{{ route('employee.destroy', $employee->id) }}" method="post" class="d-none" id="employee-delete-{{ $employee->id }}">
                                        @csrf
                                        @method('DELETE')
                                    </form>
                                </td>
                            </tr>

                            @empty
                            <tr>
                                <th colspan="5">Employee list is empty.</th>
                            </tr>

                            @endforelse

                        </tbody>
                    </table>
                </div>
            <!-- End Table ============================================== -->

             <!-- paginate -->
                <div class="container-fluid mt-3 mb-5">
                    <nav>
                        {{ $employees->withQueryString()->links() }}
                    </nav>
                </div>
                <!-- pagination end -->
      </div>

</x-app-layout>
