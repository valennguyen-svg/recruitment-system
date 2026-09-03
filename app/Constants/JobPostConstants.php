<?php

namespace App\Constants;

final class JobPostConstants
{
    public const PER_PAGE = 12;
    public const RELATED_LIMIT = 4;
    public const KEYWORD_MAX = 100;
    public const LOCATION_MAX = 100;
    public const SALARY_MAX = 1_000_000_000;
    public const REJECT_REASON_MAX = 500;
    public const MILLION = 1_000_000;

    private function __construct() {}
}