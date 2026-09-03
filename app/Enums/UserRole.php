<?php

namespace App\Enums;

enum UserRole: string
{
    case ADMIN     = 'admin';
    case RECRUITER = 'recruiter';
    case CANDIDATE = 'candidate';

    public function label(): string
    {
        return __('enums.user_role.' . $this->value);
    }

    /** @return string[] */
    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}