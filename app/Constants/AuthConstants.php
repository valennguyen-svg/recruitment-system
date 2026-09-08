<?php

namespace App\Constants;

final class AuthConstants
{
    public const PASSWORD_MIN_LENGTH   = 12;
    public const LOGIN_MAX_ATTEMPTS    = 5;
    public const SECONDS_PER_MINUTE    = 60;
    public const REMEMBER_TOKEN_LENGTH = 60;

    public const NAME_MAX_LENGTH  = 255;
    public const EMAIL_MAX_LENGTH = 255;
    public const PHONE_MAX_LENGTH = 20;   

    private function __construct() {}
}