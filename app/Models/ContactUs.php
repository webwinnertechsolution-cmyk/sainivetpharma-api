<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ContactUs extends Model
{
    protected $table = 'contact_us';

    protected $fillable = [
        'page_heading',
        'pre_heading',
        'sub_heading',
        'phone',
        'email',
        'address',
        'map_embed',
        'image',
        'image_alt',
    ];
}