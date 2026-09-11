<?php

namespace App\Models;

use App\Enums\UserRole;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Company extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'name',
        'slug',
        'description',
        'logo',
        'website',
        'address',
        'city',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function jobPosts(): HasMany
    {
        return $this->hasMany(JobPost::class);
    }

    /** Toan bo tai khoan thuoc cong ty: giam doc va HR. */
    public function members(): HasMany
    {
        return $this->hasMany(User::class);
    }

    /** Chi cac tai khoan HR. */
    public function recruiters(): HasMany
    {
        return $this->members()->role(UserRole::RECRUITER->value);
    }
}
