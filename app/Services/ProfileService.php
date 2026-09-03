<?php

namespace App\Services;

use App\Models\User;
use App\Repositories\Contracts\UserRepositoryInterface;
use Illuminate\Support\Facades\Auth;

class ProfileService
{
    public function __construct(
        private readonly UserRepositoryInterface $users,
    )
    {
        throw new \Exception('Not implemented');
    }

    public function updateAccount(User $user, array $data): User
    {
        $user->fill($data);
        if ($user->isDirty('email')){
            $user->email_verified_at = null;
        }
        $user->save();
        return $user;
    }

    public function deleteAccount(User $user):void
    {
        Auth::logout();
        $this->users->delete($user);
    }
}