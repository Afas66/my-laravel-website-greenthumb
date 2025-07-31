<x-app-layout>
    <x-slot name="header">
        <h2 class="font-lora text-xl font-semibold text-gray-900 leading-tight">
            {{ __("Edit Category: " . $category->name) }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form action="{{ route("admin.categories.update", $category) }}" method="POST">
                        @csrf
                        @method("PUT")

                        <div class="space-y-6">
                            <div>
                                <label for="name" class="block text-sm font-medium text-gray-700">Category Name</label>
                                <input type="text" name="name" id="name" value="{{ old("name", $category->name) }}" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-300 focus:ring focus:ring-primary-200 focus:ring-opacity-50">
                                @error("name")
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
                                <textarea name="description" id="description" rows="4" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-300 focus:ring focus:ring-primary-200 focus:ring-opacity-50" placeholder="Describe this category...">{{ old("description", $category->description) }}</textarea>
                                @error("description")
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="flex items-center">
                                <input type="checkbox" name="is_active" id="is_active" value="1" {{ old("is_active", $category->is_active) ? "checked" : "" }} class="h-4 w-4 text-primary-600 focus:ring-primary-500 border-gray-300 rounded">
                                <label for="is_active" class="ml-2 block text-sm text-gray-900">Active Category</label>
                            </div>
                        </div>

                        <div class="mt-6 flex items-center justify-end space-x-4">
                            <a href="{{ route("admin.categories.index") }}" class="btn-outline">Cancel</a>
                            <button type="submit" class="btn-primary">Update Category</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

