<?php declare(strict_types=1);

namespace Tests\Feature;

use App\Models\Product\Product;
use App\Services\SlugService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SlugTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic feature test example.
     */
    public function test_slug_is_generated_correct(): void
    {
        $slugService = new SlugService();

        $this->assertEquals('iphone-17', $slugService->generateUnique('iPhone 17', new Product()));

        Product::create([
            'name' => 'iPhone 17',
            'slug' => 'iphone-17',
            'is_active' => true
        ]);

        $this->assertEquals('iphone-17-1', $slugService->generateUnique('iPhone 17', new Product()));
    }
}
