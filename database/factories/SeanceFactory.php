<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Seance; 
use App\Models\Cours; 
class SeanceFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
protected $model = Seance::class; 
    public function definition()
    {
        return [
            'cours_id'=> Cours::all()->random()->id,
            'date_debut'=> $this->faker-> dateTime(),
            'date_fin'=> $this-> faker -> dateTime(),
        ];
    }
}
