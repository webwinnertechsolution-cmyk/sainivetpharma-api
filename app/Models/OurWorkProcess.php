<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class OurWorkProcess extends Model
{
    protected $table = 'our_work_process';
    public $timestamps = true;
    
    protected $fillable = [
        'image',
        'heading',
        'description',
        'link_url'
    ];
    
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';
}
