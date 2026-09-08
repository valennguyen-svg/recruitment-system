<?php

namespace App\Repositories\Contracts;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Thao tác dùng chung cho mọi repository.
 *
 * Chỉ đặt ở đây những gì đúng với mọi entity. Thao tác riêng của một entity
 * (ví dụ findByEmail) thuộc về interface con của entity đó.
 *
 * @template TModel of Model
 */
interface BaseRepositoryInterface
{
    /** @return TModel|null */
    public function find(int $id): ?Model;

    /**
     * @return TModel
     *
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException
     */
    public function findOrFail(int $id): Model;

    /** @return TModel|null */
    public function findBy(string $column, mixed $value): ?Model;

    /** @return Collection<int, TModel> */
    public function all(array $columns = ['*']): Collection;

    /**
     * @param  array<string, mixed>  $conditions
     * @return Collection<int, TModel>
     */
    public function where(array $conditions): Collection;

    /** @param  array<string, mixed>  $conditions */
    public function paginate(int $perPage, array $conditions = []): LengthAwarePaginator;

    /** @param  array<string, mixed>  $conditions */
    public function exists(array $conditions): bool;

    /** @param  array<string, mixed>  $conditions */
    public function count(array $conditions = []): int;

    /**
     * @param  array<string, mixed>  $attributes
     * @return TModel
     */
    public function create(array $attributes): Model;

    /**
     * @param  TModel  $model
     * @param  array<string, mixed>  $attributes
     * @return TModel
     */
    public function update(Model $model, array $attributes): Model;

    /**
     * @param  array<string, mixed>  $conditions
     * @param  array<string, mixed>  $attributes
     * @return TModel
     */
    public function updateOrCreate(array $conditions, array $attributes): Model;

    /** @param  TModel  $model */
    public function delete(Model $model): bool;

    /**
     * @param  array<string, mixed>  $conditions
     * @return int Số bản ghi đã xoá
     */
    public function deleteWhere(array $conditions): int;

    /**
     * Truy vấn mới, dùng khi repository con cần điều kiện phức tạp.
     *
     * @return Builder<TModel>
     */
    public function query(): Builder;

    /**
     * Nạp sẵn quan hệ cho truy vấn kế tiếp.
     *
     * @param  array<int, string>  $relations
     */
    public function with(array $relations): static;
}