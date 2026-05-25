<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Gallery extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'slug',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * ✅ Relationship: Gallery ke saath bahut saari media files
     */
    public function media()
    {
        return $this->hasMany(GalleryMedia::class, 'gallery_id', 'id')
                    ->orderBy('sort_order', 'asc');
    }

    /**
     * ✅ Get sirf images
     */
    public function images()
    {
        return $this->hasMany(GalleryMedia::class, 'gallery_id', 'id')
                    ->where('media_type', 'image')
                    ->orderBy('sort_order', 'asc');
    }
 
    /**
     * ✅ Get sirf videos
     */
    public function videos()
    {
        return $this->hasMany(GalleryMedia::class, 'gallery_id', 'id')
                    ->where('media_type', 'video')
                    ->orderBy('sort_order', 'asc');
    }

    /**
     * ✅ Slug generate kro (URL friendly)
     */
    public static function generateUniqueSlug($title)
    {
        $slug = \Illuminate\Support\Str::slug($title);
        $count = self::where('slug', 'LIKE', "{$slug}%")->count();
        
        return $count > 0 ? "{$slug}-" . ($count + 1) : $slug;
    }

    /**
     * ✅ Active galleries only
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', 1);
    }
}