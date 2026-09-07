<?php

namespace App\Models;

use App\Enums\EmploymentType;
use App\Enums\ExperienceLevel;
use App\Enums\JobStatus;
use App\Enums\SortOption;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Override;

class JobPost extends Model
{
    use HasFactory;

    protected $fillable = [
        'company_id', 'category_id', 'created_by', 'title', 'slug', 'description',
        'requirements', 'benefits', 'location', 'employment_type', 'salary_min',
        'salary_max', 'salary_negotiable', 'status', 'rejection_reason',
        'deadline', 'published_at',
    ];

    protected function casts(): array
    {
        return [
            'employment_type'=>EmploymentType::class,
            'experience_level'=>ExperienceLevel::class,
            'status'=>JobStatus::class,
            'benefits'=>'array',
            'deadline'=>'date',
            'published_at'=>'datetime',
        ];
    }

    #[Override]
    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function category()
    {
        return $this->belongsTo(JobCategory::class);
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function applications(): HasMany
    {
        return $this->hasMany(Application::class);
    }

    public function scopePublished(Builder $q): Builder
    {
        return $q->where('status', JobStatus::PUBLISHED->value);
    }

    public function scopeSearch(Builder $q, ?string $keyword): Builder
    {
        if (blank($keyword)) {
            return $q;
        }

        $words = preg_split('/\s+/u', self::normalize($keyword), -1, PREG_SPLIT_NO_EMPTY);

        foreach ($words as $word) {
            $term = self::likeTerm($word);

            $q->where(function (Builder $sub) use ($term): void {
                $sub->whereRaw('unaccent(title) ILIKE unaccent(?)', [$term])
                    ->orWhereRaw('unaccent(description) ILIKE unaccent(?)', [$term])
                    ->orWhereRaw('unaccent(location) ILIKE unaccent(?)', [$term]);
            });
        }

        return $q;
    }

    public function scopeCategory(Builder $q, ?int $categoryId): Builder
    {
        return blank($categoryId) ? $q : $q->where('category_id', $categoryId);
    }

    public function scopeLocation(Builder $q, ?string $location): Builder
    {
        if (blank($location)) {
            return $q;
        }

        return $q->whereRaw('unaccent(location) ILIKE unaccent(?)', [self::likeTerm($location)]);
    }

    public function scopeEmploymentType(Builder $q, ?string $type): Builder
    {
        return blank($type) ? $q : $q->where('employment_type', $type);
    }

    public function scopeSalaryAtLeast(Builder $q, ?int $min): Builder
    {
        if (blank($min)) {
            return $q;
        }

        return $q->where(function (Builder $sub) use ($min): void {
            $sub->where('salary_max', '>=', $min)
                ->orWhere('salary_negotiable', true);
        });
    }

    public function scopeNotExpired(Builder $q): Builder
    {
        return $q->where(function (Builder $sub): void {
            $sub->whereNull('deadline')
                ->orWhere('deadline', '>=', now()->toDateString());
        });
    }

    public function scopeSorted(Builder $q, ?string $sort): Builder
    {
        $option = SortOption::tryFrom((string) $sort) ?? SortOption::NEWEST;

        return match ($option) {
            SortOption::OLDEST => $q->orderBy('published_at'),
            SortOption::SALARY_HIGH => $q->orderByRaw('salary_max DESC NULLS LAST'),
            SortOption::DEADLINE => $q->orderByRaw('deadline ASC NULLS LAST'),
            SortOption::POPULAR  => $q->orderByDesc('views_count'),
            SortOption::NEWEST => $q->orderByDesc('published_at'),
        };
    }

    private static function normalize(string $text): string
    {
        if (class_exists(\Normalizer::class)) {
            $text = \Normalizer::normalize($text, \Normalizer::FORM_C) ?: $text;
        }

        return trim($text);
    }

    private static function likeTerm(string $keyword): string
    {
        $clean = str_replace(['\\', '%', '_'], ['\\\\', '\%', '\_'], self::normalize($keyword));

        return '%' . $clean . '%';
    }
}