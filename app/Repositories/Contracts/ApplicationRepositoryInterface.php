<?php

namespace App\Repositories\Contracts;

use App\Models\CandidateProfile;
use App\Models\JobPost;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface ApplicationRepositoryInterface extends BaseRepositoryInterface
{
    public function paginateForCandidate(?CandidateProfile $profile, int $perPage): LengthAwarePaginator;
    public function existsFor(CandidateProfile $profile, JobPost $job): bool;
}