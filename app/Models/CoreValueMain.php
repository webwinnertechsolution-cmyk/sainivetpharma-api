<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class CoreValueMain extends Model
{
    protected $table = 'corevalues_main';
    public $timestamps = true;
    
    protected $fillable = [
        'heading1',
        'image1'
    ];
    
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';
}
