<?php declare(strict_types=1);

namespace Tests\Feature\Admin;

use App\Enums\HttpStatus;
use App\Models\Product\Brand;
use App\Models\Product\Category;
use App\Models\Product\Product;
use App\Models\Product\ProductVariant;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Tests\Traits\CreatesAdminTrait;

class ProductCrudTest extends TestCase
{
    use RefreshDatabase, CreatesAdminTrait;

    public function test_the_create_product_page_can_be_rendered(): void
    {
        $response = $this->actingAs($this->asAdmin())->get(route('admin.products.create'));

        $response->assertStatus(HttpStatus::OK->value);
    }

    public function test_admin_can_create_a_product(): void
    {
        $category = Category::factory()->create();
        $brand = Brand::factory()->create();

        $productVariant = [
            'category' => $category->name,
            'brand' => $brand->name,
            'name' => 'Product',
            'description' => fake()->sentence(),
            'price' => 100000,
            'discount_price' => null,
            'currency' => 'USD',
            'stock' => 100
        ];

        $response = $this->actingAs($this->asAdmin())->post(route('admin.products.store'), $productVariant);

        $response->assertStatus(HttpStatus::FOUND->value);

        $this->assertDatabaseHas('product_variants', ['stock' => $productVariant['stock']]);
    }

    public function test_the_edit_product_page_can_be_rendered(): void
    {
        $productVariant = ProductVariant::factory()->create();

        $response = $this->actingAs($this->asAdmin())->get(route('admin.products.edit', $productVariant->id));

        $response->assertStatus(HttpStatus::OK->value);
    }

    public function test_admin_can_edit_a_product(): void
    {
        $product = Product::factory()->create([
            'name' => 'Product before'
        ]);

        $productVariant = ProductVariant::factory()->create([
            'product_id' => $product->id
        ]);

        $data = [
            'category' => $product->category->name,
            'brand' => $product->brand->name,
            'name' => 'Product after',
            'description' => fake()->sentence(),
            'price' => $productVariant->price,
            'discount_price' => $productVariant->discount_price ?? null,
            'currency' => $productVariant->currency,
            'stock' => 95
        ];

        $response = $this->actingAs($this->asAdmin())->patch(route('admin.products.update', $productVariant->id), $data);

        $response->assertStatus(HttpStatus::FOUND->value);

        $this->assertDatabaseHas('products', ['name' => $data['name']]);
        $this->assertDatabaseHas('product_variants', ['stock' => $data['stock']]);
    }

    public function test_admin_can_delete_a_product(): void
    {
        $productVariant = ProductVariant::factory()->create();

        $response = $this->actingAs($this->asAdmin())->delete(route('admin.products.destroy', $productVariant->id));

        $response->assertStatus(HttpStatus::FOUND->value);

        $this->assertDatabaseMissing('product_variants', ['id' => $productVariant->id]);
    }
}
