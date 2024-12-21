<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'role' => 'admin',
            'name' => 'Mark',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('12345678'),
            'city' => 'New York',
            'mobile_number' => '0310828828',
            'user_token' => '9d8a3ee4d0579ab18e8c28feb38e52708a394b2e08a1098c952952b58f5b43b1',
        ]);

        User::create([
            'role' => 'superAdmin',
            'name' => 'Super Admin',
            'email' => 'superadmin@gmail.com',
            'password' => Hash::make('12345678'),
            'city' => 'New York',
            'mobile_number' => '0880008828',
            'user_token' => '9d8a3ee110579ab18e8c28feb38e52708a394b2e08a1098c952952b58f5b43b1',
        ]);

        User::create([
            'role' => 'member',
            'name' => 'Member',
            'email' => 'member@gmail.com',
            'password' => Hash::make('12345678'),
            'city' => 'Los Angeles',
            'mobile_number' => '12345678',
            'user_token' => '1a2b3c4d5e6f7g8h9i0j1k2l3m4n5o6p7q8r9s0t1u2v3w4x5y6z7a8b9c0d1e2f',
        ]);
    }
}
