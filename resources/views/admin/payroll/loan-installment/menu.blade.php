<div class="widget mt-3">
    <div class="widget-body">

        <div class="d-flex align-items-center flex-wrap">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item">
                    <a href="#">Home</a>
                </li>
                <li class="breadcrumb-item"><a href="#">New entry</a></li>
                <li class="breadcrumb-item active" aria-current="page">View</li>
                </ol>
            </nav>

            <div class="ms-md-auto ms-0 btn-group">

                <a href="#search" class="btn btn-sm btn-primary" title="Search" data-bs-toggle="collapse" role="button" aria-expanded="false">
                    <x-icons.search/>
                </a>

                <a href="{{ route('loan-installment.create') }}" class="btn btn-sm btn-primary" title="Create new">
                    <x-icons.create/>
                </a>
            </div>
        </div>

    </div>
</div>
