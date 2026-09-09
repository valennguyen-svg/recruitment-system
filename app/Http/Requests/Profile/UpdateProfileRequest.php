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
            'name' => ['required', 'string', 'max:'.AuthConstants::NAME_MAX_LENGTH],
            
            
        ];
    }

    public function attributes(): array
    {
        return __('auth.attributes');
    }
}
