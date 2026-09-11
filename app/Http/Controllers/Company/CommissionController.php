<?php

namespace App\Http\Controllers\Company;

use App\Enums\CommissionStatus;
use App\Enums\UserRole;
use App\Http\Controllers\Controller;
use App\Http\Requests\Commission\CommissionFilterRequest;
use App\Http\Requests\Commission\TransitionCommissionRequest;
use App\Models\Commission;
use App\Models\User;
use App\Services\CommissionService;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class CommissionController extends Controller
{
    public function __construct(
        private readonly CommissionService $commissions,
    ) {}

        public function index(CommissionFilterRequest $request): View
    {
        $companyId = (int) $request->user()->company_id;

        return view('company.commissions.index', [
            'commissions' => $this->commissions->listForCompany($companyId, $request->filters()),
            'totals'      => $this->commissions->totals($companyId),
            'statuses'    => CommissionStatus::cases(),
            'staff'       => User::query()
                ->where('company_id', $companyId)
                ->role(UserRole::RECRUITER->value)
                ->orderBy('name')
                ->pluck('name', 'id'),
        ]);
    }

    public function approve(TransitionCommissionRequest $request, Commission $commission): RedirectResponse
    {
        return $this->transition($request, $commission, CommissionStatus::APPROVED);
    }

    public function markPaid(TransitionCommissionRequest $request, Commission $commission): RedirectResponse
    {
        return $this->transition($request, $commission, CommissionStatus::PAID);
    }

    public function void(TransitionCommissionRequest $request, Commission $commission): RedirectResponse
    {
        return $this->transition($request, $commission, CommissionStatus::VOID);
    }

    private function transition(
        TransitionCommissionRequest $request,
        Commission $commission,
        CommissionStatus $target,
    ): RedirectResponse {
        $this->commissions->transition(
            $commission,
            $target,
            $request->string('note')->value() ?: null,
        );

        return back()->with('success', __('commission.messages.updated', [
            'status' => $target->label(),
        ]));
    }
}