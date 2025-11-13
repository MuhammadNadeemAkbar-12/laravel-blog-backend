<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Step 1: Insert a role and get its ID
        $roleId = DB::table('roles')->insertGetId([
            'role_name' => 'Admin',
        ]);

        // Step 2: Insert a user linked to that role (foreign key)
        DB::table('users')->insert([
            'name' => 'John Doe',
            'email' => 'o@example.com',
            'password' => Hash::make('password'),
            'role_id' => $roleId, // foreign key
        ]);
    }
}
