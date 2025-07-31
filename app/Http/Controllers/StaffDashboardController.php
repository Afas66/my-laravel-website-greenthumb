<?php

namespace App\Http\Controllers;

use App\Models\Plant;
use App\Models\Order;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class StaffDashboardController extends Controller
{
    public function index()
    {
        // Get staff-relevant statistics
        $stats = [
            'pending_orders' => Order::where('status', 'pending')->count(),
            'processing_orders' => Order::where('status', 'processing')->count(),
            'completed_orders_today' => Order::where('status', 'completed')
                ->whereDate('updated_at', today())
                ->count(),
            'completed_orders_week' => Order::where('status', 'completed')
                ->whereBetween('updated_at', [now()->startOfWeek(), now()->endOfWeek()])
                ->count(),
            'low_stock_plants' => Plant::where('stock_quantity', '<=', 5)->count(),
            'total_plants_in_stock' => Plant::where('stock_quantity', '>', 0)->count(),
            'out_of_stock_plants' => Plant::where('stock_quantity', 0)->count(),
        ];

        // Get pending orders that need attention
        $pending_orders = Order::with(['user', 'orderItems.plant'])
            ->where('status', 'pending')
            ->latest()
            ->limit(15)
            ->get();

        // Get processing orders
        $processing_orders = Order::with(['user', 'orderItems.plant'])
            ->where('status', 'processing')
            ->latest()
            ->limit(10)
            ->get();

        // Get low stock plants that need restocking
        $low_stock_plants = Plant::where('stock_quantity', '<=', 5)
            ->where('is_active', true)
            ->orderBy('stock_quantity', 'asc')
            ->limit(15)
            ->get();

        // Get out of stock plants
        $out_of_stock_plants = Plant::where('stock_quantity', 0)
            ->where('is_active', true)
            ->limit(10)
            ->get();

        // Get recent completed orders (for reference)
        $recent_completed_orders = Order::with(['user'])
            ->where('status', 'completed')
            ->latest()
            ->limit(5)
            ->get();

        // Get orders by status for quick overview
        $orders_by_status = Order::select('status', DB::raw('count(*) as count'))
            ->groupBy('status')
            ->get()
            ->pluck('count', 'status');

        // Get today's order activity
        $todays_orders = Order::whereDate('created_at', today())
            ->with(['user'])
            ->latest()
            ->limit(10)
            ->get();

        return view('staff.dashboard', compact(
            'stats',
            'pending_orders',
            'processing_orders',
            'low_stock_plants',
            'out_of_stock_plants',
            'recent_completed_orders',
            'orders_by_status',
            'todays_orders'
        ));
    }

    /**
     * Quick update order status (staff-specific actions)
     */
    public function quickUpdateOrderStatus(Request $request, Order $order)
    {
        $validated = $request->validate([
            'status' => 'required|in:processing,shipped,delivered'
        ]);

        $order->update(['status' => $validated['status']]);

        return back()->with('success', 'Order status updated successfully.');
    }

    /**
     * Mark multiple orders as processing
     */
    public function markAsProcessing(Request $request)
    {
        $validated = $request->validate([
            'order_ids' => 'required|array',
            'order_ids.*' => 'exists:orders,id'
        ]);

        Order::whereIn('id', $validated['order_ids'])
            ->where('status', 'pending')
            ->update(['status' => 'processing']);

        return back()->with('success', 'Selected orders marked as processing.');
    }

    /**
     * Update plant stock quantity
     */
    public function updateStock(Request $request, Plant $plant)
    {
        $validated = $request->validate([
            'stock_quantity' => 'required|integer|min:0'
        ]);

        $plant->update(['stock_quantity' => $validated['stock_quantity']]);

        return back()->with('success', 'Stock quantity updated successfully.');
    }
}

