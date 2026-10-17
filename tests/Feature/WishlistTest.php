<?php declare(strict_types=1);

namespace Tests\Feature;

use App\Enums\HttpStatus;
use App\Models\Product\ProductVariant;
use App\Models\User\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class WishlistTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_cannot_see_the_wishlist_page(): void
    {
        $response = $this->get(route('wishlist'));

        $response->assertStatus(HttpStatus::FOUND->value);
    }

    public function test_user_can_see_the_wishlist_page(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get(route('wishlist'));

        $response->assertStatus(HttpStatus::OK->value);
    }

    public function test_user_can_toggle_item_to_wishlist(): void
    {
        $user = User::factory()->create();

        $productVariant = ProductVariant::factory()->create();

        $createResponse = $this->actingAs($user)->post(route('wishlist.toggle', $productVariant->id));

        $createResponse->assertStatus(HttpStatus::OK->value);

        $this->assertDatabaseHas('wishlist_items', [
            'user_id' => $user->id,
            'product_variant_id' => $productVariant->id
        ]);

        $deleteResponse = $this->actingAs($user)->post(route('wishlist.toggle', $productVariant->id));

        $deleteResponse->assertStatus(HttpStatus::OK->value);

        $this->assertDatabaseMissing('wishlist_items', [
            'user_id' => $user->id,
            'product_variant_id' => $productVariant->id
        ]);
    }
}
