<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PromotionalBanner extends Model
{
    protected $table = 'promotional_banners';
    
    public $timestamps = true;
    
    protected $fillable = [
        'background_image',
        'background_image_alt',
        'sub_heading',
        'heading',
        'sale_heading',
        'sale_end_date',
        'button_text',
        'button_url',
        'is_active',
    ];
    
    protected $casts = [
        'sale_end_date' => 'datetime',
        'is_active' => 'boolean',
    ];
    
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';
}