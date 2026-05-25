<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HomeContact extends Model
{
    protected $table = 'home_contact';
    
    public $timestamps = true;
    
    protected $fillable = [
        'heading',
        'description',
        'phone',
        'email',
        'image'
    ];
    
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';
}
