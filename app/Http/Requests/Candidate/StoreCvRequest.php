<?php

namespace App\Http\Requests\Candidate;

use App\Constants\ResumeConstants;

class StoreCvRequest extends UpdateCandidateProfileRequest
{
    public function rules(): array
    {
        return parent::rules() + [
            'title' => ['required', 'string', 'max:' . ResumeConstants::TITLE_MAX_LENGTH],
            'file' => [
                'required', 'file',
                'mimes:' . ResumeConstants::ALLOWED_MIMES,
                'max:' . ResumeConstants::MAX_SIZE_KB,
            ],
        ];
    }
}