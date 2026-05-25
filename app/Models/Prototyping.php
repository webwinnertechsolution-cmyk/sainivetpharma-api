<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Prototyping extends Model
{
    protected $table = 'prototyping';
    
    public $timestamps = true;
    
    protected $fillable = [
        'content'
    ];
    
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';
}
