<x-app-layout>
    <x-slot name="header">
        <h2 class="font-lora text-xl font-semibold text-gray-900 leading-tight">
            {{ __("Staff Dashboard") }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Statistics Cards -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <div class="w-8 h-8 bg-yellow-500 rounded-md flex items-center justify-center">
                                    <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M10 12a2 2 0 100-4 2 2 0 000 4z"/>
                                        <path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd"/>
                                    </svg>
                                </div>
                            </div>
                            <div class="ml-5 w-0 flex-1">
                                <dl>
                                    <dt class="text-sm font-medium text-gray-500 truncate">Pending Orders</dt>
                                    <dd class="text-lg font-medium text-gray-900">{{ $stats['pending_orders'] }}</dd>
                                </dl>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <div class="w-8 h-8 bg-blue-500 rounded-md flex items-center justify-center">
                                    <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M3 4a1 1 0 011-1h12a1 1 0 011 1v2a1 1 0 01-1 1H4a1 1 0 01-1-1V4zM3 10a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H4a1 1 0 01-1-1v-6zM14 9a1 1 0 00-1 1v6a1 1 0 001 1h2a1 1 0 001-1v-6a1 1 0 00-1-1h-2z"/>
                                    </svg>
                                </div>
                            </div>
                            <div class="ml-5 w-0 flex-1">
                                <dl>
                                    <dt class="text-sm font-medium text-gray-500 truncate">Processing Orders</dt>
                                    <dd class="text-lg font-medium text-gray-900">{{ $stats['processing_orders'] }}</dd>
                                </dl>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <div class="w-8 h-8 bg-green-500 rounded-md flex items-center justify-center">
                                    <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                    </svg>
                                </div>
                            </div>
                            <div class="ml-5 w-0 flex-1">
                                <dl>
                                    <dt class="text-sm font-medium text-gray-500 truncate">Completed Today</dt>
                                    <dd class="text-lg font-medium text-gray-900">{{ $stats['completed_orders_today'] }}</dd>
                                </dl>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <div class="w-8 h-8 bg-red-500 rounded-md flex items-center justify-center">
                                    <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                    </svg>
                                </div>
                            </div>
                            <div class="ml-5 w-0 flex-1">
                                <dl>
                                    <dt class="text-sm font-medium text-gray-500 truncate">Low Stock Items</dt>
                                    <dd class="text-lg font-medium text-gray-900">{{ $stats['low_stock_plants'] }}</dd>
                                </dl>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-8">
                <div class="p-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Quick Actions</h3>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <form action="{{ route('staff.orders.mark-processing') }}" method="POST" class="inline">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="btn-primary w-full text-center" onclick="return confirm('Mark all pending orders as processing?')">
                                Process All Pending Orders
                            </button>
                        </form>
                        <a href="{{ route('admin.orders.index') }}" class="btn-secondary text-center">
                            View All Orders
                        </a>
                        <a href="{{ route('admin.plants.index') }}" class="btn-outline text-center">
                            Manage Plant Stock
                        </a>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                <!-- Pending Orders -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="flex items-center justify-between mb-4">
                            <h3 class="text-lg font-medium text-gray-900">Pending Orders</h3>
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                {{ $stats['pending_orders'] }} pending
                            </span>
                        </div>
                        <div class="space-y-3 max-h-96 overflow-y-auto">
                            @forelse($pending_orders as $order)
                            <div class="flex items-center justify-between p-3 bg-yellow-50 rounded-lg">
                                <div>
                                    <p class="text-sm font-medium text-gray-900">Order #{{ $order->id }}</p>
                                    <p class="text-sm text-gray-500">{{ $order->user->name }}</p>
                                    <p class="text-xs text-gray-400">{{ $order->created_at->diffForHumans() }}</p>
                                </div>
                                <div class="text-right">
                                    <form action="{{ route('staff.orders.quick-status', $order) }}" method="POST" class="inline">
                                        @csrf
                                        @method('PATCH')
                                        <input type="hidden" name="status" value="processing">
                                        <button type="submit" class="btn-sm btn-primary">
                                            Mark Processing
                                        </button>
                                    </form>
                                    <p class="text-sm text-gray-500 mt-1">${{ number_format($order->total_amount, 2) }}</p>
                                </div>
                            </div>
                            @empty
                            <p class="text-gray-500 text-center py-4">No pending orders</p>
                            @endforelse
                        </div>
                    </div>
                </div>

                <!-- Processing Orders -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="flex items-center justify-between mb-4">
                            <h3 class="text-lg font-medium text-gray-900">Processing Orders</h3>
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                {{ $stats['processing_orders'] }} processing
                            </span>
                        </div>
                        <div class="space-y-3 max-h-96 overflow-y-auto">
                            @forelse($processing_orders as $order)
                            <div class="flex items-center justify-between p-3 bg-blue-50 rounded-lg">
                                <div>
                                    <p class="text-sm font-medium text-gray-900">Order #{{ $order->id }}</p>
                                    <p class="text-sm text-gray-500">{{ $order->user->name }}</p>
                                    <p class="text-xs text-gray-400">{{ $order->updated_at->diffForHumans() }}</p>
                                </div>
                                <div class="text-right">
                                    <form action="{{ route('staff.orders.quick-status', $order) }}" method="POST" class="inline">
                                        @csrf
                                        @method('PATCH')
                                        <input type="hidden" name="status" value="shipped">
                                        <button type="submit" class="btn-sm btn-secondary">
                                            Mark Shipped
                                        </button>
                                    </form>
                                    <p class="text-sm text-gray-500 mt-1">${{ number_format($order->total_amount, 2) }}</p>
                                </div>
                            </div>
                            @empty
                            <p class="text-gray-500 text-center py-4">No processing orders</p>
                            @endforelse
                        </div>
                    </div>
                </div>

                <!-- Low Stock Plants -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="flex items-center justify-between mb-4">
                            <h3 class="text-lg font-medium text-gray-900">Low Stock Alert</h3>
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                {{ $stats['low_stock_plants'] }} items
                            </span>
                        </div>
                        <div class="space-y-3 max-h-96 overflow-y-auto">
                            @forelse($low_stock_plants as $plant)
                            <div class="flex items-center justify-between p-3 bg-red-50 rounded-lg">
                                <div>
                                    <p class="text-sm font-medium text-gray-900">{{ $plant->name }}</p>
                                    <p class="text-sm text-gray-500">{{ $plant->category->name }}</p>
                                </div>
                                <div class="text-right">
                                    <form action="{{ route('staff.plants.update-stock', $plant) }}" method="POST" class="inline-flex items-center space-x-2">
                                        @csrf
                                        @method('PATCH')
                                        <input type="number" name="stock_quantity" value="{{ $plant->stock_quantity }}" 
                                               class="w-16 px-2 py-1 text-sm border border-gray-300 rounded" min="0">
                                        <button type="submit" class="btn-sm btn-outline">Update</button>
                                    </form>
                                    <p class="text-xs text-red-600 mt-1">{{ $plant->stock_quantity }} left</p>
                                </div>
                            </div>
                            @empty
                            <p class="text-gray-500 text-center py-4">All plants are well stocked</p>
                            @endforelse
                        </div>
                    </div>
                </div>

                <!-- Today's Activity -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="flex items-center justify-between mb-4">
                            <h3 class="text-lg font-medium text-gray-900">Today's Orders</h3>
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                {{ $todays_orders->count() }} orders
                            </span>
                        </div>
                        <div class="space-y-3 max-h-96 overflow-y-auto">
                            @forelse($todays_orders as $order)
                            <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                                <div>
                                    <p class="text-sm font-medium text-gray-900">Order #{{ $order->id }}</p>
                                    <p class="text-sm text-gray-500">{{ $order->user->name }}</p>
                                    <p class="text-xs text-gray-400">{{ $order->created_at->format('H:i') }}</p>
                                </div>
                                <div class="text-right">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                        @if($order->status === 'pending') bg-yellow-100 text-yellow-800
                                        @elseif($order->status === 'processing') bg-blue-100 text-blue-800
                                        @elseif($order->status === 'completed') bg-green-100 text-green-800
                                        @else bg-gray-100 text-gray-800
                                        @endif">
                                        {{ ucfirst($order->status) }}
                                    </span>
                                    <p class="text-sm text-gray-500 mt-1">${{ number_format($order->total_amount, 2) }}</p>
                                </div>
                            </div>
                            @empty
                            <p class="text-gray-500 text-center py-4">No orders today</p>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

