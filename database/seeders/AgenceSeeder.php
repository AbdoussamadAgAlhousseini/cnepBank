<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Agence;

class AgenceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Agence::factory()->create([
            'nom' => 'Agence Baba Hassan',
            'adresse' => 'Baba Hassan',
            'directeur_id' => '1',
        ]);

        Agence::factory()->create([
            'nom' => 'Agence CNEP Sidi YAhia',
            'adresse' => 'Hydra',
            'directeur_id' => '2',
        ]);


        Agence::factory()->create([
            'nom' => 'CNEP Ben Aknoun',
            'adresse' => 'Ben Aknoun',
            'directeur_id' => '3',
        ]);
    }
}
