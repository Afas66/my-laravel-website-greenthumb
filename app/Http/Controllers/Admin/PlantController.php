<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Plant;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class PlantController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Plant::with('category');

        // Search functionality
        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('description', 'like', '%' . $request->search . '%');
        }

        // Filter by category
        if ($request->filled('category')) {
            $query->where('category_id', $request->category);
        }

        // Filter by status
        if ($request->filled('status')) {
            $query->where('is_active', $request->status === 'active');
        }

        $plants = $query->latest()->paginate(15);
        $categories = Category::active()->get();

        return view('admin.plants.index', compact('plants', 'categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::active()->get();
        return view('admin.plants.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'stock_quantity' => 'required|integer|min:0',
            'category_id' => 'required|exists:categories,id',
            'difficulty_level' => 'required|in:beginner,intermediate,advanced',
            'light_requirements' => 'required|string|max:255',
            'water_frequency' => 'required|string|max:255',
            'size' => 'required|in:small,medium,large',
            'care_instructions' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'is_featured' => 'boolean',
            'is_active' => 'boolean',
        ]);

        $validated['slug'] = Str::slug($validated['name']);
        $validated['is_featured'] = $request->has('is_featured');
        $validated['is_active'] = $request->has('is_active');

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('plants', 'public');
        }

        Plant::create($validated);

        return redirect()->route('admin.plants.index')
            ->with('success', 'Plant created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Plant $plant)
    {
        return view('admin.plants.show', compact('plant'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Plant $plant)
    {
        $categories = Category::active()->get();
        return view('admin.plants.edit', compact('plant', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Plant $plant)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'stock_quantity' => 'required|integer|min:0',
            'category_id' => 'required|exists:categories,id',
            'difficulty_level' => 'required|in:beginner,intermediate,advanced',
            'light_requirements' => 'required|string|max:255',
            'water_frequency' => 'required|string|max:255',
            'size' => 'required|in:small,medium,large',
            'care_instructions' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'is_featured' => 'boolean',
            'is_active' => 'boolean',
        ]);

        $validated['slug'] = Str::slug($validated['name']);
        $validated['is_featured'] = $request->has('is_featured');
        $validated['is_active'] = $request->has('is_active');

        if ($request->hasFile('image')) {
            if ($plant->image) {
                Storage::disk('public')->delete($plant->image);
            }
            $validated['image'] = $request->file('image')->store('plants', 'public');
        }

        $plant->update($validated);

        return redirect()->route('admin.plants.index')
            ->with('success', 'Plant updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Plant $plant)
    {
        if ($plant->image) {
            Storage::disk('public')->delete($plant->image);
        }

        $plant->delete();

        return redirect()->route('admin.plants.index')
            ->with('success', 'Plant deleted successfully.');
    }

    /**
     * Toggle featured status
     */
    public function toggleFeatured(Plant $plant)
    {
        $plant->update(['is_featured' => !$plant->is_featured]);
        
        return back()->with('success', 'Plant featured status updated.');
    }

    /**
     * Toggle active status
     */
    public function toggleActive(Plant $plant)
    {
        $plant->update(['is_active' => !$plant->is_active]);
        
        return back()->with('success', 'Plant status updated.');
    }
}

