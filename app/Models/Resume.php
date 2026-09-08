<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Resume extends Model
{
    use HasFactory;

    protected $fillable = [
        'candidate_profile_id',
        'title',
        'file_path',
        'original_name',
        'mime_type',
        'size',
        'is_default',
    ];

    protected $casts = [
        'is_default' => 'boolean',
    ];

    public function candidateProfile(): BelongsTo
    {
        return $this->belongsTo(CandidateProfile::class);
    }
    public function toSnapshot(): array
    {
        return [
            'title' => $this->title,
            'headline' => $this->headline,
            'summary' => $this->summary,
            'skills' => $this->skills,
            'experience_years' => $this->experience_years,
            'education' => $this->education,
            'original_name' => $this->original_name,
            'file_path' => $this->file_path,
            'captured_at' => now()->toIso8601String(),
        ];
    }
}
