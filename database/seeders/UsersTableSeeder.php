<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            [
                'name' => 'Admin User',
                'email' => 'admin@example.com',
                'password' => Hash::make('password'),
                'role' => 'admin',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Agent User',
                'email' => 'agent@example.com',
                'password' => Hash::make('password'),
                'role' => 'agent',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Delivery User',
                'email' => 'delivery@example.com',
                'password' => Hash::make('password'),
                'role' => 'agent',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
