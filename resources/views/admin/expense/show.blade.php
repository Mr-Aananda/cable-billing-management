@section('title', 'Expense details')

<x-app-layout>
    <!-- Start Menu-->
    <div class="widget mt-3">
        <div class="widget-body">

            <div class="d-flex align-items-center flex-wrap">
                <nav aria-label="breadcrumb">
                    {{ Breadcrumbs::render('expense details',$expense) }}
                </nav>

                <div class="ms-md-auto ms-0">

                    <!-- header icon -->
                    <a href="{{ route('expense.index') }}" title="Go back" class="print-none btn btn-sm btn-primary ms-auto">
                        <x-icons.back/>
                    </a>

                </div>
            </div>

        </div>
    </div>
    <!-- End Menu-->


    <div class="col-md-12">
        <div class="widget mt-3">
             <div class="widget-head">
                <div class="d-flex align-items-center flex-wrap">
                    <div class="mt-0">
                        <h4 class="main-title">Expense details</h4>
                        <p><small>All the details below.</small></p>
                    </div>
                </div>

            </div>
            <div class="widget-body">
                 <div class="mb-3 row">
                        <div class="col-2">
                            <dt for="date" class="mt-1 form-label">Date </dt>
                        </div>

                        <div class="col-6">
                            <dd class="fst-italic text-muted"> {{ $expense->date}} </dd>
                        </div>
                    </div>

                    <div class="mb-3 row">
                        <div class="col-2">
                            <dt for="name" class="mt-1 form-label">Category </dt>
                        </div>

                        <div class="col-6">
                            <dd class="fst-italic text-muted">{{ $expense->expenseCategory->name}}</dd>
                        </div>
                    </div>

                    <div class="mb-3 row">
                        <div class="col-2">
                            <dt for="price" class="mt-1 form-label">Subcategory </dt>
                        </div>

                        <div class="col-6">
                            <dd class="fst-italic text-muted">{{ $expense->expenseSubcategory->name }}</dd>
                        </div>
                    </div>

                    <div class="mb-3 row">
                        <div class="col-2">
                            <dt for="amount" class="mt-1 form-label">Amount </dt>
                        </div>

                        <div class="col-6">
                            <dd class="fst-italic text-muted">{{$expense->amount}}</dd>
                        </div>
                    </div>

                    <div class="mb-3 row">

                    @if ($expense->note !== null)
                        <div class="col-2">
                            <dt for="note" class="mt-1 form-label">Note </dt>
                        </div>

                        <div class="col-6">
                            <dd class="fst-italic text-muted">{{ $expense->note }}</dd>
                        </div>

                    @endif
                    </div>
            </div>
        </div>
    </div>

</x-app-layout>

