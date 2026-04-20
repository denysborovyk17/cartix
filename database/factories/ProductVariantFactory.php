<?php declare(strict_types=1);

namespace Database\Factories;

use App\Models\Product;
use App\Models\ProductVariant;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<ProductVariant>
 */
class ProductVariantFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $options = [
            'color' => fake()->randomElement(['black', 'red', 'green']),
            'size' => fake()->randomElement(['S', 'M', 'L'])
        ];
        ksort($options);

        return [
            'product_id' => Product::factory(),
            'options' => $options,
            'options_hash' => hash('sha256', json_encode($options)),
            'price' => fake()->randomFloat(2, 10, 1000),
            'discount_price' => null,
            'stock' => fake()->numberBetween(1, 100)
        ];
    }
}
