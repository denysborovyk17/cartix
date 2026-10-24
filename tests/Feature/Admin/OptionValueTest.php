<?php declare(strict_types=1);

namespace Tests\Feature\Admin;

use App\Enums\HttpStatus;
use App\Models\Product\OptionValue;
use App\Models\Product\Option;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Tests\Traits\CreatesAdminTrait;

class OptionValueTest extends TestCase
{
    use RefreshDatabase, CreatesAdminTrait;

    public function test_the_create_option_value_page_can_be_rendered(): void
    {
        $response = $this->actingAs($this->asAdmin())->get(route('admin.option-values.create'));

        $response->assertStatus(HttpStatus::OK->value);
    }

    public function test_admin_can_create_an_option_value(): void
    {
        $option = Option::factory()->create();

        $optionValue = [
            'option_name' => $option->name,
            'value' => 'Value'
        ];

        $response = $this->actingAs($this->asAdmin())->post(route('admin.option-values.store'), $optionValue);

        $response->assertStatus(HttpStatus::FOUND->value);

        $this->assertDatabaseHas('option_values', [
            'option_id' => $option->id,
            'value' => $optionValue['value']
        ]);
    }

    public function test_the_edit_option_value_page_can_be_rendered(): void
    {
        $optionValue = OptionValue::factory()->create();

        $response = $this->actingAs($this->asAdmin())->get(route('admin.option-values.edit', $optionValue->id));

        $response->assertStatus(HttpStatus::OK->value);
    }

    public function test_admin_can_edit_an_option_value(): void
    {
        $optionValue = OptionValue::factory()->create([
            'value' => 'Value before'
        ]);

        $data = [
            'option_name' => $optionValue->option->name,
            'value' => 'Value after'
        ];

        $response = $this->actingAs($this->asAdmin())->patch(route('admin.option-values.update', $optionValue->id), $data);

        $response->assertStatus(HttpStatus::FOUND->value);

        $this->assertDatabaseHas('option_values', [
            'option_id' => $optionValue->option->id,
            'value' => $data['value']
        ]);
    }

    public function test_admin_can_delete_an_option_value(): void
    {
        $optionValue = OptionValue::factory()->create();

        $response = $this->actingAs($this->asAdmin())->delete(route('admin.option-values.destroy', $optionValue->id));

        $response->assertStatus(HttpStatus::FOUND->value);

        $this->assertDatabaseMissing('option_values', ['id' => $optionValue->id]);
    }
}
