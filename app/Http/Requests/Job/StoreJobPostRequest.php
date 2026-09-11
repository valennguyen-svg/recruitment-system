<?php

namespace App\Http\Requests\Job;

use App\Constants\JobConstants;
use App\Enums\EmploymentType;
use App\Models\JobPost;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreJobPostRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->can('create', JobPost::class);
    }

       /** @return array<string, mixed> */
    public function rules(): array
    {
        return [
            'title'             => ['required', 'string', 'max:255'],
            'category_id'       => ['required', 'integer', 'exists:job_categories,id'],
            'description'       => ['required', 'string', 'max:' . JobConstants::DESCRIPTION_MAX],
            'requirements'      => ['nullable', 'string', 'max:' . JobConstants::DESCRIPTION_MAX],
            'benefits'          => ['nullable', 'string', 'max:' . JobConstants::DESCRIPTION_MAX],
            'employment_type'   => ['required', Rule::enum(EmploymentType::class)],
            'location'          => ['required', 'string', 'max:255'],
            'deadline'          => ['required', 'date', 'after:today'],
            'salary_negotiable' => ['required', 'boolean'],

            // Luong thoa thuan thi bo qua hoan toan hai o so tien.
            'salary_min' => [
                'exclude_if:salary_negotiable,1',
                'required', 'integer', 'min:0', 'max:2000000000',
            ],
            'salary_max' => [
                'exclude_if:salary_negotiable,1',
                'required', 'integer', 'min:0', 'max:2000000000', 'gte:salary_min',
            ],
        ];
    }

    /** @return array<string, mixed> */
    public function jobData(): array
    {
        return [
            ...$this->safe()->all(),
            'salary_min' => $this->boolean('salary_negotiable') ? null : $this->integer('salary_min'),
            'salary_max' => $this->boolean('salary_negotiable') ? null : $this->integer('salary_max'),
        ];
    }
}
