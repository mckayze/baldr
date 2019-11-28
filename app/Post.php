<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $fillable = [
        'user_id', 'url_slug', 'category_id', 'content', 'featured_image', 'meta_description', 'meta_keywords',
        'scheduled_for', 'seo_title', 'status', 'subtitle', 'title'
    ];

    protected $dates = [
        'scheduled_for'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function category()
    {
        return $this->belongsTo(PostCategory::class);
    }
}