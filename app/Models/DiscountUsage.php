<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DiscountUsage extends Model
{
    protected $table = 'discount_usages';
    
    protected $fillable = [
        'discount_id',
        'customer_id',
        'order_id',
        'used_at',
    ];
    
    protected $casts = [
        'used_at' => 'datetime',
    ];
    
    // Relationships
    public function discount()
    {
        return $this->belongsTo(Discount::class);
    }
}