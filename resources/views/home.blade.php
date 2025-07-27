<x-app-layout>
    <!-- Hero Section -->
    <section class="relative bg-gradient-to-r from-primary-600 to-primary-800 text-white">
        <div class="absolute inset-0 bg-black opacity-20"></div>
        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-24">
            <div class="text-center">
                <h1 class="font-lora text-4xl md:text-6xl font-bold mb-6">
                    Grow Your Green Paradise
                </h1>
                <p class="text-xl md:text-2xl mb-8 max-w-3xl mx-auto">
                    Discover thousands of beautiful plants, expert care guides, and everything you need to create your perfect garden sanctuary.
                </p>
                <div class="flex flex-col sm:flex-row gap-4 justify-center">
                    <a href="{{ route("plants.index") }}" class="bg-white text-primary-600 px-8 py-3 rounded-lg font-semibold hover:bg-gray-100 transition-colors">
                        Shop Plants
                    </a>
                    <a href="#featured" class="border-2 border-white text-white px-8 py-3 rounded-lg font-semibold hover:bg-white hover:text-primary-600 transition-colors">
                        Learn More
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- Featured Categories -->
    <section class="py-16 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="font-lora text-3xl md:text-4xl font-bold text-gray-900 mb-4">
                    Shop by Category
                </h2>
                <p class="text-lg text-gray-600 max-w-2xl mx-auto">
                    Find the perfect plants for your space, from indoor houseplants to outdoor garden favorites.
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <!-- Indoor Plants -->
                <div class="group relative overflow-hidden rounded-lg shadow-lg hover:shadow-xl transition-shadow duration-300">
                    <div class="aspect-w-16 aspect-h-12 bg-gray-200">
                        <div class="w-full h-64 bg-gradient-to-br from-green-400 to-green-600 flex items-center justify-center">
                            <svg class="w-20 h-20 text-white" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M10 2L3 7v11a1 1 0 001 1h3v-6h6v6h3a1 1 0 001-1V7l-7-5z"/>
                            </svg>
                        </div>
                    </div>
                    <div class="absolute inset-0 bg-black bg-opacity-40 group-hover:bg-opacity-30 transition-opacity duration-300"></div>
                    <div class="absolute inset-0 flex items-center justify-center">
                        <div class="text-center text-white">
                            <h3 class="font-lora text-2xl font-bold mb-2">Indoor Plants</h3>
                            <p class="mb-4">Perfect for your home and office</p>
                            <a href="{{ route("plants.index", ["category" => "indoor"]) }}" class="bg-white text-gray-900 px-6 py-2 rounded-lg font-semibold hover:bg-gray-100 transition-colors">
                                Shop Now
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Outdoor Plants -->
                <div class="group relative overflow-hidden rounded-lg shadow-lg hover:shadow-xl transition-shadow duration-300">
                    <div class="aspect-w-16 aspect-h-12 bg-gray-200">
                        <div class="w-full h-64 bg-gradient-to-br from-earth-400 to-earth-600 flex items-center justify-center">
                            <svg class="w-20 h-20 text-white" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M3 4a1 1 0 011-1h12a1 1 0 011 1v2a1 1 0 01-1 1H4a1 1 0 01-1-1V4zM3 10a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H4a1 1 0 01-1-1v-6zM14 9a1 1 0 00-1 1v6a1 1 0 001 1h2a1 1 0 001-1v-6a1 1 0 00-1-1h-2z"/>
                            </svg>
                        </div>
                    </div>
                    <div class="absolute inset-0 bg-black bg-opacity-40 group-hover:bg-opacity-30 transition-opacity duration-300"></div>
                    <div class="absolute inset-0 flex items-center justify-center">
                        <div class="text-center text-white">
                            <h3 class="font-lora text-2xl font-bold mb-2">Garden Plants</h3>
                            <p class="mb-4">Beautiful outdoor varieties</p>
                            <a href="{{ route("plants.index", ["category" => "outdoor"]) }}" class="bg-white text-gray-900 px-6 py-2 rounded-lg font-semibold hover:bg-gray-100 transition-colors">
                                Shop Now
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Succulents -->
                <div class="group relative overflow-hidden rounded-lg shadow-lg hover:shadow-xl transition-shadow duration-300">
                    <div class="aspect-w-16 aspect-h-12 bg-gray-200">
                        <div class="w-full h-64 bg-gradient-to-br from-teal-400 to-teal-600 flex items-center justify-center">
                            <svg class="w-20 h-20 text-white" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                            </svg>
                        </div>
                    </div>
                    <div class="absolute inset-0 bg-black bg-opacity-40 group-hover:bg-opacity-30 transition-opacity duration-300"></div>
                    <div class="absolute inset-0 flex items-center justify-center">
                        <div class="text-center text-white">
                            <h3 class="font-lora text-2xl font-bold mb-2">Succulents</h3>
                            <p class="mb-4">Low-maintenance beauties</p>
                            <a href="{{ route("plants.index", ["category" => "succulents"]) }}" class="bg-white text-gray-900 px-6 py-2 rounded-lg font-semibold hover:bg-gray-100 transition-colors">
                                Shop Now
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Featured Plants -->
    <section id="featured" class="py-16 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="font-lora text-3xl md:text-4xl font-bold text-gray-900 mb-4">
                    Featured Plants
                </h2>
                <p class="text-lg text-gray-600 max-w-2xl mx-auto">
                    Handpicked favorites that are perfect for both beginners and experienced gardeners.
                </p>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                @forelse($featuredPlants as $plant)
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
                    </div>
                    <div class="p-4">
                        <h3 class="font-semibold text-lg text-gray-900 mb-2">{{ $plant->name }}</h3>
                        <p class="text-sm text-gray-600 mb-2">Light: {{ $plant->light_requirements }}</p>
                        <p class="text-sm text-gray-600 mb-4">Water: {{ $plant->water_frequency }}</p>
                        <div class="flex items-center justify-between">
                            <span class="text-xl font-bold text-primary-600">${{ number_format($plant->price, 2) }}</span>
                            <form action="{{ route("cart.add", $plant) }}" method="POST" class="inline">
                                @csrf
                                <button type="submit" class="btn-primary text-sm">Add to Cart</button>
                            </form>
                        </div>
                    </div>
                </div>
                @empty
                <div class="col-span-full text-center py-8">
                    <p class="text-gray-500">No featured plants available at the moment.</p>
                </div>
                @endforelse
            </div>

            <div class="text-center mt-12">
                <a href="{{ route("plants.index") }}" class="btn-primary">View All Plants</a>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section class="py-16 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="font-lora text-3xl md:text-4xl font-bold text-gray-900 mb-4">
                    Why Choose GreenThumb?
                </h2>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="text-center">
                    <div class="w-16 h-16 bg-primary-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <h3 class="font-semibold text-xl text-gray-900 mb-2">Quality Guarantee</h3>
                    <p class="text-gray-600">All our plants are carefully selected and guaranteed to arrive healthy and thriving.</p>
                </div>

                <div class="text-center">
                    <div class="w-16 h-16 bg-primary-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                        </svg>
                    </div>
                    <h3 class="font-semibold text-xl text-gray-900 mb-2">Expert Care Guides</h3>
                    <p class="text-gray-600">Detailed care instructions and ongoing support to help your plants flourish.</p>
                </div>

                <div class="text-center">
                    <div class="w-16 h-16 bg-primary-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                        </svg>
                    </div>
                    <h3 class="font-semibold text-xl text-gray-900 mb-2">Fast Shipping</h3>
                    <p class="text-gray-600">Quick and secure delivery with special plant-safe packaging nationwide.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Newsletter Section -->
    <section class="py-16 bg-primary-600">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h2 class="font-lora text-3xl md:text-4xl font-bold text-white mb-4">
                Stay in the Loop
            </h2>
            <p class="text-xl text-primary-100 mb-8 max-w-2xl mx-auto">
                Get plant care tips, seasonal advice, and exclusive offers delivered to your inbox.
            </p>
            <div class="max-w-md mx-auto flex gap-4">
                <input type="email" placeholder="Enter your email" class="flex-1 px-4 py-3 rounded-lg border-0 focus:ring-2 focus:ring-white focus:ring-offset-2 focus:ring-offset-primary-600">
                <button class="bg-white text-primary-600 px-6 py-3 rounded-lg font-semibold hover:bg-gray-100 transition-colors">
                    Subscribe
                </button>
            </div>
        </div>
    </section>
</x-app-layout>
