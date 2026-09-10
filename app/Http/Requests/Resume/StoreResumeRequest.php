<?php

namespace App\Http\Requests\Resume;

use App\Constants\ResumeConstants;
use Illuminate\Foundation\Http\FormRequest;

class StoreResumeRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->candidateProfile !== null;
    }

    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:'.ResumeConstants::TITLE_MAX_LENGTH],
            'file' => [
                'required', 'file',
                'mimes:'.ResumeConstants::ALLOWED_MIMES,
                'max:'.ResumeConstants::MAX_SIZE_KB,
            ],
        ];
    }

    public function attributes(): array
    {
        return __('candidate.attributes');
    }

    /**
     * Du lieu da chuan hoa de luu vao resumes.
     *
     * @return array<string, mixed>
     */
    public function resumeData(): array
    {
        $data = $this->safe()->except('file');

        if (array_key_exists('skills', $data)) {
            $data['skills'] = collect(explode(',', (string) $data['skills']))
                ->map(fn (string $skill): string => trim($skill))
                ->filter()
                ->values()
                ->all();
        }

        return $data;
    }
}
