<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Transaction;
use App\Models\Agent;
use App\Models\Compte;

class TransactionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $agents = Agent::all();

        foreach ($agents as $agent) {
            Transaction::factory(100)->create([
                'agent_id' => $agent->id,
                'agence_id' => $agent->agence_id,
                'compte_id' => Compte::factory()->create()->id,
            ]);
        }
    }
}
