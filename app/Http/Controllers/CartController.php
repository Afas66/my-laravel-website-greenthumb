<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Plant;
use App\Models\Cart;
use Illuminate\Support\Facades\Session;

class CartController extends Controller
{
    public function index()
    {
        $cartItems = $this->getCartItems();
        $total = $cartItems->sum(function($item) {
            return $item['quantity'] * $item['plant']->price;
        });

        return view('cart.index', compact('cartItems', 'total'));
    }

    public function add(Plant $plant, Request $request)
    {
        $quantity = $request->get('quantity', 1);
        
        if ($plant->stock_quantity < $quantity) {
            return back()->with('error', 'Not enough stock available.');
        }

        $cart = session()->get('cart', []);
        
        if (isset($cart[$plant->id])) {
            $newQuantity = $cart[$plant->id]['quantity'] + $quantity;
            if ($plant->stock_quantity < $newQuantity) {
                return back()->with('error', 'Not enough stock available.');
            }
            $cart[$plant->id]['quantity'] = $newQuantity;
        } else {
            $cart[$plant->id] = [
                'plant_id' => $plant->id,
                'quantity' => $quantity,
                'plant' => $plant
            ];
        }

        session()->put('cart', $cart);

        return back()->with('success', $plant->name . ' added to cart!');
    }

    public function update(Request $request, $plantId)
    {
        $cart = session()->get('cart', []);
        $quantity = $request->get('quantity', 1);

        if (isset($cart[$plantId])) {
            $plant = Plant::find($plantId);
            if ($plant && $plant->stock_quantity >= $quantity) {
                $cart[$plantId]['quantity'] = $quantity;
                session()->put('cart', $cart);
                return back()->with('success', 'Cart updated successfully!');
            } else {
                return back()->with('error', 'Not enough stock available.');
            }
        }

        return back()->with('error', 'Item not found in cart.');
    }

    public function remove($plantId)
    {
        $cart = session()->get('cart', []);
        
        if (isset($cart[$plantId])) {
            unset($cart[$plantId]);
            session()->put('cart', $cart);
            return back()->with('success', 'Item removed from cart!');
        }

        return back()->with('error', 'Item not found in cart.');
    }

    public function clear()
    {
        session()->forget('cart');
        return back()->with('success', 'Cart cleared successfully!');
    }

    private function getCartItems()
    {
        $cart = session()->get('cart', []);
        $cartItems = collect();

        foreach ($cart as $item) {
            $plant = Plant::find($item['plant_id']);
            if ($plant) {
                $cartItems->push([
                    'plant' => $plant,
                    'quantity' => $item['quantity']
                ]);
            }
        }

        return $cartItems;
    }

    public function getCartCount()
    {
        $cart = session()->get('cart', []);
        return array_sum(array_column($cart, 'quantity'));
    }
}
