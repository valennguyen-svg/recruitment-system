<?php

namespace App\Repositories\Contracts;

use App\Models\User;
use Illuminate\Foundation\Providers\FoundationServiceProvider;

interface UserRepositoryInterface extends BaseRepositoryInterface
{
    public function findByEmail(string $email): ?User;
    public function updatePassword(User $user, string $hashedPassword): User;
}