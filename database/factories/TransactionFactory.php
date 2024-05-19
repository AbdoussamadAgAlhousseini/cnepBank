<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Faker\Generator as Faker;
use App\Models\Transaction;
use App\Models\Agent;
use App\Models\Agence;
use App\Models\Compte;


/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Models\Transaction>
 */
class TransactionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $type = $this->faker->randomElement(['retrait', 'versement']);

        // Utilise la valeur générée pour déterminer le montant de la transaction
        $montant = $type === 'retrait' ? -$this->faker->randomFloat(2, 10, 1000) : $this->faker->randomFloat(2, 10, 1000);

        return [
            'montant' => $montant,
            'type' => $type,
            'agent_id' => Agent::factory(),
            'agence_id' => Agence::factory(),
            'compte_id' => Compte::factory(),
            'created_at' => $this->faker->dateTimeBetween('-1 year', 'now'),
            'updated_at' => $this->faker->dateTimeBetween('-1 year', 'now'),
        ];
    }
}
