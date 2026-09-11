<?php

namespace App\Policies;

use App\Enums\JobStatus;
use App\Enums\Permission;
use App\Models\JobPost;
use App\Models\User;

class JobPostPolicy
{
    public function viewAny(User $actor): bool
    {
        return $actor->can(Permission::JOBS_VIEW_ALL->value)
            || $actor->can(Permission::JOBS_CREATE->value);
    }

    public function view(User $actor, JobPost $job): bool
    {
        if ($job->status === JobStatus::PUBLISHED) {
            return true;
        }

        if ($actor->can(Permission::JOBS_VIEW_ALL->value)) {
            return true;
        }

        return $this->sameCompany($actor, $job);
    }

    public function create(User $actor): bool
    {
        return $actor->can(Permission::JOBS_CREATE->value)
            && $actor->company_id !== null;
    }

    public function update(User $actor, JobPost $job): bool
    {
        if (! $actor->can(Permission::JOBS_UPDATE->value)) {
            return false;
        }

        if (! $this->sameCompany($actor, $job)) {
            return false;
        }

        if ($job->status === JobStatus::PUBLISHED) {
            return false;
        }

        return $actor->can(Permission::JOBS_UPDATE_ANY->value)
            || $job->created_by === $actor->getKey();
    }

    public function delete(User $actor, JobPost $job): bool
    {
        return $actor->can(Permission::JOBS_DELETE->value)
            && $this->sameCompany($actor, $job)
            && $job->status !== JobStatus::PUBLISHED;
    }

    public function submit(User $actor, JobPost $job): bool
    {
        return $this->update($actor, $job)
            && in_array($job->status, [JobStatus::DRAFT, JobStatus::REJECTED], true);
    }

    public function approve(User $actor, JobPost $job): bool
    {
        return $actor->can(Permission::JOBS_APPROVE->value)
            && $job->status === JobStatus::PENDING_REVIEW;
    }

    private function sameCompany(User $actor, JobPost $job): bool
    {
        return $actor->company_id !== null
            && $actor->company_id === $job->company_id;
    }
}