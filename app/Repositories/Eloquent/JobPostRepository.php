<?php

namespace App\Repositories\Eloquent;

use App\Models\JobPost;
use App\Repositories\Contracts\JobPostRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

class JobPostRepository extends BaseRepository implements JobPostRepositoryInterface
{
    public function __construct(JobPost $model)
    {
        parent::__construct($model);
    }

    public function paginatePublished(array $filters, int $perPage): LengthAwarePaginator
    {
        return $this->model->newQuery()
            ->with(['company:id,name,logo,city', 'category:id,name'])
            ->published()
            ->notExpired()
            ->search($filters['q'] ?? null)
            ->category($filters['category'] ?? null)
            ->location($filters['location'] ?? null)
            ->employmentType($filters['employment_type'] ?? null)
            ->salaryAtLeast($filters['salary_min'] ?? null)
            ->sorted($filters['sort'] ?? null)
            ->paginate($perPage)
            ->withQueryString();
    }

    public function relatedTo(JobPost $jobPost, int $limit): Collection
    {
        return $this->model->newQuery()
            ->published()
            ->notExpired()
            ->where('category_id', $jobPost->category_id)
            ->whereKeyNot($jobPost->getKey())
            ->latest('published_at')
            ->take($limit)
            ->get();
    }

    public function incrementViews(JobPost $jobPost): void
    {
        $jobPost->incrementQuietly('views_count');
    }

    public function loadDetail(JobPost $jobPost): JobPost
    {
        return $jobPost->load(['company', 'category', 'creator:id,name']);
    }
}