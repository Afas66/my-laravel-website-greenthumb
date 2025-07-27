<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_number',
        'user_id',
        'status',
        'subtotal',
        'tax_amount',
        'shipping_amount',
        'total_amount',
        'billing_first_name',
        'billing_last_name',
        'billing_email',
        'billing_phone',
        'billing_address',
        'billing_city',
        'billing_state',
        'billing_postal_code',
        'billing_country',
        'shipping_first_name',
        'shipping_last_name',
        'shipping_address',
        'shipping_city',
        'shipping_state',
        'shipping_postal_code',
        'shipping_country',
        'notes',
        'shipped_at',
        'delivered_at'
    ];

    protected $casts = [
        'subtotal' => 'decimal:2',
        'tax_amount' => 'decimal:2',
        'shipping_amount' => 'decimal:2',
        'total_amount' => 'decimal:2',
        'shipped_at' => 'datetime',
        'delivered_at' => 'datetime',
    ];

    // Automatically generate order number
    protected static function boot()
    {
        parent::boot();
        
        static::creating(function ($order) {
            if (empty($order->order_number)) {
                $order->order_number = 'ORD-' . strtoupper(Str::random(10));
            }
        });
    }

    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    // Scopes
    public function scopeByStatus($query, $status)
    {
        return $query->where('status', $status);
    }

    public function scopeForUser($query, $userId)
    {
        return $query->where('user_id', $userId);
    }

    public function scopeRecent($query)
    {
        return $query->orderBy('created_at', 'desc');
    }

    // Accessors
    public function getFormattedTotalAttribute()
    {
        return '$' . number_format($this->total_amount, 2);
    }

    public function getFullBillingNameAttribute()
    {
        return $this->billing_first_name . ' ' . $this->billing_last_name;
    }

    public function getFullShippingNameAttribute()
    {
        return $this->shipping_first_name . ' ' . $this->shipping_last_name;
    }

    public function getFullBillingAddressAttribute()
    {
        return $this->billing_address . ', ' . $this->billing_city . ', ' . 
               $this->billing_state . ' ' . $this->billing_postal_code;
    }

    public function getFullShippingAddressAttribute()
    {
        return $this->shipping_address . ', ' . $this->shipping_city . ', ' . 
               $this->shipping_state . ' ' . $this->shipping_postal_code;
    }

    public function getStatusBadgeClassAttribute()
    {
        return match($this->status) {
            'pending' => 'bg-yellow-100 text-yellow-800',
            'processing' => 'bg-blue-100 text-blue-800',
            'shipped' => 'bg-purple-100 text-purple-800',
            'delivered' => 'bg-green-100 text-green-800',
            'cancelled' => 'bg-red-100 text-red-800',
            default => 'bg-gray-100 text-gray-800'
        };
    }

    // Methods
    public function updateStatus($status)
    {
        $this->status = $status;
        
        if ($status === 'shipped' && !$this->shipped_at) {
            $this->shipped_at = now();
        }
        
        if ($status === 'delivered' && !$this->delivered_at) {
            $this->delivered_at = now();
        }
        
        return $this->save();
    }

    public function calculateTotals()
    {
        $this->subtotal = $this->orderItems->sum('total_price');
        $this->tax_amount = $this->subtotal * 0.08; // 8% tax rate
        $this->total_amount = $this->subtotal + $this->tax_amount + $this->shipping_amount;
        return $this->save();
    }

    public static function createFromCart($cartItems, $orderData)
    {
        $order = self::create($orderData);
        
        foreach ($cartItems as $cartItem) {
            $order->orderItems()->create([
                'plant_id' => $cartItem->plant_id,
                'quantity' => $cartItem->quantity,
                'unit_price' => $cartItem->price,
                'total_price' => $cartItem->total_price
            ]);
            
            // Decrease plant stock
            $cartItem->plant->decreaseStock($cartItem->quantity);
        }
        
        $order->calculateTotals();
        return $order;
    }
}
