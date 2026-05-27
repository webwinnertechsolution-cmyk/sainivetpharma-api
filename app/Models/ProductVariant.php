<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductVariant extends Model
{
    use HasFactory;

    protected $fillable = [
    'product_id',
    'name',
    'sku',
    'price',
    'compare_price',
    'stock_quantity',
    'image',        // ← YE ADD KARO
    'attributes',
];

    protected $casts = [
        'attributes' => 'array',
		'compare_price' => 'decimal:2',
        'price' => 'decimal:2',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
