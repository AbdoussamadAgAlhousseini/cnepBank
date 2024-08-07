<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;


class CompteFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'numero_compte' => $this->faker->bankAccountNumber,
            'solde' => $this->faker->randomFloat(2, 100, 10000),
        ];
    }
}
