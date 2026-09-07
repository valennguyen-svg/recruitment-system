<?php

namespace App\Enums;

use Illuminate\Database\Eloquent\Builder;

enum SortOption: string
{
    case NEWEST='newest';
    case OLDEST='oldest';
    case SALARY_HIGH='salary_high';
    case DEADLINE='deadline';
    case POPULAR='popular';

    public function label(): string
    {
        return __('job.sort.' . $this->value);
    }

    public function apply(Builder $query): Builder
    {
        return match ($this) {
            self::NEWEST => $query->orderByDesc('published_at'),
            self::OLDEST => $query->orderBy('published_at'),
            self::SALARY_HIGH => $query->orderByRaw('salary_max DESC NULLS LAST'),
            self::DEADLINE=> $query->orderByRaw('deadline ASC NULLS LAST'),
            self::POPULAR=> $query->orderByDesc('views_count'),
        };
    }

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }

    public static function default(): self
    {
        return self::NEWEST;
    }
}