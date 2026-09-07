<?php

namespace App\Notifications;

use App\Enums\ApplicationStatus;
use App\Models\Application;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ApplicationStatusChangedNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(
        public Application $application,
        public ApplicationStatus $fromStatus,
        public ApplicationStatus $toStatus,
        public ?string $note = null,
    ) {}

    public function via(object $notifiable): array
    {
        return ['mail', 'database'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        $job = $this->application->jobPost;

        $mail = (new MailMessage)
            ->subject(__('notification.application_status.subject', ['job' => $job->title]))
            ->greeting(__('notification.common.greeting', ['name' => $notifiable->name]))
            ->line(__('notification.application_status.line', [
                'job' => $job->title,
                'status' => $this->toStatus->label(),
            ]));

        if ($this->note !== null) {
            $mail->line(__('notification.application_status.note', ['note' => $this->note]));
        }

        return $mail->action(
            __('notification.application_status.action'),
            route('applications.index'),
        );
    }

    public function toArray(object $notifiable): array
    {
        return [
            'application_id' => $this->application->getKey(),
            'from' => $this->fromStatus->value,
            'to' => $this->toStatus->value,
            'message' => __('notification.application_status.short', [
                'job' => $this->application->jobPost->title,
                'status' => $this->toStatus->label(),
            ]),
            'url' => route('applications.index'),
        ];
    }
}
