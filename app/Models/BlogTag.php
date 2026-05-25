<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class BlogTag extends Model
{
    protected $table = 'blog_tags';
    
    public $timestamps = true;
    
    protected $fillable = ['name', 'slug'];

    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($tag) {
            if (empty($tag->slug)) {
                $tag->slug = Str::slug($tag->name);
            }
       });
    }

    public function blogs()
    {
        return $this->belongsToMany(Blog::class, 'blog_blog_tag');
    }
}
