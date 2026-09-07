<?php

namespace App\Repositories\Contracts;

use App\Enums\UserRole;
use Illuminate\Support\Collection;

interface DashboardRepositoryInterface
{
    public function countJobs(): int;

    public function countJobsByStatus(): Collection;

    public function countApplications(): int;

    public function countApplicationsByStatus(): Collection;

    public function countHiredApplications(): int;

    public function countCompanies(): int;

    public function countUsersByRole(UserRole $role): int;

    public function jobsPerMonth(int $months): Collection;

    public function topCompanies(int $limit): Collection;

    public function topJobs(int $limit): Collection;
}
