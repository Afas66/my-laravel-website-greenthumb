<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

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
        'category_id',
    ];

    protected $casts = [
        'images' => 'array',
        'is_featured' => 'boolean',
        'is_active' => 'boolean',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function orders()
    {
        return $this->belongsToMany(Order::class, 'order_items')
                    ->withPivot('quantity', 'subtotal')
                    ->withTimestamps();
    }

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

    // Accessor for image_url
    public function getImageUrlAttribute(): string
    {
        if ($this->image) {
            return asset($this->image);
        }
        return asset('assets/images/placeholders/no_image.jpeg');
    }

    // Scopes
    public function scopeActive(Builder $query): void
    {
        $query->where('is_active', true);
    }

    public function scopeFeatured(Builder $query): void
    {
        $query->where('is_featured', true);
    }

    public function scopeInStock(Builder $query): void
    {
        $query->where('stock_quantity', '>', 0);
    }
}
