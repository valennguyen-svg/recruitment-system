<?php

namespace App\Services;

use App\Constants\RouteConstants;
use App\Constants\UserConstants;
use App\Enums\UserRole;
use App\Models\User;
use App\Repositories\Contracts\UserRepositoryInterface;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;

class AuthService
{
    public function __construct(
        private readonly UserRepositoryInterface $users,
    ) {}

    /**
     * Đăng ký tài khoản mới bằng email và mật khẩu.
     *
     * @param  array{name: string, email: string, password: string}  $data
     */
    public function register(array $data): User
    {
        return DB::transaction(function () use ($data): User {
            /** @var User $user */
            $user = $this->users->create([
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => Hash::make($data['password']),
                'is_active' => true,
            ]);

            $this->initializeCandidate($user);

            return $user;
        });
    }

    /** Tìm tài khoản theo email Google, tạo mới nếu chưa có. */
    public function findOrCreateFromGoogle(object $googleUser): User
    {
        $user = $this->users->findByEmail($googleUser->getEmail());

        if ($user !== null) {
            return $this->linkGoogleAccount($user, $googleUser);
        }

        return DB::transaction(function () use ($googleUser): User {
            /** @var User $user */
            $user = $this->users->create([
                'name' => $googleUser->getName(),
                'email' => $googleUser->getEmail(),
                'provider' => UserConstants::PROVIDER_GOOGLE,
                'provider_id' => $googleUser->getId(),
                'avatar' => $googleUser->getAvatar(),
                'password' => null,
                'is_active' => true,
                'email_verified_at' => now(),
            ]);

            $this->initializeCandidate($user);

            return $user;
        });
    }

    public function changePassword(User $user, string $plainPassword): User
    {
        return $this->users->update($user, [
            'password' => Hash::make($plainPassword),
        ]);
    }

    public function resetPassword(User $user, string $plainPassword): User
    {
        return $this->users->updatePassword($user, Hash::make($plainPassword));
    }

    /** Route đích sau khi đăng nhập, tuỳ theo vai trò. */
    public function homeRouteFor(User $user): string
    {
        foreach (RouteConstants::HOME_BY_ROLE as $role => $route) {
            if ($user->hasRole($role) && Route::has($route)) {
                return $route;
            }
        }

        return RouteConstants::DEFAULT_HOME;
    }

    /** Gắn thông tin Google vào tài khoản đã đăng ký bằng email. */
    private function linkGoogleAccount(User $user, object $googleUser): User
    {
        if (filled($user->provider)) {
            return $user;
        }

        return $this->users->update($user, [
            'provider' => UserConstants::PROVIDER_GOOGLE,
            'provider_id' => $googleUser->getId(),
            'avatar' => $googleUser->getAvatar(),
        ]);
    }

    /** Gán vai trò ứng viên và tạo hồ sơ rỗng cho tài khoản mới. */
    private function initializeCandidate(User $user): void
    {
        $user->assignRole(UserRole::CANDIDATE->value);
        $user->candidateProfile()->create([]);
    }
}
