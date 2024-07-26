<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ClientsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('clients')->insert([
            [
                'client_id' => 'C001',
                'full_name' => 'John Doe',
                'phone' => '1234567890',
                'email' => 'johndoe@example.com',
                'address' => '123 Main St',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'client_id' => 'C002',
                'full_name' => 'Jane Smith',
                'phone' => '0987654321',
                'email' => 'janesmith@example.com',
                'address' => '456 Elm St',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'client_id' => 'C003',
                'full_name' => 'Alice Johnson',
                'phone' => '1122334455',
                'email' => 'alicejohnson@example.com',
                'address' => '789 Oak St',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'client_id' => 'C004',
                'full_name' => 'Bob Brown',
                'phone' => '6677889900',
                'email' => 'bobbrown@example.com',
                'address' => '101 Pine St',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'client_id' => 'C005',
                'full_name' => 'Charlie Davis',
                'phone' => '2233445566',
                'email' => 'charliedavis@example.com',
                'address' => '202 Cedar St',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
