<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Lead;

class LeadsTableSeeder extends Seeder
{
    public function run()
    {
        Lead::create([
            'order_id' => 'ORD12345',
            'order_date' => '2024-07-10',
            'payment_method' => 'PayPal',
            'client' => 'Client 1',
            'product' => 'Product 1',
            'amount' => 100.00,
            'status' => 'active'
        ]);

    
    }
}
