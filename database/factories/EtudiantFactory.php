<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Etudiant;
class EtudiantFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
protected $model = Etudiant::class; 
    public function definition()
    {
        return [
            'nom' => $this->faker->firstName,
            'prenom' => $this->faker->lastName,
            'noet' => $this-> faker->randomNumber(), 
            'created_at' => $this->faker->dateTime(),
            'updated_at' => now(),
        ];
    }
}
