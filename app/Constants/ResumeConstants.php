<?php

namespace App\Constants;

final class ResumeConstants
{
    public const PER_PAGE = 10;

    public const TITLE_MAX_LENGTH = 255;

    public const MIMES       = 'pdf,doc,docx';
    public const ACCEPT_ATTR = '.pdf,.doc,.docx';
    public const MAX_SIZE_KB = 5120;

    public const KILOBYTES_PER_MEGABYTE = 1024;

    public const DISK      = 'public';
    public const DIRECTORY = 'resumes';

    private function __construct() {}

    public static function maxSizeMb(): int
    {
        return (int) (self::MAX_SIZE_KB / self::KILOBYTES_PER_MEGABYTE);
    }
}