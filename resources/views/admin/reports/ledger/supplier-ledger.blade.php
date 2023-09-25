@section('title', 'Supplier-ledger')

<x-app-layout>
       <div class="widget mt-3" id="print-widget">

            <!-- Start print header =========================== -->
            @include('layouts.partials.printHead')
            <!-- End print header =========================== -->

            <!-- Start widget head =========================== -->
            <div class="widget-head">
                <div class="d-flex align-items-center flex-wrap">
                    <div>
                        <h3>Ledger report : Supplier</h3>
                    </div>
                    <div class="ms-auto print-none">
                        <a type="button" class="btn btn-sm btn-primary" onclick="printable('print-widget')">
                            <x-icons.print/>
                        </a>

                        <a href="{{ route('ledger.supplier-ledger') }}" class="btn btn-sm  btn-primary" title="Reload page">
                          <x-icons.refresh/>
                        </a>
                    </div>
                </div>

            </div>
            <!-- End widget head =========================== -->

            <div class="widget-body">
                 <!-- search area -->
                <div class="print-none {{ request()->search ? 'show' : '' }}" id="supplierLedger-search">
                    <div class="px-0 border-0 card card-body rounded-0">
                        <form action="{{ route('ledger.supplier-ledger') }}" method="GET" >
                            <input type="hidden" name="search" value="1">
                            <div class="row gy-1 gx-3">
                                <div class="col-3">
                                    <label for="date" class="form-label">Date (From)</label>
                                    <input
                                    value="{{ (request()->search) ? request()->form_date : date('Y-m-d') }}"
                                    type="date"
                                    id="formdate"
                                    name="form_date"
                                    class="form-control"
                                    placeholder="YYYY-MM-DD">
                                </div>
                                <div class="col-3">
                                    <label for="date" class="form-label">Date (To)</label>
                                    <input
                                    value="{{ (request()->search) ? request()->to_date : date('Y-m-d')}}"

                                    type="date"
                                    id="todate"
                                    name="to_date"
                                    class="form-control"
                                    placeholder="YYYY-MM-DD">
                                </div>
                                <div class="col-3">
                                    <label for="select-name" class="form-label">Select Supplier</label>
                                    <select id="select-name" placeholder="... Choose one ..." autocomplete="off" name="supplier_id">
                                        <option value="">... Choose one ...</option>
                                        @foreach ($suppliers as $supplier )
                                            <option {{ request()->search ? request()->supplier_id == $supplier->id ? 'selected' : '' : '' }} value="{{$supplier->id}}">{{$supplier->name}}</option>
                                        @endforeach
                                    </select>

                                </div>

                                <!-- button -->
                                <div class="col-2">
                                    <label class="form-label">&nbsp;</label>
                                    <button type="submit" class="btn btn-block w-100 custom-btn btn-success">
                                        <i class="bi bi-search"></i>
                                        <span class="p-1">Search</span>
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- search area end -->

            <!-- Start Table ============================================== -->
                    @if (request()->search)
                    <div class="mb-3 mt-5 table-responsive">
                        <table class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th scope="col">SL</th>
                                    <th scope="col">Date</th>
                                    <th scope="col">Particular</th>
                                    <th scope="col"  class="text-end" >Debit</th>
                                    <th scope="col"  class="text-end">Credit</th>
                                    {{-- <th scope="col"  class="text-end">Discount</th> --}}
                                    <th scope="col"  class="text-end">Balance</th>
                                </tr>
                            </thead>

                            <tbody>
                                <tr>
                                    <td>1.</td>
                                    <td></td>
                                    <td class="text-wrap">Opening Balance</td>
                                    <td colspan="4" class="text-end">
                                        @php
                                        $opening_balance = 0;
                                        $balance = 0;
                                        @endphp
                                        @if($total_debit > $total_credit)
                                            @php
                                                $opening_balance = $supplier_balance - ($total_debit - $total_credit) ;
                                                $balance = $opening_balance;
                                            @endphp
                                        @else
                                            @php
                                                $opening_balance = $supplier_balance + ($total_credit - $total_debit) ;
                                                $balance = $opening_balance;
                                            @endphp
                                        @endif
                                       {{ number_format(abs($opening_balance), 2) }} {{ $opening_balance >= 0 ? 'Rec' : 'Pay' }}
                                    </td>
                                    <td class="print-none"></td>
                                </tr>

                                @forelse ($supplier_ledgers as $ledger)
                                <tr>
                                    <td>{{ $loop->iteration + 1 }}</td>
                                    <td>{{ $ledger->date->format('d-M-Y') }}</td>

                                    <td class="text-wrap">
                                        @if ($ledger->type === 'purchase')
                                            <p>Product purchase</p>
                                        @elseif ($ledger->type === 'due_manage')
                                            <p>Due Manage</p>
                                        @else
                                        <p></p>
                                        @endif

                                    </td>

                                    <td class="text-end">
                                        @if ($ledger->type === 'purchase')
                                            {{ number_format($ledger->grand_total, 2) }}

                                        @elseif ($ledger->type === 'due_manage')
                                            <p>{{ (($ledger->amount <= 0) ? number_format($ledger->amount, 2) : number_format(0, 2)) }}</p>
                                        @else
                                        <p></p>
                                        @endif
                                    </td>

                                    <td class="text-end">
                                        @if ($ledger->type === 'purchase')
                                            {{ number_format($ledger->total_paid, 2) }}
                                        @elseif ($ledger->type === 'due_manage')
                                            <p>{{ (($ledger->amount > 0) ? number_format($ledger->amount, 2) : number_format(0, 2)) }}</p>
                                        @endif
                                    </td>

                                      <td class="text-end">
                                            @php
                                                if ($ledger->type === 'purchase') {
                                                    $balance += ($ledger->grand_total - $ledger->total_paid);
                                                }
                                                elseif ($ledger->type === 'due_manage'){
                                                    if ($ledger->amount >= 0) {
                                                        $balance -= $ledger->amount;
                                                    }else{
                                                        $balance += $ledger->amount;
                                                    }
                                                }
                                            @endphp
                                            {{ number_format(abs($balance), 2) }} {{ $balance >= 0 ? 'Rec' : 'Pay' }}
                                        </td>
                                </tr>

                                @empty
                                <tr>
                                    <td colspan="10" class="text-center">No ledger available</td>
                                </tr>

                                @endforelse
                                 <tr>
                                    <th colspan="3" class="text-end">Total</th>
                                    <td class="text-end">
                                        {{ number_format($total_debit, 2) }}
                                    </td>
                                    <td class="text-end">
                                        {{ number_format($total_credit, 2) }}
                                    </td>
                                </tr>

                            </tbody>
                        </table>
                    </div>
                    @endif


            <!-- End Table ============================================== -->

             <!-- paginate -->

                <!-- pagination end -->
    </div>

    @push('styles')

        <link href="https://cdn.jsdelivr.net/npm/tom-select@2.1.0/dist/css/tom-select.css" rel="stylesheet">

    @endpush


    @push('scripts')
       <script src="https://cdn.jsdelivr.net/npm/tom-select@2.1.0/dist/js/tom-select.complete.min.js"></script>

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
