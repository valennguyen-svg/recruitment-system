<?php

namespace App\Enums;

enum UserRole: string
{
    case SUPER_ADMIN = 'super_admin';
    case ADMIN = 'admin';
    case COMPANY_ADMIN = 'company_admin';
    case RECRUITER = 'recruiter';
    case CANDIDATE = 'candidate';

    public function label(): string
    {
        return __(match ($this) {
            self::SUPER_ADMIN => 'Super administrator',
            self::ADMIN => 'Administrator',
            self::COMPANY_ADMIN => 'Company administrator',
            self::RECRUITER => 'Recruiter',
            self::CANDIDATE => 'Candidate',
        });
    }

    /**
     * Cac quyen luu trong database cho vai tro nay.
     *
     * SUPER_ADMIN co chu dinh tra ve mang rong: quyen cua no den tu luat
     * Gate::before trong AppServiceProvider, khong den tu bang
     * role_has_permissions. Xem muc 15.0.3.
     *
     * @return Permission[]
     */
    public function permissions(): array
    {
        return match ($this) {
            self::SUPER_ADMIN => [],

            self::ADMIN => [
                Permission::DASHBOARD_VIEW,
                Permission::USERS_VIEW,
                Permission::USERS_VIEW_ALL,
                Permission::COMPANIES_VIEW,
                Permission::COMPANIES_APPROVE,
                Permission::JOBS_APPROVE,
                Permission::JOBS_VIEW_ALL,
                Permission::APPLICATIONS_VIEW,
                Permission::REPORTS_VIEW,
                Permission::COMMISSIONS_VIEW,
                Permission::COMMISSIONS_VIEW_ALL,
                Permission::AUDIT_LOGS_VIEW,
            ],

            self::COMPANY_ADMIN => [
                Permission::DASHBOARD_VIEW,
                Permission::USERS_VIEW,
                Permission::USERS_CREATE,
                Permission::USERS_UPDATE,
                Permission::COMPANIES_VIEW,
                Permission::COMPANIES_UPDATE,
                Permission::JOBS_CREATE,
                Permission::JOBS_UPDATE,
                Permission::JOBS_UPDATE_ANY,
                Permission::JOBS_DELETE,
                Permission::APPLICATIONS_VIEW,
                Permission::REPORTS_VIEW,
                Permission::COMMISSIONS_VIEW,
                Permission::COMMISSIONS_MANAGE,
            ],

            self::RECRUITER => [
                Permission::COMPANIES_VIEW,
                Permission::JOBS_CREATE,
                Permission::JOBS_UPDATE,
                Permission::APPLICATIONS_VIEW,
                Permission::COMMISSIONS_VIEW,
            ],

            self::CANDIDATE => [],
        };
    }

    /** Vai tro duoc Gate::before cap toan quyen. */
    public function grantsEveryAbility(): bool
    {
        return $this === self::SUPER_ADMIN;
    }

    /** Vai tro thuoc ve mot cong ty (can company_id). */
    public function belongsToCompany(): bool
    {
        return in_array($this, [self::COMPANY_ADMIN, self::RECRUITER], true);
    }

    /** Vai tro quan tri he thong — dung de gom nhom tren giao dien, khong dung de phan quyen. */
    public function isSystemRole(): bool
    {
        return in_array($this, [self::SUPER_ADMIN, self::ADMIN], true);
    }
}
