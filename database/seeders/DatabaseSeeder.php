<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Support\Facades\Hash;use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => Hash::make('12345678'),
            'role' => 'admin',
            'country' => 'USA',
            'mobile_no' => '73783738',
            'status' => '1',
        ]);

        User::create([
            'name' => 'Regular User',
            'email' => 'user@example.com',
            'password' => Hash::make('12345678'),
            'role' => 'user',
            'country' => 'Canada',
            'mobile_no' => '487848494',
            'status' => '1',
        ]);
    }
}
