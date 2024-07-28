<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Transaction;
use App\Models\Agent;
use App\Models\Agence;
use App\Models\Compte;


class AgenceFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            //
            'nom' => $this->faker->company,
            'solde' => $this->faker->randomFloat(2, 100, 10000),
            'adresse' => $this->faker->city,

        ];
    }
}
