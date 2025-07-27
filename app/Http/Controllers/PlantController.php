<?php

namespace App\Http\Controllers;

use App\Models\Plant;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PlantController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Plant::active()->with("category");

        // Filtering logic from your implementation
        if ($request->filled("search")) {
            $query->where("name", "like", "%" . $request->search . "%");
        }

        if ($request->filled("category")) {
            $query->whereHas("category", function ($q) use ($request) {
                $q->where("slug", $request->category);
            });
        }

        if ($request->filled("difficulty")) {
            $query->where("difficulty_level", $request->difficulty);
        }

        if ($request->filled("min_price")) {
            $query->where("price", ">=", $request->min_price);
        }

        if ($request->filled("max_price")) {
            $query->where("price", "<=", $request->max_price);
        }

        // Sorting logic
        $sort = $request->get("sort", "name");
        if ($sort === "price") {
            $query->orderBy("price", "asc");
        } elseif ($sort === "newest") {
            $query->latest();
        } else {
            $query->orderBy("name", "asc");
        }

        $plants = $query->paginate(12);
        $categories = Category::active()->withCount("activePlants")->get();

        return view("plants.index", compact("plants", "categories"));
    }

    /**
     * Display the specified resource.
     */
    public function show(Plant $plant)
    {
        if (!$plant->is_active) {
            abort(404);
        }
        $relatedPlants = Plant::active()
            ->where("category_id", $plant->category_id)
            ->where("id", "!=", $plant->id)
            ->limit(4)
            ->get();

        return view("plants.show", compact("plant", "relatedPlants"));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->authorize("create_plants");
        $categories = Category::active()->get();
        return view("admin.plants.create", compact("categories"));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->authorize("create_plants");

        $validated = $request->validate([
            "name" => "required|string|max:255",
            "description" => "required|string",
            "price" => "required|numeric|min:0",
            "stock_quantity" => "required|integer|min:0",
            "category_id" => "required|exists:categories,id",
            "difficulty_level" => "required|in:beginner,intermediate,advanced",
            "light_requirements" => "required|string|max:255",
            "water_frequency" => "required|string|max:255",
            "size" => "required|in:small,medium,large",
            "care_instructions" => "required|string",
            "image" => "nullable|image|mimes:jpeg,png,jpg,gif|max:2048",
            "is_featured" => "boolean",
            "is_active" => "boolean",
        ]);

        $validated["slug"] = \Str::slug($validated["name"]);
        $validated["is_featured"] = $request->has("is_featured");
        $validated["is_active"] = $request->has("is_active");

        if ($request->hasFile("image")) {
            $validated["image"] = $request->file("image")->store("plants", "public");
        }

        Plant::create($validated);

        return redirect()->route("admin.plants.index")
            ->with("success", "Plant created successfully.");
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Plant $plant)
    {
        $this->authorize("edit_plants");
        $categories = Category::active()->get();
        return view("admin.plants.edit", compact("plant", "categories"));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Plant $plant)
    {
        $this->authorize("edit_plants");

        $validated = $request->validate([
            "name" => "required|string|max:255",
            "description" => "required|string",
            "price" => "required|numeric|min:0",
            "stock_quantity" => "required|integer|min:0",
            "category_id" => "required|exists:categories,id",
            "difficulty_level" => "required|in:beginner,intermediate,advanced",
            "light_requirements" => "required|string|max:255",
            "water_frequency" => "required|string|max:255",
            "size" => "required|in:small,medium,large",
            "care_instructions" => "required|string",
            "image" => "nullable|image|mimes:jpeg,png,jpg,gif|max:2048",
            "is_featured" => "boolean",
            "is_active" => "boolean",
        ]);

        $validated["slug"] = \Str::slug($validated["name"]);
        $validated["is_featured"] = $request->has("is_featured");
        $validated["is_active"] = $request->has("is_active");

        if ($request->hasFile("image")) {
            if ($plant->image) {
                Storage::disk("public")->delete($plant->image);
            }
            $validated["image"] = $request->file("image")->store("plants", "public");
        }

        $plant->update($validated);

        return redirect()->route("admin.plants.index")
            ->with("success", "Plant updated successfully.");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Plant $plant)
    {
        $this->authorize("delete_plants");

        if ($plant->image) {
            Storage::disk("public")->delete($plant->image);
        }

        $plant->delete();

        return redirect()->route("admin.plants.index")
            ->with("success", "Plant deleted successfully.");
    }
}
