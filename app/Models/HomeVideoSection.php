<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HomeVideoSection extends Model
{
    use HasFactory;
    protected $table = 'home_video_sections';
    protected $fillable = [
        'heading', 'sub_heading', 'view_all_text', 'view_all_url',
        'videos', 'sort_order', 'is_active',
    ];
    protected $casts = ['videos' => 'array'];
}