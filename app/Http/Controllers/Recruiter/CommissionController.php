<?php

namespace App\Http\Controllers\Recruiter;

use App\Enums\CommissionStatus;
use App\Http\Controllers\Controller;
use App\Http\Requests\Commission\CommissionFilterRequest;
use App\Services\CommissionService;
use Illuminate\View\View;

class CommissionController extends Controller
{
    public function __construct(
        private readonly CommissionService $commissions,
    ) {}

    public function index(CommissionFilterRequest $request): View
    {
        $user = $request->user();

        return view('recruiter.commissions.index', [
            'commissions' => $this->commissions->listForUser($user, $request->filters()),
            'totals'      => $this->commissions->totals((int) $user->company_id, $user->getKey()),
            'statuses'    => CommissionStatus::cases(),
        ]);
    }
}