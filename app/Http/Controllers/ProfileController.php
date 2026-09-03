<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use App\Services\ApplicationService;
use App\Services\CandidateProfileService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use App\Http\Requests\Profile\DeleteUserRequest;

class ProfileController extends Controller
{
    public function __construct(
        private readonly CandidateProfileService $profiles,
        private readonly ApplicationService $applications,
    ) {}

    public function edit(Request $request): View
    {
        $user      = $request->user();
        $candidate = $user->candidateProfile;

        if ($candidate !== null) {
            $candidate->load('resumes');
        }

        return view('profile.edit', [
            'user'         => $user,
            'candidate'    => $candidate,
            'applications' => $this->applications->listForProfile($candidate),
        ]);
    }

    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $user = $request->user();
        $user->fill($request->validated());

        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        $user->save();

        return redirect()->route('profile.edit')->with('status', 'profile-updated');
    }

    public function destroy(DeleteUserRequest $request): RedirectResponse
    {
        $this->profiles->deleteAccount($request->user());

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}