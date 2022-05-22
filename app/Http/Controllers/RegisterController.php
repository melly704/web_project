<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;


class RegisterController extends Controller
{
    public function showForm(){
        return view('auth.register');
    }

    public function store(Request $request){
        $request->validate([
           'nom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'login' => 'required|string|max:255|unique:users',
            'mdp' => 'required|string|confirmed',
        ]);

        $user = new User();
        $user-> nom = $request -> nom; 
        $user-> prenom = $request-> prenom; 
        $user->login = $request->login;
        $user->mdp = Hash::make($request->mdp);
        $user -> save();
        session()->flash('etat','User added');
 
        Auth::login($user);

        return redirect(route('welcome'));   
    }
    
    
}
