<?php

namespace App\Http\Controllers;

use App\Constants\ResumeConstants;
use App\Http\Requests\Resume\StoreResumeRequest;
use App\Http\Requests\Resume\UpdateResumeRequest;
use App\Models\Resume;
use App\Services\ResumeService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\StreamedResponse;

class ResumeController extends Controller
{
    public function __construct(
        private readonly ResumeService $resumes,
    ) {}

    public function index(Request $request): View
    {
        $profile = $request->user()->candidateProfile;

        return view('resumes.index', [
            'resumes' => $profile?->resumes()->latest()->get() ?? collect(),
        ]);
    }

    public function create(): View
    {
        return view('resumes.create');
    }

    public function store(StoreResumeRequest $request): RedirectResponse
    {
        $this->resumes->store(
            $request->user()->candidateProfile,
            $request->resumeData(),
            $request->file('file'),
        );

        return redirect()
            ->route('resumes.index')
            ->with('success', __('candidate.messages.cv_uploaded'));
    }

    public function edit(Resume $resume): View
    {
        $this->authorize('update', $resume);

        return view('resumes.edit', [
            'resume' => $resume,
        ]);
    }

    public function update(UpdateResumeRequest $request, Resume $resume): RedirectResponse
    {
        $this->resumes->update($resume, $request->resumeData(), $request->file('file'));

        return redirect()
            ->route('resumes.index')
            ->with('success', __('candidate.messages.cv_updated'));
    }

    public function destroy(Resume $resume): RedirectResponse
    {
        $this->authorize('delete', $resume);

        $this->resumes->delete($resume);

        return redirect()
            ->route('resumes.index')
            ->with('success', __('candidate.messages.cv_deleted'));
    }

    public function setDefault(Resume $resume): RedirectResponse
    {
        $this->authorize('update', $resume);

        $this->resumes->markAsDefault($resume);

        return back()->with('success', __('candidate.messages.default_set'));
    }

    public function download(Resume $resume): StreamedResponse
    {
        $this->authorize('view', $resume);

        return Storage::disk(ResumeConstants::DISK)
            ->download($resume->file_path, $resume->original_name);
    }
}