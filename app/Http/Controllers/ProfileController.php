<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    public function edit(){
        $user= Auth::user();
        return view('profile.edit', ['user'=>$user]); 
    }
        public function update(Request $request){
            $user = Auth::user(); 
            $validated = $request->validate([
                'mdp' => 'confirmed',
                'nom' => 'string|max:255', 
                'prenom' => 'string|max:255', 
            ]);
            $user -> mdp =Hash::make($request->mdp);
            $user -> nom = $request -> nom; 
            $user ->prenom = $request -> prenom; 
            $user -> save(); 
            $request->session()->flash('message', 'Mot de passe modifié');
            return redirect()->route('welcome');
    
        }

}
