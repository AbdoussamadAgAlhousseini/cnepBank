<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Agent;
use App\Models\Agence;

class AgentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $agences = Agence::all();

        foreach ($agences as $agence) {
            Agent::factory(5)->create([
                'agence_id' => $agence->id,
            ]);
        }
    }
}
