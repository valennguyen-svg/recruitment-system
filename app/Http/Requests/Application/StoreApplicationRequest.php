<?php

namespace App\Http\Requests\Application;

use App\Constants\ApplicationConstants;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreApplicationRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->candidateProfile !== null;
    }

    public function rules(): array
    {
        $candidateId = $this->user()->candidateProfile->getKey();

        return [
            'resume_id' => [
                'required', 'integer',
                Rule::exists('resumes', 'id')->where('candidate_profile_id', $candidateId),
            ],
            'cover_letter' => [
                'nullable', 'string',
                'max:' . ApplicationConstants::COVER_LETTER_MAX_LENGTH,
            ],
        ];
    }

    public function attributes(): array
    {
        return __('application.attributes');
    }
}