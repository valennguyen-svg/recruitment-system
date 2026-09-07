<?php

namespace App\Http\Requests\Candidate;

use App\Constants\ResumeConstants;
use App\Models\Resume;
use Illuminate\Foundation\Http\FormRequest;

class UpdateResumeRequest extends FormRequest
{
    public function authorize(): bool
    {
        /** @var Resume|null $resume */
        $resume = $this->route('resume');
        $profile = $this->user()?->candidateProfile;

        return $resume !== null
            && $profile !== null
            && $resume->candidate_profile_id === $profile->getKey();
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
