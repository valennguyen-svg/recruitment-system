<?php

namespace App\Services;

use App\Constants\JobConstants;
use App\Constants\JobPostConstants;
use App\Enums\JobStatus;
use App\Enums\SortOption;
use App\Models\JobCategory;
use App\Models\JobPost;
use App\Models\User;
use App\Repositories\Contracts\JobPostRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

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
        return JobCategory::orderBy('name')->get();
    }

    public function loadDetail(JobPost $job): JobPost
    {
        $this->jobs->incrementViews($job);

        return $this->jobs->loadDetail($job);
    }

    public function prepareDetail(JobPost $job): Collection
    {
        $this->jobs->incrementViews($job);
        $this->jobs->loadDetail($job);

        return $this->relatedTo($job);
    }

    public function listForActor(User $actor): LengthAwarePaginator
    {
        return $this->jobs->paginateForActor($actor, JobConstants::PER_PAGE);
    }

    /** @param array<string, mixed> $data */
    public function create(User $author, array $data): JobPost
    {
        return DB::transaction(fn (): JobPost => $this->jobs->create([
            ...$data,
            'company_id' => $author->company_id,
            'created_by' => $author->getKey(),
            'slug' => $this->uniqueSlug($data['title']),
            'status' => JobStatus::DRAFT,
        ]));
    }

    /** @param array<string, mixed> $data */
    public function update(JobPost $job, array $data): JobPost
    {
        return DB::transaction(function () use ($job, $data): JobPost {
            // Tin bi tu choi, sua xong quay ve ban nhap de gui duyet lai.
            $status = $job->status === JobStatus::REJECTED
                ? ['status' => JobStatus::DRAFT, 'rejection_reason' => null]
                : [];

            return $this->jobs->update($job, [...$data, ...$status]);
        });
    }

    public function delete(JobPost $job): void
    {
        DB::transaction(fn () => $this->jobs->delete($job));
    }

    private function uniqueSlug(string $title): string
    {
        $base = Str::slug($title);
        $slug = $base;
        $i = 1;

        while (JobPost::where('slug', $slug)->exists()) {
            $slug = "{$base}-".$i++;
        }

        return $slug;
    }
}
