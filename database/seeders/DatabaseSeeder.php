<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use App\Models\User;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // --- Seed Users ---
        User::factory()->createMany([
            [
                'name' => 'Admin User',
                'email' => 'admin@spectrum.com',
                'role' => '1',
                'password' => Hash::make('admin123'),
            ],
            [
                'name' => 'Admin PPIC',
                'email' => 'adminppic@spectrum.com',
                'role' => '3',
                'password' => Hash::make('admin123'),
            ]
        ]);

        // --- Seed Divisis ---
        $divisis = [
            'JANFAR',
            'SAWING',
            'CUTTING',
            'BENDING',
            'PRESS',
            'RACKING',
            'ROLL FORMING',
            'SPOT WELDING',
            'WELDING ACCESORIS',
            'WELDING SHOFITING 1',
            'WELDING SHOFITING 2',
            'WELDING DOOR',
        ];

        foreach ($divisis as $divisi) {
            DB::table('divisis')->insert([
                'divisi' => $divisi,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
