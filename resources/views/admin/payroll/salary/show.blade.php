@section('title', 'Salary invoice')

<x-app-layout>

        <div class="widget mt-3" id="print-widget">

            <!-- Start print header =========================== -->
            @include('layouts.partials.printHead')
            <!-- End print header =========================== -->

            <!-- Start widget head =========================== -->
            <div class="widget-head">
                <div class="d-flex align-items-center flex-wrap">
                   <div class="print-none">
                        <h4 class="main-title">Employee salary invoice</h4>
                        <p><small>All the details below.</small></p>
                    </div>
                    <div class=" ms-auto print-none">
                        <a type="button" class="btn btn-sm btn-primary" onclick="printable('print-widget')">
                            <x-icons.print/>
                        </a>

                        <a href="{{ route('payroll-salary.index') }}" title="Go back" class="print-none btn btn-sm btn-primary ms-auto">
                            <x-icons.back/>
                        </a>

                    </div>
                </div>

            </div>
            <div class="widget-card border mt-3 p-3">

                <div class="widget-body">
                    <div class="row">
                        <p class="col-4 mb-2"><span style="font-size: larger">Name:</span> {{ $salary->employee->name }} </p>
                        <p class="col-4 mb-2"><span style="font-size: larger">Salary no:</span> {{$salary->salary_no }} </p>
                        <p class="col-4 mb-2"><span style="font-size: larger">Mobile:</span> {{ $salary->employee->mobile }} </p>
                        <p class="col-4"><span style="font-size: larger">Salary month:</span> {{ $salary->salary_month }} </p>
                        <p class="col-4"><span style="font-size: larger">Salary date:</span> {{ $salary->given_date  }} </p>
                    </div>

                    <div class="row mt-3">
                        <div class="col-12 table-responsive">
                            <table class="table table-bordered">
                                <thead >
                                    <tr>
                                        <th scope="col">Details</th>
                                        <th scope="col" class="text-end">Amount</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        @if($salary['basic_salary'] != null)
                                            <td>Basic salary</td>
                                            <td class="text-end">{{ number_format($salary['basic_salary']->amount, 2) }}</td>
                                        @endif
                                    </tr>
                                    <tr>
                                        @if($salary['bonus'] != null)
                                            <td>Bonus</td>
                                            <td class="text-end">{{number_format($salary['bonus']->amount,2) }}</td>
                                        @endif
                                    </tr>

                                    {{-- <tr>
                                        @if($salary->advancePaid)
                                            <td>Advanced</td>
                                            <td class="text-end"> -{{number_format($salary->advance_paid_amount,2) }}</td>
                                        @endif
                                    </tr> --}}

                                    <tr>
                                        @if($salary['deduction'] != null)
                                            <td>Deductions</td>
                                            <td class="text-end"> -{{number_format($salary['deduction']->amount,2) }}</td>
                                        @endif
                                    </tr>
                                </tbody>
                                <tfoot class="text-end border-top">
                                    <th>Total</th>
                                    <th>{{number_format($total_salary,2)}}</th>

                                    {{-- <th>{{number_format(($salary['basic_salary']->amount + $salary['bonus']->amount) - ($salary->employee->total_advance_paid  + $salary['deduction']->amount)  ,2)}}</th> --}}
                                </tfoot>
                            </table>
                        </div>
                    </div>
                    <!-- Footer -->
                <div class="footer mt-5">
                    <div class="row">
                        <div class="col-6">
                            Employee sign
                        </div>
                        <div class="col-6 text-end">
                            Authorized sign
                        </div>
                    </div>
                </div>
                <!-- End of the footer -->
                </div>
            </div>

        </div>

</x-app-layout>
