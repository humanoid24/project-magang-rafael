<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->createMany([
            [
                'name' => 'Admin User',
                'email' => 'admin@example.com',
                'role' => '1',
                'password' => Hash::make('admin123'),
            ],
            [
                'name' => 'Admin PPIC',
                'email' => 'adminppic@example.com',
                'role' => '3',
                'password' => Hash::make('admin123'),
            ],
            [
                'name' => 'Regular User',
                'email' => 'user@example.com',
                'role' => '2',
                'password' => Hash::make('123'),
            ],
        ]);
    }
}
