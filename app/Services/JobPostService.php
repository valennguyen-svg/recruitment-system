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

    public function loadDetail(JobPost $job): JobPost
    {
        return $this->jobs->loadDetail($job);
    }

    /**
     * Ghi nhận lượt xem và trả về danh sách tin liên quan.
     *
     * @param  int|null  $userId     ID người xem, null nếu chưa đăng nhập
     * @param  string    $sessionId  Dùng để chống đếm trùng với khách vãng lai
     */
    public function prepareDetail(JobPost $job, ?int $userId, string $sessionId, ?string $ip): Collection
    {
        $this->jobs->recordView($job, $userId, $sessionId, $ip);
        $this->jobs->loadDetail($job);

        return $this->relatedTo($job);
    }
}