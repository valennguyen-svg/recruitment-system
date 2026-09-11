<?php

namespace App\Repositories\Contracts;

use App\Models\User;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface UserRepositoryInterface extends BaseRepositoryInterface
{
    public function findByEmail(string $email): ?User;

    public function updatePassword(User $user, string $hashedPassword): User;

    public function paginateStaffForCompany(int $companyId, int $perPage): LengthAwarePaginator;
}
