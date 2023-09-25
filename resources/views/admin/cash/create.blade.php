@section('title', 'Create cash')

<x-app-layout>
     <!-- Start Menu-->
    <div class="widget mt-3">
        <div class="widget-body">

            <div class="d-flex align-items-center flex-wrap">
                <nav aria-label="breadcrumb">
                    {{ Breadcrumbs::render('cash create') }}
                </nav>

                <div class="ms-md-auto ms-0 btn-group">

                    <!-- header icon -->
                    <a href="{{ route('cash.index') }}" title="Go back" class="print-none btn btn-sm btn-primary ms-auto">
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
                        <h4 class="main-title">Create new cash</h4>
                        <p><small>Can create <strong>cash</strong> from here.</small></p>
                    </div>
                </div>

            </div>
            <div class="widget-body">

                <form action="{{ route('cash.store') }}" method="POST">
                      @csrf

                    <!-- Cash name start -->
                    <div class="mb-3 row">
                        <div class="col-2">
                            <label for="cash-name" class="mt-1 form-label required">Cash name</label>
                        </div>

                        <div class="col-5">
                            <input type="text" name="cash_name" value="{{ old('cash_name')}}" class="form-control @error('cash_name') is-invalid @enderror"  id="cash-name" placeholder="Characters only" required>

                            <!-- error -->
                            @error('cash_name')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                    </div>
                    <!-- Cash name end -->
                    <!-- Balance name start -->
                    <div class="mb-3 row">
                        <div class="col-2">
                            <label for="balance" class="mt-1 form-label required">Initial balance</label>
                        </div>

                        <div class="col-5">
                            <input type="number" name="balance" value="{{ old('balance')}}" class="form-control @error('balance') is-invalid @enderror" id="balance" placeholder="0.00" required>

                            <!-- error -->
                             @error('balance')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                    </div>
                     <!-- Balance name end -->
                     <!-- Note name start -->
                    <div class="mb-3 row">
                        <div class="col-2">
                            <label for="note" class="mt-1 form-label">Note</label>
                        </div>

                        <div class="col-5">
                            <textarea name="note" class="form-control @error('note') is-invalid @enderror" id="note" rows="3"
                                placeholder="Optional">{{ old('note')}}</textarea>

                                <!-- error -->
                            @error('note')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                    </div>
                     <!-- Note name start -->

                     <!-- Button start -->
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
                                <span class="p-1">Create an Save</span>
                            </button>
                        </div>
                    </div>

                </form>

            </div>
        </div>
    </div>

</x-app-layout>

