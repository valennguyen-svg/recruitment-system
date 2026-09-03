<?php

namespace App\Repositories\Contracts;

use App\Models\CandidateProfile;
use App\Models\User;

interface CandidateProfileRepositoryInterface extends BaseRepositoryInterface
{
    public function findByUser(User $user): ?CandidateProfile;

    public function firstOrCreateForUser(User $user): CandidateProfile;

    public function loadResumes(CandidateProfile $profile): CandidateProfile;
}