<?php declare(strict_types=1);

namespace Tests\Feature\Admin;

use App\Enums\HttpStatus;
use App\Enums\UserRole;
use App\Models\User\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Tests\Traits\CreatesAdminTrait;

class UserTest extends TestCase
{
    use RefreshDatabase, CreatesAdminTrait;

    public function test_the_create_user_page_can_be_rendered(): void
    {
        $response = $this->actingAs($this->asAdmin())->get(route('admin.users.create'));

        $response->assertStatus(HttpStatus::OK->value);
    }

    public function test_admin_can_create_a_user(): void
    {
        $user = [
            'name' => 'User',
            'email' => 'user@mail.com',
            'password' => '111111111111',
            'password_confirmation' => '111111111111',
            'role' => UserRole::USER->value
        ];

        $response = $this->actingAs($this->asAdmin())->post(route('admin.users.store'), $user);

        $response->assertStatus(HttpStatus::FOUND->value);

        $this->assertDatabaseHas('users', ['email' => $user['email']]);
    }

    public function test_the_edit_user_page_can_be_rendered(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($this->asAdmin())->get(route('admin.users.edit', $user->id));

        $response->assertStatus(HttpStatus::OK->value);
    }

    public function test_admin_can_edit_a_user(): void
    {
        $user = User::factory()->create([
            'email' => 'emailbefore@mail.com'
        ]);

        $data = [
            'name' => $user->name,
            'email' => 'emailafter@mail.com',
            'role' => UserRole::USER->value
        ];

        $response = $this->actingAs($this->asAdmin())->patch(route('admin.users.update', $user->id), $data);

        $response->assertStatus(HttpStatus::FOUND->value);

        $this->assertDatabaseHas('users', ['email' => $data['email']]);
    }

    public function test_admin_can_delete_a_user(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($this->asAdmin())->delete(route('admin.users.destroy', $user->id));

        $response->assertStatus(HttpStatus::FOUND->value);

        $this->assertDatabaseMissing('categories', ['id' => $user->id]);
    }
}
