<x-app-layout>
    <x-slot name="header">
        <h2 class="font-lora text-xl font-semibold text-gray-900 leading-tight">
            {{ __("Edit Plant: " . $plant->name) }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form action="{{ route("admin.plants.update", $plant) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method("PUT")

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Basic Information -->
                            <div class="space-y-4">
                                <h3 class="text-lg font-medium text-gray-900">Basic Information</h3>

                                <div>
                                    <label for="name" class="block text-sm font-medium text-gray-700">Plant Name</label>
                                    <input type="text" name="name" id="name" value="{{ old("name", $plant->name) }}" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-300 focus:ring focus:ring-primary-200 focus:ring-opacity-50">
                                    @error("name")
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="category_id" class="block text-sm font-medium text-gray-700">Category</label>
                                    <select name="category_id" id="category_id" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-300 focus:ring focus:ring-primary-200 focus:ring-opacity-50">
                                        <option value="">Select a category</option>
                                        @foreach ($categories as $category)
                                            <option value="{{ $category->id }}" {{ old("category_id", $plant->category_id) == $category->id ? "selected" : "" }}>{{ $category->name }}</option>
                                        @endforeach
                                    </select>
                                    @error("category_id")
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="price" class="block text-sm font-medium text-gray-700">Price ($)</label>
                                    <input type="number" name="price" id="price" value="{{ old("price", $plant->price) }}" step="0.01" min="0" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-300 focus:ring focus:ring-primary-200 focus:ring-opacity-50">
                                    @error("price")
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="stock_quantity" class="block text-sm font-medium text-gray-700">Stock Quantity</label>
                                    <input type="number" name="stock_quantity" id="stock_quantity" value="{{ old("stock_quantity", $plant->stock_quantity) }}" min="0" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-300 focus:ring focus:ring-primary-200 focus:ring-opacity-50">
                                    @error("stock_quantity")
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="image" class="block text-sm font-medium text-gray-700">Plant Image</label>
                                    @if ($plant->image)
                                        <div class="mb-2">
                                            <img src="{{ Storage::url($plant->image) }}" alt="{{ $plant->name }}" class="h-32 w-32 object-cover rounded-md">
                                            <p class="text-sm text-gray-500 mt-1">Current image</p>
                                        </div>
                                    @endif
                                    <input type="file" name="image" id="image" accept="image/*" class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-primary-50 file:text-primary-700 hover:file:bg-primary-100">
                                    <p class="text-sm text-gray-500 mt-1">Leave empty to keep current image</p>
                                    @error("image")
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <!-- Plant Details -->
                            <div class="space-y-4">
                                <h3 class="text-lg font-medium text-gray-900">Plant Details</h3>

                                <div>
                                    <label for="difficulty_level" class="block text-sm font-medium text-gray-700">Difficulty Level</label>
                                    <select name="difficulty_level" id="difficulty_level" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-300 focus:ring focus:ring-primary-200 focus:ring-opacity-50">
                                        <option value="">Select difficulty</option>
                                        <option value="beginner" {{ old("difficulty_level", $plant->difficulty_level) == "beginner" ? "selected" : "" }}>Beginner</option>
                                        <option value="intermediate" {{ old("difficulty_level", $plant->difficulty_level) == "intermediate" ? "selected" : "" }}>Intermediate</option>
                                        <option value="advanced" {{ old("difficulty_level", $plant->difficulty_level) == "advanced" ? "selected" : "" }}>Advanced</option>
                                    </select>
                                    @error("difficulty_level")
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="size" class="block text-sm font-medium text-gray-700">Size</label>
                                    <select name="size" id="size" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-300 focus:ring focus:ring-primary-200 focus:ring-opacity-50">
                                        <option value="">Select size</option>
                                        <option value="small" {{ old("size", $plant->size) == "small" ? "selected" : "" }}>Small</option>
                                        <option value="medium" {{ old("size", $plant->size) == "medium" ? "selected" : "" }}>Medium</option>
                                        <option value="large" {{ old("size", $plant->size) == "large" ? "selected" : "" }}>Large</option>
                                    </select>
                                    @error("size")
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="light_requirements" class="block text-sm font-medium text-gray-700">Light Requirements</label>
                                    <input type="text" name="light_requirements" id="light_requirements" value="{{ old("light_requirements", $plant->light_requirements) }}" placeholder="e.g., Bright indirect light" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-300 focus:ring focus:ring-primary-200 focus:ring-opacity-50">
                                    @error("light_requirements")
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="water_frequency" class="block text-sm font-medium text-gray-700">Water Frequency</label>
                                    <input type="text" name="water_frequency" id="water_frequency" value="{{ old("water_frequency", $plant->water_frequency) }}" placeholder="e.g., Once a week" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-300 focus:ring focus:ring-primary-200 focus:ring-opacity-50">
                                    @error("water_frequency")
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="flex items-center space-x-4">
                                    <div class="flex items-center">
                                        <input type="checkbox" name="is_featured" id="is_featured" value="1" {{ old("is_featured", $plant->is_featured) ? "checked" : "" }} class="h-4 w-4 text-primary-600 focus:ring-primary-500 border-gray-300 rounded">
                                        <label for="is_featured" class="ml-2 block text-sm text-gray-900">Featured Plant</label>
                                    </div>

                                    <div class="flex items-center">
                                        <input type="checkbox" name="is_active" id="is_active" value="1" {{ old("is_active", $plant->is_active) ? "checked" : "" }} class="h-4 w-4 text-primary-600 focus:ring-primary-500 border-gray-300 rounded">
                                        <label for="is_active" class="ml-2 block text-sm text-gray-900">Active</label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Description and Care Instructions -->
                        <div class="mt-6 space-y-4">
                            <div>
                                <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
                                <textarea name="description" id="description" rows="4" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-300 focus:ring focus:ring-primary-200 focus:ring-opacity-50">{{ old("description", $plant->description) }}</textarea>
                                @error("description")
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="care_instructions" class="block text-sm font-medium text-gray-700">Care Instructions</label>
                                <textarea name="care_instructions" id="care_instructions" rows="4" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-300 focus:ring focus:ring-primary-200 focus:ring-opacity-50">{{ old("care_instructions", $plant->care_instructions) }}</textarea>
                                @error("care_instructions")
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div class="mt-6 flex items-center justify-end space-x-4">
                            <a href="{{ route("admin.plants.index") }}" class="btn-outline">Cancel</a>
                            <button type="submit" class="btn-primary">Update Plant</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

