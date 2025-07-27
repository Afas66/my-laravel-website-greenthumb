<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::active()->get();
        return view("categories.index", compact("categories"));
    }

    public function show(Category $category)
    {
        if (!$category->is_active) {
            abort(404);
        }
        $plants = $category->activePlants()->inStock()->paginate(12);
        return view("categories.show", compact("category", "plants"));
    }
}
