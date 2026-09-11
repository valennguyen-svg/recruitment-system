<?php

namespace App\Policies;

use App\Enums\Permission;
use App\Models\Commission;
use App\Models\User;

class CommissionPolicy
{
    // Khong co before() — xem ghi chu o UserPolicy.

    public function viewAny(User $actor): bool
    {
        return $actor->can(Permission::COMMISSIONS_VIEW->value);
    }

    public function view(User $actor, Commission $commission): bool
    {
        if (! $actor->can(Permission::COMMISSIONS_VIEW->value)) {
            return false;
        }

        // Vai tro van hanh: nhin xuyen moi cong ty.
        if ($actor->can(Permission::COMMISSIONS_VIEW_ALL->value)) {
            return true;
        }

        // Nguoi duyet hoa hong: toan bo hoa hong trong cong ty minh.
        if ($actor->can(Permission::COMMISSIONS_MANAGE->value)) {
            return $actor->company_id === $commission->company_id;
        }

        // Con lai (HR): chi hoa hong cua chinh minh.
        return $actor->is($commission->user);
    }

    public function manage(User $actor, Commission $commission): bool
    {
        return $actor->can(Permission::COMMISSIONS_MANAGE->value)
            && $actor->company_id === $commission->company_id
            && ! $commission->status->isFinal();
    }
}