<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class OurService extends Model
{
    protected $table = 'ourservice';
    public $timestamps = true;
    
    protected $fillable = [
        'main_heading',
        'image',
        'icon',
        'icon_class',
        'heading',
        'slug',
        'button_text',
        'button_url',
        'meta_title',
        'meta_description',
        'meta_keywords',
        'og_title',
        'og_description',
        'og_image'
    ];
    
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';
}
