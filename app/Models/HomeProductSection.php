<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HomeProductSection extends Model
{
    use HasFactory;

    protected $table = 'home_product_sections';

    protected $fillable = [
        'heading',
        'sub_heading',
        'view_all_text',
        'view_all_url',
        'category_id',
        'product_limit',
        'sort_order',
        'is_active',
    ];

    /**
     * Category relationship
     */
    public function category()
    {
        return $this->belongsTo(ProductCategory::class, 'category_id');
    }

    /**
     * Get products for this section
     */
    public function getProducts()
    {
        $query = \App\Models\Product::with(['categories', 'tags', 'images', 'variants'])
            ->where('status', 'published');

        if ($this->category_id) {
            $query->whereHas('categories', function ($q) {
                $q->where('product_categories.id', $this->category_id);
            });
        }

        // Sale products first, then featured, then latest
        $query->orderByRaw('CASE WHEN sale_price IS NOT NULL AND sale_price < price THEN 0 ELSE 1 END ASC')
              ->orderBy('is_featured', 'desc')
              ->latest('published_at');

        return $query->take($this->product_limit ?? 5)->get();
    }
}