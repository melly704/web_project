<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Cours; 

class CoursFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
protected $model = Cours::class; 
    public function definition()
    {
        return [
            'intitule' => $this->faker -> word, 
            'created_at' => $this-> faker -> dateTime(), 
            'updated_at' => now(),
        ];
    }
}
