<?php

namespace App\Http\Requests\Job;

class UpdateJobPostRequest extends StoreJobPostRequest
{
    public function authorize(): bool
    {
        return $this->user()?->can('update', $this->route('job'));
    }
}
