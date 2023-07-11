<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for ($i = 1; $i < 4; $i++) {
            Product::create([
                "name" => "Produk-" . $i + 1,
                "price" => 1000 . $i + 1,
                "quantity" => 1000 . $i + 1
            ]);
        }
    }
}
