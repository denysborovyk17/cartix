<?php declare(strict_types=1);

namespace Tests\Feature\Admin;

use App\Enums\HttpStatus;
use App\Models\Product\Category;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Tests\Traits\CreatesAdminTrait;

class CategoryCrudTest extends TestCase
{
    use RefreshDatabase, CreatesAdminTrait;

    public function test_the_create_category_page_can_be_rendered(): void
    {
        $response = $this->actingAs($this->asAdmin())->get(route('admin.categories.create'));

        $response->assertStatus(HttpStatus::OK->value);
    }

    public function test_admin_can_create_a_category(): void
    {
        $category = [
            'name' => 'Category'
        ];

        $response = $this->actingAs($this->asAdmin())->post(route('admin.categories.store'), $category);

        $response->assertStatus(HttpStatus::FOUND->value);

        $this->assertDatabaseHas('categories', ['name' => $category['name']]);
    }

    public function test_the_edit_category_page_can_be_rendered(): void
    {
        $category = Category::factory()->create();

        $response = $this->actingAs($this->asAdmin())->get(route('admin.categories.edit', $category->id));

        $response->assertStatus(HttpStatus::OK->value);
    }

    public function test_admin_can_edit_a_category(): void
    {
        $category = Category::factory()->create([
            'name' => 'Category before'
        ]);

        $data = [
            'name' => 'Category after'
        ];

        $response = $this->actingAs($this->asAdmin())->patch(route('admin.categories.update', $category->id), $data);

        $response->assertStatus(HttpStatus::FOUND->value);

        $this->assertDatabaseHas('categories', ['name' => $data['name']]);
    }

    public function test_admin_can_delete_a_category(): void
    {
        $category = Category::factory()->create();

        $response = $this->actingAs($this->asAdmin())->delete(route('admin.categories.destroy', $category->id));

        $response->assertStatus(HttpStatus::FOUND->value);

        $this->assertDatabaseMissing('categories', ['id' => $category->id]);
    }
}
