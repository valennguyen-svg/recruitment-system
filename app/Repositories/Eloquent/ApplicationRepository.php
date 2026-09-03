<?php

namespace App\Repositories\Eloquent;

use App\Models\Application;
use App\Models\CandidateProfile;
use App\Models\JobPost;
use App\Repositories\Contracts\ApplicationRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class ApplicationRepository extends BaseRepository implements ApplicationRepositoryInterface
{
    public function __construct(Application $model)
    {
        parent::__construct($model);
    }

    public function existsForJobAndProfile(JobPost $jobPost, CandidateProfile $profile): bool
    {
        return $this->model->newQuery()
            ->where('job_post_id', $jobPost->getKey())
            ->where('candidate_profile_id', $profile->getKey())
            ->exists();
    }

    public function paginateForProfile(?CandidateProfile $profile, int $perPage): LengthAwarePaginator
    {
        $query = $this->model->newQuery()->with(['jobPost.company', 'resume']);

        $profile === null
            ? $query->whereRaw('1 = 0')
            : $query->where('candidate_profile_id', $profile->getKey());

        return $query->latest()->paginate($perPage);
    }

    public function logStatusChange(Application $application, array $attributes): void
    {
        $application->statusLogs()->create($attributes);
    }
}