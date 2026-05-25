<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WhatWeDo extends Model
{
    // Table name
    protected $table = 'whatwedo';

    // Timestamps enable
    public $timestamps = true;

    // Mass assignable fields
    protected $fillable = [
        'image',
        'alt_tag',
        'heading',
        'description',
        'button_text',
        'button_url'
    ];

    // Optional: custom timestamp column names (default already works)
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';
}
