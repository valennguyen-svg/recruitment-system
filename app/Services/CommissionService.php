<?php

namespace App\Services;

use App\Constants\CommissionConstants;
use App\Enums\CommissionStatus;
use App\Exceptions\DomainRuleException;
use App\Models\Application;
use App\Models\Commission;
use App\Models\User;
use App\Repositories\Contracts\CommissionRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;

class CommissionService
{
    /**
     * Sinh ban ghi hoa hong cho HR tao ra tin, khi co don ung tuyen moi.
     * Tra ve null neu tin khong gan HR hoac cong ty chua dat muc hoa hong.
     */
    public function recordForApplication(Application $application): ?Commission
    {
        $job = $application->jobPost;

        if ($job === null) {
            return null;
        }

        $rate = (int) ($job->company?->commission_rate ?? 0);

        if ($job->created_by === null || $rate <= 0) {
            return null;
        }

        return Commission::firstOrCreate(
            ['application_id' => $application->getKey()],
            [
                'user_id'     => $job->created_by,
                'company_id'  => $job->company_id,
                'job_post_id' => $job->getKey(),
                'amount'      => $rate,
                'status'      => CommissionStatus::PENDING,
            ],
        );
    }

    /**
     * Doi trang thai hoa hong.
     *
     * Rang buoc may trang thai o day la invariant nghiep vu, khong phai
     * phan quyen: no dung voi moi nguoi goi, ke ca super admin von di tat
     * qua CommissionPolicy nho Gate::before.
     */
    public function transition(Commission $commission, CommissionStatus $target, ?string $note = null): Commission
    {
        if (! $commission->status->canTransitionTo($target)) {
            throw new DomainRuleException(__('commission.errors.invalid_transition', [
                'from' => $commission->status->label(),
                'to'   => $target->label(),
            ]));
        }

        return DB::transaction(function () use ($commission, $target, $note): Commission {
            $commission->update([
                'status'      => $target,
                'note'        => $note ?? $commission->note,
                'approved_at' => $target === CommissionStatus::APPROVED ? now() : $commission->approved_at,
                'paid_at'     => $target === CommissionStatus::PAID ? now() : $commission->paid_at,
            ]);

            return $commission->refresh();
        });
    }
        public function __construct(
        private readonly CommissionRepositoryInterface $commissions,
    ) {}

    /** @param array<string, mixed> $filters */
    public function listForCompany(int $companyId, array $filters): LengthAwarePaginator
    {
        return $this->commissions->paginateForCompany($companyId, $filters, CommissionConstants::PER_PAGE);
    }

    /** @param array<string, mixed> $filters */
    public function listForUser(User $user, array $filters): LengthAwarePaginator
    {
        return $this->commissions->paginateForUser($user, $filters, CommissionConstants::PER_PAGE);
    }

    /** @return array<string, int> */
    public function totals(int $companyId, ?int $userId = null): array
    {
        return $this->commissions->sumByStatus($companyId, $userId);
    }
}