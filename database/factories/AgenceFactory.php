<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Transaction;
use App\Models\Agent;
use App\Models\Agence;
use App\Models\Compte;


/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Models\Agence>
 */
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
            'adresse' => $this->faker->city,
        ];
    }
}
