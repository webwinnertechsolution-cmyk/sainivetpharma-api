<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class RoutingFaq extends Model
{
    protected $table = 'routing_faqs';
    public $timestamps = true;
    
    protected $fillable = [
        'heading',
        'description'
    ];
    
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';
}
