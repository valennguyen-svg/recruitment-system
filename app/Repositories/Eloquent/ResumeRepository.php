<?php

namespace App\Repositories\Eloquent;

use App\Models\CandidateProfile;
use App\Models\Resume;
use App\Repositories\Contracts\ResumeRepositoryInterface;

class ResumeRepository extends BaseRepository implements ResumeRepositoryInterface
{
    public function __construct(Resume $model)
    {
        parent::__construct($model);
    }

    public function createForProfile(CandidateProfile $profile, array $attributes): Resume
    {
        return $profile->resumes()->create($attributes);
    }

    public function countForProfile(CandidateProfile $profile): int
    {
        return $profile->resumes()->count();
    }

    public function belongsToProfile(Resume $resume, ?CandidateProfile $profile): bool
    {
        return $profile !== null
            && $resume->candidate_profile_id === $profile->getKey();
    }
}