<?php

namespace App\Services;

use App\Enums\AuditAction;
use App\Enums\JobStatus;
use App\Models\JobPost;
use App\Notifications\JobApprovedNotification;
use App\Notifications\JobRejectedNotification;
use App\Repositories\Contracts\AuditLogRepositoryInterface;
use App\Repositories\Contracts\JobPostRepositoryInterface;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Auth;

class JobWorkflowService
{
    public function __construct(
        private readonly JobPostRepositoryInterface $jobPosts,
        private readonly AuditLogRepositoryInterface $auditLogs,
    ) {}

    public function transition(JobPost $job, JobStatus $to, ?string $reason = null): JobPost
    {
        $from = $job->status;

        if (! $from->canTransitionTo($to)) {
            throw ValidationException::withMessages([
                'status' => __('job.errors.invalid_transition', [
                    'from' => $from->label(),
                    'to' => $to->label(),
                ]),
            ]);
        }

        return DB::transaction(function () use ($job, $from, $to, $reason): JobPost {
            $attributes = ['status' => $to->value];

            if ($to === JobStatus::PUBLISHED) {
                $attributes['published_at'] = now();
            }

            if ($to === JobStatus::REJECTED) {
                $attributes['rejection_reason'] = $reason;
            }

            $this->jobPosts->update($job, $attributes);

            $this->auditLogs->record([
                'user_id' => Auth::id(),
                'action' => AuditAction::JOB_STATUS_CHANGED->value,
                'model_type' => JobPost::class,
                'model_id' => $job->getKey(),
                'old_values' => ['status' => $from->value],
                'new_values' => ['status' => $to->value, 'reason' => $reason],
                'ip_address' => request()->ip(),
            ]);

            match ($to) {
                JobStatus::PUBLISHED => $job->creator?->notify(new JobApprovedNotification($job)),
                JobStatus::REJECTED => $job->creator?->notify(new JobRejectedNotification($job, $reason)),
                default => null,
            };

            return $job;
        });
    }
}
