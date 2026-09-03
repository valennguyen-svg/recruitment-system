<?php

namespace App\Services;

use App\Constants\JobPostConstants;
use App\Enums\JobStatus;
use App\Models\JobPost;
use App\Repositories\Contracts\JobPostRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Symfony\Component\HttpFoundation\Response;

class JobPostService
{
    public function __construct(
        private readonly JobPostRepositoryInterface $jobPosts,
    ) {}

    public function search(array $filters): LengthAwarePaginator
    {
        return $this->jobPosts->paginatePublished($filters, JobPostConstants::PER_PAGE);
    }

    public function prepareDetail(JobPost $jobPost): Collection
    {
        abort_unless(
            $jobPost->status === JobStatus::PUBLISHED,
            Response::HTTP_NOT_FOUND,
        );

        $this->jobPosts->incrementViews($jobPost);
        $this->jobPosts->loadDetail($jobPost);

        return $this->jobPosts->relatedTo($jobPost, JobPostConstants::RELATED_LIMIT);
    }
}