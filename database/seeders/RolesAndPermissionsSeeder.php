<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolesAndPermissionsSeeder extends Seeder
{
    public static $permission_keys = [
        'c' => 'create',
        'r' => 'read',
        'u' => 'update',
        'd' => 'delete',
        'a' => 'all',
        'm' => 'massive',
    ];

    public function run()
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();
        \App\CacheManagers\RoleCache::all(true, true);

        // create permissions
        $permissions = [
            'usuarios' => ['c', 'r', 'u', 'd', 'a', 'm'],
            'chamados' => ['c', 'r', 'u', 'd', 'a', 'atender'],
            'roles' => ['c', 'r', 'u', 'd', 'a', 'assign'],
            'permissions' => ['c', 'r', 'u', 'd', 'a', 'assign'],
        ];

        foreach ($permissions as $prefix => $permission_names) {
            foreach (self::getFormatedNames($prefix, $permission_names) as $permission) {
                if ($permission && is_string($permission)) {
                    Permission::updateOrCreate(['name' => $permission]);
                }
            }
        }

        $roles = [
            'admin' => [
                'usuarios' => ['a', 'c', 'r', 'u', 'd', 'm'],
                'chamados' => ['a', 'atender'],
                'roles' => ['a'],
                'permissions' => ['a', 'assign'],
            ],
            'atendente' => [
                'chamados' => ['c', 'r', 'u', 'atender'],
            ],
            'usuario' => [
                'chamados' => ['c', 'r', 'u'],
            ],
        ];

        foreach ($roles as $role => $permissions) {
            $role = Role::updateOrCreate(['name' => $role]);

            $formated_permissions = [];

            foreach ($permissions as $_permission => $_actions) {
                foreach (self::getFormatedNames($_permission, $_actions) as $formated_name) {
                    if (! $formated_name || ! is_string($formated_name)) {
                        continue;
                    }

                    $permission = Permission::where('name', $formated_name)->first();

                    if ($permission && $permission->name) {
                        $formated_permissions[] = $permission->name;
                    }
                }
            }

            if ($formated_permissions ?? []) {
                $role->syncPermissions($formated_permissions);
            }
        }

        //Super admin
        $super_role = Role::updateOrCreate(['name' => 'super-admin']);
        $super_role->givePermissionTo(Permission::all());
    }

    public static function getFormatedNames(string $permission, array $actions)
    {
        if (in_array('a', $actions)) {
            $actions = array_merge($actions, array_keys(static::$permission_keys));
        }

        foreach ($actions as $action) {
            $value = (static::$permission_keys[$action] ?? $action);

            if (strlen($value) < 1) {
                continue;
            }

            $end_value = $permission . '-' . $value;
            $names[$end_value] = $end_value;
        }

        return array_values(array_unique($names ?? []));
    }
}
