<?php

namespace App\Repositories\Eloquent;

use App\Models\CandidateProfile;
use App\Models\User;
use App\Repositories\Contracts\CandidateProfileRepositoryInterface;

class CandidateProfileRepository extends BaseRepository implements CandidateProfileRepositoryInterface
{
    public function __construct(CandidateProfile $model)
    {
        parent::__construct($model);
    }

    public function findByUser(User $user): ?CandidateProfile
    {
        return $this->model->newQuery()
            ->where('user_id', $user->getKey())
            ->first();
    }

    public function firstOrCreateForUser(User $user): CandidateProfile
    {
        return $this->model->newQuery()
            ->firstOrCreate(['user_id' => $user->getKey()]);
    }

    public function loadResumes(CandidateProfile $profile): CandidateProfile
    {
        return $profile->load('resumes');
    }
}
