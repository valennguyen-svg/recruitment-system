<?php

namespace App\Services;

use App\Repositories\Contracts\JobCategoryRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class JobCategoryService
{
    public function __construct(
        private readonly JobCategoryRepositoryInterface $categories,
    ) {}

    public function listForFilter(): Collection
    {
        return $this->categories->allSorted();
    }
}
