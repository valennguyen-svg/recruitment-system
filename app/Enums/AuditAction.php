<?php

namespace App\Enums;

enum AuditAction: string
{
    case JOB_STATUS_CHANGED = 'job_post.status_changed';

    public function label(): string
    {
        return __('enums.audit_action.' . $this->value);
    }
}