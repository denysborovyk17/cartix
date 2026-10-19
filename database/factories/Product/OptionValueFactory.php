<?php declare(strict_types=1);

namespace Database\Factories\Product;

use App\Models\Product\Option;
use App\Models\Product\OptionValue;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<OptionValue>
 */
class OptionValueFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'option_id' => Option::factory()->create(),
            'value' => fake()->word()
        ];
    }
}
