<?php

namespace Database\Seeders;

use App\Enums\UserRole;
use App\Models\Company;
use App\Models\User;
use Illuminate\Database\Seeder;

class BackfillCompanyMembershipSeeder extends Seeder
{
    public function run(): void
    {
        Company::query()->each(function (Company $company): void {
            $owner = User::find($company->user_id);

            if ($owner === null) {
                return;
            }

            $owner->update(['company_id' => $company->getKey()]);
            $owner->syncRoles([UserRole::COMPANY_ADMIN->value]);

            $this->command->info("Cong ty #{$company->id}: gan giam doc {$owner->email}");
        });
    }
}