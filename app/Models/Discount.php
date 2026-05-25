<?php
// app/Models/Discount.php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Discount extends Model
{
    protected $fillable = [
        'title', 'code', 'type', 'method',
        'value_type', 'value', 'is_active',
        'starts_at', 'ends_at'
    ];

    protected $casts = [
        'starts_at' => 'datetime',
        'ends_at'   => 'datetime',
        'is_active' => 'boolean',
    ];

    public function rule()
    {
        return $this->hasOne(DiscountRule::class);
    }

    public function bxgy()
    {
        return $this->hasOne(DiscountBxgy::class);
    }

    public function products()
    { 
        return $this->hasMany(DiscountProduct::class);
    }

    public function usages()
    {
        return $this->hasMany(DiscountUsage::class);
    }

    // Check karo discount valid hai ya nahi
    public function isValid()
    {
        if (!$this->is_active) return false;
        $now = now();
        if ($this->starts_at && $now->lt($this->starts_at)) return false;
        if ($this->ends_at && $now->gt($this->ends_at)) return false;
        return true;
    }

    // Total uses count
    public function totalUses()
    {
        return $this->usages()->count();
    }
}