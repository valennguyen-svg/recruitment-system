<?php

namespace App\Http\Requests\Company;

use App\Constants\UserConstants;
use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;

class StoreStaffRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->can('create', User::class);
    }

    /** @return array<string, mixed> */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:'.UserConstants::NAME_MAX],
            'email' => ['required', 'email', 'max:255', 'unique:users,email'],

            // Khong dung 'confirmed' o day: no gan loi vao truong password.
            // Dat 'same' tren password_confirmation de loi hien dung o do.
            'password' => ['required', Password::defaults()],
            'password_confirmation' => ['required', 'same:password'],
            
        ];
    }

    /** @return array<string, string> */
    public function messages(): array
    {
        return [
            'password.min' => __('staff.validation.password'),
            'password.mixed' => __('staff.validation.password'),
            'password.letters' => __('staff.validation.password'),
            'password.symbols' => __('staff.validation.password'),
            'password.numbers' => __('staff.validation.password'),
            'password_confirmation.same' => __('staff.validation.password_confirmation'),
        ];
    }

    /** Du lieu tao tai khoan, kem cong ty dich. */
    public function staffData(): array
    {
        return [
            ...$this->safe()->only(['name', 'email', 'password']),
            'company_id' => $this->user()->company_id,
        ];
    }
}
