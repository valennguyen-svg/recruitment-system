<?php

namespace App\Http\Controllers\Company;

use App\Http\Controllers\Controller;
use App\Http\Requests\Company\StoreStaffRequest;
use App\Http\Requests\Company\UpdateStaffRequest;
use App\Models\User;
use App\Services\CompanyStaffService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class StaffController extends Controller
{
    public function __construct(
        private readonly CompanyStaffService $staff,
    ) {}

        public function index(Request $request): View
    {
        $this->authorize('manageStaff', User::class);

        return view('company.staff.index', [
            'staff'     => $this->staff->listForCompany($request->user()->company_id),
            'companyId' => $request->user()->company_id,
        ]);
    }

    public function create(Request $request): View
    {
        $this->authorize('create', User::class);

        return view('company.staff.create');
    }

    public function store(StoreStaffRequest $request): RedirectResponse
    {
        $this->staff->create($request->staffData());

        return redirect()
            ->route('company.staff.index')
            ->with('success', __('staff.messages.created'));
    }

    public function edit(User $staff): View
    {
        $this->authorize('update', $staff);

        return view('company.staff.edit', ['staff' => $staff]);
    }

    public function update(UpdateStaffRequest $request, User $staff): RedirectResponse
    {
        $this->staff->update($staff, $request->staffData());

        return redirect()
            ->route('company.staff.index')
            ->with('success', __('staff.messages.update'));
    }

    public function destroy(User $staff): RedirectResponse
    {
        $this->authorize('update', $staff);
        $this->staff->deactivate($staff);

        return redirect()
            ->route('company.staff.index')
            ->with('success', __('staff.messages.deactivated'));
    }

    /**
     * Cong ty dang thao tac. Nguoi dung binh thuong luon lay tu tai khoan
     * cua ho. Chi nguoi khong thuoc cong ty nao moi doc duoc tham so URL —
     * ma dieu kien company_id !== null trong UserPolicy::manageStaff() dam
     * bao truong hop do chi co the la super admin (di qua nho Gate::before).
     */
    private function resolveCompanyId(Request $request): ?int
    {
        return $request->user()->company_id ?? $request->integer('company');
    }
}
