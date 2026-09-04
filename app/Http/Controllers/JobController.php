<?php

namespace App\Http\Controllers;

use App\Http\Requests\Job\JobFilterRequest;
use App\Models\JobPost;
use App\Services\JobPostService;
use Illuminate\View\View;

class JobController extends Controller
{
    public function __construct(
        private readonly JobPostService $jobs,
    ) {}

    public function index(JobFilterRequest $request): View
    {
        return view('jobs.index', [
            'jobs' => $this->jobs->search($request->filters(), $request->sortOption()),
        ]);
    }

    public function show(JobPost $job): View
    {
        $job->load(['company', 'category']);

        return view('jobs.show', [
            'job'=> $job,
            'related'=> $this->jobs->relatedTo($job),
        ]);
    }
}