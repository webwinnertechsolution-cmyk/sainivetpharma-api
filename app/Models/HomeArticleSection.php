<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class HomeArticleSection extends Model {
    protected $fillable = [
        'heading', 'sub_heading', 'view_all_text',
        'view_all_url', 'article_limit', 'is_active'
    ];
}