<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ThreeDPrinting extends Model
{
    protected $table = 'three_d_printing';
    
    public $timestamps = true;
    
    protected $fillable = [
        'content'
    ];
    
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';
}
