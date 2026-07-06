<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            'name' => 'Admin',
            'email' => 'admin@gmail.com',
            'phone' => '01745191964',
            // password (already hashed in the provided screenshot)
            'password' => Hash::make(123456), // Hash the password
            'field' => 'Data Science',
            'role' => 2,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
