<?php

namespace App\Constants;

final class LocaleConstants
{
    public const VI = 'vi';

    public const EN = 'en';

    public const SESSION_KEY = 'app_locale';

    /** @var string[] */
    public const SUPPORTED = [self::VI, self::EN];

    private function __construct() {}
}
