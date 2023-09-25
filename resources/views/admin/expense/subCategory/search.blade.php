<div class="widget mt-3 collapse print-none {{ request()->search ? 'show' : '' }}" id="search">

    <div class="widget-body">
            <div class="d-flex align-items-center flex-wrap">
                <div>
                    <h4>Search Form</h4>
                    <small>The filter result depanding on your demand</small>
                </div>
                <div class="btn-group ms-auto print-none">
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
                        {{-- search by subcategory name --}}
                        <div class="col-4">
                            <label for="name" class="form-label">Subcategory name</label>
                            <input type="text" min="0"  name="name" value="{{ request()->name }}" class="form-control"
                                placeholder="Character only">
                        </div>

                          {{-- Search by category --}}

                        <div class="col-3">
                            <label for="select-category" class="form-label">Select Category</label>
                            <select id="select-category" placeholder="... Choose one ..." autocomplete="off" name="category_id">
                                <option value="">... Choose one ...</option>
                                @foreach ($categories as $category )
                                    <option {{ request()->search ? request()->category_id == $category->id ? 'selected' : '' : '' }} value="{{$category->id}}">{{$category->name}}</option>
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
