<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        Product::insert([
            [
                'product_name' => 'Internet Home 20 Mbps',
                'speed'        => 20,
                'price'        => 250000,
                'created_at'   => now(),
                'updated_at'   => now(),
            ],
            [
                'product_name' => 'Internet Home 50 Mbps',
                'speed'        => 50,
                'price'        => 400000,
                'created_at'   => now(),
                'updated_at'   => now(),
            ],
            [
                'product_name' => 'Internet Home 100 Mbps',
                'speed'        => 100,
                'price'        => 650000,
                'created_at'   => now(),
                'updated_at'   => now(),
            ],
            [
                'product_name' => 'Internet Business 100 Mbps',
                'speed'        => 100,
                'price'        => 850000,
                'created_at'   => now(),
                'updated_at'   => now(),
            ],
            [
                'product_name' => 'Internet Business 200 Mbps',
                'speed'        => 200,
                'price'        => 1200000,
                'created_at'   => now(),
                'updated_at'   => now(),
            ],
        ]);
    }
}
