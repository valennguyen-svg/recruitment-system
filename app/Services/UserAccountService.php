<?php

namespace App\Services;

use App\Enums\UserRole;
use App\Exceptions\DomainRuleException;
use App\Models\User;
use App\Repositories\Contracts\UserRepositoryInterface;
use Illuminate\Support\Facades\DB;
use Redirect;

class UserAccountService
{
    public function __construct(
        private readonly UserRepositoryInterface $users,
    ){}

    public function delete (User $actor, User $target): void
    {
        $this->guardAgainstSelfDeletion($actor, $target);
        $this->guardAgainstLastSuperAdmin($target);

        DB::transaction(fn () => $this->users->delete($target));
    }

    /**Không ai tự xóa tài khoản cua chình mình, kể cả super admin */
    private function guardAgainstSelfDeletion(User $actor, User $target): void
    {
        if ($actor->is($target)){
             throw new DomainRuleException(__('user.errors.cannot_delete_self'));
        }
    }

    /**Hệ thống luôn phải con ít nhất một super admin đang hoạt động */
     private function guardAgainstLastSuperAdmin(User $target): void
    {
        if (! $target->isSuperAdmin()) {
            return;
        }

        $remaining = User::query()
            ->role(UserRole::SUPER_ADMIN->value)
            ->where('is_active', true)
            ->whereKeyNot($target->getKey())
            ->count();

        if ($remaining === 0) {
            throw new DomainRuleException(__('user.errors.last_super_admin'));
        }
    }
}