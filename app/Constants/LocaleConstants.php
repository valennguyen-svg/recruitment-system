<?php

namespace App\Constants;

final class LocaleConstants
{
    public const VI = 'vi';

    public const EN = 'en';

    /** @var array<int, string> */
    public const SUPPORTED = [
        self::VI,
        self::EN,
    ];

    public const SESSION_KEY = 'locale';

    /** Nhãn hiển thị trên nút chuyển ngôn ngữ. */
    public const LABELS = [
        self::VI => 'VI',
        self::EN => 'EN',
    ];

    private function __construct() {}
}
