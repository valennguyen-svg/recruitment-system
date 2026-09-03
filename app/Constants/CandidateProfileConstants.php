<?php

namespace App\Constants;

final class CandidateProfileConstants
{
    public const HEADLINE_MAX_LENGTH = 255;
    public const PHONE_MAX_LENGTH = 20;
    public const ADDRESS_MAX_LENGTH = 255;
    public const SKILLS_MAX_LENGTH = 1000;
    public const EDUCATION_MAX_LENGTH = 2000;
    public const SUMMARY_MAX_LENGTH = 5000;

    public const EXPERIENCE_YEARS_MIN = 0;
    public const EXPERIENCE_YEARS_MAX = 60;
    public const EXPERIENCE_YEARS_DEFAULT = 0;

    public const SKILLS_SEPARATOR = ',';

    private function __construct() {}
}