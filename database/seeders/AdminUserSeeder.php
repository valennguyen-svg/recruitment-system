<?php

namespace Database\Seeders;

use App\Enums\UserRole;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    private const ADMIN_EMAIL = 'admin@recruitment.test';

    private const ADMIN_NAME = 'Quản trị viên';

    private const ADMIN_PASSWORD = 'Admin@123456';

    public function run(): void
    {
        $admin = User::updateOrCreate(
            ['email' => self::ADMIN_EMAIL],
            [
                'name' => self::ADMIN_NAME,
                'password' => Hash::make(self::ADMIN_PASSWORD),
                'email_verified_at' => now(),
                'is_active' => true,
            ],
        );

        $admin->syncRoles([UserRole::ADMIN->value]);

        $this->command->info('Admin: '.self::ADMIN_EMAIL.' / '.self::ADMIN_PASSWORD);
    }
}
