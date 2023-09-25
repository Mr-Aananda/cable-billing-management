<?php

namespace App\Http\Controllers;

use App\Services\PermissionService\PermissionService;
use Database\Seeders\RoleSeeder;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|View
     */
    public function index()
    {
        $roles = Role::query()
            ->withCount('users')
            ->orderByDesc('is_permanent')
            ->orderBy('name')
            ->paginate(25);

        return view('role.index', compact('roles'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Application|Factory|View|Response
     */
    public function create(PermissionService $permissionService)
    {
        $data = [];

        $data['permission_area_groups'] = $permissionService->availablePermissionAreaGroups();
        $data['partial_permission_groups'] = $permissionService->availablePartialPermissionGroups();

        return view('role.create')
            ->with($data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:roles|max:255',
            'permissions' => 'nullable|array'
        ]);

        DB::transaction(static function () use ($request) {
            $role = Role::create($request->only('name'));

            if (!empty($request->permissions)) {
                $permissions = [];
                foreach ($request->permissions as $permission) {
                    $permissions[] = Permission::firstOrCreate(['name' => $permission]);
                }

                $role->syncPermissions($permissions);
            }
        });

        return redirect()
            ->back()
            ->withSuccess('Role created successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param Role $role
     * @return Application|Factory|View|Response
     */
    public function show($id, PermissionService $permissionService)
    {
        $data = [];

        $data['role'] = Role::query()
            ->with([
                'permissions' => fn(BelongsToMany $query): BelongsToMany => $query->select('name')
                    ->orderBy('name'),
                'users' => fn(MorphToMany $query): MorphToMany => $query->select('id', 'name')
                    ->orderBy('name')
            ])
            ->findOrFail($id);

        $data['assigned_permission_area_groups'] = $permissionService->availablePermissionAreaGroupsByRole($data['role']);

        $data['assigned_partial_permission_groups'] = $permissionService->availablePartialPermissionGroupsByRole($data['role']);

        return view('role.show')
            ->with($data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Role $role
     * @return Application|Factory|View|Response
     */
    public function edit($id, PermissionService $permissionService)
    {
        $data = [];

        $data['role'] = Role::query()
            ->with('permissions:name')
            ->findOrFail($id);

        $data['existing_permissions'] = $data['role']->permissions
            ->pluck('name')
            ->toArray();

        $data['permission_area_groups'] = $permissionService->availablePermissionAreaGroups();
        $data['partial_permission_groups'] = $permissionService->availablePartialPermissionGroups();

        return view('role.edit')
            ->with($data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Role $role
     * @return Response
     */
    public function update(Request $request, Role $role)
    {
        abort_if(RoleSeeder::ADMINISTRATOR_RULE_NAME === $role->name, 401, 'Administration rule can not update.');

        $request->validate([
            'name' => 'required|max:255|unique:roles,name,' . $role->id,
            'permissions' => 'nullable|array'
        ]);

        DB::transaction(function () use ($role, $request) {
            if (!$role->is_permanent) {
                $role->update($request->only('name'));
            }

            $permissions = [];

            if (!empty($request->permissions)) {
                foreach ($request->permissions as $permission) {
                    $permissions[] = Permission::firstOrCreate(['name' => $permission]);
                }
            }

            $role->syncPermissions($permissions);
        });

        return redirect()
            ->route('role.index')
            ->withSuccess('Role updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Role $role
     * @return Response
     */
    public function destroy($id)
    {
        $role = Role::query()
            ->findOrFail($id);

        abort_if($role->is_permanent, 401, 'Permanent role can not delete.');

        $role->syncPermissions([]);
        $role->delete();

        return redirect()
            ->route('role.index')
            ->withSuccess('Role deleted successfully');
    }
}
