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
                'slug' => 'monstera-deliciosa',
                'image' => 'assets/images/plants/monstera.jpeg',
                'description' => 'The iconic Swiss Cheese Plant with beautiful fenestrations.',
                'price' => 45.99,
                'stock_quantity' => 25,
                'sku' => 'PLT-YZZUANWM',
                'difficulty_level' => 'Intermediate',
                'light_requirements' => 'Bright indirect light',
                'water_frequency' => 'Once a week',
                'size' => 'Large',
                'care_instructions' => 'Keep soil consistently moist, but not waterlogged. Provide high humidity.',
                'is_featured' => true,
                'is_active' => true,
                'category_id' => $indoorCategory->id,
            ],
            [
                'name' => 'Snake Plant (Sansevieria)',
                'slug' => 'snake-plant-sansevieria',
                'image' => 'assets/images/plants/Snake.jpeg',
                'description' => 'Nearly indestructible plant with striking upright leaves.',
                'price' => 29.99,
                'stock_quantity' => 40,
                'sku' => 'PLT-WPQFIIVIS',
                'difficulty_level' => 'Beginner',
                'light_requirements' => 'Low to bright indirect light',
                'water_frequency' => 'Every 2-4 weeks',
                'size' => 'Medium',
                'care_instructions' => 'Tolerates neglect. Water sparingly, especially in winter.',
                'is_featured' => false,
                'is_active' => true,
                'category_id' => $indoorCategory->id,
            ],
            [
                'name' => 'Pothos Golden',
                'slug' => 'pothos-golden',
                'image' => 'assets/images/plants/Pothos.jpg',
                'description' => 'Trailing vine with heart-shaped golden-green leaves.',
                'price' => 19.99,
                'stock_quantity' => 35,
                'sku' => 'PLT-DACNYXQ1',
                'difficulty_level' => 'Beginner',
                'light_requirements' => 'Low to bright indirect light',
                'water_frequency' => 'Once a week',
                'size' => 'Small to Large (trailing)',
                'care_instructions' => 'Allow soil to dry out between waterings. Can be pruned to maintain size.',
                'is_featured' => true,
                'is_active' => true,
                'category_id' => $indoorCategory->id,
            ],
            [
                'name' => 'Fiddle Leaf Fig',
                'slug' => 'fiddle-leaf-fig',
                'image' => 'assets/images/plants/fiddle.jpeg',
                'description' => 'Statement plant with large, violin-shaped leaves.',
                'price' => 89.99,
                'stock_quantity' => 15,
                'sku' => 'PLT-GY3HALBA',
                'difficulty_level' => 'Intermediate',
                'light_requirements' => 'Bright indirect light',
                'water_frequency' => 'Once a week',
                'size' => 'Large',
                'care_instructions' => 'Requires consistent watering and bright light. Avoid moving frequently.',
                'is_featured' => false,
                'is_active' => true,
                'category_id' => $indoorCategory->id,
            ],

            // Succulents
            [
                'name' => 'Echeveria Elegans',
                'slug' => 'echeveria-elegans',
                'image' => 'assets/images/plants/echeveria.jpeg',
                'description' => 'Beautiful rosette succulent with blue-green leaves and pink edges.',
                'price' => 12.99,
                'stock_quantity' => 50,
                'sku' => 'PLT-G1LLVWHH',
                'difficulty_level' => 'Beginner',
                'light_requirements' => 'Full sun to bright indirect light',
                'water_frequency' => 'Every 2 weeks',
                'size' => 'Small',
                'care_instructions' => 'Water thoroughly when soil is dry. Provide good drainage.',
                'is_featured' => true,
                'is_active' => true,
                'category_id' => $succulentCategory->id,
            ],
            [
                'name' => 'Jade Plant',
                'slug' => 'jade-plant',
                'image' => 'assets/images/plants/JadePlantSucculents.jpg',
                'description' => 'Classic succulent with thick, glossy leaves. Known for good luck.',
                'price' => 24.99,
                'stock_quantity' => 30,
                'sku' => 'PLT-D1OOTQBC',
                'difficulty_level' => 'Beginner',
                'light_requirements' => 'Bright direct light',
                'water_frequency' => 'Every 2-3 weeks',
                'size' => 'Medium',
                'care_instructions' => 'Allow soil to dry completely between waterings. Prefers bright light.',
                'is_featured' => false,
                'is_active' => true,
                'category_id' => $succulentCategory->id,
            ],

            // Flowering Plants
            [
                'name' => 'Lavender',
                'slug' => 'lavender',
                'image' => 'assets/images/plants/lavender.jpeg',
                'description' => 'Fragrant purple flowers and silvery foliage. Perfect for aromatherapy.',
                'price' => 18.99,
                'stock_quantity' => 45,
                'sku' => 'PLT-XFFCHYSR',
                'difficulty_level' => 'Intermediate',
                'light_requirements' => 'Full sun',
                'water_frequency' => 'Once a week',
                'size' => 'Medium',
                'care_instructions' => 'Requires well-draining soil and plenty of sunlight. Prune after flowering.',
                'is_featured' => true,
                'is_active' => true,
                'category_id' => $floweringCategory->id,
            ],
            [
                'name' => 'African Violet',
                'slug' => 'african-violet',
                'image' => 'assets/images/plants/African.jpeg',
                'description' => 'Compact flowering plant with velvety leaves and colorful blooms.',
                'price' => 16.99,
                'stock_quantity' => 50,
                'sku' => 'PLT-W00P0QXB',
                'difficulty_level' => 'Intermediate',
                'light_requirements' => 'Bright indirect light',
                'water_frequency' => 'Twice weekly',
                'size' => 'Small',
                'care_instructions' => 'Water from the bottom to avoid leaf spots. Keep in warm, humid conditions.',
                'is_featured' => false,
                'is_active' => true,
                'category_id' => $floweringCategory->id,
            ],

            // Herbs
            [
                'name' => 'Basil',
                'slug' => 'basil',
                'image' => 'assets/images/plants/Basil.jpg',
                'description' => 'Fresh culinary herb perfect for cooking. Grows quickly and provides continuous harvest.',
                'price' => 8.99,
                'stock_quantity' => 70,
                'sku' => 'PLT-Q00NYXQ1',
                'difficulty_level' => 'Beginner',
                'light_requirements' => 'Full sun',
                'water_frequency' => 'Daily',
                'size' => 'Small',
                'care_instructions' => 'Keep soil moist and harvest regularly to encourage new growth.',
                'is_featured' => true,
                'is_active' => true,
                'category_id' => $herbCategory->id,
            ],
            [
                'name' => 'Rosemary',
                'slug' => 'rosemary',
                'image' => 'assets/images/plants/rosemary.jpeg',
                'description' => 'Aromatic herb with needle-like leaves, great for cooking and medicinal uses.',
                'price' => 10.99,
                'stock_quantity' => 60,
                'sku' => 'PLT-R0S3M4RY',
                'difficulty_level' => 'Beginner',
                'light_requirements' => 'Full sun',
                'water_frequency' => 'Every 1-2 weeks',
                'size' => 'Medium',
                'care_instructions' => 'Prefers well-drained soil and plenty of sunlight. Drought tolerant once established.',
                'is_featured' => false,
                'is_active' => true,
                'category_id' => $herbCategory->id,
            ],

            // Outdoor Plants
            [
                'name' => 'Hostas',
                'slug' => 'hostas',
                'image' => 'assets/images/plants/hostas.jpeg',
                'description' => 'Shade-loving perennial with large, decorative leaves. Ideal for ground cover.',
                'price' => 22.99,
                'stock_quantity' => 25,
                'sku' => 'PLT-D8XQTQBC',
                'difficulty_level' => 'Beginner',
                'light_requirements' => 'Partial to full shade',
                'water_frequency' => 'Twice weekly',
                'size' => 'Large',
                'care_instructions' => 'Keep soil consistently moist. Protect from slugs and snails.',
                'is_featured' => true,
                'is_active' => true,
                'category_id' => $outdoorCategory->id,
            ],
            [
                'name' => 'Peace Lily',
                'slug' => 'peace-lily',
                'image' => 'assets/images/plants/PeaceLily.jpg',
                'description' => 'Elegant plant with white flowers and glossy leaves. Known for air purification.',
                'price' => 34.99,
                'stock_quantity' => 18,
                'sku' => 'PLT-W20SPROQ',
                'difficulty_level' => 'Beginner',
                'light_requirements' => 'Low to bright indirect light',
                'water_frequency' => 'Once a week',
                'size' => 'Medium',
                'care_instructions' => 'Keep soil moist and mist leaves regularly. Avoid direct sunlight.',
                'is_featured' => false,
                'is_active' => true,
                'category_id' => $indoorCategory->id,
            ],
        ];

        foreach ($plants as $plantData) {
            Plant::create($plantData);
        }
    }
}
