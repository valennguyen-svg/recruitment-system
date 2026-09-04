<?php

namespace App\Services;

use App\Models\CandidateProfile;
use App\Repositories\Contracts\CandidateProfileRepositoryInterface;

class CandidateProfileService
{
    public function __construct(
        private readonly CandidateProfileRepositoryInterface $profiles,
    ) {}

    public function update(CandidateProfile $profile, array $data): CandidateProfile
    {
        return $this->profiles->update($profile, $data);
    }
}