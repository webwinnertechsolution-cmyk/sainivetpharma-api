<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ShippingMethod extends Model
{
    protected $fillable = [
        'name',
        'description',
        'delivery_time',
        'is_active',
        'sort_order',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    // Relationship: Method ke kitne rates hain
    public function rates()
    {
        return $this->hasMany(ShippingRate::class, 'method_id');
    }
}