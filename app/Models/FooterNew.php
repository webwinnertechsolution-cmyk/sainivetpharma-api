<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FooterNew extends Model
{
    protected $table = 'footer_new';

    public $timestamps = true;

    protected $fillable = [
        // Column 1 - Logo + Content + Social Media
        'col1_logo',
        'col1_logo_alt',
        'col1_content',
        'col1_social_facebook',
        'col1_social_instagram',
        'col1_social_twitter',
        'col1_social_youtube',
        'col1_social_linkedin',
        'col1_social_whatsapp',

        // Column 2 - Heading + Links List (stored as JSON)
        'col2_heading',
        'col2_links', // JSON: [{"title":"About Us","url":"/about"},...]

        // Column 3 - Heading + Content (rich text)
        'col3_heading',
        'col3_content',

        // Column 4 - Heading + Content (rich text)
        'col4_heading',
        'col4_content',
    ];

    protected $casts = [
        'col2_links' => 'array',
    ];
}