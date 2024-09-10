<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Agence;
use Illuminate\Support\Facades\Hash;

class AgentFactory extends Factory
{


    /**
     * Define the model's default state.
     * 
     * protected static ?string $password;
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nom' => $this->faker->lastName,
            'prenom' => $this->faker->firstName,
            'email' => $this->faker->unique()->safeEmail(),
            'agence_id' => Agence::factory(),
            'mot_de_passe' => Hash::make('password'),
            // Ensure the password is hashed
        ];
    }
}
