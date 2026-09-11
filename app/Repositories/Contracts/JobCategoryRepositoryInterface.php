<?php

namespace App\Repositories\Contracts;
use App\Models\User;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

use Illuminate\Database\Eloquent\Collection;

interface JobCategoryRepositoryInterface extends BaseRepositoryInterface
{
    public function allSorted(): Collection;

}
