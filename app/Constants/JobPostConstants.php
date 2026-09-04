<?php

namespace App\Constants;

final class JobPostConstants
{
    public const PER_PAGE = 15;

    public const TITLE_MAX_LENGTH = 255;
    public const LOCATION_MAX_LENGTH = 255;
    public const KEYWORD_MAX_LENGTH = 255;
    public const BENEFIT_MAX_LENGTH = 255;
    public const QUANTITY_MIN = 1;
    public const RELATED_LIMIT = 5;
    private function __construct() {}
}