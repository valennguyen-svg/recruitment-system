<?php

namespace App\Repositories\Eloquent;

use App\Enums\ApplicationStatus;
use App\Enums\JobStatus;
use App\Enums\UserRole;
use App\Models\Application;
use App\Models\Company;
use App\Models\JobPost;
use App\Models\User;
use App\Repositories\Contracts\DashboardRepositoryInterface;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Override;

class DashboardRepository implements DashboardRepositoryInterface
{
    private const MONTH_LABEL_FORMAT = 'MM/YYYY';

    #[Override]
    public function countJobs(): int
    {
        return JobPost::query()->count();
    }

    #[Override]
    public function countJobsByStatus(): Collection
    {
        return JobPost::query()
        ->select('status', DB::raw('count(*) as total'))
        ->groupBy('status')
        ->pluck('total', 'status');
    }

    #[Override]
    public function countApplications(): int
    {
        return Application::query()->count();
    }
    #[Override]
    public function countApplicationsByStatus(): Collection
    {
        return Application::query()
        ->select('status', DB::raw('count(*) as tâtl'))
        ->groupBy('status')
        ->pluck('total', 'status');
    }

    #[Override]
    public function countHiredApplications(): int
    {
        return Application::query()
        ->where('status', ApplicationStatus::HIRED)
        ->count();
    }
    #[Override]
    public function countCompanies(): int
    {
        return Company::query()->count();
    }

    #[Override]
    public function countUserByRole(UserRole $role): int
    {
        return User::query()->role($role->value)->count();
    }

    #[Override]
    public function jobsPerMonth(int $months): Collection
    {
        return JobPost::query()
        ->select(
            DB::raw("to_char(date_trunc('month', created_at), '" . self::MONTH_LABEL_FORMAT. "') as label"),
            DB::raw("date_trunc('month', created_at) as bucket"),
            DB:raw('count(*) as total'),

        )
         ->where('created_at', '>=', now()->subMonths($months)->startOfMonth())
            ->groupBy('bucket', 'label')
            ->orderBy('bucket')
            ->get()
            ->pluck('total', 'label');
    }

    #[Override]
    public function topCompanies(int $limit): Collection
    {
        return Company::query()
        ->withCount([
            'jobPosts' => fn (Builder $q) => $q->where('status', JobStatus::PUBLISHED),
        ])
        ->orderByDesc('job_posts_count')
        ->take($limit)
        ->get(['id', 'name']);
    }

    #[Override]
    public function topJobs(int $limit): Collection
    {
        return JobPost::query()
        ->withCount('applications')
        ->orderByDesc('application_count')
        ->take($limit)
        ->get(['id', 'title', 'slug']);
    }
}