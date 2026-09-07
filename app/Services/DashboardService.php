<?php

namespace App\Services;

use App\Constants\DashboardConstants;
use App\Enums\ApplicationStatus;
use App\Enums\JobStatus;
use App\Enums\UserRole;
use App\Repositories\Contracts\DashboardRepositoryInterface;
use Illuminate\Support\Collection;

class DashboardService
{
    public function __construct(
        private readonly DashboardRepositoryInterface $dashboard,
    ) {}

    /** Các con số tổng quan đầu trang. */
    public function overview(): array
    {
        $jobsByStatus = $this->dashboard->countJobsByStatus();

        return [
            'total_jobs'       => $this->dashboard->countJobs(),
            'published_jobs'   => (int) $jobsByStatus->get(JobStatus::PUBLISHED->value, 0),
            'pending_jobs'     => (int) $jobsByStatus->get(JobStatus::PENDING_REVIEW->value, 0),
            'total_apps'       => $this->dashboard->countApplications(),
            'total_companies'  => $this->dashboard->countCompanies(),
            'total_candidates' => $this->dashboard->countUsersByRole(UserRole::CANDIDATE),
        ];
    }

    /**
     * Số tin theo trạng thái, trả về mảng đã gắn nhãn đa ngôn ngữ.
     *
     * @return array<string, array{label: string, count: int}>
     */
    public function jobsByStatus(): array
    {
        $counts = $this->dashboard->countJobsByStatus();

        return collect(JobStatus::cases())
            ->mapWithKeys(fn (JobStatus $status): array => [
                $status->value => [
                    'label' => $status->label(),
                    'count' => (int) $counts->get($status->value, 0),
                ],
            ])
            ->all();
    }

    /** @return array<string, array{label: string, count: int}> */
    public function applicationsByStatus(): array
    {
        $counts = $this->dashboard->countApplicationsByStatus();

        return collect(ApplicationStatus::cases())
            ->mapWithKeys(fn (ApplicationStatus $status): array => [
                $status->value => [
                    'label' => $status->label(),
                    'count' => (int) $counts->get($status->value, 0),
                ],
            ])
            ->all();
    }

    public function jobsPerMonth(): array
    {
        return $this->dashboard
            ->jobsPerMonth(DashboardConstants::CHART_MONTHS)
            ->all();
    }

    public function topCompanies(): Collection
    {
        return $this->dashboard->topCompanies(DashboardConstants::TOP_COMPANIES);
    }

    public function topJobs(): Collection
    {
        return $this->dashboard->topJobs(DashboardConstants::TOP_JOBS);
    }

    /** Tỉ lệ đơn ứng tuyển dẫn đến trúng tuyển (%). */
    public function hireRate(): float
    {
        $total = $this->dashboard->countApplications();

        if ($total === 0) {
            return 0.0;
        }

        return round(
            $this->dashboard->countHiredApplications() / $total * DashboardConstants::PERCENT_BASE,
            DashboardConstants::PERCENT_PRECISION,
        );
    }
}