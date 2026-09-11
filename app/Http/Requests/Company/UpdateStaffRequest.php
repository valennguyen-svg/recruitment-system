<?php

namespace App\Http\Requests\Company;

use App\Constants\UserConstants;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateStaffRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return $this->user()->can('update', $this->route('staff'));
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:'.UserConstants::NAME_MAX],
            'email' => [
                'required',  'email', 'max:255',
                Rule::unique('users', 'email')->ignore($this->route('staff')),
            ],
            'is_active' => ['required', 'boolean'],
        ];
    }

    public function staffData(): array
    {
        return $this->safe()->only(['name', 'email', 'is_active']);
    }
}
