<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class IndustryWeServe extends Model
{
    protected $table = 'industries_we_serve';
    public $timestamps = true;
    
    protected $fillable = [
        'image',
        'icon',
        'icon_class',
        'heading',
        'description',
        'link_url'
    ];
    
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';
}
