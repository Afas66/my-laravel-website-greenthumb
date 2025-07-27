<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Plant;
use App\Models\Category;

class PlantSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $indoorCategory = Category::where('slug', 'indoor-plants')->first();
        $outdoorCategory = Category::where('slug', 'outdoor-plants')->first();
        $succulentCategory = Category::where('slug', 'succulents')->first();
        $floweringCategory = Category::where('slug', 'flowering-plants')->first();
        $herbCategory = Category::where('slug', 'herbs')->first();

        $plants = [
            // Indoor Plants
            [
                'name' => 'Monstera Deliciosa',
                'description' => 'The iconic Swiss Cheese Plant with beautiful fenestrated leaves. Perfect for adding tropical vibes to your home.',
                'price' => 45.99,
                'stock_quantity' => 25,
                'difficulty_level' => 'beginner',
                'light_requirements' => 'Bright indirect light',
                'water_frequency' => 'Weekly',
                'size' => 'Medium',
                'care_instructions' => 'Water when top inch of soil is dry. Provide bright, indirect light. Wipe leaves regularly to keep them glossy.',
                'is_featured' => true,
                'is_active' => true,
                'category_id' => $indoorCategory->id,
            ],
            [
                'name' => 'Snake Plant (Sansevieria)',
                'description' => 'Nearly indestructible plant with striking upright leaves. Perfect for beginners and low-light conditions.',
                'price' => 29.99,
                'stock_quantity' => 40,
                'difficulty_level' => 'beginner',
                'light_requirements' => 'Low to bright indirect light',
                'water_frequency' => 'Every 2-3 weeks',
                'size' => 'Medium',
                'care_instructions' => 'Very drought tolerant. Water sparingly and allow soil to dry completely between waterings.',
                'is_featured' => true,
                'is_active' => true,
                'category_id' => $indoorCategory->id,
            ],
            [
                'name' => 'Pothos Golden',
                'description' => 'Trailing vine with heart-shaped golden-green leaves. Excellent for hanging baskets or shelves.',
                'price' => 19.99,
                'stock_quantity' => 35,
                'difficulty_level' => 'beginner',
                'light_requirements' => 'Low to bright indirect light',
                'water_frequency' => 'Weekly',
                'size' => 'Small',
                'care_instructions' => 'Very adaptable plant. Water when soil feels dry. Can tolerate various light conditions.',
                'is_featured' => false,
                'is_active' => true,
                'category_id' => $indoorCategory->id,
            ],
            [
                'name' => 'Fiddle Leaf Fig',
                'description' => 'Statement plant with large, violin-shaped leaves. A popular choice for modern home decor.',
                'price' => 89.99,
                'stock_quantity' => 15,
                'difficulty_level' => 'intermediate',
                'light_requirements' => 'Bright indirect light',
                'water_frequency' => 'Weekly',
                'size' => 'Large',
                'care_instructions' => 'Needs consistent watering and bright light. Rotate regularly for even growth.',
                'is_featured' => true,
                'is_active' => true,
                'category_id' => $indoorCategory->id,
            ],

            // Succulents
            [
                'name' => 'Echeveria Elegans',
                'description' => 'Beautiful rosette succulent with blue-green leaves and pink edges. Perfect for beginners.',
                'price' => 12.99,
                'stock_quantity' => 50,
                'difficulty_level' => 'beginner',
                'light_requirements' => 'Bright direct light',
                'water_frequency' => 'Every 2 weeks',
                'size' => 'Small',
                'care_instructions' => 'Water deeply but infrequently. Ensure good drainage and plenty of sunlight.',
                'is_featured' => false,
                'is_active' => true,
                'category_id' => $succulentCategory->id,
            ],
            [
                'name' => 'Jade Plant',
                'description' => 'Classic succulent with thick, glossy leaves. Known as a symbol of good luck and prosperity.',
                'price' => 24.99,
                'stock_quantity' => 30,
                'difficulty_level' => 'beginner',
                'light_requirements' => 'Bright direct light',
                'water_frequency' => 'Every 2-3 weeks',
                'size' => 'Medium',
                'care_instructions' => 'Allow soil to dry completely between waterings. Pinch back to maintain shape.',
                'is_featured' => true,
                'is_active' => true,
                'category_id' => $succulentCategory->id,
            ],

            // Outdoor Plants
            [
                'name' => 'Lavender',
                'description' => 'Fragrant purple flowers and silvery foliage. Perfect for gardens and attracts beneficial insects.',
                'price' => 18.99,
                'stock_quantity' => 45,
                'difficulty_level' => 'intermediate',
                'light_requirements' => 'Full sun',
                'water_frequency' => 'Weekly',
                'size' => 'Medium',
                'care_instructions' => 'Needs well-draining soil and full sun. Prune after flowering to maintain shape.',
                'is_featured' => false,
                'is_active' => true,
                'category_id' => $outdoorCategory->id,
            ],
            [
                'name' => 'Hostas',
                'description' => 'Shade-loving perennial with large, decorative leaves. Perfect for shaded garden areas.',
                'price' => 22.99,
                'stock_quantity' => 25,
                'difficulty_level' => 'beginner',
                'light_requirements' => 'Partial to full shade',
                'water_frequency' => 'Twice weekly',
                'size' => 'Medium',
                'care_instructions' => 'Thrives in shade with consistent moisture. Mulch to retain soil moisture.',
                'is_featured' => false,
                'is_active' => true,
                'category_id' => $outdoorCategory->id,
            ],

            // Flowering Plants
            [
                'name' => 'African Violet',
                'description' => 'Compact flowering plant with velvety leaves and colorful blooms. Perfect for windowsills.',
                'price' => 16.99,
                'stock_quantity' => 20,
                'difficulty_level' => 'intermediate',
                'light_requirements' => 'Bright indirect light',
                'water_frequency' => 'Twice weekly',
                'size' => 'Small',
                'care_instructions' => 'Water from bottom to avoid getting leaves wet. Needs consistent moisture and humidity.',
                'is_featured' => false,
                'is_active' => true,
                'category_id' => $floweringCategory->id,
            ],
            [
                'name' => 'Peace Lily',
                'description' => 'Elegant plant with white flowers and glossy green leaves. Excellent air purifier.',
                'price' => 34.99,
                'stock_quantity' => 18,
                'difficulty_level' => 'beginner',
                'light_requirements' => 'Low to bright indirect light',
                'water_frequency' => 'Weekly',
                'size' => 'Medium',
                'care_instructions' => 'Droops when thirsty, making it easy to know when to water. Prefers humid conditions.',
                'is_featured' => true,
                'is_active' => true,
                'category_id' => $floweringCategory->id,
            ],

            // Herbs
            [
                'name' => 'Basil',
                'description' => 'Fresh culinary herb perfect for cooking. Grows quickly and provides continuous harvest.',
                'price' => 8.99,
                'stock_quantity' => 60,
                'difficulty_level' => 'beginner',
                'light_requirements' => 'Bright direct light',
                'water_frequency' => 'Every 2-3 days',
                'size' => 'Small',
                'care_instructions' => 'Pinch flowers to encourage leaf growth. Harvest regularly for best flavor.',
                'is_featured' => false,
                'is_active' => true,
                'category_id' => $herbCategory->id,
            ],
            [
                'name' => 'Rosemary',
                'description' => 'Aromatic herb with needle-like leaves. Perfect for cooking and has beautiful blue flowers.',
                'price' => 14.99,
                'stock_quantity' => 35,
                'difficulty_level' => 'intermediate',
                'light_requirements' => 'Full sun',
                'water_frequency' => 'Weekly',
                'size' => 'Medium',
                'care_instructions' => 'Prefers well-draining soil and full sun. Allow soil to dry between waterings.',
                'is_featured' => false,
                'is_active' => true,
                'category_id' => $herbCategory->id,
            ],
        ];

        foreach ($plants as $plant) {
            Plant::create($plant);
        }
    }
}
