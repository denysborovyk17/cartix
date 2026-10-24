<?php declare(strict_types=1);

namespace Tests\Feature\Admin;

use App\Enums\HttpStatus;
use App\Models\Product\Brand;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Tests\Traits\CreatesAdminTrait;

class BrandTest extends TestCase
{
    use RefreshDatabase, CreatesAdminTrait;

    public function test_the_create_brand_page_can_be_rendered(): void
    {
        $response = $this->actingAs($this->asAdmin())->get(route('admin.brands.create'));

        $response->assertStatus(HttpStatus::OK->value);
    }

    public function test_admin_can_create_a_brand(): void
    {
        $brand = [
            'name' => 'Brand'
        ];

        $response = $this->actingAs($this->asAdmin())->post(route('admin.brands.store'), $brand);

        $response->assertStatus(HttpStatus::FOUND->value);

        $this->assertDatabaseHas('brands', ['name' => $brand['name']]);
    }

    public function test_the_edit_brand_page_can_be_rendered(): void
    {
        $brand = Brand::factory()->create();

        $response = $this->actingAs($this->asAdmin())->get(route('admin.brands.edit', $brand->id));

        $response->assertStatus(HttpStatus::OK->value);
    }

    public function test_admin_can_edit_a_brand(): void
    {
        $brand = Brand::factory()->create([
            'name' => 'Brand before'
        ]);

        $data = [
            'name' => 'Brand after'
        ];

        $response = $this->actingAs($this->asAdmin())->patch(route('admin.brands.update', $brand->id), $data);

        $response->assertStatus(HttpStatus::FOUND->value);

        $this->assertDatabaseHas('brands', ['name' => $data['name']]);
    }

    public function test_admin_can_delete_a_brand(): void
    {
        $brand = Brand::factory()->create();

        $response = $this->actingAs($this->asAdmin())->delete(route('admin.brands.destroy', $brand->id));

        $response->assertStatus(HttpStatus::FOUND->value);

        $this->assertDatabaseMissing('brands', ['id' => $brand->id]);
    }
}
