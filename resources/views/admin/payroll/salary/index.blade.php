@section('title', 'Salaries')

<x-app-layout>
     <!-- Start Menu-->
    <div class="widget mt-3">
        <div class="widget-body">

            <div class="d-flex align-items-center flex-wrap">
                <nav aria-label="breadcrumb">
                    {{ Breadcrumbs::render('all salary') }}
                </nav>

                <div class="ms-md-auto ms-0">

                    <a href="#search" class="btn btn-sm btn-primary" title="Search" data-bs-toggle="collapse" role="button" aria-expanded="false">
                        <x-icons.search/>
                    </a>

                    <a href="{{ route('payroll-salary.create') }}" class="btn btn-sm btn-primary" title="Create new">
                        <x-icons.create/>
                    </a>
                    <a href="{{ route('payroll-salary.index') }}" class="btn btn-sm  btn-primary" title="Reload page">
                        <x-icons.refresh/>
                    </a>
                </div>
            </div>

        </div>
    </div>
    <!-- End Menu-->
    @include('admin.payroll.salary.search')

        <div class="widget mt-3" id="print-widget">

            <!-- Start print header -->
            @include('layouts.partials.printHead')
            <!-- End print header -->

            <!-- Start widget head -->
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
            <!-- End widget head -->

            <div class="widget-body">

            <!-- Start Table -->

                <div class="table-responsive">
                    <table class="table custom table-hover action-hover sm">
                        <thead>
                            <tr>
                                <th scope="col">SL</th>
                                <th scope="col">Name</th>
                                <th scope="col">Phone no</th>
                                <th scope="col">Month</th>
                                <th scope="col">Salary</th>
                                <th scope="col" class="print-none text-end">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($employees as $employee )
                            <tr>
                                <th scope="row">{{ $loop->iteration }}.</th>
                                <td>{{ $employee->name }}</td>
                                <td>{{ $employee->mobile}}</td>
                                <td>{{ $month }}</td>

                                <td>
                                    {{-- <span class="{{$employee->salaries->count() > 0 ? 'badge bg-success p-2' : 'badge bg-danger p-2' }}">
                                        {{ $employee->salaries->count() > 0 ? 'paid' : 'unpaid' }}
                                    </span> --}}
                                    @if ( $employee->salaries->count() > 0 )
                                    <span class="badge bg-success p-2">paid</span>
                                    @else
                                        <a href="{{route('payroll-salary.salaryPay', ['id' => $employee->id, 'month' => $month])}}">
                                            <span class="badge bg-danger p-2">unpaid</span>
                                        </a>
                                    @endif
                                </td>
                                <td class="print-none text-end">
                                    @if ($employee->salaries->count() > 0)
                                        <a href="{{ route('payroll-salary.show', $employee->salaries->last()['id']) }}" title="View" class="btn btn-sm btn-outline-info">
                                            <x-icons.detail/>
                                        </a>

                                        <a href="{{route('payroll-salary.edit',$employee->salaries->last()['id'])}}" title="Update"  class="btn btn-sm btn-outline-primary">
                                            <x-icons.edit/>
                                        </a>

                                        <a href="#" class="btn btn-sm btn-outline-danger" title="Trash" onclick="if(confirm('Are you sure want to delete?')) { document.getElementById('salary-delete-{{  $employee->salaries->last()['id'] }}').submit() } return false ">
                                            <x-icons.delete/>
                                        </a>

                                        <form action="{{ route('payroll-salary.destroy',  $employee->salaries->last()['id']) }}" method="post" class="d-none" id="salary-delete-{{  $employee->salaries->last()['id'] }}">
                                            @csrf
                                            @method('DELETE')
                                        </form>

                                    @endif

                                </td>
                            </tr>

                            @empty
                            <tr>
                                <th colspan="6">Employee salary list is empty.</th>
                            </tr>

                            @endforelse

                        </tbody>
                    </table>
                </div>
            <!-- End Table -->

             <!-- paginate -->
                {{-- <div class="container-fluid mt-3 mb-5">
                    <nav>
                        {{ $expenses->withQueryString()->links() }}
                    </nav>
                </div> --}}
            <!-- pagination end -->
      </div>

</x-app-layout>
