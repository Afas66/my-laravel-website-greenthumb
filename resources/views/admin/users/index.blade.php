<x-app-layout>
    <x-slot name="header">
        <h2 class="font-lora text-xl font-semibold text-gray-900 leading-tight">
            {{ __("User Management") }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="flex justify-between items-center mb-6">
                        <h3 class="text-lg font-medium text-gray-900">All Users</h3>
                        <a href="{{ route("admin.users.create") }}" class="btn-primary">Add New User</a>
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
                    <form action="{{ route("admin.users.index") }}" method="GET" class="mb-6">
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <div>
                                <label for="search" class="block text-sm font-medium text-gray-700">Search</label>
                                <input type="text" name="search" id="search" value="{{ request("search") }}" placeholder="Search by name or email" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-300 focus:ring focus:ring-primary-200 focus:ring-opacity-50">
                            </div>
                            <div>
                                <label for="role" class="block text-sm font-medium text-gray-700">Role</label>
                                <select name="role" id="role" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-300 focus:ring focus:ring-primary-200 focus:ring-opacity-50">
                                    <option value="">All Roles</option>
                                    @foreach ($roles as $role)
                                        <option value="{{ $role->name }}" {{ request("role") == $role->name ? "selected" : "" }}>{{ ucfirst($role->name) }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <label for="verified" class="block text-sm font-medium text-gray-700">Verification</label>
                                <select name="verified" id="verified" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-300 focus:ring focus:ring-primary-200 focus:ring-opacity-50">
                                    <option value="">All</option>
                                    <option value="1" {{ request("verified") == "1" ? "selected" : "" }}>Verified</option>
                                    <option value="0" {{ request("verified") == "0" ? "selected" : "" }}>Unverified</option>
                                </select>
                            </div>
                        </div>
                        <div class="mt-4 flex justify-end">
                            <button type="submit" class="btn-primary">Apply Filters</button>
                            <a href="{{ route("admin.users.index") }}" class="btn-outline ml-2">Clear Filters</a>
                        </div>
                    </form>

                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Role</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Verified</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse ($users as $user)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $user->name }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $user->email }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ ucfirst($user->getRoleNames()->first()) }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <form action="{{ route("admin.users.toggle-verification", $user) }}" method="POST" class="inline">
                                                @csrf
                                                @method("PATCH")
                                                <button type="submit" class="btn-sm {{ $user->email_verified_at ? "bg-green-500 text-white" : "bg-red-500 text-white" }} rounded-full">
                                                    {{ $user->email_verified_at ? "Yes" : "No" }}
                                                </button>
                                            </form>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                            <a href="{{ route("admin.users.edit", $user) }}" class="text-primary-600 hover:text-primary-900 mr-3">Edit</a>
                                            <form action="{{ route("admin.users.destroy", $user) }}" method="POST" class="inline">
                                                @csrf
                                                @method("DELETE")
                                                <button type="submit" class="text-red-600 hover:text-red-900" onclick="return confirm("Are you sure you want to delete this user?")">Delete</button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-center">No users found.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-4">
                        {{ $users->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

