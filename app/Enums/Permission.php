<?php

namespace App\Enums;

enum Permission: string
{
    // Bang dieu khien
    case DASHBOARD_VIEW = 'dashboard.view';

    // Nguoi dung
    case USERS_VIEW        = 'users.view';
    case USERS_VIEW_ALL    = 'users.view_all';
    case USERS_CREATE      = 'users.create';
    case USERS_UPDATE      = 'users.update';
    case USERS_DELETE      = 'users.delete';
    case USERS_ASSIGN_ROLE = 'users.assign_role';

    // Cong ty
    case COMPANIES_VIEW    = 'companies.view';
    case COMPANIES_UPDATE  = 'companies.update';
    case COMPANIES_APPROVE = 'companies.approve';
    case COMPANIES_DELETE  = 'companies.delete';

    // Tin tuyen dung
    case JOBS_CREATE     = 'jobs.create';
    case JOBS_UPDATE     = 'jobs.update';
    case JOBS_UPDATE_ANY = 'jobs.update_any';
    case JOBS_DELETE     = 'jobs.delete';
    case JOBS_APPROVE    = 'jobs.approve';
    case JOBS_VIEW_ALL   = 'jobs.view_all';

    // Don ung tuyen
    case APPLICATIONS_VIEW = 'applications.view';

    // Bao cao va hoa hong
    case REPORTS_VIEW         = 'reports.view';
    case COMMISSIONS_VIEW     = 'commissions.view';
    case COMMISSIONS_VIEW_ALL = 'commissions.view_all';
    case COMMISSIONS_MANAGE   = 'commissions.manage';

    // He thong
    case AUDIT_LOGS_VIEW = 'audit_logs.view';
    case SETTINGS_MANAGE = 'settings.manage';

    public function label(): string
    {
        return __(match ($this) {
            self::DASHBOARD_VIEW       => 'View dashboard',
            self::USERS_VIEW           => 'View users',
            self::USERS_VIEW_ALL       => 'View users of every company',
            self::USERS_CREATE         => 'Create users',
            self::USERS_UPDATE         => 'Update users',
            self::USERS_DELETE         => 'Delete users',
            self::USERS_ASSIGN_ROLE    => 'Assign roles',
            self::COMPANIES_VIEW       => 'View companies',
            self::COMPANIES_UPDATE     => 'Update companies',
            self::COMPANIES_APPROVE    => 'Approve companies',
            self::COMPANIES_DELETE     => 'Delete companies',
            self::JOBS_CREATE          => 'Create job posts',
            self::JOBS_UPDATE          => 'Update job posts',
            self::JOBS_UPDATE_ANY      => 'Update any job post in the company',
            self::JOBS_DELETE          => 'Delete job posts',
            self::JOBS_APPROVE         => 'Approve job posts',
            self::JOBS_VIEW_ALL        => 'View all job posts',
            self::APPLICATIONS_VIEW    => 'View applications',
            self::REPORTS_VIEW         => 'View reports',
            self::COMMISSIONS_VIEW     => 'View commissions',
            self::COMMISSIONS_VIEW_ALL => 'View commissions of every company',
            self::COMMISSIONS_MANAGE   => 'Manage commissions',
            self::AUDIT_LOGS_VIEW      => 'View audit logs',
            self::SETTINGS_MANAGE      => 'Manage settings',
        });
    }

    /** Nhom quyen, suy ra tu tien to cua slug — dung de gom nhom tren giao dien. */
    public function group(): string
    {
        return explode('.', $this->value)[0];
    }
}