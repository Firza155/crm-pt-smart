<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Database\Seeders\DefaultUserSeeder;
use Database\Seeders\ProductSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            DefaultUserSeeder::class,
            ProductSeeder::class,
        ]);
    }
}
