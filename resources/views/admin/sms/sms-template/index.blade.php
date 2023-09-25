@section('title', 'SMS templates')

<x-app-layout>
     <!-- Start Menu-->
    <div class="widget mt-3">
        <div class="widget-body">
            <div class="d-flex align-items-center flex-wrap">
                <nav aria-label="breadcrumb">
                    {{ Breadcrumbs::render('all templates') }}
                </nav>

                <div class="ms-md-auto ms-0">
                    <a href="{{ route('sms-template.create') }}" class="btn btn-sm btn-primary" title="Create new">
                        <x-icons.create/>
                    </a>
                     <a href="{{ route('sms-template.index') }}" class="btn btn-sm  btn-primary" title="Reload page">
                          <x-icons.refresh/>
                    </a>
                </div>
            </div>
        </div>
    </div>
    <!-- End Menu-->

        <div class="widget mt-3" id="print-widget">

            <!-- Start print header-->
            @include('layouts.partials.printHead')
            <!-- End print header -->

            <!-- Start widget head -->
            <div class="widget-head">
                <div class="d-flex align-items-center flex-wrap">
                    <div>
                        <h3>All records</h3>
                        <small>About {{count($templates)}} results found</small>
                    </div>
                    <div class="ms-auto print-none">
                        <a type="button" class="btn btn-sm btn-outline-secondary" onclick="printable('print-widget')">
                            <x-icons.print/>
                        </a>
                         {{-- <a href="{{ route('designation.trash') }}" class="btn btn-sm btn-outline-secondary" title="Trash">
                            <x-icons.trash/>
                        </a> --}}
                    </div>
                </div>

            </div>
            <!-- End widget head-->

            <div class="widget-body">
            <!-- Start Table -->
                <div class="table-responsive">
                    <table class="table custom table-hover action-hover sm">
                        <thead>
                            <tr>
                                <th scope="col">SL</th>
                                <th scope="col">Title</th>
                                <th scope="col">Description</th>
                                <th scope="col" class="print-none text-end">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($templates as $template )
                            <tr>
                                <th scope="row">{{ $templates->firstItem() + $loop->index }}.</th>
                                <td>{{$template->title}}</td>
                                <td>{{$template->description}}</td>
                                <td class="print-none text-end">
                                    <a href="{{route('sms-template.edit',$template->id)}}" title="Update"  class="btn btn-sm btn-outline-primary">
                                        <x-icons.edit/>
                                    </a>
                                    <a href="#" class="btn btn-sm btn-outline-danger" title="Trash" onclick="if(confirm('Are you sure want to delete?')) { document.getElementById('template-delete-{{ $template->id }}').submit() } return false ">
                                        <x-icons.delete/>
                                    </a>

                                    <form action="{{ route('sms-template.destroy', $template->id) }}" method="post" class="d-none" id="template-delete-{{ $template->id }}">
                                        @csrf
                                        @method('DELETE')
                                    </form>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <th colspan="5">Template list is empty.</th>
                            </tr>
                            @endforelse

                        </tbody>
                    </table>
                </div>
            <!-- End Table -->

             <!-- paginate -->
                <div class="container-fluid mt-3 mb-5">
                    <nav>
                        {{ $templates->withQueryString()->links() }}
                    </nav>
                </div>
            <!-- pagination end -->
      </div>
</x-app-layout>
