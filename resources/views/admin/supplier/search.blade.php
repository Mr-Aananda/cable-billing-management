<div class="widget mt-3 collapse print-none {{ request()->search ? 'show' : '' }}" id="search">

    <div class="widget-body">
            <div class="d-flex align-items-center flex-wrap">
                <div>
                    <h4>Search Form</h4>
                    <small>The filter result depanding on your demand. </small>
                </div>
                <div class="ms-auto print-none">
                    <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="collapse" data-bs-target="#search">
                        <x-icons.chevron/>
                    </button>
                </div>
            </div>
            <!-- search area -->
            <div class="px-0 border-0 card card-body rounded-0">
                <!-- search form -->
                <form action="{{ route($route_name) }}" method="GET">
                    <input type="hidden" name="search" value="1">
                    <div class="row">
                        <div class="col-3">
                            <label for="select-name" class="form-label">Select Supplier</label>
                            <select id="select-name" placeholder="... Choose one ..." autocomplete="off" name="name">
                                <option value="">... Choose one ...</option>
                                @foreach ($suppliers as $supplier )
                                    <option {{ request()->search ? request()->name == $supplier->name ? 'selected' : '' : '' }} value="{{$supplier->name}}">{{$supplier->name}}</option>
                                @endforeach
                            </select>

                        </div>

                        <div class="col-3">
                            <label for="mobile" class="form-label">Mobile no</label>
                            <input type="number" name="mobile_no" value="{{ request()->mobile_no }}" class="form-control"
                                placeholder="01xxxxxxxxx">
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