<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'plant_id',
        'quantity',
        'unit_price',
        'total_price'
    ];

    protected $casts = [
        'unit_price' => 'decimal:2',
        'total_price' => 'decimal:2',
    ];

    // Relationships
    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function plant()
    {
        return $this->belongsTo(Plant::class);
    }

    // Accessors
    public function getFormattedUnitPriceAttribute()
    {
        return '$' . number_format($this->unit_price, 2);
    }

    public function getFormattedTotalPriceAttribute()
    {
        return '$' . number_format($this->total_price, 2);
    }

    // Methods
    protected static function boot()
    {
        parent::boot();
        
        static::creating(function ($orderItem) {
            if (empty($orderItem->total_price)) {
                $orderItem->total_price = $orderItem->unit_price * $orderItem->quantity;
            }
        });
        
        static::updating(function ($orderItem) {
            if ($orderItem->isDirty(['unit_price', 'quantity'])) {
                $orderItem->total_price = $orderItem->unit_price * $orderItem->quantity;
            }
        });
    }
}
