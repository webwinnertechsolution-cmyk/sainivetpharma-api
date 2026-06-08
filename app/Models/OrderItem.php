<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    use HasFactory;

    protected $table = 'order_items';

    protected $fillable = [
        'order_id',
        'product_id',
        'product_name',
        'product_slug',
        'product_sku',
        'variant_id',
        'variant_name',
        'variant_attributes',
        'original_price',
        'sale_price',
        'unit_price',
        'quantity',
        'total_price',
        'discount_per_unit',
        'item_discount_total',
        'discount_applied',
        'is_free_item',
        'parent_item_id',
        'bxgy_discount_id',
        'product_image',
        'tax_amount',
    ];

    protected $casts = [
        'variant_attributes' => 'array',
        'discount_applied' => 'array',
        'original_price' => 'decimal:2',
        'sale_price' => 'decimal:2',
        'unit_price' => 'decimal:2',
        'total_price' => 'decimal:2',
        'discount_per_unit' => 'decimal:2',
        'item_discount_total' => 'decimal:2',
        'tax_amount' => 'decimal:2',
        'is_free_item' => 'boolean',
    ];

    // Parent Order
    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id');
    }

    // Parent Item (for BXGY free items)
    public function parentItem()
    {
        return $this->belongsTo(OrderItem::class, 'parent_item_id');
    }

    // Child Items (free items linked to this)
    public function childItems()
    {
        return $this->hasMany(OrderItem::class, 'parent_item_id');
    }
}
