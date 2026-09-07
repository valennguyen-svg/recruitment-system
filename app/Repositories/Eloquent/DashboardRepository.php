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

class DashboardRepository implements DashboardRepositoryInterface
{
    private const MONTH_LABEL_FORMAT = 'MM/YYYY';

    public function countJobs(): int
    {
        return JobPost::query()->count();
    }

    public function countJobsByStatus(): Collection
    {
        return JobPost::query()
            ->select('status', DB::raw('count(*) as total'))
            ->groupBy('status')
            ->pluck('total', 'status');
    }

    public function countApplications(): int
    {
        return Application::query()->count();
    }

    public function countApplicationsByStatus(): Collection
    {
        return Application::query()
            ->select('status', DB::raw('count(*) as total'))
            ->groupBy('status')
            ->pluck('total', 'status');
    }

    public function countHiredApplications(): int
    {
        return Application::query()
            ->where('status', ApplicationStatus::HIRED)
            ->count();
    }

    public function countCompanies(): int
    {
        return Company::query()->count();
    }

    public function countUsersByRole(UserRole $role): int
    {
        return User::query()->role($role->value)->count();
    }

    public function jobsPerMonth(int $months): Collection
    {
        return JobPost::query()
            ->select(
                DB::raw("to_char(date_trunc('month', created_at), '".self::MONTH_LABEL_FORMAT."') as label"),
                DB::raw("date_trunc('month', created_at) as bucket"),
                DB::raw('count(*) as total'),
            )
            ->where('created_at', '>=', now()->subMonths($months)->startOfMonth())
            ->groupBy('bucket', 'label')
            ->orderBy('bucket')
            ->get()
            ->pluck('total', 'label');
    }

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

    public function topJobs(int $limit): Collection
    {
        return JobPost::query()
            ->withCount('applications')
            ->orderByDesc('applications_count')
            ->take($limit)
            ->get(['id', 'title', 'slug']);
    }
}
