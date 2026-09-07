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
            'title' => ['required', 'string', 'max:'.ResumeConstants::TITLE_MAX_LENGTH],
            'file' => [
                'nullable', 'file',
                'mimes:'.ResumeConstants::ALLOWED_MIMES,
                'max:'.ResumeConstants::MAX_SIZE_KB,
            ],
        ];
    }

    public function attributes(): array
    {
        return __('candidate.attributes');
    }
}
