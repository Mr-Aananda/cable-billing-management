<div class="widget mt-3 collapse print-none {{ request()->search ? 'show' : '' }}" id="search">

    <div class="widget-body">
            <div class="d-flex align-items-center flex-wrap">
                <div>
                    <h4>Search Form</h4>
                    <small>The filter result depanding on your demand. </small>
                </div>
                <div class="btn-group ms-auto print-none">
                    <button type="button" class="btn btn-sm btn-primary ms-3" data-bs-toggle="collapse" data-bs-target="#search">
                        <x-icons.chevron/>
                    </button>
                </div>
            </div>
            <!-- search area -->
            <div class="px-0 border-0 card card-body rounded-0">
                <!-- search form -->
                <form action="{{ route("monthly-recharge.index") }}" method="GET">
                    <input type="hidden" name="search" value="1">
                    {{-- <input type="hidden" name="perPage" value="{{ $perPage }}"> --}}
                    <div class="row">
                        <div class="col-2">
                            <label for="select-name" class="form-label">Select Customer</label>
                            <select id="select-name" placeholder="... Choose one ..." autocomplete="off" name="customer_id">
                                <option value="">... Choose one ...</option>
                                @foreach ($customers as $customer )
                                    <option {{ request()->search ? request()->customer_id == $customer->id ? 'selected' : '' : '' }} value="{{$customer->id}}">{{$customer->name}}</option>
                                @endforeach
                            </select>

                        </div>
                        <div class="col-2">
                            <label for="cable_id" class="form-label">Cable ID</label>
                            <input type="number" name="cable_id" value="{{ request()->cable_id }}" class="form-control"
                                placeholder="Search by cable id">
                        </div>

                        {{-- <div class="col-2">
                            <label for="select-area" class="form-label">Select Area</label>
                            <select id="select-area" placeholder="... Choose one ..." autocomplete="off" name="area_id">
                                <option value="">... Choose one ...</option>
                                @foreach ($areas as $area )
                                    <option {{ request()->search ? request()->area_id == $area->id ? 'selected' : '' : '' }} value="{{$area->id}}">{{$area->name}}</option>
                                @endforeach
                            </select>

                        </div> --}}

                        <div class="col-2">
                            <label for="mobile" class="form-label">Mobile no</label>
                            <input type="number" name="mobile_no" value="{{ request()->mobile_no }}" class="form-control"
                                placeholder="01xxxxxxxxx">
                        </div>

                        <div class="col-2">
                            <label for="status" class="form-label">Status Type</label>
                            <select name="status" class="form-control" id="status">
                                <option value="" selected disabled> -- Choose one -- </option>
                                <option value="active" {{ request()->status == 'active' ? 'selected' : '' }} > Active </option>
                                <option value="inactive" {{ request()->status == 'inactive' ? 'selected' : '' }} > Inactive</option>
                                <option value="disconnected" {{ request()->status == 'disconnected' ? 'selected' : '' }} > Disconnected </option>
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
         <!-- search area end -->
    </div>
</div>
