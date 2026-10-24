<?php declare(strict_types=1);

namespace Tests\Feature\Admin;

use App\Enums\HttpStatus;
use App\Models\Product\Brand;
use App\Models\Product\Option;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Tests\Traits\CreatesAdminTrait;

class OptionTest extends TestCase
{
    use RefreshDatabase, CreatesAdminTrait;

    public function test_the_create_option_page_can_be_rendered(): void
    {
        $response = $this->actingAs($this->asAdmin())->get(route('admin.options.create'));

        $response->assertStatus(HttpStatus::OK->value);
    }

    public function test_admin_can_create_an_option(): void
    {
        $option = [
            'name' => 'Brand'
        ];

        $response = $this->actingAs($this->asAdmin())->post(route('admin.options.store'), $option);

        $response->assertStatus(HttpStatus::FOUND->value);

        $this->assertDatabaseHas('options', ['name' => $option['name']]);
    }

    public function test_the_edit_option_page_can_be_rendered(): void
    {
        $option = Option::create([
            'name' => 'Option'
        ]);

        $response = $this->actingAs($this->asAdmin())->get(route('admin.options.edit', $option->id));

        $response->assertStatus(HttpStatus::OK->value);
    }

    public function test_admin_can_edit_an_option(): void
    {
        $option = Option::create([
            'name' => 'Option before'
        ]);

        $data = [
            'name' => 'Option after'
        ];

        $response = $this->actingAs($this->asAdmin())->patch(route('admin.options.update', $option->id), $data);

        $response->assertStatus(HttpStatus::FOUND->value);

        $this->assertDatabaseHas('options', ['name' => $data['name']]);
    }

    public function test_admin_can_delete_an_option(): void
    {
        $option = Option::create([
            'name' => 'Option'
        ]);

        $response = $this->actingAs($this->asAdmin())->delete(route('admin.options.destroy', $option->id));

        $response->assertStatus(HttpStatus::FOUND->value);

        $this->assertDatabaseMissing('options', ['id' => $option->id]);
    }
}
