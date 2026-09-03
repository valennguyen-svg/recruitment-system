<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JobCategory extends Model
{
    /** @use HasFactory<\Database\Factories\JobCategoryFactory> */
    use HasFactory;
    protected $fillable = ['name', 'slug'];
    public function jobPosts() 
    {
        return $this->hasMany(JobPost::class);
    }
}
