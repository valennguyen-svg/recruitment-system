<?php

namespace App\Notifications;

use App\Models\Application;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewApplicationNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(public Application $application) {}

    public function via(object $notifiable): array
    {
        return ['mail', 'database'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject(__('notification.new_application.subject', [
                'job' => $this->application->jobPost->title,
            ]))
            ->greeting(__('notification.common.greeting', ['name' => $notifiable->name]))
            ->line(__('notification.new_application.line', [
                'name' => $this->candidateName(),
                'job' => $this->application->jobPost->title,
            ]))
            ->action(
                __('notification.new_application.action'),
                route('jobs.show', $this->application->jobPost),
            );
    }

    public function toArray(object $notifiable): array
    {
        return [
            'application_id' => $this->application->getKey(),
            'message' => __('notification.new_application.short', [
                'name'=> $this->candidateName(),
                'job' => $this->application->jobPost->title,
            ]),
            'url'            => route('jobs.show', $this->application->jobPost),
        ];
    }

    private function candidateName(): string
    {
        return $this->application->candidateProfile?->user?->name ?? '';
    }
}