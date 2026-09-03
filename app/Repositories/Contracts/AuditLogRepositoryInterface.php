<?php

namespace App\Repositories\Contracts;

interface AuditLogRepositoryInterface extends BaseRepositoryInterface
{
    public function record(array $attributes): void;
}