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
        private readonly CandidateProfileService $service,
    ) {}

    public function create(Request $request): View
    {
        return view('candidate.cv-form', [
            'user'    => $request->user(),
            'profile' => $this->service->getProfileWithResumes($request->user()),
        ]);
    }

    public function store(StoreCvRequest $request): RedirectResponse
    {
        $this->service->registerCv(
            $request->user(),
            $request->validated(),
            $request->file('file'),
        );

        return redirect()
            ->route('profile.edit')
            ->with('success', __('candidate.messages.cv_registered'));
    }

    public function update(UpdateCandidateProfileRequest $request): RedirectResponse
    {
        $this->service->updateProfile($request->user(), $request->validated());

        return redirect()
            ->route('profile.edit')
            ->with('success', __('candidate.messages.profile_updated'));
    }
}