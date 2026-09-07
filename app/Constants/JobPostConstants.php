<?php

namespace App\Constants;

final class JobPostConstants
{
    public const PER_PAGE = 15;

    public const RELATED_LIMIT = 5;

    public const TITLE_MAX = 255;

    public const KEYWORD_MAX = 255;

    public const LOCATION_MAX = 255;

    public const BENEFIT_MAX = 255;

    public const SALARY_MIN = 0;

    public const SALARY_MAX = 1000000000;

    public const SALARY_HIGH = 30000000;

    public const POPULAR = 100;

    public const QUANTITY_MIN = 1;

    public const REJECT_REASON_MAX = 1000;

    private function __construct() {}
}
