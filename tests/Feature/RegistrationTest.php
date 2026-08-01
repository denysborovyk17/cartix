<?php declare(strict_types=1);

namespace Tests\Feature;

use App\Enums\HttpStatus;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RegistrationTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic feature test example.
     */
    public function test_a_user_can_be_created(): void
    {
        $userData = [
            'name' => 'John Doe',
            'email' => 'johndoe@mail.com',
            'password' => '111111111111',
            'password_confirmation' => '111111111111'
        ];

        $response = $this->post(route('register.store'), $userData);

        $response->assertStatus(HttpStatus::FOUND->value);

        $this->assertDatabaseHas('users', ['email' => $userData['email']]);
    }
}
