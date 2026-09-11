<?php

namespace App\Repositories\Contracts;

use App\Models\User;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface CommissionRepositoryInterface
{
    /** @param array<string, mixed> $filters */
    public function paginateForCompany(int $companyId, array $filters, int $perPage): LengthAwarePaginator;

    /** @param array<string, mixed> $filters */
    public function paginateForUser(User $user, array $filters, int $perPage): LengthAwarePaginator;

    /** @return array<string, int> */
    public function sumByStatus(int $companyId, ?int $userId = null): array;
}