<x-app-layout>
    <x-slot name="header">
        <h2 class="font-lora text-xl font-semibold text-gray-900 leading-tight">
            {{ __("Order #" . $order->id) }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    @if (session("success"))
                        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                            <span class="block sm:inline">{{ session("success") }}</span>
                        </div>
                    @endif

                    @if (session("error"))
                        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                            <span class="block sm:inline">{{ session("error") }}</span>
                        </div>
                    @endif

                    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                        <!-- Order Information -->
                        <div class="lg:col-span-2">
                            <div class="bg-gray-50 rounded-lg p-6 mb-6">
                                <h3 class="text-lg font-medium text-gray-900 mb-4">Order Information</h3>
                                <div class="grid grid-cols-2 gap-4">
                                    <div>
                                        <p class="text-sm font-medium text-gray-500">Order ID</p>
                                        <p class="text-sm text-gray-900">#{{ $order->id }}</p>
                                    </div>
                                    <div>
                                        <p class="text-sm font-medium text-gray-500">Status</p>
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                            @if($order->status === "pending") bg-yellow-100 text-yellow-800
                                            @elseif($order->status === "processing") bg-blue-100 text-blue-800
                                            @elseif($order->status === "shipped") bg-purple-100 text-purple-800
                                            @elseif($order->status === "delivered") bg-green-100 text-green-800
                                            @else bg-gray-100 text-gray-800
                                            @endif">
                                            {{ ucfirst($order->status) }}
                                        </span>
                                    </div>
                                    <div>
                                        <p class="text-sm font-medium text-gray-500">Order Date</p>
                                        <p class="text-sm text-gray-900">{{ $order->created_at->format("M d, Y H:i") }}</p>
                                    </div>
                                    <div>
                                        <p class="text-sm font-medium text-gray-500">Total Amount</p>
                                        <p class="text-sm text-gray-900">${{ number_format($order->total_amount, 2) }}</p>
                                    </div>
                                </div>
                            </div>

                            <!-- Customer Information -->
                            <div class="bg-gray-50 rounded-lg p-6 mb-6">
                                <h3 class="text-lg font-medium text-gray-900 mb-4">Customer Information</h3>
                                <div class="grid grid-cols-2 gap-4">
                                    <div>
                                        <p class="text-sm font-medium text-gray-500">Name</p>
                                        <p class="text-sm text-gray-900">{{ $order->user->name }}</p>
                                    </div>
                                    <div>
                                        <p class="text-sm font-medium text-gray-500">Email</p>
                                        <p class="text-sm text-gray-900">{{ $order->user->email }}</p>
                                    </div>
                                </div>
                            </div>

                            <!-- Order Items -->
                            <div class="bg-gray-50 rounded-lg p-6">
                                <h3 class="text-lg font-medium text-gray-900 mb-4">Order Items</h3>
                                <div class="overflow-x-auto">
                                    <table class="min-w-full divide-y divide-gray-200">
                                        <thead class="bg-gray-100">
                                            <tr>
                                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Plant</th>
                                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Price</th>
                                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Quantity</th>
                                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Subtotal</th>
                                            </tr>
                                        </thead>
                                        <tbody class="bg-white divide-y divide-gray-200">
                                            @foreach ($order->orderItems as $item)
                                                <tr>
                                                    <td class="px-6 py-4 whitespace-nowrap">
                                                        <div class="flex items-center">
                                                            @if ($item->plant->image)
                                                                <img src="{{ Storage::url($item->plant->image) }}" alt="{{ $item->plant->name }}" class="h-10 w-10 object-cover rounded-md mr-3">
                                                            @else
                                                                <div class="h-10 w-10 bg-gray-200 rounded-md flex items-center justify-center text-gray-500 text-xs mr-3">No Image</div>
                                                            @endif
                                                            <div>
                                                                <p class="text-sm font-medium text-gray-900">{{ $item->plant->name }}</p>
                                                                <p class="text-sm text-gray-500">{{ $item->plant->category->name }}</p>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">${{ number_format($item->price, 2) }}</td>
                                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $item->quantity }}</td>
                                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">${{ number_format($item->price * $item->quantity, 2) }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <!-- Order Actions -->
                        <div class="lg:col-span-1">
                            <div class="bg-gray-50 rounded-lg p-6">
                                <h3 class="text-lg font-medium text-gray-900 mb-4">Order Actions</h3>
                                
                                @if ($order->status !== "cancelled" && $order->status !== "delivered")
                                    <form action="{{ route("admin.orders.update-status", $order) }}" method="POST" class="mb-4">
                                        @csrf
                                        @method("PATCH")
                                        <div class="mb-4">
                                            <label for="status" class="block text-sm font-medium text-gray-700">Update Status</label>
                                            <select name="status" id="status" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-300 focus:ring focus:ring-primary-200 focus:ring-opacity-50">
                                                @foreach (["pending", "processing", "shipped", "delivered", "cancelled"] as $status)
                                                    <option value="{{ $status }}" {{ $order->status == $status ? "selected" : "" }}>{{ ucfirst($status) }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="mb-4">
                                            <label for="notes" class="block text-sm font-medium text-gray-700">Notes (Optional)</label>
                                            <textarea name="notes" id="notes" rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-300 focus:ring focus:ring-primary-200 focus:ring-opacity-50" placeholder="Add any notes about this status update...">{{ $order->notes }}</textarea>
                                        </div>
                                        <button type="submit" class="btn-primary w-full">Update Status</button>
                                    </form>
                                @endif

                                @if ($order->status !== "cancelled" && $order->status !== "delivered")
                                    <form action="{{ route("admin.orders.cancel", $order) }}" method="POST" class="mb-4">
                                        @csrf
                                        @method("PATCH")
                                        <button type="submit" class="btn-outline w-full text-red-600 border-red-300 hover:bg-red-50" onclick="return confirm("Are you sure you want to cancel this order?")">Cancel Order</button>
                                    </form>
                                @endif

                                @if ($order->status === "cancelled")
                                    <form action="{{ route("admin.orders.destroy", $order) }}" method="POST">
                                        @csrf
                                        @method("DELETE")
                                        <button type="submit" class="btn-outline w-full text-red-600 border-red-300 hover:bg-red-50" onclick="return confirm("Are you sure you want to permanently delete this order?")">Delete Order</button>
                                    </form>
                                @endif

                                <div class="mt-6 pt-6 border-t border-gray-200">
                                    <a href="{{ route("admin.orders.index") }}" class="btn-outline w-full text-center">Back to Orders</a>
                                </div>
                            </div>

                            @if ($order->notes)
                                <div class="bg-gray-50 rounded-lg p-6 mt-6">
                                    <h3 class="text-lg font-medium text-gray-900 mb-2">Notes</h3>
                                    <p class="text-sm text-gray-700">{{ $order->notes }}</p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

