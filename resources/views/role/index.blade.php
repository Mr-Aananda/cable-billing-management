@section('title', 'Roles')

<x-app-layout>
    <div class="row">
        <div class="col-12">
            <div class="card mt-4">
                <div class="card-header text-center fs-4">
                    Roles
                    <div class="float-end">
                        @can('role.create')
                            <a class="btn btn-sm btn-primary text-white" href="{{ route('role.create') }}"
                               title="Add new">
                                <x-icons.create/>
                            </a>
                        @endcan
                    </div>
                </div>
                <div class="card-body">
                    <table class="table">
                        <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Name</th>
                            <th scope="col" class="text-center">Total Assigned</th>
                            <th scope="col" class="text-center">Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse($roles as $role)
                            <tr>
                                <th scope="row">{{ $roles->firstItem() + $loop->index }}</th>
                                <td>
                                    {{ $role->name }}
                                    @if($role->is_permanent)
                                        <span data-bs-toggle="tooltip" title="This role is permanent">
                                            <x-icons.lock/>
                                        </span>
                                    @endif
                                </td>
                                <td class="text-center">{{ $role->users_count }}</td>
                                <td class="text-center">
                                    @can('role.show')
                                        <a href="{{ route('role.show', $role->id) }}"
                                           class="btn btn-sm btn-outline-primary">
                                            <x-icons.show/>
                                        </a>
                                    @endcan
                                    @can('role.edit')
                                        @unless(\Database\Seeders\RoleSeeder::ADMINISTRATOR_RULE_NAME == $role->name)
                                            <a href="{{ route('role.edit', $role->id) }}"
                                               class="btn btn-sm btn-outline-info">
                                                <x-icons.edit/>
                                            </a>
                                        @endunless
                                    @endcan

                                    @can('role.destroy')
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
                                    @endcan
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="10" class="text-center">No roles found</td>
                            </tr>
                        @endforelse
                        </tbody>
                        <thead class="border-white">
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Name</th>
                            <th scope="col" class="text-center">Total Assigned</th>
                            <th scope="col" class="text-center">Actions</th>
                        </tr>
                        </thead>
                    </table>

                    {{ $roles->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
