<?php

namespace App\Http\Requests\Profile;

use App\Constants\UserConstants;
use Illuminate\Foundation\Http\FormRequest;

class DeleteUserRequest extends FormRequest
{
    protected $errorBag = UserConstants::ERROR_BAG_DELETION;
    public function authorize(): bool
    {
        return $this->user() !== null;
    }

    public function rules(): array
    {
        return[
            'password'=>['required', 'current_password'],
        ];
    }
    
    public function attributes(): array
    {
        return __('auth.attributes');
    }
}