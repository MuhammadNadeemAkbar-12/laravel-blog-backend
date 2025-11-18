<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UsersSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('users')->insert([
            [
                'role_id' => 1, // User
                'name' => 'John Doe',
                'email' => 'john@example.com',
                'email_verified_at' => now(),
                'password' => Hash::make('123'),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'role_id' => 2, // Admin
                'name' => 'Admin User',
                'email' => 'admin@example.com',
                'email_verified_at' => now(),
                'password' => Hash::make('123'),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'role_id' => 3, // Super Admin
                'name' => 'Super Admin',
                'email' => 'superadmin@example.com',
                'email_verified_at' => now(),
                'password' => Hash::make('123'),
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
