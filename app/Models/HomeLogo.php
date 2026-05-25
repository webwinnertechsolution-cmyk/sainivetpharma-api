<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HomeLogo extends Model
{
    use HasFactory;
    protected $table    = 'home_logos';
    protected $fillable = ['image', 'alt_tag', 'url', 'sort_order', 'is_active'];
}