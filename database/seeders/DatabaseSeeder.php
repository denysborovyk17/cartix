<?php

namespace Database\Seeders;

use App\Models\Brand;
use App\Models\Product;
use App\Models\User;
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
            CategorySeeder::class
        ]);

        Brand::factory()->count(5)->create();
        Product::factory()->withVariants()->count(50)->create();
    }
}
