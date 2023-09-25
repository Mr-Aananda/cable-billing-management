<div class="widget mt-3 collapse print-none {{ request()->search ? 'show' : '' }}" id="search">

    <div class="widget-body">
            <div class="d-flex align-items-center flex-wrap">
                <div>
                    <h4>Search Form</h4>
                    <small>The filter result depanding on your demand</small>
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
                        {{-- date to date search --}}
                        <div class="col-3">
                            <label for="date" class="form-label">Date (From)</label>
                            <input
                            {{-- value="{{ (request()->search) ? request()->form_date : date('Y-m-d') }}" --}}
                            value="{{ (request()->search) ? request()->form_date : '' }}"
                            type="date"
                            id="formdate"
                            name="form_date"
                            class="form-control"
                            placeholder="YYYY-MM-DD">
                        </div>
                        <div class="col-3">
                            <label for="date" class="form-label">Date (To)</label>
                            <input
                            {{-- value="{{ (request()->search) ? request()->to_date : date('Y-m-d') }}" --}}
                            value="{{ (request()->search) ? request()->to_date : '' }}"
                            type="date"
                            id="todate"
                            name="to_date"
                            class="form-control"
                            placeholder="YYYY-MM-DD">
                        </div>

                        {{-- Search by category --}}
                        <div class="col-3">
                            <label for="select-category" class="form-label">Select Category</label>
                            <select id="select-category" placeholder="... Choose one ..." autocomplete="off" name="name">
                                <option value="">... Choose one ...</option>
                                @foreach ($categories as $category )
                                    <option {{ request()->search ? request()->name == $category->name ? 'selected' : '' : '' }} value="{{$category->name}}">{{$category->name}}</option>
                                @endforeach
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
