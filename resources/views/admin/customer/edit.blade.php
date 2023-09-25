@section('title', 'Edit customer')

<x-app-layout>
    <!-- Start Menu-->
    <div class="widget mt-3">
        <div class="widget-body">

            <div class="d-flex align-items-center flex-wrap">
                <nav aria-label="breadcrumb">
                    {{ Breadcrumbs::render('customer edit',$customer) }}
                </nav>

                <div class="ms-md-auto ms-0 btn-group">

                    <!-- header icon -->
                    <a href="{{ route('customer.index') }}" title="Go back" class="print-none btn btn-sm btn-primary ms-auto">
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
                        <h4 class="main-title">Edit old customer</h4>
                        <p><small>Can edit <strong>customer</strong> from here.</small></p>
                    </div>
                </div>

            </div>
            <div class="widget-body">

                <form action="{{ route('customer.update', $customer->id) }}" method="POST">
                      @csrf
                      @method('PATCH')

                       <!-- Customer name start -->
                    <div class="mb-3 row">
                        <div class="col-2">
                            <label for="name" class="mt-1 form-label required">Customer name</label>
                        </div>

                        <div class="col-5">
                            <input type="text" name="name" value="{{ old('name',$customer->name)}}" class="form-control @error('name') is-invalid @enderror"  id="name" placeholder="Characters only" required>

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
                            <input type="number" name="mobile_no" value="{{ old('mobile_no',$customer->mobile_no)}}" class="form-control @error('mobile_no') is-invalid @enderror"  id="mobile" placeholder="01xxxxxxxxx" min="0" required>

                            <!-- error -->
                            @error('mobile_no')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                    </div>
                    <!-- Customer mobile no end -->

                     <!-- Customer package start -->
                     <div class="mb-3 row">
                        <div class="col-2">
                            <label for="select-package" class="mt-1 form-label required">Select package</label>
                        </div>

                        <div class="col-5">
                            <select name="package_id" class="@error('package_id') is-invalid @enderror" id="select-package" autocomplete="off"  placeholder="... Choose one ...">
                                <option value="" > -- Choose one -- </option>

                                @foreach ($packages as $package)
                                    <option value="{{ $package->id }}" {{ (old('package_id', $customer->sales->first()->package_id) == $package->id) ? 'selected' : '' }}>{{ $package->name }}</option>
                                @endforeach
                            </select>

                            <!-- error -->
                            @error('package_id')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                    </div>
                    <!-- Customer package end -->
                    <!-- Customer status start -->
                    <div class="mb-3 row">
                        <div class="col-2">
                            <label for="status" class="mt-1 form-label required">Status</label>
                        </div>

                        <div class="col-5">
                            <select name="status" class="form-control @error('status') is-invalid @enderror" id="status" required>
                                <option value="" selected disabled> -- Choose one -- </option>
                                <option value="active" {{ $customer->sales->first()->status == 'active' ? 'selected' : '' }} > Active </option>
                                <option value="inactive" {{ $customer->sales->first()->status == 'inactive' ? 'selected' : '' }} > Inactive</option>
                                <option value="disconnected" {{ $customer->sales->first()->status == 'disconnected' ? 'selected' : '' }} > Disconnected </option>
                            </select>

                            <!-- error -->
                            @error('status')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                    </div>
                     <!-- Customer status end -->
                     <!-- Package date start -->
                    <div class="mb-3 row">
                        <div class="col-2">
                            <label for="date" class="mt-1 form-label required">Started date</label>
                        </div>

                        <div class="col-5">
                            <input type="date" name="date" value="{{ old('date', ($customer->sales->first() && $customer->sales->first()->active_date) ? $customer->sales->first()->active_date->format('Y-m-d') : $customer->sales->first()->date->format('Y-m-d')) }}" class="form-control @error('date') is-invalid @enderror" id="date" required>

                            <!-- error -->
                            @error('date')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                    </div>
                    <!-- Package date end -->
                    <!-- Package expire date start -->
                    <div id="expire_date_row" style="display: none;">
                        <div class="mb-3 row">
                        <div class="col-2">
                            <label for="expire_date" class="mt-1 form-label">Expire date</label>
                        </div>

                        <div class="col-5">
                            <input type="date" name="expire_date" value="{{ old('expire_date', ($customer->sales->first() && $customer->sales->first()->expire_date) ? $customer->sales->first()->expire_date->format('Y-m-d') : '') }}" class="form-control @error('expire_date') is-invalid @enderror" id="date">

                            <!-- error -->
                            @error('expire_date')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                    </div>
                    </div>
                    <!-- Package expire date end -->

                     <!--  cable id start -->
                    <div class="mb-3 row">
                        <div class="col-2">
                            <label for="cable-id" class="mt-1 form-label required">Cable ID</label>
                        </div>

                        <div class="col-5">
                            <input type="text" name="cable_id" value="{{ old('cable_id',$customer->sales->first()->cable_id)}}" class="form-control @error('cable_id') is-invalid @enderror" id="cable-id" placeholder="xxxxxx" required>

                            <!-- error -->
                            @error('cable_id')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                    </div>
                    <!--  cable id end -->

                    <!-- Customer area start -->
                     <div class="mb-3 row">
                        <div class="col-2">
                            <label for="select-beast" class="mt-1 form-label required">Select Area</label>
                        </div>

                        <div class="col-5">
                            <select name="area_id" class="@error('area_id') is-invalid @enderror" id="select-beast" autocomplete="off"  placeholder="... Choose one ...">
                                <option value="" > -- Choose one -- </option>

                                @foreach ($areas as $area)
                                    <option value="{{ $area->id }}" {{ (old('area_id', $customer->area_id) == $area->id) ? 'selected' : '' }}>{{ $area->name }}</option>
                                @endforeach
                            </select>

                            <!-- error -->
                            @error('area_id')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                    </div>
                    <!-- Customer area end -->

                    <!-- Opening balance start-->
                    <div class="mb-3 row">
                        <div class="col-2">
                            <label for="balance" class="mt-1 form-label">Balance</label>
                        </div>

                        <div class="col-3">
                            <input type="number" name="balance" value="{{ old('balance',$customer->balance)}}" class="form-control @error('balance') is-invalid @enderror" id="balance" placeholder="0.00">

                            <!-- error -->
                            @error('balance')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                        <div class="col-2">
                            <select name="balance_status" class="form-select" aria-label="Default select example">
                                <option value="0"  {{$customer->balance < 0 ? 'selected':''}} >Payable</option>
                                <option value="1" {{$customer->balance >= 0 ? 'selected':''}} >Recieveable</option>
                            </select>
                        </div>
                    </div>
                    <!-- Oprning balance end -->

                    <!-- Customer address start -->
                    <div class="mb-3 row">
                        <div class="col-2">
                            <label for="address" class="mt-1 form-label">Address</label>
                        </div>

                        <div class="col-5">
                            <textarea name="address" class="form-control @error('address') is-invalid @enderror" id="address" rows="2"
                                placeholder="Optional">{{ old('address',$customer->address)}}</textarea>

                                <!-- error -->
                            @error('address')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                    </div>
                    <!-- Customer address end -->

                    <!-- Customer description start -->
                    <div class="mb-3 row">
                        <div class="col-2">
                            <label for="description" class="mt-1 form-label">Note</label>
                        </div>

                        <div class="col-5">
                            <textarea name="description" class="form-control @error('description') is-invalid @enderror" id="description" rows="3"
                                placeholder="Optional">{{ old('description',$customer->description)}}</textarea>

                                <!-- error -->
                            @error('description')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                    </div>
                    <!-- Customer description end -->

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

             new TomSelect("#select-package",{
                create: true,
                sortField: {
                    field: "text",
                    direction: "asc"
                }
            });
        </script>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
            const statusDropdown = document.querySelector('#status');
            const expireDateRow = document.querySelector('#expire_date_row');

            statusDropdown.addEventListener('change', function() {
                if (statusDropdown.value === 'active' || statusDropdown.value === 'inactive') {
                    expireDateRow.style.display = 'block';
                } else {
                    expireDateRow.style.display = 'none';
                }
            });
        });

        </script>
    @endpush

</x-app-layout>

