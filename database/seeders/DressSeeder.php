<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Dress;

class DressSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $sizes = ['S', 'M', 'L', 'XL'];
        $categories = ['Wedding', 'Formal', 'Casual', 'Traditional'];
        $statuses = ['tersedia', 'tidak tersedia', 'perawatan'];

        for ($i = 1; $i <= 20; $i++) {
            Dress::create([
                'name' => 'Dress ' . $i,
                'size' => $sizes[array_rand($sizes)],
                'category' => $categories[array_rand($categories)],
                'stock' => rand(1, 10),
                'rental_price' => rand(50000, 200000),
                'status' => $statuses[array_rand($statuses)],
                'description' => "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed quis eros vitae enim dictum tempor et nec mauris. Integer viverra nec sem at dignissim. Integer sed hendrerit felis, ut faucibus sapien.",
                'image_path' => null,
            ]);
        }
    }
}
