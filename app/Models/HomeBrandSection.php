<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HomeBrandSection extends Model
{
    use HasFactory;
    protected $table    = 'home_brand_section';
    protected $fillable = ['heading', 'view_all_text', 'view_all_url', 'is_active'];
}