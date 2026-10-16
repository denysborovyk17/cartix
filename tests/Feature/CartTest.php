<?php declare(strict_types=1);

namespace Tests\Feature;

use App\Actions\Cart\MergeGuestCartAction;
use App\Enums\HttpStatus;
use Exception;
use App\Models\Product\{ProductVariant};
use App\Models\User\User;
use App\Models\Cart\{Cart, CartItem};
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CartTest extends TestCase
{
    use RefreshDatabase;

    public function test_cart_page_can_be_rendered(): void
    {
        $response = $this->get(route('cart.index'));

        $response->assertStatus(HttpStatus::OK->value);
    }

    public function test_product_can_be_added_to_cart(): void
    {
        $productVariant = ProductVariant::factory()->create();

        $user = User::factory()->create();

        $response = $this->actingAs($user)->postJson(route('cart.store'), [
            'product_variant_id' => $productVariant->id,
            'quantity' => 1
        ]);

        $response->assertStatus(HttpStatus::OK->value);

        $this->assertDatabaseHas('cart_items', [
            'product_variant_id' => $productVariant->id
        ]);
    }

    public function test_product_can_be_added_again_in_cart(): void
    {
        $user = User::factory()->create();

        $productVariant = ProductVariant::factory()->create();

        $this->actingAs($user)->postJson(route('cart.store'), [
            'product_variant_id' => $productVariant->id,
            'quantity' => 1
        ]);

        $response = $this->actingAs($user)->postJson(route('cart.store'), [
            'product_variant_id' => $productVariant->id,
            'quantity' => 1
        ]);

        $response->assertStatus(HttpStatus::OK->value);

        $this->assertDatabaseHas('cart_items', [
            'product_variant_id' => $productVariant->id,
            'quantity' => 2
        ]);
    }

    public function test_product_can_be_updated_in_cart(): void
    {
        $user = User::factory()->create();

        $cart = Cart::create(['user_id' => $user->id]);

        $productVariant = ProductVariant::factory()->create();

        CartItem::create([
            'cart_id' => $cart->id,
            'product_variant_id' => $productVariant->id,
            'quantity' => 1
        ]);

        $response = $this->actingAs($user)->patchJson(route('cart.update', $cart->id), [
            'product_variant_id' => $productVariant->id,
            'quantity' => 5
        ]);

        $response->assertStatus(HttpStatus::OK->value);

        $this->assertDatabaseHas('cart_items', [
            'product_variant_id' => $productVariant->id,
            'quantity' => 5
        ]);
    }

    public function test_product_can_be_deleted_from_cart(): void
    {
        $productVariant = ProductVariant::factory()->create();

        $user = User::factory()->create();

        $cart = Cart::create(['user_id' => $user->id]);

        CartItem::create([
            'cart_id' => $cart->id,
            'product_variant_id' => $productVariant->id,
            'quantity' => 1
        ]);

        $response = $this->actingAs($user)->deleteJson(route('cart.destroy', $cart->id), [
            'product_variant_id' => $productVariant->id
        ]);

        $response->assertStatus(HttpStatus::OK->value);

        $this->assertDatabaseMissing('cart_items', [
            'cart_id' => $cart->id,
            'product_variant_id' => $productVariant->id
        ]);
    }

    /**
     * @throws Exception
     */
    public function test_guest_cart_can_merge_with_user_cart(): void
    {
        $productVariant = ProductVariant::factory()->create();
        $user = User::factory()->create();

        $userCart = Cart::create(['user_id' => $user->id]);
        CartItem::create([
            'cart_id' => $userCart->id,
            'product_variant_id' => $productVariant->id,
            'quantity' => 1
        ]);

        $sessionId = 'session_id_1234';
        $guestCart = Cart::create(['session_id' => $sessionId]);
        CartItem::create([
            'cart_id' => $guestCart->id,
            'product_variant_id' => $productVariant->id,
            'quantity' => 1
        ]);

        $mergeGuestCartAction = app(MergeGuestCartAction::class);
        $mergeGuestCartAction->handle($user->id, $sessionId);

        $this->assertDatabaseHas('cart_items', [
            'cart_id' => $userCart->id,
            'product_variant_id' => $productVariant->id,
            'quantity' => 2
        ]);
    }
}
