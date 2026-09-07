<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\ConfirmPasswordRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class ConfirmablePasswordController extends Controller
{
    private const SESSION_KEY = 'auth.password_confirmed_at';

    public function show(): View
    {
        return view('auth.confirm-password');
    }

    public function store(ConfirmPasswordRequest $request): RedirectResponse
    {
        $validated = Auth::guard('web')->validate([
            'email' => $request->user()->email,
            'password' => $request->validated('password'),
        ]);

        if (! $validated) {
            throw ValidationException::withMessages([
                'password' => __('auth.password'),
            ]);
        }

        $request->session()->put(self::SESSION_KEY, time());

        return redirect()->intended(route('dashboard', absolute: false));
    }
}
