<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-lora text-xl font-semibold text-gray-900">
                {{ __("All Plants") }}
            </h2>
            <div class="text-sm text-gray-600">
                {{ $plants->total() }} plants found
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col lg:flex-row gap-8">
                <!-- Sidebar Filters -->
                <div class="lg:w-1/4">
                    <div class="bg-white rounded-lg shadow-sm p-6 sticky top-6">
                        <h3 class="font-semibold text-lg mb-4">Filters</h3>

                        <form method="GET" action="{{ route("plants.index") }}" class="space-y-6">
                            <!-- Search -->
                            <div>
                                <label for="search" class="block text-sm font-medium text-gray-700 mb-2">Search</label>
                                <input type="text" name="search" id="search"
                                       value="{{ request("search") }}"
                                       placeholder="Search plants..."
                                       class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-primary-500 focus:border-primary-500">
                            </div>

                            <!-- Categories -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Category</label>
                                <div class="space-y-2">
                                    <label class="flex items-center">
                                        <input type="radio" name="category" value=""
                                               {{ !request("category") ? "checked" : "" }}
                                               class="text-primary-600 focus:ring-primary-500">
                                        <span class="ml-2 text-sm text-gray-700">All Categories</span>
                                    </label>
                                    @foreach($categories as $category)
                                    <label class="flex items-center">
                                        <input type="radio" name="category" value="{{ $category->slug }}"
                                               {{ request("category") == $category->slug ? "checked" : "" }}
                                               class="text-primary-600 focus:ring-primary-500">
                                        <span class="ml-2 text-sm text-gray-700">
                                            {{ $category->name }} ({{ $category->active_plants_count }})
                                        </span>
                                    </label>
                                    @endforeach
                                </div>
                            </div>

                            <!-- Difficulty Level -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Difficulty</label>
                                <div class="space-y-2">
                                    <label class="flex items-center">
                                        <input type="radio" name="difficulty" value=""
                                               {{ !request("difficulty") ? "checked" : "" }}
                                               class="text-primary-600 focus:ring-primary-500">
                                        <span class="ml-2 text-sm text-gray-700">All Levels</span>
                                    </label>
                                    <label class="flex items-center">
                                        <input type="radio" name="difficulty" value="beginner"
                                               {{ request("difficulty") == "beginner" ? "checked" : "" }}
                                               class="text-primary-600 focus:ring-primary-500">
                                        <span class="ml-2 text-sm text-gray-700">Beginner</span>
                                    </label>
                                    <label class="flex items-center">
                                        <input type="radio" name="difficulty" value="intermediate"
                                               {{ request("difficulty") == "intermediate" ? "checked" : "" }}
                                               class="text-primary-600 focus:ring-primary-500">
                                        <span class="ml-2 text-sm text-gray-700">Intermediate</span>
                                    </label>
                                    <label class="flex items-center">
                                        <input type="radio" name="difficulty" value="advanced"
                                               {{ request("difficulty") == "advanced" ? "checked" : "" }}
                                               class="text-primary-600 focus:ring-primary-500">
                                        <span class="ml-2 text-sm text-gray-700">Advanced</span>
                                    </label>
                                </div>
                            </div>

                            <!-- Price Range -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Price Range</label>
                                <div class="grid grid-cols-2 gap-2">
                                    <input type="number" name="min_price" placeholder="Min"
                                           value="{{ request("min_price") }}"
                                           class="px-3 py-2 border border-gray-300 rounded-md focus:ring-primary-500 focus:border-primary-500">
                                    <input type="number" name="max_price" placeholder="Max"
                                           value="{{ request("max_price") }}"
                                           class="px-3 py-2 border border-gray-300 rounded-md focus:ring-primary-500 focus:border-primary-500">
                                </div>
                            </div>

                            <button type="submit" class="w-full btn-primary">
                                Apply Filters
                            </button>
                        </form>
                    </div>
                </div>

                <!-- Main Content -->
                <div class="lg:w-3/4">
                    <!-- Sort Options -->
                    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6 gap-4">
                        <div class="flex items-center space-x-4">
                            <span class="text-sm text-gray-600">Sort by:</span>
                            <select name="sort" onchange="updateSort(this.value)"
                                    class="border border-gray-300 rounded-md px-3 py-1 text-sm focus:ring-primary-500 focus:border-primary-500">
                                <option value="name" {{ request("sort") == "name" ? "selected" : "" }}>Name</option>
                                <option value="price" {{ request("sort") == "price" ? "selected" : "" }}>Price</option>
                                <option value="newest" {{ request("sort") == "newest" ? "selected" : "" }}>Newest</option>
                                <option value="featured" {{ request("sort") == "featured" ? "selected" : "" }}>Featured</option>
                            </select>
                        </div>

                        <div class="flex items-center space-x-2">
                            <span class="text-sm text-gray-600">View:</span>
                            <button class="p-2 border border-gray-300 rounded-md">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M5 3a2 2 0 00-2 2v2a2 2 0 002 2h2a2 2 0 002-2V5a2 2 0 00-2-2H5zM5 11a2 2 0 00-2 2v2a2 2 0 002 2h2a2 2 0 002-2v-2a2 2 0 00-2-2H5zM11 5a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V5zM11 13a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path>
                                </svg>
                            </button>
                        </div>
                    </div>

                    <!-- Plants Grid -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                        @forelse($plants as $plant)
                        <div class="plant-card">
                            <div class="relative">
                                <div class="w-full h-48 bg-gray-200 rounded-t-lg overflow-hidden">
                                    @if($plant->image)
                                        <img src="{{ $plant->image_url }}" alt="{{ $plant->name }}"
                                             class="w-full h-full object-cover">
                                    @else
                                        <div class="w-full h-full flex items-center justify-center">
                                            <svg class="w-16 h-16 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                                <path d="M10 2L3 7v11a1 1 0 001 1h3v-6h6v6h3a1 1 0 001-1V7l-7-5z"/>
                                            </svg>
                                        </div>
                                    @endif
                                </div>
                                <div class="difficulty-badge difficulty-{{ $plant->difficulty_level }}">
                                    {{ ucfirst($plant->difficulty_level) }}
                                </div>
                                @if($plant->is_featured)
                                <div class="absolute top-2 left-2 bg-primary-600 text-white px-2 py-1 text-xs font-semibold rounded-full">
                                    Featured
                                </div>
                                @endif
                            </div>
                            <div class="p-4">
                                <div class="flex items-start justify-between mb-2">
                                    <h3 class="font-semibold text-lg text-gray-900">{{ $plant->name }}</h3>
                                    <span class="text-sm text-gray-500">{{ $plant->category->name }}</span>
                                </div>
                                <p class="text-sm text-gray-600 mb-3 line-clamp-2">{{ $plant->description }}</p>
                                <div class="space-y-1 mb-4">
                                    <p class="text-xs text-gray-600">
                                        <span class="font-medium">Light:</span> {{ $plant->light_requirements }}
                                    </p>
                                    <p class="text-xs text-gray-600">
                                        <span class="font-medium">Water:</span> {{ $plant->water_frequency }}
                                    </p>
                                    <p class="text-xs text-gray-600">
                                        <span class="font-medium">Size:</span> {{ ucfirst($plant->size) }}
                                    </p>
                                </div>
                                <div class="flex items-center justify-between">
                                    <span class="text-xl font-bold text-primary-600">${{ number_format($plant->price, 2) }}</span>
                                    <div class="flex items-center space-x-2">
                                        <a href="{{ route("plants.show", $plant->slug) }}"
                                           class="text-sm text-primary-600 hover:text-primary-700 font-medium">
                                            View Details
                                        </a>
                                        <form action="{{ route("cart.add", $plant) }}" method="POST" class="inline">
                                            @csrf
                                            <button type="submit" class="btn-primary text-sm">Add to Cart</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @empty
                        <div class="col-span-full text-center py-12">
                            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                            <h3 class="mt-2 text-sm font-medium text-gray-900">No plants found</h3>
                            <p class="mt-1 text-sm text-gray-500">Try adjusting your search criteria or filters.</p>
                        </div>
                        @endforelse
                    </div>

                    <!-- Pagination -->
                    @if($plants->hasPages())
                    <div class="mt-8">
                        {{ $plants->appends(request()->query())->links() }}
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <script>
        function updateSort(value) {
            const url = new URL(window.location);
            url.searchParams.set("sort", value);
            window.location.href = url.toString();
        }
    </script>
</x-app-layout>
