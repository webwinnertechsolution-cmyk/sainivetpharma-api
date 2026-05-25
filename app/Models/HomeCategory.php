<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HomeCategory extends Model
{
    use HasFactory;

    protected $table = 'home_categories';

    protected $fillable = [
        'image',
        'alt_tag',
        'title',
        'url',
        'sort_order',
    ];
}