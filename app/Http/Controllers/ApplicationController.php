<?php

namespace App\Http\Controllers;

use App\Http\Requests\Application\StoreApplicationRequest;
use App\Http\Requests\Application\UpdateApplicationStatusRequest;
use App\Models\Application;
use App\Models\JobPost;
use App\Services\ApplicationService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ApplicationController extends Controller
{
    public function __construct(
        private readonly ApplicationService $applications,
    ) {}

    public function index(Request $request): View
    {
        return view('applications.index', [
            'applications' => $this->applications->listForProfile(
                $request->user()->candidateProfile,
            ),
        ]);
    }

    public function store(StoreApplicationRequest $request, JobPost $jobPost): RedirectResponse
    {
        $this->applications->apply(
            $request->user()->candidateProfile,
            $jobPost,
            $request->validated(),
        );

        return redirect()
            ->route('applications.index')
            ->with('success', __('application.messages.submitted'));
    }

    public function updateStatus(UpdateApplicationStatusRequest $request, Application $application): RedirectResponse
    {
        $this->applications->changeStatus(
            $application,
            $request->status(),
            $request->validated('note'),
        );

        return back()->with('success', __('application.messages.status_updated'));
    }
}
