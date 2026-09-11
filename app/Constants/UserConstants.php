<?php

namespace App\Constants;

final class UserConstants
{
    public const PROVIDER_GOOGLE = 'google';

    public const STATUS_PROFILE_UPDATED = 'profile-updated';

    public const STATUS_PASSWORD_UPDATED = 'password-updated';

    public const STATUS_LINK_SENT = 'verification-lonk-sent';

    public const ERROR_BAG_PASSWORD = 'updatePassword';

    public const ERROR_BAG_DELETION = 'userDeletion';

    public const TEMPORARY_PASSWORD_LENGTH = 12;

    public const STAFF_PER_PAGE = 15;

    public const NAME_MAX = 255;

    private function __construct() {}
}
