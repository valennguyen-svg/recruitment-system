<?php

namespace App\Http\Controllers;

use App\Http\Requests\Application\StoreApplicationRequest;
use App\Models\JobPost;
use App\Services\ApplicationService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\Response;

class ApplicationController extends Controller
{
    public function __construct(
        private readonly ApplicationService $applications,
    ) {}

    public function store(StoreApplicationRequest $request, JobPost $jobPost): RedirectResponse
    {
        $profile = $request->user()->candidateProfile;

        abort_if($profile === null, Response::HTTP_FORBIDDEN, __('application.errors.no_profile'));

        $this->applications->apply($jobPost, $profile, $request->validated());

        return back()->with('success', __('application.messages.applied'));
    }

    public function index(Request $request): View
    {
        return view('applications.index', [
            'applications' => $this->applications->listForProfile($request->user()->candidateProfile),
        ]);
    }
}