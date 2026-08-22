<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $table = 'orders';

    protected $fillable = [
    'customer_id',
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
public function customer()
{
    return $this->belongsTo(Customer::class, 'customer_id');
}
    // Generate Order Number: 1, 2, 3, 4, 5...
    public static function generateOrderNumber()
    {
        $lastOrderNumber = self::whereRaw(
            "order_number REGEXP '^[0-9]+$'"
        )
        ->orderByRaw('CAST(order_number AS UNSIGNED) DESC')
        ->value('order_number');

        return $lastOrderNumber
            ? (string) ((int) $lastOrderNumber + 1)
            : '1';
    }
}
