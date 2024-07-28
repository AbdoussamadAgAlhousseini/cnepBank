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
            'nom' => 'Agence 1',
            'adresse' => 'Baba Hassan',
            'directeur_id' => '1',
        ]);

        Agence::factory()->create([
            'nom' => 'Agence 2',
            'adresse' => 'Ouled Fayet',
            'directeur_id' => '2',
        ]);


        Agence::factory()->create([
            'nom' => 'Agence 3',
            'adresse' => 'Ben Aknoun',
            'directeur_id' => '3',
        ]);
    }
}
