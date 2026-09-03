<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Str;
use App\Enums\UserRole;
use Illuminate\Http\RedirectResponse;
use Symfony\Component\HttpFoundation\RedirectResponse as SymfonyRedirted;

class GoogleController extends Controller
{
    private const PROVIDER ='google';
    public function redirect(): SymfonyRedirted
    {
        return Socialite::driver(self::PROVIDER)->redirect();
    }
    public function callback(): RedirectResponse
    {
        $googleUser = Socialite::driver(self::PROVIDER)->stateless()->user();

        $user = User::Where('email', $googleUser->getEmail())->first();

        if ($user !== null){
            if (blank(!$user->provider)) {
                $user->update([
                    'provider' => self::PROVIDER,
                    'provider_id' =>$googleUser->getId(),
                    'avatar' => $googleUser->getAvatar(),
                ]);
            }
        } else{
            $user = User::create([
                'name' => $googleUser->getName(),
                'email' => $googleUser->getEmail(),
                'provider'=>self::PROVIDER,
                'provider_id' => $googleUser->getId(),
                'avatar'=>$googleUser->getAvatar(),
                'password'=>null,
                'email_verified_at' =>now(),
            ]);
            $user->assignRole(UserRole::CANDIDATE->value);
            $user->candidateProfile()->create([]);
        }
        if(!$user->is_active){
           return redirect()->route('login')->withErrors([
            'email'=> __('auth.account_locked'),
           ]);
        }
        Auth::login($user, remember: true);
        return redirect()->intended(route('dashboard', absolute: false));
    }
}
