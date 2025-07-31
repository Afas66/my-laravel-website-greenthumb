<?php

namespace App\Http\Controllers;

use App\Models\Plant;
use App\Models\Category;
use App\Models\User;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminDashboardController extends Controller
{
    public function index()
    {
        // Get dashboard statistics
        $stats = [
            'total_plants' => Plant::count(),
            'total_categories' => Category::count(),
            'total_users' => User::count(),
            'total_orders' => Order::count(),
            'active_plants' => Plant::where('is_active', true)->count(),
            'featured_plants' => Plant::where('is_featured', true)->count(),
            'low_stock_plants' => Plant::where('stock_quantity', '<=', 5)->count(),
        ];

        // Get recent orders (last 10)
        $recent_orders = Order::with(['user', 'orderItems.plant'])
            ->latest()
            ->limit(10)
            ->get();

        // Get recent users (last 10)
        $recent_users = User::with('roles')
            ->latest()
            ->limit(10)
            ->get();

        // Get low stock plants
        $low_stock_plants = Plant::where('stock_quantity', '<=', 5)
            ->where('is_active', true)
            ->orderBy('stock_quantity', 'asc')
            ->limit(10)
            ->get();

        // Get top categories by plant count
        $top_categories = Category::withCount('plants')
            ->orderBy('plants_count', 'desc')
            ->limit(5)
            ->get();

        // Get order status distribution
        $order_status_distribution = Order::select('status', DB::raw('count(*) as count'))
            ->groupBy('status')
            ->get()
            ->pluck('count', 'status');

        return view('admin.dashboard', compact(
            'stats',
            'recent_orders',
            'recent_users',
            'low_stock_plants',
            'top_categories',
            'order_status_distribution'
        ));
    }
}

