<?php declare(strict_types=1);

namespace Tests\Feature;

use App\Enums\HttpStatus;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RegistrationTest extends TestCase
{
    use RefreshDatabase;

    public function test_registration_page_can_be_rendered(): void
    {
        $response = $this->get(route('register'));

        $response->assertStatus(HttpStatus::OK->value);
    }

    public function test_new_users_can_register(): void
    {
        $user = [
            'name' => 'John Doe',
            'email' => 'johndoe@mail.com',
            'password' => '111111111111',
            'password_confirmation' => '111111111111'
        ];

        $response = $this->post(route('register.store'), $user);

        $response->assertStatus(HttpStatus::FOUND->value);

        $this->assertDatabaseHas('users', ['email' => $user['email']]);

        $this->assertAuthenticated();

        $response->assertRedirect(route('index'));
    }
}
