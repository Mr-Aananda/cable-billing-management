@section('title', 'Edit package')

<x-app-layout>
    <!-- Start Menu-->
    <div class="widget mt-3">
        <div class="widget-body">

            <div class="d-flex align-items-center flex-wrap">
                <nav aria-label="breadcrumb">
                    {{ Breadcrumbs::render('package edit',$package) }}
                </nav>

                <div class="ms-md-auto ms-0 btn-group">

                    <!-- header icon -->
                    <a href="{{ route('package.index') }}" title="Go back" class="print-none btn btn-sm btn-primary ms-auto">
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
                        <h4 class="main-title">Edit old package</h4>
                        <p><small>Can edit <strong>package</strong> from here.</small></p>
                    </div>
                </div>

            </div>
            <div class="widget-body">

                <form action="{{ route('package.update', $package->id) }}" method="POST">
                      @csrf
                      @method('PATCH')

                       <!-- Package name start -->
                    <div class="mb-3 row">
                        <div class="col-2">
                            <label for="name" class="mt-1 form-label required">Package name</label>
                        </div>

                        <div class="col-5">
                            <input type="text" name="name" value="{{ old('name', $package->name)}}" class="form-control @error('name') is-invalid @enderror"  id="name" placeholder="Characters only" required>

                            <!-- error -->
                            @error('name')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                    </div>
                     <!-- Package name end -->

                    <!-- Package price start -->
                    <div class="mb-3 row">
                        <div class="col-2">
                            <label for="price" class="mt-1 form-label required">Price</label>
                        </div>

                        <div class="col-5">
                            <input type="number" name="price" value="{{ old('price', $package->price)}}" class="form-control @error('price') is-invalid @enderror"  id="price" min="0" placeholder="0.00" required>

                            <!-- error -->
                            @error('price')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                    </div>
                     <!-- Package price end -->

                    <!-- Package cost start -->
                    <div class="mb-3 row">
                        <div class="col-2">
                            <label for="cost" class="mt-1 form-label">Cost</label>
                        </div>

                        <div class="col-5">
                            <input type="number" name="cost" value="{{ old('cost', $package->cost)}}" class="form-control @error('cost') is-invalid @enderror"  id="cost" min="0" placeholder="0.00">

                            <!-- error -->
                            @error('cost')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                    </div>
                    <!-- Package cost end -->

                    <!-- Package description start -->
                    <div class="mb-3 row">
                        <div class="col-2">
                            <label for="description" class="mt-1 form-label">Discription</label>
                        </div>

                        <div class="col-5">
                            <textarea name="description" class="form-control @error('description') is-invalid @enderror" id="description" rows="3"
                                placeholder="Optional">{{ old('description',$package->description)}}</textarea>

                                <!-- error -->
                            @error('description')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                    </div>
                     <!-- Package description end -->

                     <!--  Buttton start -->
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
                    <!--  Buttton end -->

                </form>

            </div>
        </div>
    </div>

</x-app-layout>

