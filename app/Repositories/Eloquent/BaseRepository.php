<?php

namespace App\Repositories\Eloquent;

use App\Repositories\Contracts\BaseRepositoryInterface;
use Illuminate\Database\Eloquent\Model;

abstract class BaseRepository implements BaseRepositoryInterface
{
    public function __construct(protected Model $model) {}

    public function find(int $id): ?Model
    {
        return $this->model->newQuery()->find($id);
    }

    public function create(array $attributes): Model
    {
        return $this->model->newQuery()->create($attributes);
    }

    public function update(Model $model, array $attributes): Model
    {
        $model->fill($attributes)->save();

        return $model->refresh();
    }

    public function delete(Model $model): bool
    {
        return (bool) $model->delete();
    }

    /** @param array<string, mixed> $conditions */
    public function count(array $conditions = []): int
    {
        return $this->model->where($conditions)->count();
    }
}
