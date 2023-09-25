@section('title', 'Custom SMS')

<x-app-layout>
     <!-- Start Menu-->
    <div class="widget mt-3">
        <div class="widget-body">
            <div class="d-flex align-items-center flex-wrap">
                <nav aria-label="breadcrumb">
                    {{ Breadcrumbs::render('custom sms') }}
                </nav>
                <div class="ms-md-auto ms-0">
                     <a href="{{ route('sms.custom-sms') }}" class="btn btn-sm  btn-primary" title="Reload page">
                          <x-icons.refresh/>
                        </a>
                </div>
            </div>
        </div>
    </div>
    <!-- End Menu-->

        <div class="widget mt-3" id="print-widget">

            <!-- Start print header-->
            @include('layouts.partials.printHead')
            <!-- End print header -->

            <!-- Start widget head -->
            <div class="widget-head">
                <div class="d-flex align-items-center flex-wrap">
                    <div class="mt-3">
                        <h4 class="main-title">Custom SMS Send</h4>
                        <p><small>Can send <strong>Custom SMS</strong> from here.</small></p>
                    </div>
                    <div class="ms-auto print-none">
                        <a type="button" class="btn btn-sm btn-outline-secondary" onclick="printable('print-widget')">
                            <x-icons.print/>
                        </a>
                    </div>
                </div>

                <div class="mt-3">
                    <p class="mb-2 fw-bold text-muted"> 1. Type Mobile Number and Use Comma to separate more than one Number.</p>
                    <p class="mb-2 fw-bold text-muted"> 2. Type Message  and then click Send button to Send SMS.</p>
                    <div class="mt-4">
                        <strong>
                            {{-- <span class="fs-5 text-muted">SMS Balance: {{ $sms_balance }} (BDT)</span> &nbsp; &nbsp; --}}
                            <span class="fs-5 text-muted">Remaining SMS: {{ $total_sms_count }}</span>
                        </strong>
                    </div>
            </div>

            </div>
            <!-- End widget head-->

            <div class="widget-body">
                <form action="{{ route('sms.custom-sms') }}" method="POST">
                    @csrf
                        <div class="p-0 mt-4 card-body">
                            <div class="mb-3 row">
                                <!-- Write number Start-->
                                <div class="col-12">
                                    <label for="mobile" class="mt-1 form-label required">Mobile Number</label>
                                        <textarea name="mobiles" class="form-control" id="mobile" rows="3"
                                            placeholder="Use comma to separate number" required>{{ old('mobiles') }}</textarea>

                                        <!-- error -->
                                        @error('mobiles')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                </div>
                                <!-- Write number End-->

                                <!-- Write Message Start-->
                                <div class="col-12 mt-2">
                                    <label for="message" class="mt-1 form-label required">Message</label>
                                        <textarea name="message" class="form-control" id="message" rows="4"
                                            placeholder="Type message here.." required>{{ old('message')}}</textarea>

                                        <!-- error -->
                                        @error('message')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                </div>
                                <!-- Write Message End-->
                        </div>

                         <div class="row">
                             <!-- SMS & Character count start -->
                            <div class="col-4">
                                <p class="text-muted">
                                    <span>
                                        <strong>Total Characters</strong>
                                        <input type="text" id="total_characters" class="form-control" name="total_characters" value="30" readonly>
                                    </span>
                                </p>
                            </div>

                            <div class="col-4">
                                <p class="text-muted">
                                    <span>
                                        <strong>Total Messages</strong>
                                        <input  type="text" id="total_messages" class="form-control" value="1" name="total_messages" readonly>
                                    </span>
                                </p>
                            </div>
                            <!-- SMS & Character count end -->
                        </div>

                        <div class="mb-3 row">
                            <div class="col-2">
                                <label class="mt-1 form-label">&nbsp;</label>
                            </div>

                            <div class="col-12">
                                <button type="reset" class="btn btn-warning me-2">
                                    <i class="bi bi-dash-square"></i>
                                    <span class="p-1">Reset</span>
                                </button>

                                <button type="submit" class="btn btn-success">
                                    <i class="bi bi-envelope"></i>
                                    <span class="p-1">Send</span>
                                </button>
                            </div>
                        </div>

                    </div>
                </form>

            </div>
        </div>

    @push('scripts')

        <!-- SMS & Character count js start -->
        <script src="{{ vite_asset("resources/template/sms/sms.js") }}"></script>
        <!-- SMS & Character count js end -->
    @endpush
</x-app-layout>
