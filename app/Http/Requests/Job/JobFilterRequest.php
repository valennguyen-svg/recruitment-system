<?php

namespace App\Http\Requests\Job;

use App\Enums\EmploymentType;
use App\Enums\ExperienceLevel;
use App\Enums\SortOption;
use App\Constants\JobPostConstants;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use PhpParser\Node\Expr\FuncCall;

class JobFilterRequest extends FormRequest
{
    public function auithorize(): bool
    {
        return true;
    }
    public function rules(): array
    {
        return [
            'keyword'=>['nullable','string','max:' . JobPostConstants::KEYWORD_MAX_LENGTH],
            'location'=>['nullable', 'string', 'max:' . JobPostConstants::LOCATION_MAX_LENGTH],
            'category_id'=>['nullable','integer', 'exists:categories,id'],
            'employment_type'=>['nullable', Rule::enum(EmploymentType::class)],
            'experience_level'=>['nullable', Rule::enum(ExperienceLevel::class)],
            'sort'=>['nullable', Rule::enum(SortOption::class)],
        ];
    }
    public function attributes(): array
    {
        return __('job.attributes');
    }

    public function filters(): array
    {
        return $this->safe()->only([
            'keyword', 'lacation', 'category_id',
            'employment_type', 'exprience_level',
        ]);
    }
    public function sortOption(): SortOption
    {
        return SortOption::tryFrom((string) $this->validate('sort'))
        ?? SortOption::default();
    }
}