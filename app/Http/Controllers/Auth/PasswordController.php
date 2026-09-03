<?php

namespace App\Http\Controllers\Auth;

use App\Constants\UserConstants;
use App\Http\Controllers\Controller;
use App\Http\Requests\Profile\UpdatePasswordRequest;
use App\Services\AuthService;
use Illuminate\Http\RedirectResponse;

class PasswordController extends Controller
{
    public function __construct(
        private readonly AuthService $auth,
    ) {}

    public function update(UpdatePasswordRequest $request): RedirectResponse
    {
        $this->auth->changePassword($request->user(), $request->validated('password'));

        return back()->with('status', UserConstants::STATUS_PASSWORD_UPDATED);
    }
}