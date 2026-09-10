<?php

namespace App\Enums;

enum JobStatus: string
{
    case DRAFT = 'draft';
    case PENDING_REVIEW = 'pending_review';
    case PUBLISHED = 'published';
    case REJECTED = 'rejected';
    case CLOSED = 'closed';
    case EXPIRED = 'expired';

    public function label(): string
    {
        return __(match ($this) {
            self::DRAFT => 'job.status.draft',
            self::PENDING_REVIEW => 'job.status.pending_review',
            self::PUBLISHED => 'job.status.published',
            self::REJECTED => 'job.status.rejected',
            self::CLOSED => 'job.status.closed',
            self::EXPIRED => 'job.status.expired',
        });
    }

    /** @return self[] */
    public function allowedTransitions(): array
    {
        return match ($this) {
            self::DRAFT => [self::PENDING_REVIEW],
            self::PENDING_REVIEW => [self::PUBLISHED, self::REJECTED],
            self::PUBLISHED => [self::CLOSED, self::EXPIRED],
            self::REJECTED => [self::PENDING_REVIEW],
            self::CLOSED, self::EXPIRED => [],
        };
    }

    public function canTransitionTo(self $target): bool
    {
        return in_array($target, $this->allowedTransitions(), true);
    }
}
