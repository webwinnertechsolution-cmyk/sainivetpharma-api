<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class ExperienceThePower extends Model
{
    // Table name
    protected $table = 'experience_the_power';
    
    // Timestamps enable
    public $timestamps = true;
    
    // Mass assignable fields
    protected $fillable = [
        'image',
        'alt_tag',
        'sub_heading',
        'heading',
        'tab',
        'description'
    ];
    
    // Optional: custom timestamp column names (default already works)
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';
}
