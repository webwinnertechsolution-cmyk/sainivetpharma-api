<?php
// app/Models/DiscountRule.php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class DiscountRule extends Model
{
    protected $fillable = [
        'discount_id',
        'eligibility',
        'min_requirement',
        'min_amount',
        'min_quantity',
        'max_uses_total',
        'max_uses_per_customer',
        'applies_to',
        'combine_product_discounts',
        'combine_order_discounts',
        'combine_shipping_discounts',
        'all_countries',
        'exclude_shipping_over',
    ];

    protected $casts = [
        'combine_product_discounts'  => 'boolean',
        'combine_order_discounts'    => 'boolean',
        'combine_shipping_discounts' => 'boolean',
        'all_countries'              => 'boolean',
    ];

    public function discount()
    {
        return $this->belongsTo(Discount::class);
    }
}