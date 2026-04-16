<?php declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            Category::create(['name' => 'Men', 'slug' => 'men']),
            Category::create(['name' => 'Women', 'slug' => 'women']),
            Category::create(['name' => 'Children', 'slug' => 'children']),
        ];

        $subcategories = [
            'Jackets' => 'jackets',
            'T-Shirts' => 't-shirts',
            'Pants' => 'pants',
            'Shorts' => 'shorts',
            'Shoes' => 'shoes',
        ];

        foreach ($categories as $category) {
            foreach ($subcategories as $name => $slug) {
                Category::firstOrCreate([
                    'name' => $category->name . ' ' . $name,
                    'slug' => $category->slug . '-' . $slug,
                    'parent_id' => $category->id
                ]);
            }
        }
    }
}
