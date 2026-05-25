<?php
// app/Models/DiscountProduct.php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class DiscountProduct extends Model
{
	
	 public $timestamps = false; // ✅ Add karo
    protected $fillable = [
        'discount_id',
        'type',
        'product_type',
        'product_id',
    ];

    public function discount()
    {
        return $this->belongsTo(Discount::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}