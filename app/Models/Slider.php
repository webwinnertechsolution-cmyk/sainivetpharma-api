<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Slider extends Model
{
    protected $table = 'slider';
    public $timestamps = true;
    
 
    
	
	
	  protected $fillable = [
    'slide_type',   // <-- ADD
    'image',
    'alt_tag',
    'video',        // <-- ADD
    'video_alt_tag',// <-- ADD
    'sub_heading',
    'heading',
    'description',
    'button_text',
    'button_url'
];
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';
}
