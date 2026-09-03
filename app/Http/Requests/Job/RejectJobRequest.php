<?php

namespace App\Http\Requests\Job;

use App\Constants\JobPostConstants;
use Illuminate\Foundation\Http\FormRequest;

class RejectJobRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->can('approve', $this->route('job')) ?? false;
    }

    public function rules(): array
    {
        return [
            'reason' => ['required', 'string', 'max:' . JobPostConstants::REJECT_REASON_MAX],
        ];
    }

    public function attributes(): array
    {
        return __('job.attributes');
    }
}