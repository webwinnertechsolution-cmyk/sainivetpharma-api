<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Wishlist extends Model
{
    protected $table = 'wishlists';
    
    protected $fillable = [
        'user_id',      // ✅ Nullable (optional for now)
        'product_id'    // ✅ Required
    ];
    
    public $timestamps = true;
    
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';
    
    // ✅ Default values for nullable fields
    protected $attributes = [
        'user_id' => null,  // Default NULL
    ];
    
    // ── Relationships ──
    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }
    
    // ✅ Optional: User relationship (for future when auth is added)
    public function user()
    {
        return $this->belongsTo(\App\Models\User::class, 'user_id', 'id');
    }
}