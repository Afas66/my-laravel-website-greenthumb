<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Indoor Plants',
                'slug' => 'indoor-plants',
                'description' => 'Beautiful houseplants perfect for your home and office spaces. These plants thrive indoors and help purify the air.',
                'is_active' => true,
            ],
            [
                'name' => 'Outdoor Plants',
                'slug' => 'outdoor-plants',
                'description' => 'Hardy outdoor plants for your garden, patio, and landscape. Perfect for creating beautiful outdoor spaces.',
                'is_active' => true,
            ],
            [
                'name' => 'Succulents',
                'slug' => 'succulents',
                'description' => 'Low-maintenance succulent plants that store water in their leaves. Perfect for beginners and busy plant parents.',
                'is_active' => true,
            ],
            [
                'name' => 'Flowering Plants',
                'slug' => 'flowering-plants',
                'description' => 'Colorful flowering plants that add beauty and fragrance to any space. Seasonal and perennial varieties available.',
                'is_active' => true,
            ],
            [
                'name' => 'Herbs',
                'slug' => 'herbs',
                'description' => 'Fresh culinary and medicinal herbs you can grow at home. Perfect for cooking and natural remedies.',
                'is_active' => true,
            ],
            [
                'name' => 'Trees & Shrubs',
                'slug' => 'trees-shrubs',
                'description' => 'Larger plants including small trees and shrubs for landscaping and creating natural privacy screens.',
                'is_active' => true,
            ],
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }
    }
}
