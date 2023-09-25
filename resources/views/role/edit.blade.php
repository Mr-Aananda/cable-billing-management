@section('title', 'Edit Role')

@include('layouts.partials.parent-children-checkbox-script')

<x-app-layout>
    <div class="row">
        <div class="col-12">
            <div class="card mt-4">
                <div class="card-header text-center fs-4">
                    Edit Role
                    @can('role.index')
                        <div class="float-start">
                            <a class="btn btn-sm btn-secondary text-white" href="{{ route('role.index') }}"
                               title="Back to list">
                                <x-icons.back/>
                            </a>
                        </div>
                    @endcan
                </div>
                <div class="card-body">
                    <form action="{{ route('role.update', $role->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="mb-3">
                            <label for="name" class="form-label required">Name</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name"
                                   name="name" value="{{ old('name', $role->name) }}"
                                   placeholder="Enter name"
                                   @if($role->is_permanent) readonly @endif
                                   @disabled(\Database\Seeders\RoleSeeder::ADMINISTRATOR_RULE_NAME == $role->name)
                            >
                            @error('name')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <p class="text-center fs-5 text-decoration-underline">Permissions</p>
                            {{--<ul class="list-group list-group-flush">
                                @forelse($permission_areas as $permission_area)
                                    <li class="list-group-item">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox"
                                                   value="{{ $permission_area }}" id="{{ $permission_area }}"
                                                   name="permissions[]"
                                                   @disabled(\Database\Seeders\RoleSeeder::ADMINISTRATOR_RULE_NAME==$role->name)
                                            @checked(
                                            (\Database\Seeders\RoleSeeder::ADMINISTRATOR_RULE_NAME== $role->name)
                                            ||
                                            in_array($permission_area, old('permissions',$existing_permissions)))
                                            />
                                            <label class="form-check-label" for="{{ $permission_area }}">
                                                {{ $permission_area }}
                                            </label>
                                        </div>
                                    </li>
                                @empty
                                @endforelse
                            </ul>--}}

                            <div class="row row-cols-1 row-cols-md-3 g-4">
                                @forelse($permission_area_groups as $group => $permission_areas)
                                    <div class="col">
                                        <div class="card h-100" x-data="parentChildrenCheckboxData">
                                            <div class="card-header text-center">
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="checkbox"
                                                           id="permission-area-checkbox-parent-{{ $loop->index }}"
                                                           x-model="allChecked" @change="onAllCheckedChange"
                                                           x-ref="parentCheckbox">
                                                    <label class="form-check-label"
                                                           for="permission-area-checkbox-parent-{{ $loop->index }}">{{ ucwords($group) }}</label>
                                                </div>
                                            </div>
                                            <div class="card-body" x-ref="checkboxItemContainer">
                                                <ul class="list-group list-group-flush">
                                                    @forelse($permission_areas as $permission_area)
                                                        <li class="list-group-item">
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="checkbox"
                                                                       value="{{ $permission_area['value'] }}"
                                                                       id="{{ $permission_area['value'] }}"
                                                                       name="permissions[]"
                                                                       @change="onCheckboxItemChange"
                                                                       @disabled(\Database\Seeders\RoleSeeder::ADMINISTRATOR_RULE_NAME == $role->name)
                                                                @checked(
                                                                (\Database\Seeders\RoleSeeder::ADMINISTRATOR_RULE_NAME == $role->name)
                                                                ||
                                                                in_array($permission_area['value'], old('permissions',$existing_permissions)))
                                                                />
                                                                <label class="form-check-label"
                                                                       for="{{ $permission_area['value'] }}">
                                                                    {{ $permission_area['key'] }}
                                                                </label>
                                                            </div>
                                                        </li>
                                                    @empty
                                                    @endforelse
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                @empty
                                @endforelse
                            </div>
                        </div>

                        <div class="mb-3">
                            <p class="text-center fs-5 text-decoration-underline">Partial Permissions</p>

                            <div class="row row-cols-1 row-cols-md-4 g-4">
                                @forelse($partial_permission_groups as $group => $partial_permissions)
                                    <div class="col">
                                        <div class="card" x-data="parentChildrenCheckboxData">
                                            <div class="card-header text-center">
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="checkbox"
                                                           id="partial-permission-checkbox-parent-{{ $loop->index }}"
                                                           x-model="allChecked" @change="onAllCheckedChange"
                                                           x-ref="parentCheckbox">
                                                    <label class="form-check-label"
                                                           for="partial-permission-checkbox-parent-{{ $loop->index }}">{{ ucwords($group) }}</label>
                                                </div>
                                            </div>
                                            <div class="card-body px-0" x-ref="checkboxItemContainer">
                                                <ul class="list-group list-group-flush">
                                                    @forelse($partial_permissions as $partial_permission)
                                                        <li class="list-group-item">
                                                            <input class="form-check-input" type="checkbox"
                                                                   value="{{ $partial_permission['name'] }}"
                                                                   id="{{ $partial_permission['name'] }}"
                                                                   name="permissions[]"
                                                                   @change="onCheckboxItemChange"
                                                                   @disabled(\Database\Seeders\RoleSeeder::ADMINISTRATOR_RULE_NAME==$role->name)
                                                            @checked(
                                                            (\Database\Seeders\RoleSeeder::ADMINISTRATOR_RULE_NAME==
                                                            $role->name)
                                                            ||
                                                            in_array($partial_permission['name'],old('permissions',$existing_permissions))
                                                            )>
                                                            <label class="form-check-label"
                                                                   for="{{ $partial_permission['name'] }}">
                                                                {{
                                                                    \Illuminate\Support\Str::of($partial_permission['name'])
                                                                    ->replace('_',' ')
                                                                    ->replace('-',' ')
                                                                    ->ucfirst()
                                                                }}
                                                            </label>
                                                            @isset($partial_permission['description'])
                                                                <div class="form-text">
                                                                    {{ $partial_permission['description'] }}
                                                                </div>
                                                            @endisset
                                                        </li>
                                                    @empty
                                                    @endforelse
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                @empty
                                @endforelse
                            </div>

                        </div>
                        <button type="submit" class="btn btn-success"
                                @disabled(\Database\Seeders\RoleSeeder::ADMINISTRATOR_RULE_NAME==$role->name)
                            >Update
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
