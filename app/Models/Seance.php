<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Etudiant; 
use App\Models\Cours; 

class Seance extends Model
{
    use HasFactory;
    public $timestamps= false; 
    public function etudiants(){
        return $this-> belongsToMany(Etudiant::class, 'presences', 'seance_id', 'etudiant_id'); 
    }
    public function cours(){
        return $this -> belongsTo(Cours::class, 'cours_id'); 
    }
}
