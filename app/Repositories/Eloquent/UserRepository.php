<?php

namespace App\Repositories\Eloquent;

use App\Constants\AuthConstants;
use App\Enums\UserRole;
use App\Models\User;
use App\Repositories\Contracts\UserRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Str;

class UserRepository extends BaseRepository implements UserRepositoryInterface
{
    public function __construct(User $model)
    {
        parent::__construct($model);
    }

    public function findByEmail(string $email): ?User
    {
        return $this->model->newQuery()->where('email', $email)->first();
    }

    public function updatePassword(User $user, string $hashedPassword): User
    {
        $user->forceFill([
            'password' => $hashedPassword,
            'remember_token' => Str::random(AuthConstants::REMEMBER_TOKEN_LENGTH),
        ])->save();

        return $user;
    }

    public function paginateStaffForCompany(int $companyId, int $perPage): LengthAwarePaginator
    {
        return $this->model
            ->newQuery()
            ->where('company_id', $companyId)
            ->role(UserRole::RECRUITER->value)
            ->withCount('jobPosts')
            ->latest()
            ->paginate($perPage);
    }
}
