<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $fillable = [
        'title', 
        'slug', 
        'content', 
        'excerpt', 
        'feature_gallery', 
        'attachments', 
        'status'
    ];

    protected $casts = [
        'feature_gallery' => 'array',
        'attachments' => 'array'
    ];

    public function categories()
    {
        return $this->belongsToMany(Category::class, 'post_category');
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class, 'post_tag');
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }
}
