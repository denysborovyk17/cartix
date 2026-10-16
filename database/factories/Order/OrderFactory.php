<?php declare(strict_types=1);

namespace Database\Factories\Order;

use App\Enums\OrderStatus;
use App\Models\Order\Order;
use App\Models\User\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Order>
 */
class OrderFactory extends Factory
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
            'status' => OrderStatus::PENDING,
            'total' => fake()->numberBetween(10000, 100000),
            'first_name' => fake()->word(),
            'last_name' => fake()->word(),
            'email' => fake()->email(),
            'phone' => '+380671111111',
            'city' => fake()->word(),
            'address' => fake()->word(),
            'notes' => fake()->sentence()
        ];
    }
}
