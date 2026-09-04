<?php

namespace App\Services;

use App\Constants\JobPostConstants;
use App\Enums\SortOption;
use App\Models\JobPost;
use App\Repositories\Contracts\JobPostRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

class JobPostService
{
    public function __construct(
        private readonly JobPostRepositoryInterface $jobs,
    ) {}

    public function search(array $filters, SortOption $sort): LengthAwarePaginator
    {
        return $this->jobs->paginatePublished($filters, $sort, JobPostConstants::PER_PAGE);
    }

    public function relatedTo(JobPost $job): Collection
    {
         return $this->jobs->relatedTo($job, JobPostConstants::RELATED_LIMIT);
    }
    public function categories(): Collection
    {
        return \App\Models\JobCategory::orderBy('name')->get();
    }
    public function loadDetail(JobPost $job): JobPost
    {
        $this->jobs->incrementViews($job);
        return $this->jobs->loadDetail($job);
    }
}