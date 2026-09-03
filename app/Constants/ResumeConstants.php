<?php

namespace App\Constants;

final class ResumeConstants
{
    public const DISK = 'public';
    public const STORAGE_PATH  = 'resumes';
    public const MAX_SIZE_KB = 5120;
    public const ALLOWED_MIMES = 'pdf,doc,docx';
    public const ACCEPT_ATTR = '.pdf,.doc,.docx';

    public const TITLE_MAX_LENGTH = 255;

    public static function maxSizeMb(): int
    {
        return intdiv(self::MAX_SIZE_KB, 1024);
    }

    private function __construct() {}
}