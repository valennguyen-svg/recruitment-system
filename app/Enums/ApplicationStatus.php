<?php

namespace App\Enums;

enum ApplicationStatus: string
{
    case APPLIED = 'applied';
    case SCREENING = 'screening';
    case INTERVIEW = 'interview';
    case OFFER = 'offer';
    case HIRED = 'hired';
    case REJECTED = 'rejected';
    case WITHDRAWN = 'withdrawn';

    public function label(): string
    {
        return __(match ($this) {
            self::APPLIED => 'Applied',
            self::SCREENING => 'Screening',
            self::INTERVIEW => 'Interview',
            self::OFFER => 'Offer sent',
            self::HIRED => 'Hired',
            self::REJECTED => 'Rejected',
            self::WITHDRAWN => 'Withdrawn',
        });
    }

    public function badgeClass(): string
    {
        return match ($this) {
            self::APPLIED => 'bg-gray-100 text-gray-700',
            self::SCREENING => 'bg-blue-100 text-blue-700',
            self::INTERVIEW => 'bg-amber-100 text-amber-700',
            self::OFFER => 'bg-purple-100 text-purple-700',
            self::HIRED => 'bg-green-100 text-green-700',
            self::REJECTED => 'bg-red-100 text-red-700',
            self::WITHDRAWN => 'bg-slate-100 text-slate-600',
        };
    }

    /** @return self[] */
    public function allowedTransitions(): array
    {
        return match ($this) {
            self::APPLIED => [self::SCREENING, self::REJECTED, self::WITHDRAWN],
            self::SCREENING => [self::INTERVIEW, self::REJECTED, self::WITHDRAWN],
            self::INTERVIEW => [self::OFFER, self::REJECTED, self::WITHDRAWN],
            self::OFFER => [self::HIRED, self::REJECTED, self::WITHDRAWN],
            self::HIRED, self::REJECTED, self::WITHDRAWN => [],
        };
    }

    public function canTransitionTo(self $target): bool
    {
        return in_array($target, $this->allowedTransitions(), true);
    }
}
