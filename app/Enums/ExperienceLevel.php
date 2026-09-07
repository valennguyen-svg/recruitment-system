<?php

namespace App\Enums;

enum ExperienceLevel: string
{
    case INTERN = 'intern';
    case JUNIOR = 'junior';
    case MIDDLE = 'middle';
    case SENIOR = 'senior';
    case LEAD = 'lead';

    public function label(): string
    {
        return __('job.experience_level.'.$this->value);
    }

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}
