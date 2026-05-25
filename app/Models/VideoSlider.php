<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class VideoSlider extends Model
{
    protected $table = 'videoslider';
    public $timestamps = true;
    
    protected $fillable = [
        'heading1',
        'subheading1'
    ];
    
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';

    /**
     * Get all videos for this slider
     */
    public function videos(): HasMany
    {
        return $this->hasMany(VideoSliderVideo::class, 'video_slider_id')
                    ->orderBy('display_order', 'asc');
    }
}