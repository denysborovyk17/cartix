<?php declare(strict_types=1);

namespace Database\Factories;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->words(2, true),
            'category_id' => Category::query()->inRandomOrder()->value('id'),
            'brand_id' => Brand::query()->inRandomOrder()->value('id'),
            'slug' => fake()->unique()->slug(),
            'description' => fake()->sentence(),
            'image' => 'https://picsum.photos/id/' . fake()->numberBetween(0, 100) . '/800/800/',
            'price' => fake()->randomFloat(2, 10, 1000),
            'discount_price' => null,
            'stock' => fake()->numberBetween(1, 100),
            'is_active' => true,
        ];
    }
}
