@section('title', 'Employee details')

<x-app-layout>
    <!-- Start Menu-->
    <div class="widget mt-3">
        <div class="widget-body">

            <div class="d-flex align-items-center flex-wrap">
                <nav aria-label="breadcrumb">
                    {{ Breadcrumbs::render('employee details',$employee) }}
                </nav>

                <div class="ms-md-auto ms-0 btn-group">

                    <!-- header icon -->
                    <a href="{{ route('employee.index') }}" title="Go back" class="print-none btn btn-sm btn-primary ms-auto">
                        <x-icons.back/>
                    </a>

                </div>
            </div>

        </div>
    </div>
    <!-- End Menu-->


    <div class="col-md-12">
        <div class="widget mt-3">
            <div class="widget-head">
                <div class="d-flex align-items-center flex-wrap">
                    <div class="mt-0">
                        <h4 class="main-title">Employee details</h4>
                        <p><small>All the details below.</small></p>
                    </div>
                </div>

            </div>
            <div class="widget-body">
                <div class="mb-3 row">
                    <div class="col-2">
                        <dt for="image" class="mt-1 form-label">&nbsp;</dt>
                    </div>

                    <div class="col-6">

                        @if ($employee->image !== null)
                            <img src="{{ $employee->url }}" alt="image" width="200" class="rounded">

                        @else
                            <img src="https://ui-avatars.com/api/?name={{ $employee->name }}&background=random&size=200" alt="{{ $employee->name }}">
                        @endif
                    </div>
                 </div>

                <div class="mb-3 row">
                    <div class="col-2">
                        <dt for="name" class="mt-1 form-label">Name </dt>
                    </div>

                    <div class="col-6">
                        <dd class="fst-italic text-muted fw-bold">{{ $employee->name}}</dd>
                    </div>
                </div>

                <div class="mb-3 row">
                    <div class="col-2">
                        <dt for="mobile" class="mt-1 form-label">Mobile no </dt>
                    </div>

                    <div class="col-6">
                        <dd class="fst-italic text-muted">{{ $employee->mobile }}</dd>
                    </div>
                </div>

                <div class="mb-3 row">
                    <div class="col-2">
                        <dt for="basic_salary" class="mt-1 form-label">Basic salary </dt>
                    </div>

                    <div class="col-6">
                        <dd class="fst-italic text-muted">{{ $employee->basic_salary }}</dd>
                    </div>
                </div>

                 @if ($employee->nid_no !== null)
                <div class="mb-3 row">
                        <div class="col-2">
                            <dt for="note" class="mt-1 form-label">NID number </dt>
                        </div>

                        <div class="col-6">
                            <dd class="fst-italic text-muted">{{ $employee->nid_no }}</dd>
                        </div>
                </div>
                @endif

                @if ($employee->address !== null)
                <div class="mb-3 row">
                        <div class="col-2">
                            <dt for="note" class="mt-1 form-label">Address </dt>
                        </div>

                        <div class="col-6">
                            <dd class="fst-italic text-muted">{{ $employee->address }}</dd>
                        </div>

                </div>
                @endif

                @if ($employee->note !== null)
                <div class="mb-3 row">
                        <div class="col-2">
                            <dt for="note" class="mt-1 form-label">Note </dt>
                        </div>

                        <div class="col-6">
                            <dd class="fst-italic text-muted">{{ $employee->note }}</dd>
                        </div>
                </div>
                @endif
            </div>
        </div>
    </div>
    <!-- End basic form with icon ================================ -->

</x-app-layout>

