<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;
use Override;

class ConfirmPasswordRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user() !== null;
    }

    public function rules(): array
    {
        return[
            'password' =>['required', 'string'],
        ];
    }

    public function attributes(): array
    {
        return __('auth.attributes');
    }
}