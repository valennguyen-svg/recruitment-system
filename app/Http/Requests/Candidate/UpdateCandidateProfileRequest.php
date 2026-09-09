<?php

namespace App\Http\Requests\Candidate;

use App\Constants\CandidateProfileConstants as Profile;
use Illuminate\Foundation\Http\FormRequest;
use Psy\CodeCleaner\FunctionReturnInWriteContextPass;

class UpdateCandidateProfileRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user() !== null;
    }

    public function rules(): array
    {
        return [
            'headline' => ['nullable', 'string', 'max:'.Profile::HEADLINE_MAX_LENGTH],
            'phone' => ['nullable', 'string', 'max:'.Profile::PHONE_MAX_LENGTH],
            'date_of_birth' => ['nullable', 'date', 'before:today'],
            'address' => ['nullable', 'string', 'max:'.Profile::ADDRESS_MAX_LENGTH],
            'skills' => ['nullable', 'string', 'max:'.Profile::SKILLS_MAX_LENGTH],
            'education' => ['nullable', 'string', 'max:'.Profile::EDUCATION_MAX_LENGTH],
            'summary' => ['nullable', 'string', 'max:'.Profile::SUMMARY_MAX_LENGTH],
            'experience_years' => [
                'nullable', 'integer',
                'min:'.Profile::EXPERIENCE_YEARS_MIN,
                'max:'.Profile::EXPERIENCE_YEARS_MAX,
            ],
        ];
    }

    public function attributes(): array
    {
        return __('candidate.attributes');
    }
    public function profileData(): array
    {
        $data = $this->validated();
        $data['skills']=collect(explode(',', $data['skills'] ?? ''))
        ->map(fn (string $skill): string => trim($skill))
        ->filter()
        ->values()
        ->all();

        return $data;
    }
}
