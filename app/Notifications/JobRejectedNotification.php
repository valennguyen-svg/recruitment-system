<?php

namespace App\Notifications;

use App\Models\JobPost;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class JobRejectedNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(
        public JobPost $job,
        public ?string $reason = null,
    ) {}

    public function via(object $notifiable): array
    {
        return ['mail', 'database'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        $mail = (new MailMessage)
            ->subject(__('notification.job_rejected.subject'))
            ->greeting(__('notification.common.greeting', ['name' => $notifiable->name]))
            ->line(__('notification.job_rejected.line', ['job' => $this->job->title]));

        if ($this->reason !== null) {
            $mail->line(__('notification.job_rejected.reason', ['reason' => $this->reason]));
        }

        return $mail->action(__('notification.job_rejected.action'), route('jobs.show', $this->job));
    }

    public function toArray(object $notifiable): array
    {
        return [
            'job_id' => $this->job->getKey(),
            'title' => $this->job->title,
            'reason' => $this->reason,
            'message' => __('notification.job_rejected.short', ['job' => $this->job->title]),
            'url' => route('jobs.show', $this->job),
        ];
    }
}