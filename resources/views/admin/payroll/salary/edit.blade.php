@section('title', 'Edit service')

<x-app-layout>

    <div class="col-md-12">
        <div class="widget mt-3">
             <div class="widget-head">
                <div class="d-flex align-items-center flex-wrap">
                    <div class="mt-0">
                        <h4 class="main-title">Edit old employee</h4>
                        <p><small>Can edit <strong>employee</strong> from here.</small></p>
                    </div>
                    <!-- header icon -->
                    <a href="{{ route('payroll-salary.index') }}" title="Go back" class="print-none btn btn-sm btn-primary ms-auto">
                        <x-icons.back/>
                    </a>
                </div>

            </div>
            <div class="widget-body">

                <form action="{{ route('payroll-salary.update', $oldSalary->id) }}" method="POST" enctype="multipart/form-data">
                      @csrf
                      @method('PATCH')

                      {{-- React components --}}

                      <div
                        data-employees="{{ $employees  }}"
                        data-cashes="{{ $cashes  }}"
                        data-selected-employee-id="{{ request()->id }}"
                        data-old-salary="{{ $oldSalary }}"
                        data-month="{{ $month }}"
                        id="create-employee-salary">

                      </div>



                    <div class="mb-3 row">
                        <div class="col-2">
                            <label class="mt-1 form-label">&nbsp;</label>
                        </div>

                        <div class="col-10">
                            <button type="reset" class="btn btn-warning me-2">
                                <i class="bi bi-trash"></i>
                                <span class="p-1">Reset</span>
                            </button>

                            <button type="submit" class="btn btn-success">
                                <i class="bi bi-check-circle"></i>
                                <span class="p-1">Update</span>
                            </button>
                        </div>
                    </div>

                </form>

            </div>
        </div>
    </div>

</x-app-layout>

