<?php

namespace App\Http\Controllers\Company;

use App\Http\Controllers\Controller;
use App\Http\Requests\Job\StoreJobPostRequest;
use App\Http\Requests\Job\UpdateJobPostRequest;
use App\Models\JobCategory;
use App\Models\JobPost;
use App\Services\JobPostService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class JobPostController extends Controller
{
    public function __construct(
        private readonly JobPostService $jobs,
    ) {}

    public function index(Request $request): View
    {
        $this->authorize('viewAny', JobPost::class);

        return view('company.jobs.index', [
            'jobs' => $this->jobs->listForActor($request->user()),
        ]);
    }

    public function create(): View
    {
        $this->authorize('create', JobPost::class);

        return view('company.jobs.create', [
            'categories' => JobCategory::orderBy('name')->pluck('name', 'id'),
        ]);
    }

    public function store(StoreJobPostRequest $request): RedirectResponse
    {
        $job = $this->jobs->create($request->user(), $request->jobData());

        return redirect()
            ->route('company.jobs.index')
            ->with('success', __('job.messages.created', ['title' => $job->title]));
    }

    public function edit(JobPost $job): View
    {
        $this->authorize('update', $job);

        return view('company.jobs.edit', [
            'job' => $job,
            'categories' => JobCategory::orderBy('name')->pluck('name', 'id'),
        ]);
    }

    public function update(UpdateJobPostRequest $request, JobPost $job): RedirectResponse
    {
        $this->jobs->update($job, $request->jobData());

        return redirect()
            ->route('company.jobs.index')
            ->with('success', __('job.messages.updated'));
    }

    public function destroy(JobPost $job): RedirectResponse
    {
        $this->authorize('delete', $job);

        $this->jobs->delete($job);

        return redirect()
            ->route('company.jobs.index')
            ->with('success', __('job.messages.deleted'));
    }
}
