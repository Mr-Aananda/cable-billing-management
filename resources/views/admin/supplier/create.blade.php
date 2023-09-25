@section('title', 'Create supplier')

<x-app-layout>
     <!-- Start Menu-->
    <div class="widget mt-3">
        <div class="widget-body">

            <div class="d-flex align-items-center flex-wrap">
                <nav aria-label="breadcrumb">
                    {{ Breadcrumbs::render('supplier create') }}
                </nav>

                <div class="ms-md-auto ms-0">

                    <!-- header icon -->
                    <a href="{{ route('supplier.index') }}" title="Go back" class="print-none btn btn-sm btn-primary ms-auto">
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
                        <h4 class="main-title">Create new supplier</h4>
                        <p><small>Can create <strong>supplier</strong> from here.</small></p>
                    </div>
                </div>

            </div>
            <div class="widget-body">

                <form action="{{ route('supplier.store') }}" method="POST">
                      @csrf

                    <!-- supplier name start -->
                    <div class="mb-3 row">
                        <div class="col-2">
                            <label for="name" class="mt-1 form-label required">Supplier name</label>
                        </div>

                        <div class="col-5">
                            <input type="text" name="name" value="{{ old('name')}}" class="form-control @error('name') is-invalid @enderror"  id="name" placeholder="Characters only" required>

                            <!-- error -->
                            @error('name')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                    </div>
                    <!-- Customer name end -->
                    <!-- Customer mobile no start -->
                    <div class="mb-3 row">
                        <div class="col-2">
                            <label for="mobile" class="mt-1 form-label required">Mobile </label>
                        </div>

                        <div class="col-5">
                            <input type="number" name="mobile_no" value="{{ old('mobile_no')}}" class="form-control @error('mobile_no') is-invalid @enderror"  id="mobile" placeholder="01xxxxxxxxx" min="0" required>

                            <!-- error -->
                            @error('mobile_no')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                    </div>
                    <!-- Customer mobile no end -->

                    <!-- Opening balance start-->
                    <div class="mb-3 row">
                        <div class="col-2">
                            <label for="balance" class="mt-1 form-label">Balance</label>
                        </div>

                        <div class="col-3">
                            <input type="number" name="balance" value="{{ old('balance')}}" class="form-control @error('balance') is-invalid @enderror" id="balance" placeholder="0.00">

                            <!-- error -->
                            @error('balance')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                         <div class="col-2">
                            <select name="balance_status" class="form-select" aria-label="Default select example">
                                <option value="0" selected >Payable</option>
                                <option value="1">Receivable</option>
                            </select>
                        </div>
                    </div>
                    <!-- Opening balance end -->

                    <!-- supplier address start -->
                    <div class="mb-3 row">
                        <div class="col-2">
                            <label for="address" class="mt-1 form-label">Address</label>
                        </div>

                        <div class="col-5">
                            <textarea name="address" class="form-control @error('address') is-invalid @enderror" id="address" rows="2"
                                placeholder="Optional">{{ old('address')}}</textarea>

                                <!-- error -->
                            @error('address')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                    </div>
                    <!-- supplier address end -->

                    <!-- supplier description start -->
                    <div class="mb-3 row">
                        <div class="col-2">
                            <label for="description" class="mt-1 form-label">Note</label>
                        </div>

                        <div class="col-5">
                            <textarea name="description" class="form-control @error('description') is-invalid @enderror" id="description" rows="3"
                                placeholder="Optional">{{ old('description')}}</textarea>

                                <!-- error -->
                            @error('description')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                    </div>
                    <!-- supplier description end -->

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
                                <span class="p-1">Create & Save</span>
                            </button>
                        </div>
                    </div>

                </form>

            </div>
        </div>
    </div>
</x-app-layout>
