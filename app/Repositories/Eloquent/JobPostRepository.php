<?php

namespace App\Repositories\Eloquent;

use App\Enums\JobStatus;
use App\Enums\SortOption;
use App\Models\JobPost;
use App\Repositories\Contracts\JobPostRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;

class JobPostRepository extends BaseRepository implements JobPostRepositoryInterface
{
    public function __construct(JobPost $model)
    {
        parent::__construct($model);
    }

    public function paginatePublished(array $filters, SortOption $sort, int $perPage): LengthAwarePaginator
    {
        $query = $this->model->newQuery()
            ->with(['company', 'category'])
            ->where('status', JobStatus::PUBLISHED)
            ->where(fn (Builder $q) => $q->whereNull('deadline')->orWhere('deadline', '>=', now()));

        $this->applyFilters($query, $filters);

        return $sort->apply($query)->paginate($perPage)->withQueryString();
    }

    public function relatedTo(JobPost $job, int $limit): Collection
    {
        return $this->model->newQuery()
            ->with('company')
            ->where('status', JobStatus::PUBLISHED)
            ->where('category_id', $job->category_id)
            ->whereKeyNot($job->getKey())
            ->latest('published_at')
            ->take($limit)
            ->get();
    }

    public function incrementViews(JobPost $job): void
    {
        $job->increment('views_count');
    }

    public function loadDetail(JobPost $job): JobPost
    {
        return $job->load(['company', 'category']);
    }

    private function applyFilters(Builder $query, array $filters): void
    {
        $query
            ->when($filters['keyword'] ?? null, fn (Builder $q, string $keyword) => $q->where(
                fn (Builder $sub) => $sub
                    ->where('title', 'ilike', "%{$keyword}%")
                    ->orWhere('description', 'ilike', "%{$keyword}%"),
            ))
            ->when($filters['location'] ?? null, fn (Builder $q, string $location) => $q->where('location', 'ilike', "%{$location}%"))
            ->when($filters['category_id'] ?? null, fn (Builder $q, $id) => $q->where('category_id', $id))
            ->when($filters['employment_type'] ?? null, fn (Builder $q, $type) => $q->where('employment_type', $type))
            ->when($filters['experience_level'] ?? null, fn (Builder $q, $level) => $q->where('experience_level', $level))
            ->when($filters['salary_min'] ?? null, fn (Builder $q, $min) => $q->where('salary_max', '>=', $min));
    }
}