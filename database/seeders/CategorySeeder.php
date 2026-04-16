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
        $men = Category::create(['name' => 'Men', 'slug' => 'men']);
        $women = Category::create(['name' => 'Women', 'slug' => 'women']);
        $children = Category::create(['name' => 'Children', 'slug' => 'children']);

        $categories = [
            'Jackets' => 'jackets',
            'T-Shirts' => 't-shirts',
            'Pants' => 'pants',
            'Shorts' => 'shorts',
            'Shoes' => 'shoes',
        ];

        foreach ($categories as $name => $slug) {
            Category::create([
                'name' => $name,
                'slug' => $men->slug.'-'.$slug,
                'parent_id' => $men->id
            ]);

            Category::create([
                'name' => $name,
                'slug' => $women->slug.'-'.$slug,
                'parent_id' => $women->id
            ]);

            Category::create([
                'name' => $name,
                'slug' => $children->slug.'-'.$slug,
                'parent_id' => $children->id
            ]);
        }
    }
}
