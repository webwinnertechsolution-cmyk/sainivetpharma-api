<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ShippingZone extends Model
{
    protected $fillable = [
        'name',
        'countries',
        'is_active',
        'sort_order',
    ];

    protected $casts = [
        'countries' => 'array',
        'is_active' => 'boolean',
    ];

    // Relationship: Zone ke kitne rates hain
    public function rates()
    {
        return $this->hasMany(ShippingRate::class, 'zone_id');
    }
}