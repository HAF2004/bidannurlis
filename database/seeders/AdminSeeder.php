<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create admin user
        User::firstOrCreate(
            ['email' => 'admin@admin.com'],
            [
                'name' => 'Administrator',
                'password' => Hash::make('admin'),
                'role' => 'admin',
            ]
        );

        // Create bidan user for testing
        User::firstOrCreate(
            ['email' => 'bidan@bidan.com'],
            [
                'name' => 'Bidan Demo',
                'password' => Hash::make('bidan'),
                'role' => 'bidan',
            ]
        );
    }
}
