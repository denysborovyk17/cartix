<?php declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Option;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class OptionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $colors = Option::create(['name' => 'Color']);
        $sizes = Option::create(['name' => 'Size']);

        $colors->values()->createMany([
            ['value' => 'Black'],
            ['value' => 'White'],
            ['value' => 'Red'],
            ['value' => 'Green'],
            ['value' => 'Yellow'],
            ['value' => 'Blue'],
            ['value' => 'Brown'],
            ['value' => 'Orange'],
            ['value' => 'Pink'],
            ['value' => 'Purple'],
            ['value' => 'Grey']
        ]);

        $sizes->values()->createMany([
            ['value' => 'S'],
            ['value' => 'M'],
            ['value' => 'L']
        ]);
    }
}
