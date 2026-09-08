<?php

namespace App\Models;

use App\Enums\ApplicationStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Application extends Model
{
    use HasFactory;

    protected $fillable = [
        'job_post_id',
        'candidate_profile_id',
        'resume_id',
        'status',
        'cover_letter',
        'recruiter_note',
        'applied_at',
    ];

    protected function casts(): array
    {
        return [
            'applied_at' => 'datetime',
            'status' => ApplicationStatus::class,
            'resumes_snapshot'=>'array',
        ];
    }

    public function jobPost()
    {
        return $this->belongsTo(JobPost::class);
    }

    public function candidateProfile()
    {
        return $this->belongsTo(CandidateProfile::class);
    }

    public function resume()
    {
        return $this->belongsTo(Resume::class);
    }

    public function statusLogs()
    {
        return $this->hasMany(ApplicationStatusLog::class);
    }

    public function candidate()
    {
        return $this->hasOneThrough(
            User::class,
            CandidateProfile::class,
            'id',
            'id',
            'candidate_profile_id',
            'user_id',
        );
    }
     public function resumeTitle(): ?string
    {
        return $this->resume_snapshot['title'] ?? $this->resume?->title;
    }
}
