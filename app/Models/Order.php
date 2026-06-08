<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $table = 'orders';

    protected $fillable = [
        'order_number',
        'order_status',
        'customer_type',
        'firebase_uid',
        'user_id',
        'email',
        'phone',
        'shipping_first_name',
        'shipping_last_name',
        'shipping_address',
        'shipping_apartment',
        'shipping_city',
        'shipping_state',
        'shipping_country',
        'shipping_zip',
        'shipping_phone',
        'billing_first_name',
        'billing_last_name',
        'billing_address',
        'billing_city',
        'billing_state',
        'billing_country',
        'billing_zip',
        'subtotal',
        'discount_amount',
        'discount_code',
        'discount_type',
        'discount_details',
        'shipping_method',
        'shipping_rate_id',
        'shipping_cost',
        'shipping_discount',
        'is_free_shipping',
        'tax_amount',
        'tax_rate',
        'total',
        'currency',
        'payment_method',
        'payment_status',
        'payment_transaction_id',
        'paid_at',
        'customer_note',
        'admin_note',
        'ip_address',
        'user_agent',
    ];

    protected $casts = [
        'discount_details' => 'array',
        'subtotal' => 'decimal:2',
        'discount_amount' => 'decimal:2',
        'shipping_cost' => 'decimal:2',
        'shipping_discount' => 'decimal:2',
        'tax_amount' => 'decimal:2',
        'total' => 'decimal:2',
        'is_free_shipping' => 'boolean',
        'paid_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    // Order Items
    public function items()
    {
        return $this->hasMany(OrderItem::class, 'order_id');
    }

    // Status History
    public function statusHistories()
    {
        return $this->hasMany(OrderStatusHistory::class, 'order_id');
    }

    // Discount Usages
    public function discountUsages()
    {
        return $this->hasMany(DiscountUsage::class, 'order_id');
    }

    // User (if registered)
    public function user()
    {
        return $this->belongsTo(GoogleUser::class, 'user_id');
    }

    // Generate Unique Order Number
    public static function generateOrderNumber()
    {
        $prefix = 'ORD';
        $date = now()->format('Ymd');
        $random = strtoupper(substr(uniqid(), -6));
        $orderNumber = $prefix . '-' . $date . '-' . $random;

        // Check unique
        while (self::where('order_number', $orderNumber)->exists()) {
            $random = strtoupper(substr(uniqid(), -6));
            $orderNumber = $prefix . '-' . $date . '-' . $random;
        }

        return $orderNumber;
    }
}
