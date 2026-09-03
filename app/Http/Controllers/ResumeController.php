<?php

namespace App\Http\Controllers;

use App\Constants\ResumeConstants;
use App\Http\Requests\Candidate\StoreResumeRequest;
use App\Http\Requests\Candidate\UpdateResumeRequest;
use App\Models\Resume;
use App\Services\CandidateProfileService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\StreamedResponse;

class ResumeController extends Controller
{
    public function __construct(
        private readonly CandidateProfileService $service,
    ) {}

    public function store(StoreResumeRequest $request): RedirectResponse
    {
        $profile = $this->service->getOrCreateProfile($request->user());

        $this->service->storeResume(
            $profile,
            $request->validated('title'),
            $request->file('file'),
        );

        return redirect()
            ->route('profile.edit')
            ->with('success', __('candidate.messages.resume_uploaded'));
    }

    public function update(UpdateResumeRequest $request, Resume $resume): RedirectResponse
    {
        $this->service->updateResume(
            $resume,
            $request->validated('title'),
            $request->file('file'),
        );

        return redirect()
            ->route('profile.edit')
            ->with('success', __('candidate.messages.resume_updated'));
    }

    public function download(Request $request, Resume $resume): StreamedResponse
    {
        $this->assertOwnership($request, $resume);

        return Storage::disk(ResumeConstants::DISK)
            ->download($resume->file_path, $resume->original_name);
    }

    public function destroy(Request $request, Resume $resume): RedirectResponse
    {
        $this->assertOwnership($request, $resume);
        $this->service->deleteResume($resume);

        return redirect()
            ->route('profile.edit')
            ->with('success', __('candidate.messages.resume_deleted'));
    }

    private function assertOwnership(Request $request, Resume $resume): void
    {
        abort_unless(
            $this->service->ownsResume($request->user()->candidateProfile, $resume),
            Response::HTTP_FORBIDDEN,
        );
    }
}