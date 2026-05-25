<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    protected $table = 'menus';
    
    public $timestamps = true;
    
    protected $fillable = [
        'title',
        'url',
        'parent_id',
        'order',
        'icon',
        'is_active',
        'target'
    ];
    
    protected $casts = [
        'is_active' => 'boolean',
        'order' => 'integer'
    ];
    
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';

    /**
     * Parent menu relationship
     * Agar yeh menu kisi ka child hai toh uska parent milega
     */
    public function parent()
    {
        return $this->belongsTo(Menu::class, 'parent_id');
    }

    /**
     * Children menus relationship
     * Agar is menu ke niche aur menus hain toh wo milenge
     */
    public function children()
    {
        return $this->hasMany(Menu::class, 'parent_id')
                    ->where('is_active', 1)
                    ->orderBy('order');
    }

    /**
     * Recursively get all children with their children
     * Multi-level nested menus ke liye
     */
    public function childrenRecursive()
    {
        return $this->children()->with('childrenRecursive');
    }

    /**
     * Scope: Get only active menus
     * Usage: Menu::active()->get()
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', 1);
    }

    /**
     * Scope: Get only parent menus (no children)
     * Usage: Menu::parent()->get()
     */
    public function scopeParent($query)
    {
        return $query->whereNull('parent_id');
    }

    /**
     * Check if menu has children
     */
    public function hasChildren()
    {
        return $this->children()->count() > 0;
    }
}
