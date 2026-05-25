<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class CoreValue extends Model
{
    protected $table = 'corevalues';
    public $timestamps = true;
    
    protected $fillable = [
        'image',
        'heading'
    ];
    
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';
}
