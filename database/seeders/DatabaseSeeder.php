<?php declare(strict_types=1);

namespace Database\Seeders;

use App\Models\{Brand, Product, User};
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory()->create([
            'name' => 'Denys',
            'email' => 'denys@mail.com',
        ]);

        $this->call([
            CategorySeeder::class,
            OptionSeeder::class
        ]);

        Brand::factory()->count(10)->create();
        Product::factory()->withAllVariants()->count(100)->create();
        Product::factory()->withOptions()->withAllVariants()->count(100)->create();
    }
}
