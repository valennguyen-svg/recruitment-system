<?php

namespace App\Models;

use App\Enums\UserRole;
use Database\Factories\JobCategoryFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class JobCategory extends Model
{
    /** @use HasFactory<JobCategoryFactory> */
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
    ];

    public function jobPosts()
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
