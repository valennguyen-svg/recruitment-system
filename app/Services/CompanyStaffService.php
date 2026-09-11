<?php

namespace App\Services;

use App\Constants\UserConstants;
use App\Enums\UserRole;
use App\Models\User;
use App\Repositories\Contracts\UserRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class CompanyStaffService
{
    public function __construct(
        private readonly UserRepositoryInterface $users,
    ) {}

    public function listForCompany(?int $companyId): LengthAwarePaginator
    {
        return $this->users->paginateStaffForCompany(
            $companyId ?? 0,
            UserConstants::STAFF_PER_PAGE,
        );
    }

    public function create(array $data): User
    {
        return DB::transaction(function () use ($data): User {
            $staff = $this->users->create([
                ...$data,
                'password' => Hash::make($data['password']),
                'is_avtive' => true,
                'email_verified_at' => now(),
            ]);
            $staff->assignRole(UserRole::RECRUITER->value);

            return $staff;
        });
    }

    public function update(User $staff, array $data): User
    {
        return $this->users->update($staff, $data);
    }

    public function deactivate(User $staff): User
    {
        return $this->users->update($staff, ['is_active' => false]);
    }
}
