<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Industry extends Model
{
    protected $table = 'industries';
    
    public $timestamps = true;
    
    protected $fillable = [
        'background_image',
        'image',
        'alt_tag',
        'heading',
        'description',
        'layout' // left ya right
    ];
    
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';
}
