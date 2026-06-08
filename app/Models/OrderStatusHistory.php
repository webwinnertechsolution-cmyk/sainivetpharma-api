<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderStatusHistory extends Model
{
    use HasFactory;

    protected $table = 'order_status_histories';

    protected $fillable = [
        'order_id',
        'status_from',
        'status_to',
        'changed_by',
        'notes',
    ];

    protected $casts = [
        'created_at' => 'datetime',
    ];

    // Parent Order
    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id');
    }
}
