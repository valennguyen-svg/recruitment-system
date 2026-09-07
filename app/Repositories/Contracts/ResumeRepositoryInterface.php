<?php

namespace App\Repositories\Contracts;

use App\Models\CandidateProfile;
use App\Models\Resume;

interface ResumeRepositoryInterface extends BaseRepositoryInterface
{
    public function createForProfile(CandidateProfile $profile, array $attributes): Resume;

    public function countForProfile(CandidateProfile $profile): int;

    public function belongsToProfile(Resume $resume, ?CandidateProfile $profile): bool;

    public function latestFor(CandidateProfile $profile): ?Resume;

    public function clearDefaultFor(int $candidateProfileId): void;
}
