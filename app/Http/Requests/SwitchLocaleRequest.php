<?php

namespace App\Http\Requests;

use App\Constants\LocaleConstants;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class SwitchLocaleRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'locale' => ['required', 'string', Rule::in(LocaleConstants::SUPPORTED)],
        ];
    }
}
