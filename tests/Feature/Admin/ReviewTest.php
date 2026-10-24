<?php declare(strict_types=1);

namespace Tests\Feature\Admin;

use App\Enums\HttpStatus;
use App\Models\Product\Review;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Tests\Traits\CreatesAdminTrait;

class ReviewTest extends TestCase
{
    use RefreshDatabase, CreatesAdminTrait;

    public function test_the_edit_review_page_can_be_rendered(): void
    {
        $review = Review::factory()->create();

        $response = $this->actingAs($this->asAdmin())->get(route('admin.reviews.edit', $review->id));

        $response->assertStatus(HttpStatus::OK->value);
    }

    public function test_admin_can_edit_a_review(): void
    {
        $review = Review::factory()->create();

        $data = [
            'comment' => 'Updated text'
        ];

        $response = $this->actingAs($this->asAdmin())->patch(route('admin.reviews.update', $review->id), $data);

        $response->assertStatus(HttpStatus::FOUND->value);

        $this->assertDatabaseMissing('reviews', [
            'id' => $review->id,
            'comment' => $review->comment
        ]);
    }

    public function test_admin_can_delete_a_review(): void
    {
        $review = Review::factory()->create();

        $response = $this->actingAs($this->asAdmin())->delete(route('admin.reviews.destroy', $review->id));

        $response->assertStatus(HttpStatus::FOUND->value);

        $this->assertDatabaseMissing('reviews', ['id' => $review->id]);
    }
}
