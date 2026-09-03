<?php

namespace App\Repositories\Contracts;

use App\Models\JobPost;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

interface JobPostRepositoryInterface extends BaseRepositoryInterface
{
    public function paginatePublished(array $filters, int $perPage): LengthAwarePaginator;

    public function relatedTo(JobPost $jobPost, int $limit): Collection;

    public function incrementViews(JobPost $jobPost): void;

    public function loadDetail(JobPost $jobPost): JobPost;
}