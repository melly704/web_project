<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cours;

class CoursController extends Controller
{
     public function create()
    {
        return view('cours.create');
    }

   
    public function store(Request $request)
    {
        $validated = $request->validate([
            'intitule' => 'required|string|unique:cours', 
        ]);

        $cours = new Cours();
        $cours-> intitule= $request-> intitule ; 
        
        $cours-> save(); 
        $request->session()->flash('message', 'Cours enregistré');
        return redirect()->route('cours.index');
    }

    public function index(){
        $cours = Cours::all(); 
        return view('cours.index', ['cours'=> $cours]); 
    }

    public function cours_enseignant(){
        $enseignant = Auth()->user();
        $cours = [];
        foreach($enseignant->cours as $c){
            array_push($cours, $c);
        }
        return view('cours.index', ['cours'=>$cours]);
    }
    public function copy(Request $request,$cours1_id){
        $cours_one = Cours::findOrFail($cours1_id); 
        $cours = Cours::all(); 
        $session = $request-> session(); 
        $associations = $session -> get('associations', []); 
        $etudiants = $cours_one-> etudiants;
        $session -> put('associations', $etudiants); 

        $cours_one = Cours::findOrFail($cours1_id); 
        
        return view('cours.index', ['cours'=>$cours, 'cours1_id'=> $cours1_id]); 
    }
    public function paste(Request $request,  $cours2_id){
        $session = $request -> session(); 
        $cours_two  = Cours::findOrFail($cours2_id); 
        $associations = $session -> get('associations');
        foreach ($associations as $etudiant){
            $cours_two -> etudiants() -> attach($etudiant); 
        }
        $request->session()->flash('message', 'Associations copiées');
        return redirect()->route('cours.index');
    }
    public function search(Request $request){
        $recherche = $request -> search;
        $cours = Cours::where('intitule', 'like', '%'.$recherche.'%')->paginate(5);
        return view('cours.index',['cours'=>$cours]); 

    }
    public function delete(Request $request, $cours_id){
        $cours = Cours::findOrFail($cours_id);
        foreach($cours->etudiants as $etudiant){
            $etudiant -> cours() -> detach($cours); 
        }
        foreach($cours->users as $user){
            $user -> cours()->detach($cours); 
        }
        foreach($cours-> seances as $seance){
        $seance -> cours() -> dissociate();
        $seance -> delete();
        }
        $cours->delete(); 
        $request->session()->flash('message', 'cours supprimé');
        return redirect()->route('cours.index');

    }
    public function edit($id){
        $cours = Cours::findOrFail($id);
        return view('cours.edit', ['cours'=>$cours]); 
    }

    public function update(Request $request, $id){
            $validated = $request->validate([
            'intitule' => 'required|string',
        ]);

        $cours = Cours::findOrFail($id); 
        $cours-> intitule= $request-> intitule ;  
        $cours -> save(); 



        $request->session()->flash('message', 'Cours modifié');
        return redirect()->route('cours.index');
    }
}

