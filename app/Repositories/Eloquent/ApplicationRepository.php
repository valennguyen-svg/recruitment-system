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

    public function paginateForCandidate(?CandidateProfile $profile, int $perPage): LengthAwarePaginator
    {
        return $this->model->newQuery()
            ->with(['jobPost.company', 'resume'])
            ->where('candidate_profile_id', $profile?->getKey())
            ->latest()
            ->paginate($perPage);
    }

    public function existsFor(CandidateProfile $profile, JobPost $job): bool
    {
        return $this->model->newQuery()
            ->where('candidate_profile_id', $profile->getKey())
            ->where('job_post_id', $job->getKey())
            ->exists();
    }
}