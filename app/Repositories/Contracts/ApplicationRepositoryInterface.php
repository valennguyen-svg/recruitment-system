<?php

namespace App\Repositories\Contracts;

use App\Models\Application;
use App\Models\CandidateProfile;
use App\Models\JobPost;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface ApplicationRepositoryInterface extends BaseRepositoryInterface
{
    public function existsForJobAndProfile(JobPost $jobPost, CandidateProfile $profile): bool;

    public function paginateForProfile(?CandidateProfile $profile, int $perPage): LengthAwarePaginator;

    public function logStatusChange(Application $application, array $attributes): void;
}