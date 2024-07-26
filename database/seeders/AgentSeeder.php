<?php
use Illuminate\Database\Seeder;
use App\Models\Agent;

class AgentSeeder extends Seeder
{
    public function run()
    {
        Agent::factory()->count(10)->create();
    }
}
