<?php

namespace App\Providers;

use App\Constants\AuthConstants;
use App\Constants\NotificationConstants;
use App\Models\User;
use App\Policies\UserPolicy;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
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
        $this->registerSuperAdminGate();
        Gate::policy(User::class, UserPolicy::class);
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
    private function registerSuperAdminGate(): void
    {
        Gate::before(function (User $user, string $ability): ?bool {
            // Tai khoan bi khoa khong duoc huong dac quyen, du dang mang vai tro.
            if (! $user->is_active) {
                return null;
            }

            return $user->isSuperAdmin() ? true : null;
        });
    }
}
