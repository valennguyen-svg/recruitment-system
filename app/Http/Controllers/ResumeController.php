<?php

namespace App\Http\Controllers;

use App\Constants\ResumeConstants;
use App\Http\Requests\Resume\StoreResumeRequest;
use App\Http\Requests\Resume\UpdateResumeRequest;
use App\Models\Resume;
use App\Services\ResumeService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\StreamedResponse;

class ResumeController extends Controller
{
    public function __construct(
        private readonly ResumeService $resumes,
    ) {}

    public function store(StoreResumeRequest $request): RedirectResponse
    {
        $this->resumes->store(
            $request->user()->candidateProfile,
            $request->validated(),
            $request->file('file'),
        );

        return redirect()
            ->route('profile.edit')
            ->with('success', __('candidate.messages.cv_uploaded'));
    }

    public function update(UpdateResumeRequest $request, Resume $resume): RedirectResponse
    {
        $this->resumes->update($resume, $request->validated(), $request->file('file'));

        return redirect()
            ->route('profile.edit')
            ->with('success', __('candidate.messages.cv_updated'));
    }

    public function destroy(Resume $resume): RedirectResponse
    {
        $this->authorize('delete', $resume);

        $this->resumes->delete($resume);

        return redirect()
            ->route('profile.edit')
            ->with('success', __('candidate.messages.cv_deleted'));
    }

    public function download(Resume $resume): StreamedResponse
    {
        $this->authorize('view', $resume);

        return Storage::disk(ResumeConstants::DISK)
            ->download($resume->file_path, $resume->original_name);
    }
}
