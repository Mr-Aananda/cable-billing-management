@section('title', $role->name . ' - Details')

<x-app-layout>
    <div class="row">
        <div class="col-12">
            <div class="card mt-4">
                <div class="card-header text-center fs-4">
                    {{ $role->name }}'s Details
                    <div class="float-start">
                        <a class="btn btn-sm btn-secondary text-white" href="{{ route('role.index') }}"
                           title="Back to list">
                            <x-icons.back/>
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-12 text-center">
                            <h4>Name: {{ $role->name }}</h4>
                            <p>Created {{ $role->created_at->diffForHumans() }} </p>

                            @unless(\Database\Seeders\RoleSeeder::ADMINISTRATOR_RULE_NAME == $role->name)
                                <div class="text-center mt-4">
                                    <a href="{{ route('role.edit', $role->id) }}" class="btn btn-sm btn-outline-info">
                                        <x-icons.edit/>
                                    </a>

                                    @unless($role->is_permanent)
                                        <form action="{{ route('role.destroy', $role->id) }}" method="POST"
                                              class="d-inline"
                                              onsubmit="return confirm('Are you sure want to delete?')"
                                        >
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger">
                                                <x-icons.delete/>
                                            </button>
                                        </form>
                                    @endunless
                                </div>
                            @endunless

                        </div>
                        <div class="col-12 mt-5">
                            <h5 class="text-center text-decoration-underline">Permissions</h5>
                            @unless(\Database\Seeders\RoleSeeder::ADMINISTRATOR_RULE_NAME == $role->name)

                                <div class="row row-cols-1 row-cols-md-3 g-4">

                                    @forelse($assigned_permission_area_groups as $group => $permission_areas)
                                        <div class="col">
                                            <div class="card h-100">
                                                <div class="card-header text-center">{{ ucwords($group) }}</div>
                                                <div class="card-body">
                                                    <ul class="list-group list-group-flush">
                                                        @forelse($permission_areas as $permission_area)
                                                            <li class="list-group-item">{{ $permission_area['key'] }}</li>
                                                        @empty
                                                            <li class="list-group-item text-center">No permission. 😕
                                                            </li>
                                                        @endforelse
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    @empty
                                    @endforelse
                                </div>
                            @else
                                <p class="text-center">All permissions. 😎 </p>
                            @endunless
                        </div>

                        <div class="mt-2">
                            <p class="text-center fs-5 text-decoration-underline">Partial Permissions</p>

                            @unless(\Database\Seeders\RoleSeeder::ADMINISTRATOR_RULE_NAME == $role->name)

                                <div
                                    class="row row-cols-1 g-4 @if(count($assigned_partial_permission_groups)) row-cols-md-4 @endif">
                                    @forelse($assigned_partial_permission_groups as $group => $partial_permissions)
                                        <div class="col">
                                            <div class="card">
                                                <div class="card-header text-center">{{ ucfirst($group) }}</div>
                                                <div class="card-body px-0">
                                                    <ul class="list-group list-group-flush">
                                                        @forelse($partial_permissions as $partial_permission)
                                                            <li class="list-group-item">
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
                                                            <li class="list-group-item text-center">No permission. 😕
                                                            </li>
                                                        @endforelse
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    @empty
                                        <div class="col text-center">
                                            <p>No Permission. 😕</p>
                                        </div>
                                    @endforelse
                                </div>

                            @else
                                <p class="text-center">All permissions. 😎 </p>
                            @endunless
                        </div>

                        <div class="col-12 mt-5">
                            <h5 class="text-center text-decoration-underline">Assigned Users</h5>
                            <div class="row">
                                @forelse($role->users->chunk(10) as $chunk)
                                    <div class="col-md-3">
                                        <ol start="{{ $loop->index * count($chunk) + 1 }}">
                                            @foreach($chunk as $user)
                                                <li>
                                                    <a href="{{ route('user.show', $user->id) }}"
                                                       target="_blank">{{ $user->name }}</a>
                                                </li>
                                            @endforeach
                                        </ol>
                                    </div>
                                @empty
                                    <p class="text-center">No user assigned yet. 😕 </p>
                                @endforelse
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
