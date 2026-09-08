<?php

namespace App\Repositories\Eloquent;

use App\Repositories\Contracts\BaseRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * @template TModel of Model
 *
 * @implements BaseRepositoryInterface<TModel>
 */
abstract class BaseRepository implements BaseRepositoryInterface
{
    /**
     * Quan hệ sẽ nạp ở truy vấn kế tiếp.
     * Tự reset sau mỗi truy vấn để không rò rỉ sang lần gọi sau.
     *
     * @var array<int, string>
     */
    protected array $relations = [];

    /** @param  TModel  $model */
    public function __construct(
        protected readonly Model $model,
    ) {}

    public function find(int $id): ?Model
    {
        return $this->query()->find($id);
    }

    public function findOrFail(int $id): Model
    {
        return $this->query()->findOrFail($id);
    }

    public function findBy(string $column, mixed $value): ?Model
    {
        return $this->query()->where($column, $value)->first();
    }

    public function all(array $columns = ['*']): Collection
    {
        return $this->query()->get($columns);
    }

    public function where(array $conditions): Collection
    {
        return $this->applyConditions($this->query(), $conditions)->get();
    }

    public function paginate(int $perPage, array $conditions = []): LengthAwarePaginator
    {
        return $this->applyConditions($this->query(), $conditions)
            ->paginate($perPage)
            ->withQueryString();
    }

    public function exists(array $conditions): bool
    {
        return $this->applyConditions($this->query(), $conditions)->exists();
    }

    public function count(array $conditions = []): int
    {
        return $this->applyConditions($this->query(), $conditions)->count();
    }

    public function create(array $attributes): Model
    {
        return $this->model->newQuery()->create($attributes);
    }

    public function update(Model $model, array $attributes): Model
    {
        $model->update($attributes);

        return $model->refresh();
    }

    public function updateOrCreate(array $conditions, array $attributes): Model
    {
        return $this->model->newQuery()->updateOrCreate($conditions, $attributes);
    }

    public function delete(Model $model): bool
    {
        return (bool) $model->delete();
    }

    public function deleteWhere(array $conditions): int
    {
        return $this->applyConditions($this->model->newQuery(), $conditions)->delete();
    }

    public function query(): Builder
    {
        $query = $this->model->newQuery();

        if ($this->relations !== []) {
            $query->with($this->relations);

            $this->relations = [];
        }

        return $query;
    }

    public function with(array $relations): static
    {
        $this->relations = $relations;

        return $this;
    }

    /**
     * Áp điều kiện dạng mảng vào truy vấn. Hỗ trợ ba dạng:
     *
     *   ['status' => 'published']        → where('status', 'published')
     *   ['id' => [1, 2, 3]]              → whereIn('id', [1, 2, 3])
     *   ['salary' => ['>=', 10000000]]   → where('salary', '>=', 10000000)
     *   ['deleted_at' => null]           → whereNull('deleted_at')
     *
     * @param  Builder<TModel>  $query
     * @param  array<string, mixed>  $conditions
     * @return Builder<TModel>
     */
    protected function applyConditions(Builder $query, array $conditions): Builder
    {
        foreach ($conditions as $column => $value) {
            match (true) {
                $value === null
                    => $query->whereNull($column),
                is_array($value) && count($value) === 2 && is_string($value[0] ?? null)
                    => $query->where($column, $value[0], $value[1]),
                is_array($value)
                    => $query->whereIn($column, $value),
                default
                    => $query->where($column, $value),
            };
        }

        return $query;
    }
}