<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HomeBrand extends Model
{
    use HasFactory;
    protected $table    = 'home_brands';
    protected $fillable = ['image', 'alt_tag', 'url', 'sort_order', 'is_active'];
}