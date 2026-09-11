<?php

namespace App\Repositories\Eloquent;

use App\Models\Commission;
use App\Models\User;
use App\Repositories\Contracts\CommissionRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;

class CommissionRepository implements CommissionRepositoryInterface
{
    public function __construct(
        private readonly Commission $model,
    ) {}

    /** @param array<string, mixed> $filters */
    public function paginateForCompany(int $companyId, array $filters, int $perPage): LengthAwarePaginator
    {
        return $this->baseQuery($filters)
            ->where('company_id', $companyId)
            ->paginate($perPage);
    }

    /**
     * Loc theo user_id dat SAU baseQuery de ghi de moi bo loc user_id
     * gui tu request — HR khong xem duoc hoa hong cua nguoi khac.
     *
     * @param array<string, mixed> $filters
     */
    public function paginateForUser(User $user, array $filters, int $perPage): LengthAwarePaginator
    {
        return $this->baseQuery($filters)
            ->where('user_id', $user->getKey())
            ->paginate($perPage);
    }

    /** @return array<string, int> */
    public function sumByStatus(int $companyId, ?int $userId = null): array
    {
        return $this->model
            ->newQuery()
            ->where('company_id', $companyId)
            ->when($userId, fn (Builder $q, int $id) => $q->where('user_id', $id))
            ->selectRaw('status, sum(amount) as total')
            ->groupBy('status')
            ->pluck('total', 'status')
            ->map(fn ($total): int => (int) $total)
            ->all();
    }

    /** @param array<string, mixed> $filters */
    private function baseQuery(array $filters): Builder
    {
        return $this->model
            ->newQuery()
            ->when($filters['user_id'] ?? null, fn (Builder $q, $id) => $q->where('user_id', $id))
            ->when($filters['status'] ?? null, fn (Builder $q, $status) => $q->where('status', $status))
            ->when($filters['from'] ?? null, fn (Builder $q, $from) => $q->whereDate('created_at', '>=', $from))
            ->when($filters['to'] ?? null, fn (Builder $q, $to) => $q->whereDate('created_at', '<=', $to))
            ->with(['user:id,name', 'jobPost:id,title'])
            ->latest();
    }
}