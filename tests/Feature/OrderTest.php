<?php declare(strict_types=1);

namespace Tests\Feature;

use App\Enums\HttpStatus;
use App\Models\Order\Order;
use App\Models\User\User;
use App\Models\Cart\{Cart, CartItem};
use App\Models\Product\ProductVariant;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class OrderTest extends TestCase
{
    use RefreshDatabase;

    public function test_checkout_page_can_be_rendered(): void
    {
        $response = $this->get(route('checkout'));

        $response->assertStatus(HttpStatus::FOUND->value);
    }

    public function test_user_can_create_the_order(): void
    {
        $user = User::factory()->create();

        $cart = Cart::create([
            'user_id' => $user->id
        ]);

        $productVariant = ProductVariant::factory()->create();

        CartItem::create([
            'cart_id' => $cart->id,
            'product_variant_id' => $productVariant->id,
            'quantity' => 1
        ]);

        $order = [
            'first_name' => 'Name',
            'last_name' => 'Surname',
            'email' => 'namesurname@mail.com',
            'phone' => '+380671111111',
            'city' => 'Kyiv',
            'address' => 'Nova Poshta #2',
            'notes' => 'I\'m waiting' ?? ''
        ];

        $response = $this->actingAs($user)->post(route('checkout.store'), $order);

        $response->assertStatus(HttpStatus::FOUND->value);

        $this->assertDatabaseHas('orders', ['email' => $order['email']]);
        $this->assertDatabaseHas('order_items', ['product_variant_id' => $productVariant->id]);
    }

    public function test_payment_page_can_be_rendered(): void
    {
        $user = User::factory()->create();

        $order = Order::factory()->create();

        $this->withSession(['order_id' => $order->id]);

        $response = $this->actingAs($user)->get(route('orders.payment', $order->id));

        $response->assertStatus(HttpStatus::OK->value);
    }

    public function test_user_can_pay_for_the_order(): void
    {
        $user = User::factory()->create();

        $cart = Cart::create([
            'user_id' => $user->id
        ]);

        $productVariant = ProductVariant::factory()->create();

        CartItem::create([
            'cart_id' => $cart->id,
            'product_variant_id' => $productVariant->id,
            'quantity' => 1
        ]);

        $orderData = [
            'first_name' => 'Name',
            'last_name' => 'Surname',
            'email' => 'namesurname@mail.com',
            'phone' => '+380671111111',
            'city' => 'Kyiv',
            'address' => 'Nova Poshta #2',
            'notes' => 'I\'m waiting' ?? ''
        ];

        $this->actingAs($user)->post(route('checkout.store'), $orderData);

        $orderId = session('order_id');

        $order = Order::where('id', $orderId)->firstOrFail();

        $paymentData = [
            'card_last4' => '4242424242424242'
        ];

        $this->actingAs($user)->post(route('orders.payment.complete', $order->id), $paymentData);

        $this->assertDatabaseHas('payments', [
            'order_id' => $order->id,
            'card_last4' => substr($paymentData['card_last4'], -4)
        ]);
    }
}
