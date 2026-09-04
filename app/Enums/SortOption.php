<?php

namespace App\Enums;

use Illuminate\Database\Eloquent\Builder;

enum SortOption: string
{
    case NEWEST      = 'newest';
    case OLDEST      = 'oldest';
    case SALARY_DESC = 'salary_desc';
    case DEADLINE    = 'deadline';

    public function label(): string
    {
        return __('job.sort.' . $this->value);
    }

    public function apply(Builder $query): Builder
    {
        return match ($this) {
            self::NEWEST      => $query->latest('published_at'),
            self::OLDEST      => $query->oldest('published_at'),
            self::SALARY_DESC => $query->orderByDesc('salary_max'),
            self::DEADLINE    => $query->orderBy('deadline'),
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
        public function filters(): array
    {
        $validated = $this->safe()->all();

        return [
            'keyword'         => $validated['q']               ?? null,
            'category_id'     => $validated['category']        ?? null,
            'location'        => $validated['location']        ?? null,
            'employment_type' => $validated['employment_type'] ?? null,
            'salary_min'      => $validated['salary_min']      ?? null,
        ];
    }

    public function sortOption(): SortOption
    {
        return SortOption::tryFrom((string) $this->input('sort'))
            ?? SortOption::default();
    }

}