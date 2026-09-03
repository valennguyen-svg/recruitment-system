<?php

namespace App\Notifications;

use App\Models\JobPost;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class JobApprovedNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(public JobPost $job) {}

    public function via(object $notifiable): array
    {
        return ['mail', 'database'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject(__('notification.job_approved.subject'))
            ->greeting(__('notification.common.greeting', ['name' => $notifiable->name]))
            ->line(__('notification.job_approved.line', ['job' => $this->job->title]))
            ->action(__('notification.job_approved.action'), route('jobs.show', $this->job));
    }

    public function toArray(object $notifiable): array
    {
        return [
            'job_id'  => $this->job->getKey(),
            'title'   => $this->job->title,
            'message' => __('notification.job_approved.short', ['job' => $this->job->title]),
            'url'     => route('jobs.show', $this->job),
        ];
    }
}