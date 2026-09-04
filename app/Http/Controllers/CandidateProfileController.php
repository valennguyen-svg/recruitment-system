<?php

namespace App\Http\Controllers;

use App\Http\Requests\Candidate\UpdateCandidateProfileRequest;
use App\Services\CandidateProfileService;
use Illuminate\Http\RedirectResponse;

class CandidateProfileController extends Controller
{
    public function __construct(
        private readonly CandidateProfileService $profiles,
    ) {}

    public function update(UpdateCandidateProfileRequest $request): RedirectResponse
    {
        $this->profiles->update(
            $request->user()->candidateProfile,
            $request->profileData(),
        );

        return redirect()
            ->route('profile.edit')
            ->with('success', __('candidate.messages.profile_updated'));
    }
}