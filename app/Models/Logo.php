<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Logo extends Model
{
    protected $table = 'logos';
    
    public $timestamps = true;
    
    protected $fillable = [
        'image'
    ];
    
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';
}
