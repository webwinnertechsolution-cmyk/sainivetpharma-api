<?php
// app/Models/DiscountBxgy.php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class DiscountBxgy extends Model
{
    protected $table = 'discount_bxgy';

    protected $fillable = [
        'discount_id',
        'buy_type',
        'buy_quantity',
        'buy_amount',
        'buy_from',
        'get_quantity',
        'get_from',
        'get_value_type',
        'get_value',
        'max_uses_per_order',
    ];

    public function discount()
    {
        return $this->belongsTo(Discount::class);
    }
}