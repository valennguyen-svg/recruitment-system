<?php

namespace Database\Seeders;

use App\Enums\Permission as PermissionEnum;
use App\Enums\UserRole;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        app(PermissionRegistrar::class)->forgetCachedPermissions();

        foreach (PermissionEnum::cases() as $permission) {
            Permission::firstOrCreate([
                'name'       => $permission->value,
                'guard_name' => 'web',
            ]);
        }

        foreach (UserRole::cases() as $userRole) {
            $role = Role::firstOrCreate([
                'name'       => $userRole->value,
                'guard_name' => 'web',
            ]);

            $role->syncPermissions(
                array_column($userRole->permissions(), 'value')
            );
        }

        app(PermissionRegistrar::class)->forgetCachedPermissions();
    }
}