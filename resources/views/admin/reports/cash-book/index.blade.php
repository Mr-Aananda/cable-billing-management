@section('title', 'Cash Book')

<x-app-layout>
    <div class="widget mt-3" id="print-widget">

            <!-- Start print header =========================== -->
            @include('layouts.partials.printHead')
            <!-- End print header =========================== -->

            <!-- Start widget head =========================== -->
            <div class="widget-head mt-2">
                <div class="d-flex align-items-center flex-wrap">
                    <div>
                        <h3>Cash Book</h3>
                    </div>
                    <div class="ms-auto print-none">
                        <a type="button" class="btn btn-sm btn-primary" onclick="printable('print-widget')">
                            <x-icons.print/>
                        </a>

                        <a href="{{ route('report.cash-book') }}" class="btn btn-sm btn-primary" title="Reload page">
                          <x-icons.refresh/>
                        </a>
                    </div>
                </div>
            </div>
            <!-- End widget head =========================== -->

            <div class="widget-body">
                <div class="print-none">
                     <form action="{{ route('report.cash-book-date-data') }}" method="GET">
                        <input type="hidden" name="search" value="1">
                        <div class="row">
                            <div class="col-6">
                                <label for="date" class="form-label">Date</label>
                                <input type="date" name="date" value="{{ request()->date }}" class="form-control">
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

                <div class="row col-md-12 mt-3">
                     <div class="col-md-6">
                        <table class="table table-bordered table-sm">
                            <thead>
                                <tr>
                                    <th>Income Details</th>
                                    <th class="text-end">Amount</th>
                                </tr>
                            </thead>
                            <tbody>
                                 <tr>
                                    <td class="text-wrap">Opening Balance</td>
                                    <td class="text-end">{{number_format($data['opening_balance']->balance ?? 0,2)}}</td>
                                </tr>

                                {{-- Sale history --}}
                                <tr>
                                    <th colspan="2" style="font-size: larger">Sale :</th>
                                </tr>

                                @foreach ($data['sales'] as $sale )

                                 <tr>
                                    <td class="text-wrap">{{$sale->customer->name}}</td>
                                    <td class="text-end">{{number_format($sale->total_paid,2)}}</td>
                                </tr>

                                @endforeach

                                <tr>
                                    <th>Total Sale:</th>
                                    <td class="text-end">
                                        {{number_format($data['total_sale'],2)}}
                                    </td>
                                </tr>

                                {{-- Due manage history --}}
                                <tr>
                                    <th colspan="2" style="font-size: larger">Due Recieve:</th>
                                </tr>

                               @foreach ($data['due_receives'] as $due )
                                <tr>
                                    <td class="text-wrap">{{$due->customer->name}}</td>
                                    <td class="text-end">
                                        {{number_format($due->amount,2)}}
                                    </td>
                                </tr>

                               @endforeach
                                <tr>
                                    <th>Total Due Recieve:</th>
                                    <td class="text-end">
                                        {{number_format($data['total_due_receive'],2)}}
                                    </td>
                                </tr>

                                {{-- Monthly recharge history --}}
                                <tr>
                                    <th colspan="2" style="font-size: larger">Monthly Recharge:</th>
                                </tr>
                                @foreach ($data['monthly_recharge'] as $recharge )
                                <tr>
                                    <td class="text-wrap">{{$recharge->customer->name}}</td>
                                    <td class="text-end">
                                        {{number_format($recharge->amount,2)}}
                                    </td>
                                </tr>
                               @endforeach
                                <tr>
                                    <th>Total Monthly Recharge:</th>
                                    <td class="text-end">
                                        {{number_format($data['total_monthly_recharge'],2)}}
                                    </td>
                                </tr>

                                <tr>
                                    <th style="font-size: larger">Total Income :</th>
                                    <td class="text-end fw-bold">
                                        {{number_format($data['total_sale'] + $data['total_due_receive'],2)}}
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <div class="col-md-6">
                        <table class="table table-bordered table-sm">
                            <thead>
                                <tr>
                                    <th>Expense Details</th>
                                    <th class="text-end">Amount</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <th colspan="2" style="font-size: larger">Purchase :</th>
                                </tr>

                                @foreach ($data['purchases'] as $purchase )

                                <tr>
                                    <td class="text-wrap">{{$purchase->supplier->name}}</td>
                                    <td class="text-end">{{number_format($purchase->total_paid,2)}}</td>
                                </tr>

                                @endforeach

                                <tr>
                                    <th>Total Purchase:</th>
                                    <td class="text-end">
                                         {{number_format($data['total_purchase'],2)}}
                                    </td>
                                </tr>

                                <tr>
                                    <th colspan="2" style="font-size: larger">Due Payment:</th>
                                </tr>

                                @foreach ($data['due_payments'] as $payment )
                                <tr>
                                    <td class="text-wrap">{{$payment->supplier->name}}</td>
                                    <td class="text-end">
                                        {{number_format(abs($payment->amount),2)}}
                                    </td>
                                </tr>

                               @endforeach

                                <tr>
                                    <th>Total Due Payment:</th>
                                    <td class="text-end">
                                        {{number_format(abs($data['total_due_payment']),2)}}
                                    </td>
                                </tr>

                                <tr>
                                    <th colspan="2" style="font-size: larger">Expense:</th>
                                </tr>

                                <tr>
                                    <th>Total Expense:</th>
                                    <td class="text-end">
                                        {{number_format($data['total_expense'],2)}}
                                    </td>
                                </tr>

                                <tr>
                                    <th style="font-size: larger">Total Expense :</th>
                                    <td class="text-end fw-bold">
                                        {{number_format(
                                            $data['total_purchase'] +
                                           abs( $data['total_due_payment']) +
                                            $data['total_expense']
                                        ,2)}}
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="row col-md-12 p-2">
                    <table class="table table-bordered table-sm">
                        <tbody>
                            <tr>
                                <td style="font-size: larger" class="text-wrap fw-bold">Remaining Balance : </td>
                                <td class="text-end fw-bold">{{number_format($data['closing_balance'],2 )}}</td>
                            </tr>

                        </tbody>
                    </table>

                    <div class="container mt-3">
                        <!-- Start Modal button ================================= -->
                        <button class="btn btn-success print-none float-end" data-bs-toggle="modal" data-bs-target="#closingBalanceModal">Closing balance</button>
                        <!-- End Modal button ================================= -->
                        <!-- Start Modal ===================================== -->
                        <div class="modal fade" id="closingBalanceModal" tabindex="-1" aria-labelledby="closingBalanceModalLabel"
                            aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="closingBalanceModalLabel">Create closing balance</h5>
                                        <button type="button" class="btn icon" data-bs-dismiss="modal" aria-label="Close"><i class="bi bi-x-lg"></i></button>
                                    </div>
                                    <div class="modal-body">
                                        <form action="{{route('report.closing-balance-store')}}" method="POST">
                                            @csrf
                                            <div class="mb-2">
                                                <label for="date" class="col-form-label required">Date:</label>
                                                <input type="date" name="date" class="form-control" value="{{date('Y-m-d')}}" id="date" required>
                                            </div>
                                            <div class="mb-2">
                                                <label for="balance" class="col-form-label required">Balance:</label>
                                                <input type="number" name="balance" class="form-control" value="{{ $data['closing_balance']}}" id="balance" placeholder="0.00" required readonly>
                                            </div>

                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                                                <button type="submit" class="btn btn-success">Save changes</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- End Modal ===================================== -->

                    </div>
                </div>

            </div>
     </div>

</x-app-layout>
