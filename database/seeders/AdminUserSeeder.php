<?php

namespace Database\Seeders;

use App\Enums\UserRole;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        $superAdmin = User::firstOrCreate(
            ['email' => 'superadmin@recruitment.test'],
            [
                'name' => 'Super Admin',
                'password' => Hash::make('password123'),
                'email_verified_at' => now(),
                'is_active' => true,
            ],
        );

        $superAdmin->syncRoles([UserRole::SUPER_ADMIN->value]);

        $admin = User::firstOrCreate(
            ['email' => 'admin@recruitment.test'],
            [
                'name' => 'Admin',
                'password' => Hash::make('password123'),
                'email_verified_at' => now(),
                'is_active' => true,
            ],
        );

        $admin->syncRoles([UserRole::ADMIN->value]);
    }
}
