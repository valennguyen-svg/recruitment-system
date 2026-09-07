<?php

namespace App\Http\Requests\Profile;

use App\Constants\AuthConstants;
use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateProfileRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user() !== null;
    }

    public function rules(): array
    {
        return [
            'name'=> ['required', 'string', 'max:' . AuthConstants::NAME_MAX_LENGTH],
            'email'=> [
                'required', 'string', 'lowercase', 'email',
                'max:' . AuthConstants::EMAIL_MAX_LENGTH,
                Rule::unique(User::class)->ignore($this->user()->getKey()),
            ],
        ];
    }

    public function attributes(): array
    {
        return __('auth.attributes');
    }
}