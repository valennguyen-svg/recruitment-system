<?php

namespace App\Enums;

enum SortOption: string
{
    case NEWEST = 'newest';
    case OLDEST = 'oldest';
    case SALARY_HIGH = 'salary_high';
    case DEADLINE = 'deadline';
    case POPULAR = 'popular';

    public function label(): string
    {
        return __('enums.sort_option.' . $this->value);
    }

    /** @return string[] */
    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}