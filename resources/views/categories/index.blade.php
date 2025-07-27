<x-app-layout>
    <x-slot name="header">
        <h2 class="font-lora text-xl font-semibold text-gray-900 leading-tight">
            {{ __("All Categories") }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        @forelse($categories as $category)
                            <div class="bg-primary-100 rounded-lg shadow-md overflow-hidden transform transition duration-300 hover:scale-105">
                                <div class="p-6">
                                    <h3 class="font-lora text-2xl font-semibold text-primary-800 mb-2">{{ $category->name }}</h3>
                                    <p class="text-primary-700 text-sm mb-4">{{ $category->description }}</p>
                                    <a href="{{ route("plants.index", ["category" => $category->slug]) }}" class="btn-primary inline-block text-sm">
                                        View Plants ({{ $category->active_plants_count }})
                                    </a>
                                </div>
                            </div>
                        @empty
                            <div class="col-span-full text-center py-8">
                                <p class="text-gray-500">No categories found.</p>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
