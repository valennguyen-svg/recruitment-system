<?php

namespace App\Providers;

use App\Constants\AuthConstants;
use App\Constants\NotificationConstants;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use Illuminate\Validation\Rules\Password;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        $this->configurePasswordRules();
        $this->composeNotificationBell();
    }

    private function configurePasswordRules(): void
    {
        Password::defaults(fn (): Password => Password::min(AuthConstants::PASSWORD_MIN_LENGTH)
            ->letters()
            ->numbers()
            ->symbols()
            ->mixedCase()
            ->uncompromised());
    }

    private function composeNotificationBell(): void
    {
        View::composer('layouts.partials.notification-bell', function ($view): void {
            $user = Auth::user();

            $view->with([
                'unread' => $user
                    ? $user->unreadNotifications()
                        ->latest()
                        ->take(NotificationConstants::BELL_PREVIEW)
                        ->get()
                    : collect(),
                'unreadCount' => $user?->unreadNotifications()->count() ?? 0,
            ]);
        });
    }
}
