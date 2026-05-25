<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AnnouncementBar extends Model
{
    protected $table = 'announcement_bars';

    protected $fillable = [
        'announcements',
        'phone_label',
        'phone_number',
        'phone_url',
        'bg_color',
        'text_color',
        'slide_interval',
        'is_active',
    ];

    protected $casts = [
        'announcements' => 'array',
        'is_active'     => 'boolean',
    ];
}