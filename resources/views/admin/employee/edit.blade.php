@section('title', 'Edit service')

<x-app-layout>
    <!-- Start Menu-->
    <div class="widget mt-3">
        <div class="widget-body">

            <div class="d-flex align-items-center flex-wrap">
                <nav aria-label="breadcrumb">
                    {{ Breadcrumbs::render('employee edit',$employee) }}
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
                        <h4 class="main-title">Edit old employee</h4>
                        <p><small>Can edit <strong>employee</strong> from here.</small></p>
                    </div>
                </div>

            </div>
            <div class="widget-body">

                <form action="{{ route('employee.update', $employee->id) }}" method="POST" enctype="multipart/form-data">
                      @csrf
                      @method('PATCH')

                    <!-- type text -->
                   <div class="mb-3 row">
                        <div class="col-2">
                            <label for="name" class="mt-1 form-label required">Name </label>
                        </div>

                        <div class="col-5">
                            <input type="text" name="name" value="{{ old('name',$employee->name)}}" class="form-control @error('name') is-invalid @enderror"  id="name" placeholder="Characters only"  required>

                            <!-- error -->
                            @error('name')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-3 row">
                        <div class="col-2">
                            <label for="mobile" class="mt-1 form-label required">Mobile </label>
                        </div>

                        <div class="col-5">
                            <input type="number" name="mobile" value="{{ old('mobile',$employee->mobile)}}" class="form-control @error('mobile') is-invalid @enderror"  id="mobile" placeholder="01xxxxxxxxx" min="0" required>

                            <!-- error -->
                            @error('mobile')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-3 row">
                        <div class="col-2">
                            <label for="image" class="mt-1 form-label">Image </label>
                        </div>

                        <div class="col-5">
                            <input type="file" name="image" value="{{ old('image')}}" class="form-control @error('image') is-invalid @enderror"  id="image">

                             <!-- error -->
                            @error('image')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror


                            @if ($employee->image !== null)
                                <img src="{{ $employee->url }}" alt="image" width="80" class="rounded">
                                @else
                                <small class="fst-italic text-muted text-danger"> Image not found.</small>

                            @endif

                        </div>
                    </div>

                    <div class="mb-3 row">
                        <div class="col-2">
                            <label for="nid_number" class="mt-1 form-label">NID number </label>
                        </div>

                        <div class="col-5">
                            <input type="number" name="nid_number" value="{{ old('nid_number',$employee->nid_number)}}" class="form-control @error('nid_number') is-invalid @enderror"  id="nid_number" placeholder="Only number" min="0">

                            <!-- error -->
                            @error('nid_number')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-3 row">
                        <div class="col-2">
                            <label for="basic_salary" class="mt-1 form-label">Basic salary </label>
                        </div>

                        <div class="col-5">
                            <input type="number" name="basic_salary" value="{{ old('basic_salary', $employee->basic_salary)}}" class="form-control @error('basic_salary') is-invalid @enderror"  id="basic_salary" placeholder="Only number" min="0">

                            <!-- error -->
                            @error('basic_salary')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-3 row">
                        <div class="col-2">
                            <label for="address" class="mt-1 form-label">Address</label>
                        </div>

                        <div class="col-5">
                            <textarea name="address" class="form-control @error('address') is-invalid @enderror" id="address" rows="2"
                                placeholder="Optional">{{ old('address',$employee->address)}}</textarea>

                                <!-- error -->
                            @error('address')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-3 row">
                        <div class="col-2">
                            <label for="note" class="mt-1 form-label">Note</label>
                        </div>

                        <div class="col-5">
                            <textarea name="note" class="form-control @error('note') is-invalid @enderror" id="note" rows="3"
                                placeholder="Optional">{{ old('note',$employee->note)}}</textarea>

                                <!-- error -->
                            @error('note')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
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

