<?php

namespace App\Models;

use App\Enums\UserRole;
use App\Models\CandidateProfile;
use App\Models\Resume;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasFactory, HasRoles, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'provider',
        'provider_id',
        'avatar',
        'phone',
        'is_active',
    ];

    protected $hidden = [
        'password',
        'remember_token'];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'is_active' => 'boolean',
        ];
    }

    public function candidateProfile()
    {
        return $this->hasOne(CandidateProfile::class);
    }

    public function company()
    {
        return $this->hasOne(Company::class);
    }

    public function resumes()
    {
        return $this->hasManyThrough(
            Resume::class,
            CandidateProfile::class,
            'user_id',
            'candidate_profile_id',
            'id',
            'id',
        );
    }

    public function hasPassword(): bool
    {
        return $this->password !== null;
    }

    public function isSuperAdmin(): bool
    {
        return $this->hasRole(UserRole::SUPER_ADMIN->value);
    }
}
