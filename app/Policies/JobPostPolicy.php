<?php

namespace App\Policies;

use App\Enums\UserRole;
use App\Models\JobPost;
use App\Models\User;

class JobPostPolicy
{
    public function viewAny(User $user): bool
    {
        return false;
    }

    public function view(User $user, JobPost $jobPost): bool
    {
        return false;
    }

    public function create(User $user): bool
    {
        return false;
    }

    public function update(User $user, JobPost $jobPost): bool
    {
        return $user->hasRole(UserRole::ADMIN->value)
            || $this->ownsCompany($user, $jobPost);
    }

    public function delete(User $user, JobPost $jobPost): bool
    {
        return $this->update($user, $jobPost);
    }

    public function restore(User $user, JobPost $jobPost): bool
    {
        return false;
    }

    public function forceDelete(User $user, JobPost $jobPost): bool
    {
        return false;
    }

    public function approve(User $user, JobPost $jobPost): bool
    {
        return $user->hasRole(UserRole::ADMIN->value);
    }

    public function close(User $user, JobPost $jobPost): bool
    {
        return $user->hasRole(UserRole::ADMIN->value)
            || $this->ownsCompany($user, $jobPost);
    }

    private function ownsCompany(User $user, JobPost $jobPost): bool
    {
        return $user->hasRole(UserRole::RECRUITER->value)
            && $jobPost->company_id === $user->company?->getKey();
    }
}