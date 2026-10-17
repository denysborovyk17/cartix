<?php declare(strict_types=1);

namespace Tests\Feature;

use App\Enums\HttpStatus;
use App\Models\User\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthenticationTest extends TestCase
{
    use RefreshDatabase;

    public function test_register_page_can_be_rendered(): void
    {
        $response = $this->get(route('register'));

        $response->assertStatus(HttpStatus::OK->value);
    }

    public function test_guest_can_register(): void
    {
        $user = [
            'name' => 'Elon Musk',
            'email' => 'elonmusk@mail.com',
            'password' => '111111111111',
            'password_confirmation' => '111111111111'
        ];

        $response = $this->postJson(route('register.store'), $user);

        $response->assertStatus(HttpStatus::FOUND->value);

        $this->assertDatabaseHas('users', ['email' => $user['email']]);

        $this->assertAuthenticated();

        $response->assertRedirect(route('index'));
    }

    public function test_login_page_can_be_rendered(): void
    {
        $response = $this->get(route('login'));

        $response->assertStatus(HttpStatus::OK->value);
    }

    public function test_users_can_authenticate_using_the_login_page(): void
    {
        $user = User::factory()->create([
            'password' => '111111111111'
        ]);

        $response = $this->post(route('login.attempt'), [
            'email' => $user->email,
            'password' => '111111111111'
        ]);

        $this->assertAuthenticated();

        $response->assertRedirect(route('index'));
    }

    public function test_users_can_not_authenticate_with_invalid_password(): void
    {
        $user = User::factory()->create();

        $this->post(route('login.attempt'), [
            'email' => $user->email,
            'password' => 'invalid_password'
        ]);

        $this->assertGuest();
    }

    public function test_users_can_logout(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post(route('logout'));

        $this->assertGuest();

        $response->assertRedirect(route('index'));
    }
}
