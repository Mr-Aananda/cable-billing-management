@section('title', 'Create expense')

<x-app-layout>
     <!-- Start Menu-->
    <div class="widget mt-3">
        <div class="widget-body">

            <div class="d-flex align-items-center flex-wrap">
                <nav aria-label="breadcrumb">
                    {{ Breadcrumbs::render('expense create') }}
                </nav>

                <div class="ms-md-auto ms-0 btn-group">

                    <!-- header icon -->
                    <a href="{{ route('expense.index') }}" title="Go back" class="print-none btn btn-sm btn-primary ms-auto">
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
                        <h4 class="main-title">Create new expense</h4>
                        <p><small>Can create <strong>expense</strong> from here.</small></p>
                    </div>
                </div>

            </div>
            <div class="widget-body">

                <form action="{{ route('expense.store') }}" method="POST">
                      @csrf

                    <!-- type text -->
                    <div class="mb-3 row">
                        <div class="col-2">
                            <label for="date" class="mt-1 form-label required">Date</label>
                        </div>

                        <div class="col-5">
                            <input type="date" name="date" value="{{ old('date')}}" class="form-control @error('date') is-invalid @enderror" id="date" required>

                            <!-- error -->
                            @error('date')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                    </div>

                    {{-- React component start --}}
                    <div
                        data-categories="{{ $categories }}"
                        data-expense="{{ json_encode([]) }}"
                        data-errors="{{ $errors ?? [] }}"
                        id="get-subcategories-by-category">
                    </div>
                    {{-- React component end --}}

                    <div class="mb-3 row">
                        <div class="col-2">
                            <label for="amount" class="mt-1 form-label required">Amount</label>
                        </div>

                        <div class="col-5">
                            <div class="input-group">
                                <div class="col-4">
                                    <select name="payment_type" class="form-select @error('payment_type') is-invalid @enderror" id="payment_type" required>
                                        <option value="cash" selected >Cash</option>
                                        {{-- <option value="cash" >Bkash</option> --}}
                                        {{-- <option value="rocket" >Rocket</option> --}}
                                        {{-- <option value="nagad" >Nagad</option> --}}
                                        {{-- <option value="bank" >Bank</option> --}}
                                    </select>
                                       <!-- error -->
                                        @error('payment_type')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                </div>

                                <input type="number" name="amount" value="{{ old('amount')}}" step="any" min="0"
                                    class="form-control @error('amount') is-invalid @enderror" id="amount" placeholder="0.00" aria-describedby="amount-addon" required>

                                    <!-- error -->
                                    @error('amount')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                            </div>
                        </div>
                    </div>

                    <div class="mb-3 row">
                        <div class="col-2">
                            <label for="cash-id" class="mt-1 form-label">&nbsp;</label>
                        </div>

                        <div class="col-5">
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
