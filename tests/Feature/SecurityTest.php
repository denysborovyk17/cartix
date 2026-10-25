<?php declare(strict_types=1);

namespace Tests\Feature;

use App\Enums\HttpStatus;
use App\Enums\UserRole;
use App\Models\Cart\Cart;
use App\Models\Cart\CartItem;
use App\Models\Product\ProductVariant;
use App\Models\User\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Tests\Traits\CreatesAdminTrait;

class SecurityTest extends TestCase
{
    use RefreshDatabase, CreatesAdminTrait;

    public function test_guest_cannot_access_the_admin_side(): void
    {
        $response = $this->get(route('admin.index'));

        $response->assertStatus(HttpStatus::NOT_FOUND->value);
    }

    public function test_guest_cannot_make_a_request_to_admin_side(): void
    {
        $brand = [
            'name' => 'Brand'
        ];

        $response = $this->post(route('admin.brands.store'), $brand);

        $response->assertStatus(HttpStatus::NOT_FOUND->value);
    }

    public function test_user_cannot_access_the_admin_side(): void
    {
        $user = User::factory()->create([
            'role' => UserRole::USER
        ]);

        $response = $this->actingAs($user)->get(route('admin.index'));

        $response->assertStatus(HttpStatus::NOT_FOUND->value);
    }

    public function test_user_cannot_make_a_request_to_admin_side(): void
    {
        $user = User::factory()->create([
            'role' => UserRole::USER
        ]);

        $data = [
            'name' => 'Brand'
        ];

        $response = $this->actingAs($user)->post(route('admin.brands.store'), $data);

        $response->assertStatus(HttpStatus::NOT_FOUND->value);
    }

    public function test_admin_can_access_the_admin_side(): void
    {
        $response = $this->actingAs($this->asAdmin())->get(route('admin.index'));

        $response->assertStatus(HttpStatus::OK->value);
    }

    public function test_admin_can_make_a_request_to_admin_side(): void
    {
        $data = [
            'name' => 'Brand'
        ];

        $response = $this->actingAs($this->asAdmin())->post(route('admin.brands.store'), $data);

        $response->assertStatus(HttpStatus::FOUND->value);

        $this->assertDatabaseHas('brands', ['name' => $data['name']]);
    }

    public function test_the_checkout_page_cannot_be_rendered_with_a_cart_that_is_empty(): void
    {
        $response = $this->get(route('checkout'));

        $response->assertStatus(HttpStatus::FOUND->value);
    }

    public function test_the_checkout_page_can_be_rendered_with_a_cart_that_is_not_empty(): void
    {
        $user = User::factory()->create();

        $cart = Cart::create([
            'user_id' => $user->id
        ]);

        $productVariant = ProductVariant::factory()->create();

        $cart->items()->create([
            'product_variant_id' => $productVariant->id
        ]);

        $response = $this->actingAs($user)->get(route('checkout'));

        $response->assertStatus(HttpStatus::OK->value);
    }
}
