<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class PrintingFaq extends Model
{
    // Table name
    protected $table = 'printing_faqs';
    
    // Timestamps enable
    public $timestamps = true;
    
    // Mass assignable fields
    protected $fillable = [
        'heading',
        'description'
    ];
    
    // Optional: custom timestamp column names (default already works)
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';
}
