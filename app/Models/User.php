<?php

namespace App\Models;

use App\Enums\UserRole;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
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
        'company_id',
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

    public function ownedCompany(): HasOne
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

    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }

    /** Nguoi dung nay va doi tuong kia co cung cong ty khong. */
    public function sharesCompanyWith(?self $other): bool
    {
        return $this->company_id !== null
            && $this->company_id === $other?->company_id;
    }
    /**
     * Diem duy nhat trong app duoc phep hoi vai tro super admin.
     * Dung boi luat Gate::before va boi cac invariant nghiep vu
     * (vi du: khong xoa super admin cuoi cung).
     */
    public function isSuperAdmin(): bool
    {
        return $this->hasRole(UserRole::SUPER_ADMIN->value);
    }
}
