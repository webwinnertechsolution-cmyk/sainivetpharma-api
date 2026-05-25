<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OurWorkProcessMain extends Model
{
    protected $table = 'ourworkprocessmain';
    
    public $timestamps = true;
    
    protected $fillable = [
        'heading1',
        'image1',
        'button_text',
        'button_url'
    ];
    
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';
}
