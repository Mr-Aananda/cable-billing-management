@section('title', 'Edit sms template')

<x-app-layout>
    <!-- Start Menu-->
    <div class="widget mt-3">
        <div class="widget-body">

            <div class="d-flex align-items-center flex-wrap">
                <nav aria-label="breadcrumb">
                    {{ Breadcrumbs::render('template edit',$template) }}
                </nav>

                <div class="ms-md-auto ms-0">
                    <a href="{{ route('sms-template.index') }}" title="Go back" class="print-none btn btn-sm btn-primary ms-auto">
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
                        <h4 class="main-title">Edit old template</h4>
                        <p><small>Can edit <strong>sms template</strong> from here.</small></p>
                    </div>
                </div>

            </div>
            <div class="widget-body">

                <form action="{{ route('sms-template.update', $template->id) }}" method="POST">
                      @csrf
                      @method('PATCH')

                    <div class="mb-3 row">
                        <div class="col-2">
                            <label for="title" class="mt-1 form-label required">Title</label>
                        </div>

                        <div class="col-5">
                            <input type="text" name="title" value="{{ old('title',$template->title)}}" class="form-control @error('title') is-invalid @enderror"  id="title" placeholder="Enter title" required>

                            <!-- error -->
                            @error('title')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-3 row">
                        <div class="col-2">
                            <label for="description" class="mt-1 form-label required">Description</label>
                        </div>

                        <div class="col-5">
                            <textarea name="description" class="form-control @error('description') is-invalid @enderror" id="description" rows="2"
                                placeholder="Enter description heree..." required>{{ old('description',$template->description)}}</textarea>

                                <!-- error -->
                            @error('description')
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


