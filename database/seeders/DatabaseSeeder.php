<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Agence;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        \App\Models\User::factory(4)->create();


        $this->call([
            AgenceSeeder::class,
            AgentSeeder::class,
            CompteSeeder::class,
            TransactionSeeder::class,
        ]);
    }
}
