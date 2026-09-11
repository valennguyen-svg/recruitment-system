<?php

namespace App\Models;

use App\Enums\CommissionStatus;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Commission extends Model
{
    protected $fillable = [
        'user_id',
        'company_id',
        'job_post_id',
        'application_id',
        'amount',
        'status',
        'note',
        'approved_at',
        'paid_at',
    ];

    protected function casts(): array
    {
        return [
            'status' => CommissionStatus::class,
            'amount' => 'integer',
            'approved_at' => 'datetime',
            'paid_at' => 'datetime',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }

    public function jobPost(): BelongsTo
    {
        return $this->belongsTo(JobPost::class);
    }

    public function application(): BelongsTo
    {
        return $this->belongsTo(Application::class);
    }
}
