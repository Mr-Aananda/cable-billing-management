@section('title', $user->name . ' - Profile')

<x-app-layout>
    <div class="row">
        <div class="col-12">
            <div class="card mt-4">
                <div class="card-header text-center fs-4">
                    {{ $user->name }}'s Profile
                    <div class="float-start">
                        <a class="btn btn-sm btn-secondary text-white" href="{{ route('user.index') }}"
                           title="Back to list">
                            <x-icons.back/>
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="text-center">
                                <img src="https://ui-avatars.com/api/?name={{ $user->name }}&background=random&size=300"
                                     class="rounded" alt="{{ $user->name }}">
                            </div>

                            <div class="text-center mt-4">
                                <h3>{{ $user->name }}</h3>
                                <div class="d-flex flex-column">
                                    <span>{{ $user->email }}</span>
                                    <span>{{ $user->phone }}</span>
                                </div>
                                <div class="flex">
                                    @forelse($user->roles as $role)
                                        <span class="badge rounded-pill text-bg-dark">{{ $role->name }}</span>
                                    @empty
                                    @endforelse
                                </div>
                            </div>

                            <div class="text-center mt-4">
                                <a href="{{ route('user.edit', $user->id) }}" class="btn btn-sm btn-outline-info">
                                    <x-icons.edit/>
                                </a>
                                <form action="{{ route('user.destroy', $user->id) }}" method="POST"
                                      class="d-inline"
                                      onsubmit="return confirm('Are you sure want to delete?')"
                                >
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger">
                                        <x-icons.delete/>
                                    </button>
                                </form>
                            </div>

                            <p class="text-center mt-2">
                                Joined {{ $user->created_at->diffForHumans() }}
                            </p>
                        </div>

                        <div class="col-md-8">
                            <div class="col-12 mt-5">
                                <h5 class="text-center text-decoration-underline">Permissions</h5>
                                @unless(in_array(\Database\Seeders\RoleSeeder::ADMINISTRATOR_RULE_NAME, $user->getRoleNames()->toArray()))

                                    <div class="row row-cols-1 row-cols-md-2 g-4">

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

                                @unless(in_array(\Database\Seeders\RoleSeeder::ADMINISTRATOR_RULE_NAME, $user->getRoleNames()->toArray()))

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
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
