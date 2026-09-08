<?php

namespace App\Services;

use App\Models\User;
use App\Repositories\Contracts\UserRepositoryInterface;
use Illuminate\Support\Facades\Auth;

class ProfileService
{
    public function __construct(
        private readonly UserRepositoryInterface $users,
    ) {}

    /**
     * Cập nhật thông tin tài khoản.
     * Đổi email sẽ huỷ trạng thái đã xác minh, buộc xác minh lại.
     *
     * @param  array{name: string, email: string}  $data
     */
    public function updateAccount(User $user, array $data): User
    {
        $user->fill($data);
        $user->save();

        return $user;
    }

    /** Đăng xuất rồi xoá tài khoản. */
    public function deleteAccount(User $user): void
    {
        Auth::logout();

        $this->users->delete($user);
    }
}