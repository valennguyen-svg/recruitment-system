<?php

namespace App\Http\Controllers;

use App\Http\Requests\Candidate\StoreCvRequest;
use App\Http\Requests\Candidate\UpdateCandidateProfileRequest;
use App\Services\CandidateProfileService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CandidateProfileController extends Controller
{
    public function __construct(
        private readonly CandidateProfileService $profiles,
    ) {}

    public function create(Request $request): View
    {
        $user = $request->user();

        return view('candidate.cv-form', [
            'user'    => $user,
            'profile' => $this->profiles->forUser($user),
        ]);
    }

    public function store(StoreCvRequest $request): RedirectResponse
    {
        $this->profiles->storeCv(
            $request->user()->candidateProfile,
            $request->profileData(),
            $request->file('file'),
        );

        return redirect()
            ->route('profile.edit')
            ->with('success', __('candidate.messages.cv_uploaded'));
    }

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