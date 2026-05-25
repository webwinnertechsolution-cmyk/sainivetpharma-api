<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ReverseEngineering extends Model
{
    protected $table = 'reverse_engineering';
    
    public $timestamps = true;
    
    protected $fillable = [
        'content'
    ];
    
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';
}
