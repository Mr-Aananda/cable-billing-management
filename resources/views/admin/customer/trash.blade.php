@section('title', 'Customers trash')

<x-app-layout>
    <!-- Start Menu-->
    <div class="widget mt-3">
        <div class="widget-body">

            <div class="d-flex align-items-center flex-wrap">
                <nav aria-label="breadcrumb">
                    {{ Breadcrumbs::render('customer trash') }}
                </nav>

                <div class="ms-md-auto ms-0">

                    <a href="#search" class="btn btn-sm btn-primary" title="Search" data-bs-toggle="collapse" role="button" aria-expanded="false">
                        <x-icons.search/>
                    </a>

                    <a href="{{ route('customer.create') }}" class="btn btn-sm btn-primary" title="Create new">
                        <x-icons.create/>
                    </a>
                     <a href="{{ route('customer.trash') }}" class="btn btn-sm btn-primary" title="Reload page">
                            <x-icons.refresh/>
                    </a>

                    <a href="{{ route('customer.index') }}" class="btn btn-sm btn-primary" title="Go back">
                        <x-icons.back/>
                    </a>

                </div>
            </div>

        </div>
    </div>
    <!-- End Menu-->
    @include('admin.customer.search')

        <div class="widget mt-3" id="print-widget">

            <!-- Start print header =========================== -->
            @include('layouts.partials.printHead')
            <!-- End print header =========================== -->

            <!-- Start widget head =========================== -->
            <div class="widget-head">
                <div class="d-flex align-items-center flex-wrap">
                    <div>
                        <h3>All trashes</h3>
                        <small>About {{count($customers)}} results found</small>
                    </div>
                    <div class="ms-auto print-none">
                        <a type="button" class="btn btn-sm btn-secondary" onclick="printable('print-widget')">
                            <x-icons.print/>
                        </a>
                    </div>
                </div>

            </div>
            <!-- End widget head =========================== -->

            <div class="widget-body">
                <form action="{{ route('customer.trash') }}" method="POST">
                    @csrf
                    <!-- Start Table ============================================== -->
                    <div class="table-responsive">
                        <table class="table custom table-hover action-hover sm">
                            <thead>
                                <tr>
                                    <th scope="col" class="p-0">
                                        <label for="check-all" class="p-2 d-block">
                                            <input type="checkbox" class="me-2" id="check-all">
                                            <span>SL </span>
                                        </label>
                                    </th>
                                    <th scope="col">Name</th>
                                    <th scope="col">Mobile no</th>
                                    <th scope="col">Balance</th>
                                    <th scope="col">Area</th>
                                    <th scope="col" class="print-none text-end">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($customers as $customer)
                                <tr>
                                    <th scope="row" class="p-0">
                                        <label class="p-2 d-block">
                                            <input type="checkbox" name="customers[]" value="{{ $customer->id }}" class="me-2">
                                            {{ $customers->firstItem() + $loop->index }}.
                                        </label>
                                    </th>
                                    <td>{{$customer->name}}</td>
                                    <td>{{$customer->mobile_no}}</td>
                                    <td>
                                        {{ number_format(abs($customer->balance), 2) }}
                                        <span class="{{ $customer->balance >= 0 ? 'text-success' : 'text-danger' }}">{{ $customer->balance >= 0 ? '(Rec)' : '(Pay)' }}</span>
                                    </td>
                                    <td>{{$customer->area->name ?? "not found"}}</td>
                                    <td class="print-none text-end">
                                        <a href="{{route('customer.restore',$customer->id)}}" title="Restore" class="btn btn-sm btn-outline-success">
                                            <x-icons.restore/>
                                        </a>

                                        <a href="{{ route('customer.permanentDelete', $customer->id) }}" class="btn btn-sm btn-outline-danger" onclick="return confirm('Are you sure, want to delete this data permanently?')" title="Permanent delete" >
                                            <x-icons.trash/>
                                        </a>

                                    </td>
                                </tr>

                                @empty
                                <tr>
                                    <th colspan="6">Trash list is empty.</th>
                                </tr>

                                @endforelse

                            </tbody>
                        </table>
                    </div>
                    <!-- End Table ============================================== -->
                        <!-- submit button -->
                    <div class="mt-3">
                        <button class="btn btn-sm btn-success me-2" name="restore" value="1" onclick="return confirm('Do you want to restore all selected record(s)?')" {{ ($customers->count() > 0) ? '' : 'disabled'}}>Restore all</button>

                        <button class="btn btn-sm  btn-danger" name="delete" value="1" onclick="return confirm('The selected record(s) will be delete permanently!')" {{ ($customers->count() > 0) ? '' : 'disabled'}}>Permanently delete</button>
                    </div>
                    <!-- submit button end -->
                </form>


             <!-- paginate -->
                <div class="container-fluid mt-3 mb-3">
                    <nav>
                        {{ $customers->withQueryString()->links() }}
                    </nav>
                </div>
                <!-- pagination end -->
        </div>

    @push('scripts')
        <!-- checked all program script -->
        <script>
            // select master & child checkboxes
            let masterCheckbox = document.getElementById("check-all"),
                childCheckbox = document.querySelectorAll('[name="customers[]"]');

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
    @endpush

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
        </script>

        <script>
            new TomSelect("#select-name",{
                create: true,
                sortField: {
                    field: "text",
                    direction: "asc"
                }
            });
        </script>
    @endpush

</x-app-layout>
