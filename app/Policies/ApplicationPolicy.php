<?php

namespace App\Policies;

use App\Enums\ApplicationStatus;
use App\Enums\UserRole;
use App\Models\Application;
use App\Models\User;

class ApplicationPolicy
{
    public function viewAny(User $user): bool
    {
        return false;
    }

    public function view(User $user, Application $application): bool
    {
        return $user->hasRole(UserRole::ADMIN->value)
            || $this->ownedByCandidate($user, $application)
            || $this->belongsToRecruiterCompany($user, $application);
    }

    public function updateStatus(User $user, Application $application): bool
    {
        return $user->hasRole(UserRole::ADMIN->value)
            || $this->belongsToRecruiterCompany($user, $application);
    }

    public function withdraw(User $user, Application $application): bool
    {
        return $this->ownedByCandidate($user, $application)
            && $application->status !== ApplicationStatus::HIRED;
    }

    public function create(User $user): bool
    {
        return false;
    }

    public function update(User $user, Application $application): bool
    {
        return false;
    }

    public function delete(User $user, Application $application): bool
    {
        return false;
    }

    public function restore(User $user, Application $application): bool
    {
        return false;
    }

    public function forceDelete(User $user, Application $application): bool
    {
        return false;
    }

    private function ownedByCandidate(User $user, Application $application): bool
    {
        return $application->candidateProfile?->user_id === $user->getKey();
    }

    private function belongsToRecruiterCompany(User $user, Application $application): bool
    {
        return $user->hasRole(UserRole::RECRUITER->value)
            && $application->jobPost->company_id === $user->company?->getKey();
    }
}