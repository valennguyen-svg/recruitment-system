<?php

namespace App\Services;

use App\Constants\ApplicationConstants;
use App\Enums\ApplicationStatus;
use App\Models\Application;
use App\Models\CandidateProfile;
use App\Models\JobPost;
use App\Repositories\Contracts\ApplicationRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class ApplicationService
{
    public function __construct(
        private readonly ApplicationRepositoryInterface $applications,
        private readonly CommissionService $commission,
    ) {}

    public function listForProfile(?CandidateProfile $profile): LengthAwarePaginator
    {
        return $this->applications->paginateForCandidate(
            $profile,
            ApplicationConstants::PER_PAGE,
        );
    }

    public function apply(CandidateProfile $profile, JobPost $job, array $data): Application
    {
        return DB::transaction(function () use ($profile, $job, $data): Application {
            if ($this->applications->existsFor($profile, $job)) {
                throw ValidationException::withMessages([
                    'resume_id' => __('job.messages.already_applied'),
                ]);
            }

            return $this->applications->create([
                'candidate_profile_id' => $profile->getKey(),
                'job_post_id' => $job->getKey(),
                'resume_id' => $data['resume_id'],
                'cover_letter' => $data['cover_letter'] ?? null,
                'status' => ApplicationStatus::APPLIED,
            ]);
            $this->commission->recordForApplication($application);

            return $application;
        });
    }

    public function changeStatus(Application $application, ApplicationStatus $target, ?string $note = null): Application
    {
        if (! $application->status->canTransitionTo($target)) {
            throw ValidationException::withMessages([
                'status' => __('application.messages.invalid_transition', [
                    'from' => $application->status->label(),
                    'to' => $target->label(),
                ]),
            ]);
        }

        return $this->applications->update($application, [
            'status' => $target,
            'note' => $note,
        ]);
    }

    /** Đếm số đơn ứng tuyển đã nộp. */
    public function countForProfile(?CandidateProfile $profile): int
    {
        return $profile?->applications()->count() ?? 0;
    }
}
