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

    public function filters(): array
    {
        $validated = $this->safe()->all();
        return [
            'keyword'=>$validated['q'] ?? null,
            'category_id'=>$validated['category']??null,
            'location'=>$validated['location']??null,
            'employment_type'=>$validated['emplyment_type']??null,
            'salary_min'=>$validated['salary_min']??null,
        ];
    }
    public function sortOption(): SortOption
    {
        return SortOption::tryFrom((string) $this->input('sort'))
        ?? SortOption::default();
    }
}