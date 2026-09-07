<?php

namespace App\Http\Controllers\Auth;

use App\Constants\UserConstants;
use App\Http\Controllers\Controller;
use App\Services\AuthService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use Symfony\Component\HttpFoundation\RedirectResponse as SymfonyRedirect;

class GoogleController extends Controller
{
    public function __construct(
        private readonly AuthService $auth,
    ) {}

    public function redirect(): SymfonyRedirect
    {
        return Socialite::driver(UserConstants::PROVIDER_GOOGLE)->redirect();
    }

    public function callback(): RedirectResponse
    {
        $googleUser = Socialite::driver(UserConstants::PROVIDER_GOOGLE)
            ->stateless()
            ->user();

        $user = $this->auth->findOrCreateFromGoogle($googleUser);

        if (! $user->is_active) {
            return redirect()
                ->route('login')
                ->withErrors(['email' => __('auth.account_locked')]);
        }

        Auth::login($user, remember: true);

        return redirect()->intended(
            route($this->auth->homeRouteFor($user)),
        );
    }
}
