<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Plant extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'price',
        'stock_quantity',
        'sku',
        'images',
        'difficulty_level',
        'light_requirements',
        'water_frequency',
        'size',
        'care_instructions',
        'is_featured',
        'is_active',
        'category_id'
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'images' => 'array',
        'is_featured' => 'boolean',
        'is_active' => 'boolean',
    ];

    // Automatically generate slug and SKU
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($plant) {
            if (empty($plant->slug)) {
                $plant->slug = Str::slug($plant->name);
            }
            if (empty($plant->sku)) {
                $plant->sku = 'PLT-' . strtoupper(Str::random(8));
            }
        });

        static::updating(function ($plant) {
            if ($plant->isDirty('name') && empty($plant->slug)) {
                $plant->slug = Str::slug($plant->name);
            }
        });
    }

    // Relationships
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function cartItems()
    {
        return $this->hasMany(Cart::class);
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    public function scopeInStock($query)
    {
        return $query->where('stock_quantity', '>', 0);
    }

    public function scopeByDifficulty($query, $difficulty)
    {
        return $query->where('difficulty_level', $difficulty);
    }

    public function scopeByCategory($query, $categoryId)
    {
        return $query->where('category_id', $categoryId);
    }

    public function scopePriceRange($query, $min, $max)
    {
        return $query->whereBetween('price', [$min, $max]);
    }

    // Accessors
    public function getFirstImageAttribute()
    {
        return $this->images ? $this->images[0] : null;
    }

    public function getFormattedPriceAttribute()
    {
        return '$' . number_format($this->price, 2);
    }

    public function getIsInStockAttribute()
    {
        return $this->stock_quantity > 0;
    }

    // Methods
    public function decreaseStock($quantity)
    {
        if ($this->stock_quantity >= $quantity) {
            $this->decrement('stock_quantity', $quantity);
            return true;
        }
        return false;
    }

    public function increaseStock($quantity)
    {
        $this->increment('stock_quantity', $quantity);
    }
    public function getImageUrlAttribute()
    {
    if ($this->image) {
        return asset('storage/' . $this->image);
       }
    return null;
    }
}
