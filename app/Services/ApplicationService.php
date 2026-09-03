<?php

namespace App\Services;

use App\Constants\ApplicationConstants;
use App\Enums\ApplicationStatus;
use App\Enums\JobStatus;
use App\Models\Application;
use App\Models\CandidateProfile;
use App\Models\JobPost;
use App\Models\User;
use App\Notifications\ApplicationStatusChangedNotification;
use App\Notifications\NewApplicationNotification;
use App\Repositories\Contracts\ApplicationRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\UniqueConstraintViolationException;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class ApplicationService
{
    public function __construct(
        private readonly ApplicationRepositoryInterface $applications,
    ) {}

    public function apply(JobPost $jobPost, CandidateProfile $profile, array $data): Application
    {
        $this->assertJobIsOpen($jobPost);
        $this->assertNotApplied($jobPost, $profile);

        try {
            return DB::transaction(function () use ($jobPost, $profile, $data): Application {
                /** @var Application $application */
                $application = $this->applications->create([
                    'job_post_id' => $jobPost->getKey(),
                    'candidate_profile_id' => $profile->getKey(),
                    'resume_id' => $data['resume_id'],
                    'cover_letter' => $data['cover_letter'] ?? null,
                    'status' => ApplicationStatus::APPLIED->value,
                    'applied_at' => now(),
                ]);

                $application->load('jobPost', 'candidateProfile.user');
                $jobPost->creator?->notify(new NewApplicationNotification($application));

                return $application;
            });
        } catch (UniqueConstraintViolationException) {
            throw ValidationException::withMessages([
                'resume_id' => __('application.errors.already_applied'),
            ]);
        }
    }

    public function listForProfile(?CandidateProfile $profile): LengthAwarePaginator
    {
        return $this->applications->paginateForProfile($profile, ApplicationConstants::PER_PAGE);
    }

    public function changeStatus(
        Application $application,
        ApplicationStatus $to,
        User $changedBy,
        ?string $note = null,
    ): Application {
        $from = $application->status;

        if (! $from->canTransitionTo($to)) {
            throw ValidationException::withMessages([
                'status' => __('application.errors.invalid_transition', [
                    'from' => $from->label(),
                    'to' => $to->label(),
                ]),
            ]);
        }

        return DB::transaction(function () use ($application, $from, $to, $changedBy, $note): Application {
            $this->applications->update($application, ['status' => $to->value]);

            $this->applications->logStatusChange($application, [
                'from_status' => $from->value,
                'to_status' => $to->value,
                'changed_by' => $changedBy->getKey(),
                'note' => $note,
            ]);

            $application->load('jobPost', 'candidateProfile.user');
            $application->candidateProfile?->user?->notify(
                new ApplicationStatusChangedNotification($application, $from, $to, $note),
            );

            return $application;
        });
    }

    private function assertJobIsOpen(JobPost $jobPost): void
    {
        if ($jobPost->status !== JobStatus::PUBLISHED) {
            throw ValidationException::withMessages([
                'resume_id' => __('application.errors.job_closed'),
            ]);
        }

        if ($jobPost->deadline !== null && $jobPost->deadline->isPast()) {
            throw ValidationException::withMessages([
                'resume_id' => __('application.errors.job_expired'),
            ]);
        }
    }

    private function assertNotApplied(JobPost $jobPost, CandidateProfile $profile): void
    {
        if ($this->applications->existsForJobAndProfile($jobPost, $profile)) {
            throw ValidationException::withMessages([
                'resume_id' => __('application.errors.already_applied'),
            ]);
        }
    }
}