<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use App\Models\Cours;

class UserController extends Controller
{
    public function index(){
        $users = User::paginate(10); 
        return view('users.index', ['users'=>$users]); 
    }
    public function edit_type($id){
        $user = User::findOrFail($id);  
        return view('admin.edit_type', ['user'=> $user]); 
    }
    public function update_type(Request $request, $id){
       $user = User::findOrFail($id); 
         if($request-> type == 'enseignant' || $request-> type == 'gestionnaire'){
             $user -> type = $request -> type;
             $user -> save();
            session()->flash('etat','User confirmed');
         }
       return redirect()->route('welcome'); 

    }
    public function deny($id){
        $user = User::findOrFail($id);
        $user -> delete();
        session()->flash('etat','User deleted');
        return redirect()->route('welcome');
    }
        public function create()
    {
        return view('users.create');
    }

   
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nom' => 'required',
            'prenom' => 'required|string',
            'login' => 'required|unique:users,login',
           'type' => 'exists:users,type',
            'mdp' => 'required|confirmed',
        ]);

        $user = new User; 
        $user-> nom= $request-> nom ; 
        $user -> prenom = $request -> prenom;
        $user -> login = $request -> login; 
        $user -> type = $request -> type; 
        $user -> mdp = Hash::make($request->mdp);
        $user -> save(); 



        $request->session()->flash('message', 'Utilisateur enregistré');
        return redirect()->route('user.index');
    }

    public function enseignant_inscription($cours_id){
        $enseignants = User::where('type', 'enseignant')->get();
        return view('users.enseignants.index_all', ['enseignants'=> $enseignants,'cours_id'=> $cours_id ]); 
    }

    public function enseignant_cours(Request $request, $enseignant_id, $cours_id){
        $enseignant = User::findOrFail($enseignant_id); 
        $cours = Cours::findOrFail($cours_id); 
        foreach($cours->users as $user){
            if($user->id==$enseignant->id){
                return redirect()->back()->withErrors(['message' => 'L\'enseignant est déjà associé à ce cours']);
            }
        }
        $enseignant -> cours() -> attach($cours);
        $request->session()->flash('message', 'Enseignant enregistré');
        return redirect()->route('cours.index');
    }
    public function index_enseignant($cours_id){
        $cours = Cours::findOrFail($cours_id); 
        $enseignants = []; 
        foreach($cours-> users as $user){
            if($user->type=='enseignant'){
            array_push($enseignants, $user);  
            }
        }
        return view('users.enseignants.index_all', ['enseignants'=> $enseignants, 'cours_id'=>$cours_id]); 
    }
    public function enseignant_dettach(Request $request, $enseignant_id, $cours_id){
        $enseignant = User::findOrFail($enseignant_id);
        $cours = Cours::findOrFail($cours_id);
        foreach($cours->users as $user){
            if($user-> type == 'enseignant' && $user->id == $enseignant -> id){
                $enseignant->cours()->detach($cours);
                 $request->session()->flash('message', 'Enseignant supprimé');
                  return redirect()->route('enseignant.index', $cours_id);
            }
        }
        return redirect()->back()->withErrors(['message' => 'L\'enseignant n\'est pas associé à ce cours']);
    }

    public function enseignants_index_type(){

        $enseignants = User::where('type', 'enseignant')->paginate(5); 

        return view('users.index', ['users'=>$enseignants]); 
    }
    public function gestionnaires_index_type(){
        $gestionnaires = User::where('type', 'gestionnaire')-> paginate(5); 
        return view('users.index', ['users'=>$gestionnaires]); 
    }
    public function search(Request $request){
        $recherche = $request -> search;
        $users = User::where('nom', 'like', '%'.$recherche.'%')->orWhere('prenom', 'like', '%'.$recherche.'%')->orWhere('login', 'like', '%'.$recherche.'%')->paginate(5);
        return view('users.index',['users'=>$users]); 

    }
    public function edit($user_id){
        $user = User::findOrFail($user_id);
        return view('users.edit', ['user'=>$user]); 
    }

    public function update(Request $request, $user_id){
            $validated = $request->validate([
            'nom' => 'required',
            'prenom' => 'required|string',
            'login' => 'required|string',
            'type' => 'exists:users,type',
        ]);

        $user = User::findOrFail($user_id); 
        $user-> nom= $request-> nom ; 
        $user -> prenom = $request -> prenom;
        $user -> login = $request -> login; 
        $user -> type = $request -> type; 
        $user -> save(); 



        $request->session()->flash('message', 'Utilisateur modifié');
        return redirect()->route('user.index');
    }
    
    public function delete(Request $request , $user_id){
        $user = User::findOrFail($user_id); 
        foreach($user -> cours as $cours){
            $user -> cours() -> detach($cours); 
        }
        $user -> delete(); 
        $request->session()->flash('message', 'Utilisateur suprimé');
        return redirect()->route('user.index');

    }
}
