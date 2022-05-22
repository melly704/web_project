<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User; 
use App\Models\Etudiant; 
use App\Models\Cours; 
use App\Models\Seance; 

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $users= User::factory(25)->create();
        $cours = Cours::factory(10)-> create(); 
        $seances = Seance::factory(25)-> create();
        $etudiants = Etudiant::factory(50)-> create();
        $cours-> each(function($cours) use ($users){
            $cours -> users() -> attach($users->random(rand(0, 2)));
        });
        $cours-> each(function($cours) use ($etudiants){
            $cours -> etudiants() -> attach($etudiants-> random(rand(0,2)));
        });
        $cours-> each(function($seances) use ($etudiants){
            $seances -> etudiants() -> attach($etudiants -> random(rand(0,2)));
        });
    }
    
}
