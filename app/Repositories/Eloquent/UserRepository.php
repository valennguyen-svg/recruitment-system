<?php

namespace App\Repositories\Eloquent;

use App\Models\User;
use App\Repositories\Contracts\UserRepositoryInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Override;

class UserRepository extends BaseRepository implements UserRepositoryInterface
{
    #[Override]
    public function __construct(User $model)
    {
        parent::__construct($model);
    }

    #[Override]
    public function findByEmail(string $email): ?User
    {
        return $this->model->newQuery()->where('email', $email)->first();
    }

    #[Override]
    public function updatePassword(User $user, string $hashedPassword): User
    {
        $user->forceFill([
            'password'=>$hashedPassword,
            'remember_token'=>Str::random(\App\Constants\AuthConstants::REMEMBER_TOKEN_LENGTH),
        ])->save();
        return $user;
    }
}