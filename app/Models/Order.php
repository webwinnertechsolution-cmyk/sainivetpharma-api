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
        'email',
        'phone',
        'first_name',
        'last_name',
        'address',
        'apartment',
        'city',
        'state',
        'country',
        'zip',
        'subtotal',
        'shipping_cost',
        'total',
        'currency',
        'payment_method',
        'payment_status',
        'payment_transaction_id',
        'paid_at',
        'ip_address',
        'user_agent',
    ];

    protected $casts = [
        'subtotal' => 'decimal:2',
        'shipping_cost' => 'decimal:2',
        'total' => 'decimal:2',
        'paid_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    // Relationships
    public function items()
    {
        return $this->hasMany(OrderItem::class, 'order_id');
    }

    // Generate Unique Order Number
    public static function generateOrderNumber()
    {
        $prefix = 'ORD';
        $date = now()->format('Ymd');
        $random = strtoupper(substr(uniqid(), -6));
        $orderNumber = $prefix . '-' . $date . '-' . $random;

        // Check if unique
        while (self::where('order_number', $orderNumber)->exists()) {
            $random = strtoupper(substr(uniqid(), -6));
            $orderNumber = $prefix . '-' . $date . '-' . $random;
        }

        return $orderNumber;
    }
}
