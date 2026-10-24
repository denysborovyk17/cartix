<?php declare(strict_types=1);

namespace Database\Factories\Product;

use App\Models\Product\Product;
use App\Models\Product\Review;
use App\Models\User\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Review>
 */
class ReviewFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory()->create(),
            'product_id' => Product::factory()->create(),
            'rating' => fake()->numberBetween(1, 5),
            'comment' => fake()->sentence()
        ];
    }
}
