<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductReview extends Model
{
    protected $fillable = [
        'product_id',
        'reviewer_name',
        'reviewer_email',
        'rating',
        'review_content',
        'is_verified',
        'is_approved',
    ];

    protected $casts = [
        'is_verified' => 'boolean',
        'is_approved' => 'boolean',
    ];

    // ── Relationship ──
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}