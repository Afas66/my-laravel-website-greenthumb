<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-lora text-xl font-semibold text-gray-900 leading-tight">
                {{ $category->name }} Plants
            </h2>
            <div class="text-sm text-gray-600">
                {{ $plants->total() }} plants found in this category
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
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
                                <h3 class="mt-2 text-sm font-medium text-gray-900">No plants found in this category.</h3>
                                <p class="mt-1 text-sm text-gray-500">Please check back later or explore other categories.</p>
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
</x-app-layout>
