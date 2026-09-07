<?php

namespace App\Http\Controllers;

use App\Constants\UserConstants;
use App\Http\Requests\Profile\DeleteUserRequest;
use App\Http\Requests\Profile\UpdateProfileRequest;
use App\Services\ApplicationService;
use App\Services\ProfileService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ProfileController extends Controller
{
    public function __construct(
        private readonly ProfileService $profiles,
        private readonly ApplicationService $applications,
    ) {}

    public function edit(Request $request): View
    {
        $user      = $request->user();
        $candidate = $user->candidateProfile;

        $candidate?->load('resumes');

        return view('profile.edit', [
            'user'         => $user,
            'candidate'    => $candidate,
            'applications' => $this->applications->listForProfile($candidate),
        ]);
    }

    public function update(UpdateProfileRequest $request): RedirectResponse
    {
        $this->profiles->updateAccount($request->user(), $request->validated());

        return redirect()
            ->route('profile.edit')
            ->with('status', UserConstants::STATUS_PROFILE_UPDATED);
    }

    public function destroy(DeleteUserRequest $request): RedirectResponse
    {
        $this->profiles->deleteAccount($request->user());

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}