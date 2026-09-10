<?php

namespace Database\Seeders;

use App\Enums\UserRole;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    private const ADMIN_EMAIL = 'admin@recruitment.test';

    private const ADMIN_PASSWORD = 'Admin@123456';

    public function run(): void
    {
        $superAdmin = User::firstOrCreate(
            ['email' => 'superadmin@recruitment.test'],
            [
                'name' => 'Super Admin',
                'password' => Hash::make('password123'),
                'email_verified_at'=>now(),
                'is_active'=> true,
            ],
        );
        $superAdmin->syncRoles([UserRole::SUPER_ADMIN->value]);

        $admin = User::updateOrCreate(
            ['email' => 'admin@recruitement.test'],
            [
                'name' => 'Admin',
                'password' => Hash::make('password123'),
                'email_verified_at' => now(),
                'is_active' => true,
            ],
        );

        $admin->syncRoles([UserRole::ADMIN->value]);

        $this->command->info('Admin: '.self::ADMIN_EMAIL.' / '.self::ADMIN_PASSWORD);
    }
}
