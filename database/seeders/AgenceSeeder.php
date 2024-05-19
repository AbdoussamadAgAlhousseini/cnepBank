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
        ]);

        Agence::factory()->create([
            'nom' => 'Agence 2',
            'adresse' => 'Ouled Fayet',
        ]);


        Agence::factory()->create([
            'nom' => 'Agence 3',
            'adresse' => 'Ben Aknoun',
        ]);
    }
}
