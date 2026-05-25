<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class GalleryMedia extends Model
{
    use HasFactory;

    protected $table = 'gallery_media';

    protected $fillable = [
        'gallery_id',
        'media_type',
        'file_name',
        'thumbnail',
        'alt_tag',
        'title',
        'sort_order',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * ✅ Inverse Relationship: GalleryMedia belongs to Gallery
     */
    public function gallery()
    {
        return $this->belongsTo(Gallery::class, 'gallery_id', 'id');
    }

    /**
     * ✅ Get full file path (for frontend)
     */
    public function getFileUrlAttribute()
    {
        if ($this->media_type === 'image') {
            return asset('uploads/gallery/images/' . $this->file_name);
        } else {
            return asset('uploads/gallery/videos/' . $this->file_name);
        }
    }

    /**
     * ✅ Get thumbnail URL
     */
    public function getThumbnailUrlAttribute()
    {
        if ($this->thumbnail) {
            return asset('uploads/gallery/thumbnails/' . $this->thumbnail);
        }
        
        // Default: use file_name as fallback for images
        if ($this->media_type === 'image') {
            return asset('uploads/gallery/images/' . $this->file_name);
        }
        
        // Default video thumbnail
        return asset('images/default-video-thumbnail.jpg');
    }

    /**
     * ✅ Is this an image?
     */
    public function isImage()
    {
        return $this->media_type === 'image';
    }

    /**
     * ✅ Is this a video?
     */
    public function isVideo()
    {
        return $this->media_type === 'video';
    }
}