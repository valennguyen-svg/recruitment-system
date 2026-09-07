<?php

namespace App\Constants;

use App\Enums\UserRole;

final class RouteConstants
{
    public const ADMIN_HOME = 'admin.dashboard';

    public const RECRUITER_HOME = 'recruiter.dashboard';

    public const CANDIDATE_HOME = 'jobs.index';

    public const DEFAULT_HOME = 'dashboard';

    /** Trang chủ tương ứng với từng vai trò. */
    public const HOME_BY_ROLE = [
        UserRole::ADMIN->value => self::ADMIN_HOME,
        UserRole::RECRUITER->value => self::RECRUITER_HOME,
        UserRole::CANDIDATE->value => self::CANDIDATE_HOME,
    ];

    private function __construct() {}
}
