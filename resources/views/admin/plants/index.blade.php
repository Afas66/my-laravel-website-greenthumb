<x-app-layout>
    <x-slot name="header">
        <h2 class="font-lora text-xl font-semibold text-gray-900 leading-tight">
            {{ __("Plant Management") }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="flex justify-between items-center mb-6">
                        <h3 class="text-lg font-medium text-gray-900">All Plants</h3>
                        <a href="{{ route("admin.plants.create") }}" class="btn-primary">Add New Plant</a>
                    </div>

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
                    <form action="{{ route("admin.plants.index") }}" method="GET" class="mb-6">
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <div>
                                <label for="search" class="block text-sm font-medium text-gray-700">Search</label>
                                <input type="text" name="search" id="search" value="{{ request("search") }}" placeholder="Search by name or description" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-300 focus:ring focus:ring-primary-200 focus:ring-opacity-50">
                            </div>
                            <div>
                                <label for="category" class="block text-sm font-medium text-gray-700">Category</label>
                                <select name="category" id="category" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-300 focus:ring focus:ring-primary-200 focus:ring-opacity-50">
                                    <option value="">All Categories</option>
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}" {{ request("category") == $category->id ? "selected" : "" }}>{{ $category->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <label for="status" class="block text-sm font-medium text-gray-700">Status</label>
                                <select name="status" id="status" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-300 focus:ring focus:ring-primary-200 focus:ring-opacity-50">
                                    <option value="">All Statuses</option>
                                    <option value="active" {{ request("status") == "active" ? "selected" : "" }}>Active</option>
                                    <option value="inactive" {{ request("status") == "inactive" ? "selected" : "" }}>Inactive</option>
                                </select>
                            </div>
                        </div>
                        <div class="mt-4 flex justify-end">
                            <button type="submit" class="btn-primary">Apply Filters</button>
                            <a href="{{ route("admin.plants.index") }}" class="btn-outline ml-2">Clear Filters</a>
                        </div>
                    </form>

                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Image</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Category</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Price</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Stock</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Featured</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Active</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse ($plants as $plant)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            @if ($plant->image)
                                                <img src="{{ Storage::url($plant->image) }}" alt="{{ $plant->name }}" class="h-16 w-16 object-cover rounded-md">
                                            @else
                                                <div class="h-16 w-16 bg-gray-200 rounded-md flex items-center justify-center text-gray-500 text-xs">No Image</div>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $plant->name }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $plant->category->name }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">${{ number_format($plant->price, 2) }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $plant->stock_quantity }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <form action="{{ route("admin.plants.toggle-featured", $plant) }}" method="POST" class="inline">
                                                @csrf
                                                @method("PATCH")
                                                <button type="submit" class="btn-sm {{ $plant->is_featured ? "bg-green-500 text-white" : "bg-gray-200 text-gray-700" }} rounded-full">
                                                    {{ $plant->is_featured ? "Yes" : "No" }}
                                                </button>
                                            </form>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <form action="{{ route("admin.plants.toggle-active", $plant) }}" method="POST" class="inline">
                                                @csrf
                                                @method("PATCH")
                                                <button type="submit" class="btn-sm {{ $plant->is_active ? "bg-green-500 text-white" : "bg-red-500 text-white" }} rounded-full">
                                                    {{ $plant->is_active ? "Active" : "Inactive" }}
                                                </button>
                                            </form>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                            <a href="{{ route("admin.plants.edit", $plant) }}" class="text-primary-600 hover:text-primary-900 mr-3">Edit</a>
                                            <form action="{{ route("admin.plants.destroy", $plant) }}" method="POST" class="inline">
                                                @csrf
                                                @method("DELETE")
                                                <button type="submit" class="text-red-600 hover:text-red-900" onclick="return confirm("Are you sure you want to delete this plant?")">Delete</button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="8" class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-center">No plants found.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-4">
                        {{ $plants->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

