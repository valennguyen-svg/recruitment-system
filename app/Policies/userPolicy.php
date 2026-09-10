<?php

namespace App\Policies;

use App\Enums\Permission;
use App\Enums\UserRole;
use App\Models\User;

class UserPolicy
{
    // Khong co before(): luat Gate::before trong AppServiceProvider da lo
    // phan super admin cho toan bo ung dung. Them before() o day chi la
    // lap lai, va lap lai thi som muon se lech nhau.

    public function viewAny(User $actor): bool
    {
        return $actor->can(Permission::USERS_VIEW->value);
    }

    public function view(User $actor, User $target): bool
    {
        if (! $actor->can(Permission::USERS_VIEW->value)) {
            return false;
        }

        // Vai tro van hanh nhin xuyen moi cong ty.
        if ($actor->can(Permission::USERS_VIEW_ALL->value)) {
            return true;
        }

        // Con lai: chi trong cong ty cua minh.
        return $actor->sharesCompanyWith($target);
    }

    /** Man hinh quan ly nhan su cua mot cong ty. */
    public function manageStaff(User $actor): bool
    {
        return $actor->can(Permission::USERS_CREATE->value)
            && $actor->company_id !== null;
    }

    public function create(User $actor): bool
    {
        return $this->manageStaff($actor);
    }

    public function update(User $actor, User $target): bool
    {
        return $actor->can(Permission::USERS_UPDATE->value)
            && $actor->sharesCompanyWith($target)
            && ! $target->hasRole(UserRole::COMPANY_ADMIN->value);
    }

    public function delete(User $actor, User $target): bool
    {
        return $actor->can(Permission::USERS_DELETE->value)
            && $actor->isNot($target);
    }

    public function assignRole(User $actor): bool
    {
        return $actor->can(Permission::USERS_ASSIGN_ROLE->value);
    }
}