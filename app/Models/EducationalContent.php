<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class EducationalContent extends Model
{
    protected $fillable = ['title', 'slug', 'category', 'content', 'image', 'video_url', 'order'];

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($content) {
            $content->slug = Str::slug($content->title);
        });
    }
}
