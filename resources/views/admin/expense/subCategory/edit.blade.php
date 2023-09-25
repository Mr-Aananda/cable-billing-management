@section('title', 'Edit expense-Subcategory')

<x-app-layout>
     <!-- Start Menu-->
    <div class="widget mt-3">
        <div class="widget-body">

            <div class="d-flex align-items-center flex-wrap">
                <nav aria-label="breadcrumb">
                    {{ Breadcrumbs::render('subcategory edit',$subcategory) }}
                </nav>

                <div class="ms-md-auto ms-0 btn-group">

                    <!-- header icon -->
                    <a href="{{ route('expense-subcategory.index') }}" title="Go back" class="print-none btn btn-sm btn-primary ms-auto">
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
                        <h4 class="main-title">Edit old subcategory</h4>
                        <p><small>Can edit <strong>expense-subcategory</strong> from here.</small></p>
                    </div>
                </div>

            </div>
            <div class="widget-body">

                <form action="{{ route('expense-subcategory.update', $subcategory->id) }}" method="POST">
                      @csrf
                      @method('PATCH')

                    <!-- type text -->
                    <div class="mb-3 row">
                        <div class="col-2">
                            <label for="category-id" class="mt-1 form-label required">Select category</label>
                        </div>

                        <div class="col-5">
                            <select name="expense_category_id" class="form-control @error('expense_category_id') is-invalid @enderror" id="category-id" required>
                                <option value="" selected disabled>-- Choose one --</option>

                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}" {{ (old('expense_category_id', $subcategory->expense_category_id) == $category->id) ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach

                            </select>

                                <!-- error -->
                            @error('expense_category_id')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-3 row">
                        <div class="col-2">
                            <label for="name" class="mt-1 form-label required">Subcategory name</label>
                        </div>

                        <div class="col-5">
                            <input type="text" name="name" value="{{ old('name', $subcategory->name)}}" class="form-control @error('name') is-invalid @enderror" id="name" placeholder="Characters only" required>

                            <!-- error -->
                            @error('name')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-3 row">
                        <div class="col-2">
                            <label for="note" class="mt-1 form-label">Note</label>
                        </div>

                        <div class="col-5">
                            <textarea name="note" class="form-control @error('note') is-invalid @enderror" id="note" rows="3"
                                placeholder="Optional">{{ old('note', $subcategory->note)}}</textarea>

                                <!-- error -->
                                @error('note')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                        </div>
                    </div>


                    <div class="mb-3 row">
                        <div class="col-2">
                            <label class="mt-1 form-label">&nbsp;</label>
                        </div>

                        <div class="col-10">
                            <button type="reset" class="btn btn-warning me-2">
                                <i class="bi bi-trash"></i>
                                <span class="p-1">Reset</span>
                            </button>

                            <button type="submit" class="btn btn-success">
                                <i class="bi bi-check-circle"></i>
                                <span class="p-1">Update</span>
                            </button>
                        </div>
                    </div>

                </form>

            </div>
        </div>
    </div>

</x-app-layout>

