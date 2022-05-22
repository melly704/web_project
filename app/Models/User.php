<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Models\Cours; 

class User extends Authenticatable
{
    use HasFactory;
    
    public $timestamps = false;

    protected $hidden = ['mdp'];

    protected $fillable = 
    ['login', 
     'mdp', 
     'type'];

    protected $attributes = [
        'type' => NULL
    ];


     public function getAuthPassword(){
        return $this->mdp;
    }
    public function cours(){
        return $this->belongsToMany(Cours::class, 'cours_users', 'user_id', 'cours_id');
    }

    public function isAdmin(){
        return $this-> type == 'admin'; 
    }
    public function isGestionnaire(){
        return $this-> type == 'gestionnaire'; 
    }
    public function isTeacher(){
        return $this-> type == 'enseignant'; 
    }
    public function isConfirmed(){
        return $this-> type != NULL; 
    }
}
