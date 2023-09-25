<?php

namespace App\Services\PermissionService;

use App\Models\User;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Role;

class PermissionService
{

    /**
     * Get all partial permission groups.
     *
     * @return array
     */
    public function availablePartialPermissionGroups(): array
    {
        return config('permission.partial_permissions');
    }

    /**
     * Get all permission area groups.
     *
     * @return array
     */
    public function availablePermissionAreaGroups(): array
    {
        $routes = collect(Route::getRoutes()->get())
            ->map(function ($route) {
                $action = $route->getAction();

                if (!isset($action['middleware'])) {
                    return;
                }

                if (in_array('permission.remove', $action['middleware'])) {
                    return;
                }

                if (in_array('permission.add', $action['middleware'])) {
                    return $action['as'] ?? null;
                }
            })
            ->filter()
            /*            ->map(fn($value) => $value
                            . '.first'
                            . '.Second'
                            . '.Third'
                            . '.Fourth'
                            . '.Fifth'
                            . '.Six'
                            . '.Seven'
                            . '.Eight'
                            . '.Nine'
                            . '.Ten'
                            . '.Eleven'
                            . '.Twelve'
                            . '.Thirteen'
                            . '.Fourteen'
                            . '.Fifteen'
                        )*/
            ->values()
            ->toArray();

        return $this->oneLayerTree($routes);

        /*$formatted = [
            'dashboard' => [
                'key' => 'Dashboard',
                'value' => 'dashboard'
            ],
            'user' => [
                [
                    'key' => 'Index',
                    'value' => 'user.index'
                ],
                [
                    'key' => 'Create',
                    'value' => 'user.create'
                ],
            ],
            'test' => [
                [
                    'key' => 'Index',
                    'value' => 'test.index',
                    'children' => [
                        [
                            'key' => 'child1',
                            'value' => 'test.index.child1',
                            'children' => [
                                [
                                    'key' => 'newchild-index',
                                    'value' => 'test.index.child1.newchild-index'
                                ],
                                [
                                    'key' => 'newchild-one',
                                    'value' => 'test.index.child1.newchild-one'
                                ],
                                [
                                    'key' => 'newchild-two',
                                    'value' => 'test.index.child1.newchild-two'
                                ],
                            ]
                        ]
                    ]
                ]
            ]
        ];*/
    }

    /**
     * Get all available permissions groups for user.
     *
     * @param User $user
     * @return array
     */
    public function availablePartialPermissionGroupsByUser(User $user): array
    {
        $assigned_permissions = $user->getAllPermissions()
            ->pluck('name')
            ->toArray();

        $partial_permissions = $this->availablePartialPermissionGroups();

        return collect($partial_permissions)
            ->map(function ($partial_permissions) use ($assigned_permissions) {
                $output = [];

                foreach ($partial_permissions as $partial_permission) {

                    if (!in_array($partial_permission['name'], $assigned_permissions, true)) {
                        continue;
                    }

                    $output[] = [
                        'name' => $partial_permission['name'],
                        'description' => $partial_permission['description']
                    ];
                }

                return $output;
            })
            ->filter()
            ->toArray();
    }

    /**
     * Get all available permissions area groups for user.
     *
     * @param User $user
     * @return array
     */
    public function availablePermissionAreaGroupsByUser(User $user): array
    {
        $assigned_permissions = $user->getAllPermissions()
            ->pluck('name')
            ->toArray();

        $permission_area_groups = $this->availablePermissionAreaGroups();

        return collect($permission_area_groups)
            ->map(function ($permission_areas) use ($assigned_permissions) {
                $output = [];

                foreach ($permission_areas as $permission_area) {
                    if (!in_array($permission_area['value'], $assigned_permissions, true)) {
                        continue;
                    }

                    $output[] = $permission_area;
                }

                return $output;
            })
            ->filter()
            ->toArray();
    }

    /**
     * Get all available permission area groups by role.
     *
     * @param Role $role
     * @return array
     */
    public function availablePermissionAreaGroupsByRole(Role $role): array
    {
        $assigned_permissions = $role->permissions
            ->pluck('name')
            ->toArray();

        $permission_area_groups = $this->availablePermissionAreaGroups();

        return collect($permission_area_groups)
            ->map(function ($permission_areas) use ($assigned_permissions) {
                $output = [];

                foreach ($permission_areas as $permission_area) {
                    if (!in_array($permission_area['value'], $assigned_permissions, true)) {
                        continue;
                    }

                    $output[] = $permission_area;
                }

                return $output;
            })
            ->filter()
            ->toArray();
    }

    /**
     * Get all available partial permission groups by role.
     *
     * @param Role $role
     * @return array
     */
    public function availablePartialPermissionGroupsByRole(Role $role): array
    {
        $assigned_permissions = $role->permissions
            ->pluck('name')
            ->toArray();

        $partial_permission_groups = $this->availablePartialPermissionGroups();

        return collect($partial_permission_groups)
            ->map(function ($partial_permissions) use ($assigned_permissions) {
                $output = [];

                foreach ($partial_permissions as $partial_permission) {

                    if (!in_array($partial_permission['name'], $assigned_permissions, true)) {
                        continue;
                    }

                    $output[] = [
                        'name' => $partial_permission['name'],
                        'description' => $partial_permission['description']
                    ];
                }

                return $output;
            })
            ->filter()
            ->toArray();
    }

    /**
     * Format route into one layer group tree.
     *
     * @param array $routes
     * @return array
     */
    private function oneLayerTree(array $routes): array
    {
        $output = [];

        foreach ($routes as $route) {
            $first_layer_explode = explode('.', $route, 2);

            // single route
            if (count($first_layer_explode) === 1) {
                $output[$route][] = [
                    'key' => ucfirst($route),
                    'value' => $route
                ];

                continue;
            }

            // multiple routes
            $first_part = $first_layer_explode[0];
            $last_part = end($first_layer_explode);

            if (Route::has($first_part)) {
                $output[$first_part][] = [
                    'key' => Str::of($first_part)
                        ->replace('.', ' ')
                        ->ucfirst(),
                    'value' => $first_part
                ];
            }

            $output[$first_part][] = [
                'key' => Str::of($last_part)
                    ->replace('-', ' ')
                    ->replace('.', ' -> ')
                    ->title(),
                'value' => $route
            ];


        }

        return $output;
    }
}
