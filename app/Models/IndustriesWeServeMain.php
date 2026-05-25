<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class IndustriesWeServeMain extends Model
{
    protected $table = 'industriesweservemain';
    public $timestamps = true;
    
    protected $fillable = [
        'heading1',
        'image1'
    ];
    
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';
}
