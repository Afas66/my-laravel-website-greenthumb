<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\User;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Order::with(['user', 'orderItems.plant']);

        // Search functionality
        if ($request->filled('search')) {
            $query->where('id', 'like', '%' . $request->search . '%')
                  ->orWhereHas('user', function($q) use ($request) {
                      $q->where('name', 'like', '%' . $request->search . '%')
                        ->orWhere('email', 'like', '%' . $request->search . '%');
                  });
        }

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter by date range
        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }
        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        $orders = $query->latest()->paginate(15);

        // Get status counts for filter tabs
        $statusCounts = [
            'all' => Order::count(),
            'pending' => Order::where('status', 'pending')->count(),
            'processing' => Order::where('status', 'processing')->count(),
            'shipped' => Order::where('status', 'shipped')->count(),
            'delivered' => Order::where('status', 'delivered')->count(),
            'cancelled' => Order::where('status', 'cancelled')->count(),
        ];

        return view('admin.orders.index', compact('orders', 'statusCounts'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Order $order)
    {
        $order->load(['user', 'orderItems.plant']);
        return view('admin.orders.show', compact('order'));
    }

    /**
     * Update order status
     */
    public function updateStatus(Request $request, Order $order)
    {
        $validated = $request->validate([
            'status' => 'required|in:pending,processing,shipped,delivered,cancelled',
            'notes' => 'nullable|string|max:500'
        ]);

        $order->update([
            'status' => $validated['status'],
            'notes' => $validated['notes'] ?? $order->notes
        ]);

        return back()->with('success', 'Order status updated successfully.');
    }

    /**
     * Cancel an order
     */
    public function cancel(Order $order)
    {
        if (in_array($order->status, ['delivered', 'cancelled'])) {
            return back()->with('error', 'Cannot cancel this order.');
        }

        $order->update(['status' => 'cancelled']);

        // Restore stock quantities
        foreach ($order->orderItems as $item) {
            $item->plant->increment('stock_quantity', $item->quantity);
        }

        return back()->with('success', 'Order cancelled successfully.');
    }

    /**
     * Delete an order (soft delete)
     */
    public function destroy(Order $order)
    {
        // Only allow deletion of cancelled orders
        if ($order->status !== 'cancelled') {
            return back()->with('error', 'Only cancelled orders can be deleted.');
        }

        $order->delete();

        return redirect()->route('admin.orders.index')
            ->with('success', 'Order deleted successfully.');
    }

    /**
     * Bulk update order statuses
     */
    public function bulkUpdateStatus(Request $request)
    {
        $validated = $request->validate([
            'order_ids' => 'required|array',
            'order_ids.*' => 'exists:orders,id',
            'status' => 'required|in:pending,processing,shipped,delivered,cancelled'
        ]);

        Order::whereIn('id', $validated['order_ids'])
            ->update(['status' => $validated['status']]);

        return back()->with('success', 'Selected orders updated successfully.');
    }
}

