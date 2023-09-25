@section('title', 'Template SMS')

<x-app-layout>
     <!-- Start Menu-->
    <div class="widget mt-3">
        <div class="widget-body">
            <div class="d-flex align-items-center flex-wrap">
                <nav aria-label="breadcrumb">
                    {{ Breadcrumbs::render('template sms') }}
                </nav>
                <div class="ms-md-auto ms-0">
                    {{-- <a href="#search" class="btn btn-sm btn-primary" title="Search" data-bs-toggle="collapse" role="button" aria-expanded="false">
                        <x-icons.search/>
                    </a> --}}
                    <a href="{{ route('sms.template-sms') }}" class="btn btn-sm  btn-primary" title="Reload page">
                          <x-icons.refresh/>
                        </a>
                </div>

            </div>
        </div>
    </div>
    <!-- End Menu-->
       <!-- Start Search-->
         {{-- @include('sms.search') --}}
       <!-- End Search-->

        <div class="widget mt-3" id="print-widget">

            <!-- Start print header-->
            @include('layouts.partials.printHead')
            <!-- End print header -->

            <!-- Start widget head -->
            <div class="widget-head">
                <div class="d-flex align-items-center flex-wrap">
                    <div class="mt-3">
                        <h4 class="main-title">Template SMS Send</h4>
                        <p><small>Can send <strong>Template SMS</strong> from here.</small></p>
                        <p><small>About {{ isset($datas) ? count($datas) : 0 }} results found.</small></p>
                    </div>
                    <div class="ms-auto print-none">
                        <a type="button" class="btn btn-sm btn-outline-secondary" onclick="printable('print-widget')">
                            <x-icons.print/>
                        </a>
                    </div>
                </div>

                <div class="mt-3">
                    <p class="mb-2 fw-bold text-muted"> 1. If don't want send SMS Please Uncheck Customer.</p>
                    <p class="mb-2 fw-bold text-muted"> 2. Select Message and then click Send button to Send SMS.</p>
                    <div class="mt-4">
                       <strong>
                            {{-- <span class="fs-5 text-muted">SMS Balance: {{ $sms_balance }} (BDT)</span> &nbsp; &nbsp; --}}
                            <span class="fs-5 text-muted">Remaining SMS: {{ $total_sms_count }}</span>
                        </strong>
                    </div>
                </div>
                <div class="mt-3">
                    <form action="{{route($route_name)}}" method="GET">
                        <input type="hidden" name="search" value="1">
                        <div class="row">
                            <div class="col-8">
                                <label for="type">Filter by:</label>
                                <select name="type" id="type" class="form-control">
                                    <option value="all" {{ $type == 'all' ? 'selected' : '' }}>All</option>
                                    <option value="customer" {{ $type == 'customer' ? 'selected' : '' }}>Customer</option>
                                    <option value="supplier" {{ $type == 'supplier' ? 'selected' : '' }}>Supplier</option>
                                    <option value="employee" {{ $type == 'employee' ? 'selected' : '' }}>Employee</option>
                                </select>
                            </div>
                            <div class="col-2">
                                <label for="perPage" class="form-label">Records per page</label>
                                <select id="perPage" name="perPage" class="form-select" onchange="this.form.submit()">
                                    <option value="25" {{ Request::get('perPage') == 25 ? 'selected' : '' }}>25</option>
                                    <option value="50" {{ Request::get('perPage') == 50 ? 'selected' : '' }}>50</option>
                                    <option value="100" {{ Request::get('perPage') == 100 ? 'selected' : '' }}>100</option>
                                    <option value="250" {{ Request::get('perPage') == 250 ? 'selected' : '' }}>250</option>
                                    <option value="all" {{ Request::get('perPage') == 'all' ? 'selected' : '' }}>All</option>
                                </select>
                            </div>
                            <!-- button -->
                            <div class="col-2">
                                <label class="form-label">&nbsp;</label>
                                <button type="submit" class="btn btn-block w-100  btn-success rounded-pill">
                                    <x-icons.search/>
                                    <span class="p-1">Search</span>
                                </button>
                            </div>
                        </div>
                    </form>
                </div>

            </div>
            <!-- End widget head-->

            <div class="widget-body">
                <form action="{{ route('sms.template-sms') }}" method="POST">
                        @csrf
                        <div class="mb-3 table-responsive">
                            <table class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th scope="col" class="p-0">
                                            <label for="check-all" class="p-2 d-block">
                                                <input type="checkbox" class="me-2" id="check-all">
                                                <span>SL </span>
                                            </label>
                                        </th>
                                         <th scope="col">Name</th>
                                        <th scope="col">Mobile No</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    @forelse($datas as $index=> $data)
                                        <tr>
                                            <th scope="row" class="p-0">
                                                <label class="p-2 d-block">
                                                    <input type="checkbox" name="mobiles[]" value="{{ $data->mobile_no }}" class="me-2">
                                                        {{ $index + $datas->firstItem() }}.
                                                </label>
                                            </th>
                                            <td>{{ $data->name ?? '' }}</td>
                                            {{-- <td>{{ $data->mobile_no ?? ''}}</td> --}}
                                            <td>
                                                @if($data->type === 'employee')
                                                    {{ $data->mobile ?? '' }}
                                                @else
                                                    {{ $data->mobile_no ?? '' }}
                                                @endif
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <th colspan="3">No data available here. </th>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                        <!-- data table end -->

                        <!-- paginate -->
                        <div class="container-fluid mt-2 mb-2">
                            <nav>
                                {{ $datas->withQueryString()->links() }}
                            </nav>
                        </div>
                        <!-- pagination end -->

                        <div class="mb-3 row">
                            <!-- Template start -->
                            <div class="col-8">
                                <label for="template" class="mt-1 form-label required">Template</label>
                                <select name="template" onchange="myFunction(event)" class="form-select" id="template" required>
                                    <option value="" selected disabled> --Select template-- </option>
                                    @foreach ($templates as $template)
                                        <option value="{{ $template->description }}">{{ $template->title }}</option>
                                    @endforeach
                                </select>

                                <!-- error -->
                                @error('template')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                            <!-- Template end -->
                        </div>

                        <div class="mb-3 row">
                            <!-- Write Message Start-->
                            <div class="col-8">
                                <label for="message" class="mt-1 form-label required">Message</label>
                                    <textarea name="message" class="form-control" id="message" rows="4"
                                        placeholder="Type message here.." required readonly></textarea>

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
                    </form>
            </div>
        </div>

    @push('scripts')
        <!-- checked all program script -->
        <script>
            // select master & child checkboxes
            let masterCheckbox = document.getElementById("check-all"),
                childCheckbox = document.querySelectorAll('[name="mobiles[]"]');
            // add 'change' event into master checkbox
            masterCheckbox.addEventListener("change", function() {
                // add/remove attribute into child checkbox conditionally
                for (var i = 0; i < childCheckbox.length; i++) {
                    if(this.checked) {
                        childCheckbox[i].checked = true; // add attribute
                    } else {
                        childCheckbox[i].checked = false; // add attribute
                    }
                }
            });
        </script>
        <!-- checked all program script end -->

        <!-- SMS & Character count js start -->
        <script src="{{ vite_asset("resources/template/sms/sms.js") }}"></script>
        <!-- SMS & Character count js end -->

    @endpush
</x-app-layout>
