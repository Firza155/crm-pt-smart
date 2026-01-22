<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class DefaultUserSeeder extends Seeder
{
    public function run(): void
    {
        User::firstOrCreate(
            ['email' => 'manager@ptsmart.test'],
            [
                'name' => 'Manager',
                'password' => Hash::make('password123'),
                'role' => 'manager',
            ]
        );

        User::firstOrCreate(
            ['email' => 'sales@ptsmart.test'],
            [
                'name' => 'Sales',
                'password' => Hash::make('password123'),
                'role' => 'sales',
            ]
        );
    }
}
