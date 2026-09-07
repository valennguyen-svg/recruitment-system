<?php

namespace App\Http\Controllers;

use App\Enums\JobStatus;
use App\Http\Requests\Job\JobSearchRequest;
use App\Http\Requests\Job\RejectJobRequest;
use App\Models\JobPost;
use App\Services\JobCategoryService;
use App\Services\JobPostService;
use App\Services\JobWorkflowService;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class JobPostController extends Controller
{
    public function __construct(
        private readonly JobPostService $jobPostService,
        private readonly JobWorkflowService $workflow,
        private readonly JobCategoryService $categories,
    ) {}

    public function index(JobSearchRequest $request): View
    {
        return view('jobs.index', [
            'jobs' => $this->jobPostService->search(
                $request->filters(),
                $request->sortOption(),
            ),
            'categories' => $this->categories->listForFilter(),
        ]);
    }

    public function show(JobPost $jobPost): View
    {
        return view('jobs.show', [
            'jobPost' => $jobPost,
            'related' => $this->jobPostService->prepareDetail($jobPost),
        ]);
    }

    public function submitForReview(JobPost $job): RedirectResponse
    {
        $this->authorize('update', $job);
        $this->workflow->transition($job, JobStatus::PENDING_REVIEW);

        return back()->with('success', __('job.messages.submitted'));
    }

    public function approve(JobPost $job): RedirectResponse
    {
        $this->authorize('approve', $job);
        $this->workflow->transition($job, JobStatus::PUBLISHED);

        return back()->with('success', __('job.messages.approved'));
    }

    public function reject(RejectJobRequest $request, JobPost $job): RedirectResponse
    {
        $this->workflow->transition($job, JobStatus::REJECTED, $request->validated('reason'));

        return back()->with('success', __('job.messages.rejected'));
    }
}
