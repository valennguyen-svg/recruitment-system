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

    private function __construct() {}
}
