<?php

namespace App\Enums;

enum CommissionStatus: string
{
    case PENDING  = 'pending';
    case APPROVED = 'approved';
    case PAID     = 'paid';
    case VOID     = 'void';

    public function label(): string
    {
        return __(match ($this) {
            self::PENDING  => 'Pending approval',
            self::APPROVED => 'Approved',
            self::PAID     => 'Paid',
            self::VOID     => 'Voided',
        });
    }

    /** Mau hien thi tren giao dien. */
    public function badgeClass(): string
    {
        return match ($this) {
            self::PENDING  => 'bg-yellow-100 text-yellow-700',
            self::APPROVED => 'bg-blue-100 text-blue-700',
            self::PAID     => 'bg-green-100 text-green-700',
            self::VOID     => 'bg-gray-100 text-gray-600',
        };
    }

    /** @return self[] */
    public function allowedTransitions(): array
    {
        return match ($this) {
            self::PENDING  => [self::APPROVED, self::VOID],
            self::APPROVED => [self::PAID, self::VOID],
            self::PAID     => [],
            self::VOID     => [],
        };
    }

    public function canTransitionTo(self $target): bool
    {
        return in_array($target, $this->allowedTransitions(), true);
    }

    /** Hoa hong da chot, khong tinh lai duoc. */
    public function isFinal(): bool
    {
        return in_array($this, [self::PAID, self::VOID], true);
    }

        /** Ten route xu ly viec chuyen sang trang thai nay. */
    public function routeName(): string
    {
        return match ($this) {
            self::APPROVED => 'company.commissions.approve',
            self::PAID     => 'company.commissions.paid',
            self::VOID     => 'company.commissions.void',
            self::PENDING  => 'company.commissions.index',
        };
    }
}