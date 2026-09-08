<?php

namespace App\Http\Requests\Resume;

use App\Constants\ResumeConstants;
use Illuminate\Foundation\Http\FormRequest;

class UpdateResumeRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->can('update', $this->route('resume')) ?? false;
    }

        public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:' . ResumeConstants::TITLE_MAX_LENGTH],
            'headline' => ['nullable', 'string', 'max:' . ResumeConstants::HEADLINE_MAX],
            'summary' => ['nullable', 'string'],
            'skills' => ['nullable', 'string', 'max:' . ResumeConstants::SKILLS_MAX],
            'education' => ['nullable', 'string'],
            'experience_years' => [
                'nullable', 'integer',
                'min:' . ResumeConstants::EXPERIENCE_YEARS_MIN,
                'max:' . ResumeConstants::EXPERIENCE_YEARS_MAX,
            ],
            'file' => [
                'nullable', 'file',
                'mimes:' . ResumeConstants::ALLOWED_MIMES,
                'max:' . ResumeConstants::MAX_SIZE_KB,
            ],
        ];
    }

    /** Chuyển skills từ chuỗi phân tách dấu phẩy thành mảng để lưu jsonb. */
    public function resumeData(): array
    {
        $data = $this->safe()->except('file');

        $data['skills'] = collect(explode(ResumeConstants::SKILLS_SEPARATOR, $data['skills'] ?? ''))
            ->map(fn (string $skill): string => trim($skill))
            ->filter()
            ->values()
            ->all();

        return $data;
    }

    public function attributes(): array
    {
        return __('candidate.attributes');
    }
}
