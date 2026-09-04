<?php

namespace App\Http\Requests\Job;

use App\Constants\JobPostConstants;
use App\Enums\EmploymentType;
use App\Enums\ExperienceLevel;
use App\Enums\JobStatus;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreJobPostRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->company !== null;
    }

    public function rules(): array
    {
        return [
            'title'=> ['required', 'string', 'max:' . JobPostConstants::TITLE_MAX_LENGTH],
            'category_id'=> ['required', 'integer', 'exists:categories,id'],
            'location'=> ['required', 'string', 'max:' . JobPostConstants::LOCATION_MAX_LENGTH],
            'employment_type'=> ['required', Rule::enum(EmploymentType::class)],
            'experience_level'=> ['required', Rule::enum(ExperienceLevel::class)],
            'salary_min'=> ['nullable', 'integer', 'min:0'],
            'salary_max'=> ['nullable', 'integer', 'gte:salary_min'],
            'quantity'=> ['required', 'integer', 'min:' . JobPostConstants::QUANTITY_MIN],
            'description'=> ['required', 'string'],
            'requirements'=> ['required', 'string'],
            'benefits'=> ['nullable', 'array'],
            'benefits.*'=> ['string', 'max:' . JobPostConstants::BENEFIT_MAX_LENGTH],
            'deadline' => ['required', 'date', 'after:today'],
            'status'=> ['required', Rule::enum(JobStatus::class)],
        ];
    }

    public function attributes(): array
    {
        return __('job.attributes');
    }
}