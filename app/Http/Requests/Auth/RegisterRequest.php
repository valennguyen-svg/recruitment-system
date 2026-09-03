<?php

namespace App\Http\Requests\Auth;

use App\Constants\AuthConstants;
use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;
use Override;

class RegisterRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }
    public function rules(): array
    {
        return [
            'name'=>['required', 'string', 'max:' . AuthConstants::NAME_MAX_LENGTH],
            'email'=>[
                'required', 'string', 'lowercase', 'email',
                'max:' . AuthConstants::EMAIL_MAX_LENGTH,
                'unique:' . User::class,
            ],
            'password'=>['required', 'confirmed', Password::defaults()],
        ];
    }
    #[Override]
    public function attributes(): array
    {
        return __('auth.attributes');
        
    }
}