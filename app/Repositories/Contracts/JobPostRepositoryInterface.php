<?php

namespace App\Repositories\Contracts;

use App\Enums\SortOption;
use App\Models\JobPost;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

interface JobPostRepositoryInterface extends BaseRepositoryInterface
{
    public function paginatePublished(array $filters, SortOption $sort, int $perPage): LengthAwarePaginator;

    public function relatedTo(JobPost $job, int $limit): Collection;

    public function recordView(JobPost $job, ?int $userId, string $sessionId, ?string $ip): bool;
    
    public function loadDetail(JobPost $job): JobPost;
}
