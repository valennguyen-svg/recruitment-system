<?php

namespace App\Repositories\Eloquent;

use App\Models\JobCategory;
use App\Repositories\Contracts\JobCategoryRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class JobCategoryRepository extends BaseRepository implements JobCategoryRepositoryInterface
{
    public function __construct(JobCategory $model)
    {
        parent::__construct($model);
    }

    public function allSorted(): Collection
    {
        return $this->model->newQuery()
            ->orderBy('name')
            ->get(['id', 'name']);
    }
}
