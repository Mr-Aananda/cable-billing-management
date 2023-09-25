@section('title', 'Edit monthly recharge')

<x-app-layout>
    <!-- Start Menu-->
    <div class="widget mt-3">
        <div class="widget-body">

            <div class="d-flex align-items-center flex-wrap">
                <div class="ms-md-auto ms-0 btn-group">

                    <!-- header icon -->
                    <a href="{{ route('monthly-recharge.index') }}" title="Go back" class="print-none btn btn-sm btn-primary ms-auto">
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
                        <h4 class="main-title">Edit old monthly recharge</h4>
                        <p><small>Can edit <strong>monthly recharge</strong> from here.</small></p>
                    </div>
                </div>

            </div>
            <div class="widget-body">

                <form action="{{ route('monthly-recharge.update', $package_customer->id) }}" method="POST">
                      @csrf
                      @method('PATCH')

                    <!-- Package rechare date start -->
                    <div class="mb-3 row">
                        <div class="col-2">
                            <label for="date" class="mt-1 form-label required">Recharge date</label>
                        </div>

                        <div class="col-5">
                            <input type="date" name="active_date" value="{{ old('active_date',$package_customer->active_date->format('Y-m-d')) }}" class="form-control @error('date') is-invalid @enderror" id="date" required>

                            <!-- error -->
                            @error('active_date')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                    </div>
                    <!-- Package rechare date end -->
                    <!-- Package expire date start -->
                    <div class="mb-3 row">
                        <div class="col-2">
                            <label for="date" class="mt-1 form-label required">Expiry date</label>
                        </div>

                        <div class="col-5">
                            <input type="date" name="expire_date" value="{{ old('expire_date',$package_customer->expire_date)->format('Y-m-d') }}" class="form-control @error('expire_date') is-invalid @enderror" id="expire_date" required>

                            <!-- error -->
                            @error('expire_date')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                    </div>
                    <!-- Package expire date end -->

                     <!-- Package expire date start -->
                    <div class="mb-3 row">
                        <div class="col-2">
                            <label for="cash_id" class="mt-1 form-label required">Cash Types</label>
                        </div>

                        <div class="col-5">
                            <select name="cash_id" class="form-select " id="cash-id" required>
                                @foreach ($cashes as $cash)
                                 <option value="{{ $cash->id }}">{{ $cash->cash_name }}</option>
                                @endforeach
                            </select>

                            <!-- error -->
                            @error('cash_id')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                    </div>
                    <!-- Package expire date end -->

                     <!--  Buttton start -->
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
                    <!--  Buttton end -->

                </form>

            </div>
        </div>
    </div>
</x-app-layout>

