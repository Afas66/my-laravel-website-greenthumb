<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Plant;
use App\Models\Category;

class HomeController extends Controller
{
    public function index()
    {
        $featuredPlants = Plant::with('category')
            ->active()
            ->featured()
            ->inStock()
            ->limit(8)
            ->get();

        $categories = Category::active()
            ->withCount('activePlants')
            ->having('active_plants_count', '>', 0)
            ->limit(6)
            ->get();

        return view('home', compact('featuredPlants', 'categories'));
    }
}
