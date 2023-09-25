@section('title', 'Create supplier due manage')

<x-app-layout>
     <!-- Start Menu-->
    <div class="widget mt-3">
        <div class="widget-body">

            <div class="d-flex align-items-center flex-wrap">
                <nav aria-label="breadcrumb">
                    {{ Breadcrumbs::render('supplier due payment create') }}
                </nav>

                <div class="ms-md-auto ms-0">

                    <!-- header icon -->
                    <a href="{{ route('supplier-due-manage.index') }}" title="Go back" class="print-none btn btn-sm btn-primary ms-auto">
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
                        <h4 class="main-title">Create new payment</h4>
                        <p><small>Can create <strong> payment</strong> from here.</small></p>
                    </div>
                </div>

            </div>
            <div class="widget-body">
                        <form action="{{ route('supplier-due-manage.store') }}" method="POST">
                            @csrf

                            <div class="mb-3 row">
                                <div class="col-2">
                                    <label for="date" class="mt-1 form-label required">Date</label>
                                </div>

                                <div class="col-6">
                                    <input type="date" name="date" value="{{ old('date')}}" class="form-control @error('date') is-invalid @enderror" id="date" required>

                                    <!-- error -->
                                    @error('date')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            </div>

                            <div
                                data-suppliers = "{{$suppliers}}"
                                data-errors="{{ $errors ?? [] }}"
                                data-supplier-due = "{{json_encode('')}}"
                             id="get-previous-balance-by-supplier">

                            </div>

                            {{-- <div class="mb-3 row">
                                <div class="col-2">
                                    <label for="select-supplier" class="mt-1 form-label required">Select supplier</label>
                                </div>

                                <div class="col-7">
                                    <select name="supplier_id" class="@error('supplier_id') is-invalid @enderror" id="select-supplier" autocomplete="off"  placeholder="... Choose one ...">
                                        <option value="" > -- Choose one -- </option>

                                        @foreach ($suppliers as $supplier)
                                            <option value="{{ $supplier->id }}">{{ $supplier->name }}</option>
                                        @endforeach
                                    </select>

                                    <!-- error -->
                                    @error('supplier_id')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            </div> --}}

                            <div class="mb-3 row">
                                <div class="col-2 ">
                                    <label for="amount" class="mt-1 form-label required">Amount</label>
                                </div>
                                <div class="col-4">
                                    <div class="input-group">
                                        <select name="payment_type" class="form-select @error('payment_type') is-invalid @enderror" id="item-part" required>
                                                <option value="cash">Cash</option>
                                        </select>

                                          <div class="col-8">
                                            <input type="number" name="amount" value="{{ old('amount') }}" class="form-control" placeholder="0.00" id="amount" aria-describedby="button-addon-paid" required>
                                          </div>
                                        <!-- error -->
                                        @error('payment_type')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                        @enderror

                                        <!-- error -->
                                        @error('amount')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror

                                    </div>
                                </div>
                                <div class="col-2">
                                        <select name="balance_status" class="form-select" aria-label="Default select example">
                                            <option value="0" selected >Payable</option>
                                            <option value="1">Receivable</option>
                                        </select>
                                    </div>
                            </div>

                            <div class="mb-3 row">
                                <div class="col-2">
                                    <label for="cash-id" class="mt-1 form-label">&nbsp;</label>
                                </div>

                                <div class="col-6">
                                    <select name="cash_id" class="form-select  @error('cash_id') is-invalid @enderror" id="cash-id" required>
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

                            <div class="mb-3 row">
                                <div class="col-2">
                                    <label for="adjustment" class="mt-1 form-label">Adjustment</label>
                                </div>

                                <div class="col-6">
                                    <div class="input-group">
                                        <input type="number" name="adjustment" value="{{ old('adjustment') }}" class="form-control @error('adjustment') is-invalid @enderror" placeholder="0.00" id="adjustment" aria-describedby="button-addon-adjustment">
                                    </div>

                                <!-- error -->
                                        @error('adjustment')
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

                                <div class="col-6">
                                    <textarea name="note" class="form-control @error('note') is-invalid @enderror" id="note" rows="2"
                                        placeholder="Optional">{{ old('note')}}</textarea>

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
                                        <span class="p-1">Create & Save</span>
                                    </button>
                                </div>
                            </div>

                        </form>
            </div>
        </div>
    </div>

     {{-- @push('styles')

        <link href="https://cdn.jsdelivr.net/npm/tom-select@2.1.0/dist/css/tom-select.css" rel="stylesheet">

    @endpush


    @push('scripts')
       <script src="https://cdn.jsdelivr.net/npm/tom-select@2.1.0/dist/js/tom-select.complete.min.js"></script>

        <script>
            new TomSelect("#select-supplier",{
                create: true,
                sortField: {
                    field: "text",
                    direction: "asc"
                }
            });
        </script>
    @endpush --}}
</x-app-layout>

