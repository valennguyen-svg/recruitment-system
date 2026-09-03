<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Resume extends Model
{
    /** @use HasFactory<\Database\Factories\ResumeFactory> */
    use HasFactory;
    protected $fillable = [
        'candidate_profile_id',
        'title',
        'file_path',
        'original_name',
        'mime_type',
        'size',
        'is_default'
        ];

    protected $casts = [
        'is_default' => 'boolean',
    ];    
    public function candidateProfile()
    {
        return $this->belongsTo(CandidateProfile::class);
    }
}
