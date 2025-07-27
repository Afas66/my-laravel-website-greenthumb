<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'session_id',
        'plant_id',
        'quantity',
        'price'
    ];

    protected $casts = [
        'price' => 'decimal:2',
    ];

    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function plant()
    {
        return $this->belongsTo(Plant::class);
    }

    // Accessors
    public function getTotalPriceAttribute()
    {
        return $this->price * $this->quantity;
    }

    // Scopes
    public function scopeForUser($query, $userId)
    {
        return $query->where('user_id', $userId);
    }

    public function scopeForSession($query, $sessionId)
    {
        return $query->where('session_id', $sessionId);
    }

    public function scopeForUserOrSession($query, $userId = null, $sessionId = null)
    {
        if ($userId) {
            return $query->where('user_id', $userId);
        }
        return $query->where('session_id', $sessionId);
    }

    // Methods
    public static function getCartItems($userId = null, $sessionId = null)
    {
        return self::with('plant.category')
            ->forUserOrSession($userId, $sessionId)
            ->get();
    }

    public static function getCartTotal($userId = null, $sessionId = null)
    {
        return self::forUserOrSession($userId, $sessionId)
            ->selectRaw('SUM(price * quantity) as total')
            ->value('total') ?? 0;
    }

    public static function getCartCount($userId = null, $sessionId = null)
    {
        return self::forUserOrSession($userId, $sessionId)
            ->sum('quantity');
    }

    public static function addToCart($plantId, $quantity, $userId = null, $sessionId = null)
    {
        $plant = Plant::find($plantId);
        if (!$plant || !$plant->is_active || $plant->stock_quantity < $quantity) {
            return false;
        }

        $existingItem = self::forUserOrSession($userId, $sessionId)
            ->where('plant_id', $plantId)
            ->first();

        if ($existingItem) {
            $newQuantity = $existingItem->quantity + $quantity;
            if ($plant->stock_quantity < $newQuantity) {
                return false;
            }
            $existingItem->update(['quantity' => $newQuantity]);
            return $existingItem;
        }

        return self::create([
            'user_id' => $userId,
            'session_id' => $sessionId,
            'plant_id' => $plantId,
            'quantity' => $quantity,
            'price' => $plant->price
        ]);
    }

    public static function clearCart($userId = null, $sessionId = null)
    {
        return self::forUserOrSession($userId, $sessionId)->delete();
    }
}
