<?php

namespace App\Http\Requests\Profile;

use App\Constants\AuthConstants;
use Illuminate\Foundation\Http\FormRequest;

class UpdateProfileRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user() !== null;
    }

    public function rules(): array
    {
        return [
            'name' => [
                'required',
                'string',
                'max:' . AuthConstants::NAME_MAX_LENGTH,
            ],
            
            'phone' => [
                'nullable',
                'string',
                'max:' . AuthConstants::PHONE_MAX_LENGTH,
            ],
        ];
    }

    public function attributes(): array
    {
        return __('auth.attributes');
    }
}