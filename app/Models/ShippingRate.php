<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ShippingRate extends Model
{
    protected $fillable = [
        'zone_id',
        'method_id',
        'rate_type',
        'base_rate',
        'min_cart_value',
        'weight_from',
        'weight_to',
        'per_kg_rate',
        'cod_available',
        'cod_charge',
        'is_active',
    ];

    protected $casts = [
        'base_rate'      => 'decimal:2',
        'min_cart_value' => 'decimal:2',
        'weight_from'    => 'decimal:2',
        'weight_to'      => 'decimal:2',
        'per_kg_rate'    => 'decimal:2',
        'cod_charge'     => 'decimal:2',
        'cod_available'  => 'boolean',
        'is_active'      => 'boolean',
    ];

    // Belongs to Zone
    public function zone()
    {
        return $this->belongsTo(ShippingZone::class, 'zone_id');
    }

    // Belongs to Method
    public function method()
    {
        return $this->belongsTo(ShippingMethod::class, 'method_id');
    }
}