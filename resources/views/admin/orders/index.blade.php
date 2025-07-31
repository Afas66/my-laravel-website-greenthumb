<x-app-layout>
    <x-slot name="header">
        <h2 class="font-lora text-xl font-semibold text-gray-900 leading-tight">
            {{ __("Order Management") }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">All Orders</h3>

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

                    <!-- Search and Filter Form -->
                    <form action="{{ route("admin.orders.index") }}" method="GET" class="mb-6">
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <div>
                                <label for="search" class="block text-sm font-medium text-gray-700">Search</label>
                                <input type="text" name="search" id="search" value="{{ request("search") }}" placeholder="Search by Order ID or Customer" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-300 focus:ring focus:ring-primary-200 focus:ring-opacity-50">
                            </div>
                            <div>
                                <label for="status" class="block text-sm font-medium text-gray-700">Status</label>
                                <select name="status" id="status" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-300 focus:ring focus:ring-primary-200 focus:ring-opacity-50">
                                    <option value="">All Statuses</option>
                                    @foreach (["pending", "processing", "shipped", "delivered", "cancelled"] as $s)
                                        <option value="{{ $s }}" {{ request("status") == $s ? "selected" : "" }}>{{ ucfirst($s) }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <label for="date_from" class="block text-sm font-medium text-gray-700">Date From</label>
                                <input type="date" name="date_from" id="date_from" value="{{ request("date_from") }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-300 focus:ring focus:ring-primary-200 focus:ring-opacity-50">
                            </div>
                            <div>
                                <label for="date_to" class="block text-sm font-medium text-gray-700">Date To</label>
                                <input type="date" name="date_to" id="date_to" value="{{ request("date_to") }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-300 focus:ring focus:ring-primary-200 focus:ring-opacity-50">
                            </div>
                        </div>
                        <div class="mt-4 flex justify-end">
                            <button type="submit" class="btn-primary">Apply Filters</button>
                            <a href="{{ route("admin.orders.index") }}" class="btn-outline ml-2">Clear Filters</a>
                        </div>
                    </form>

                    <!-- Status Tabs -->
                    <div class="mb-6">
                        <div class="flex space-x-4 border-b border-gray-200">
                            @foreach ($statusCounts as $status => $count)
                                <a href="{{ route("admin.orders.index", ["status" => $status === "all" ? "" : $status]) }}" 
                                   class="py-2 px-4 text-sm font-medium {{ (request("status") == $status || (request("status") == "" && $status == "all")) ? "border-b-2 border-primary-500 text-primary-600" : "text-gray-500 hover:text-gray-700" }}">
                                    {{ ucfirst($status) }} ({{ $count }})
                                </a>
                            @endforeach
                        </div>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Order ID</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Customer</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Order Date</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse ($orders as $order)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">#{{ $order->id }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $order->user->name }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">${{ number_format($order->total_amount, 2) }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                                @if($order->status === "pending") bg-yellow-100 text-yellow-800
                                                @elseif($order->status === "processing") bg-blue-100 text-blue-800
                                                @elseif($order->status === "shipped") bg-purple-100 text-purple-800
                                                @elseif($order->status === "delivered") bg-green-100 text-green-800
                                                @else bg-gray-100 text-gray-800
                                                @endif">
                                                {{ ucfirst($order->status) }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $order->created_at->format("M d, Y H:i") }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                            <a href="{{ route("admin.orders.show", $order) }}" class="text-primary-600 hover:text-primary-900 mr-3">View</a>
                                            @if ($order->status !== "cancelled" && $order->status !== "delivered")
                                                <form action="{{ route("admin.orders.cancel", $order) }}" method="POST" class="inline">
                                                    @csrf
                                                    @method("PATCH")
                                                    <button type="submit" class="text-red-600 hover:text-red-900" onclick="return confirm("Are you sure you want to cancel this order?")">Cancel</button>
                                                </form>
                                            @endif
                                            @if ($order->status === "cancelled")
                                                <form action="{{ route("admin.orders.destroy", $order) }}" method="POST" class="inline">
                                                    @csrf
                                                    @method("DELETE")
                                                    <button type="submit" class="text-red-600 hover:text-red-900" onclick="return confirm("Are you sure you want to delete this order permanently?")">Delete</button>
                                                </form>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-center">No orders found.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-4">
                        {{ $orders->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

