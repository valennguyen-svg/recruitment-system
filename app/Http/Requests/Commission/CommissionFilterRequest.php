<?php

namespace App\Http\Requests\Commission;

use App\Enums\CommissionStatus;
use App\Models\Commission;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CommissionFilterRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return $this->user()->can('viewAny', Commission::class);
    }

    public function rules(): array
    {
        return [
            'user_id' => ['nullable', 'integer', 'exists:users,id'],
            'status' => ['nullable', Rule::enum(CommissionStatus::class)],
            'form' => ['nullable', 'date'],
            'to' => ['nullable', 'date', 'after_or_equal:from'],
        ];
    }

    public function filters(): array
    {
        return $this->safe()->only(['user_id', 'status', 'from', 'to']);
    }
}
