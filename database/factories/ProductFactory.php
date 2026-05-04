<?php declare(strict_types=1);

namespace Database\Factories;

use App\Models\{Brand, Category, Option, Product, ProductVariant};
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
            'category_id' => Category::query()->inRandomOrder()->value('id'),
            'brand_id' => Brand::query()->inRandomOrder()->value('id'),
            'name' => fake()->words(2, true),
            'slug' => fake()->unique()->slug(),
            'description' => fake()->sentence(),
            'image' => 'https://picsum.photos/id/' . fake()->numberBetween(0, 100) . '/800/800/',
            'is_active' => true,
        ];
    }

    public function withOptions(): self
    {
        return $this->afterCreating(function (Product $product) {
            $options = Option::query()->inRandomOrder()->limit(rand(1, 2))->get();

            $product->options()->sync($options);
        });
    }

    public function withAllVariants(): self
    {
        return $this->afterCreating(function (Product $product) {
            $options = $product->options()->with('values')->orderBy('id')->get();

            if ($options->isEmpty()) {
                ProductVariant::factory()->create([
                    'product_id' => $product->id
                ]);
                return;
            }

            $valuesToCombine = $options->map(
                fn($option) => $option->values->pluck('id')
            )->filter()->values()->toArray();

            if (empty($valuesToCombine)) {
                return;
            }

            $firstArray = array_shift($valuesToCombine);
            $combinations = collect($firstArray)->crossJoin(...$valuesToCombine)->toArray();

            foreach ($combinations as $combination) {
                $productVariant = ProductVariant::factory()->create([
                    'product_id' => $product->id,
                ]);

                $productVariant->optionValues()->sync($combination);
            }
        });
    }
}
