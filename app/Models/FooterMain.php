<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class FooterMain extends Model
{
    protected $table = 'footer_main';
    
    public $timestamps = true;
    
    protected $fillable = [
        'location1_icon',
        'location1_text',
        'location2_icon',
        'location2_text',
        'copyright_year',
        'copyright_text',
        'powered_by_text',
        'powered_by_link',
    ];
    
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';
}
