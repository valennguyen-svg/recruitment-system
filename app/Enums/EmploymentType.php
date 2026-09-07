<?php

namespace App\Enums;

enum EmploymentType: string
{
    case FULL_TIME = 'full_time';
    case PART_TIME = 'part_time';
    case CONTRACT = 'contract';
    case INTERNSHIP = 'internship';
    case FREELANCE = 'freelance';

    public function label(): string
    {
        return __(match ($this) {
            self::FULL_TIME => 'Full-time',
            self::PART_TIME => 'Part-time',
            self::CONTRACT => 'Contract',
            self::INTERNSHIP => 'Internship',
            self::FREELANCE => 'Freelance',
        });
    }

    /** @return string[] */
    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}
