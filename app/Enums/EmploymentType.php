<?php

namespace App\Enums;

enum EmploymentType: string
{
    case FULL_TIME  = 'full_time';
    case PART_TIME  = 'part_time';
    case CONTRACT   = 'contract';
    case INTERNSHIP = 'internship';

    public function label(): string
    {
        return __('enums.employment_type.' . $this->value);
    }

    /** @return string[] */
    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}