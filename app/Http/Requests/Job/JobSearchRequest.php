<?php

namespace App\Http\Requests\Job;

use App\Constants\JobPostConstants;
use App\Enums\EmploymentType;
use App\Enums\SortOption;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class JobSearchRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'q' => ['nullable', 'string', 'max:' . JobPostConstants::KEYWORD_MAX],
            'category' => ['nullable', 'integer', 'exists:job_categories,id'],
            'location' => ['nullable', 'string', 'max:' . JobPostConstants::LOCATION_MAX],
            'employment_type' => ['nullable', Rule::in(EmploymentType::values())],
            'salary_min' => ['nullable', 'integer', 'min:0', 'max:' . JobPostConstants::SALARY_MAX],
            'sort' => ['nullable', Rule::in(SortOption::values())],
        ];
    }

    public function attributes(): array
    {
        return __('job.attributes');
    }

    /** @return array<string, mixed> */
    public function filters(): array
    {
        return $this->safe()->only([
            'q', 'category', 'location', 'employment_type', 'salary_min', 'sort',
        ]);
    }
}