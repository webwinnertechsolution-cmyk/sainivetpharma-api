<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PlasticFabrication extends Model
{
    protected $table = 'plastic_fabrication';
    
    public $timestamps = true;
    
    protected $fillable = [
        'content'
    ];
    
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';
}
