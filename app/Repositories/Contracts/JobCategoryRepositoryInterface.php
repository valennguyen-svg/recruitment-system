<?php

namespace App\Repositories\Contracts;

use Illuminate\Database\Eloquent\Collection;

interface JobCategoryRepositoryInterface extends BaseRepositoryInterface
{
    public function allSorted(): Collection;
}
