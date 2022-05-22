<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Seance; 
use App\Models\Etudiant;
use App\Models\Cours;
class SeanceController extends Controller
{
    public function create($cours_id)
    {
        return view('seances.create', ['cours_id'=> $cours_id]);
    }

   
    public function store(Request $request, $cours_id)
    {
        $validated = $request->validate([
            'date_debut' => 'required|date', 
            'date_fin' => 'required|date', 
        ]);

        $seance = new Seance();
        $seance -> cours_id = $cours_id; 
        $seance-> date_debut= $request-> date_debut ; 
        $seance-> date_fin= $request-> date_fin ; 
        $seance-> save(); 
        $request->session()->flash('message', 'Seance entregistré');
        return redirect()->route('welcome');
    }
    public function presence(Request $request, $etudiant_id, $cours_id, $seance_id){
        $etudiant = Etudiant::findOrFail($etudiant_id);
        if($request->session()->get('presents')){
            $presents=$request->session()->get('presents');
            foreach($presents as $present){

                $e_id= $present[$cours_id];
            $e=Etudiant::findOrFail($e_id);
            $seance = Seance::findOrFail($seance_id);
            foreach($seance->etudiants as $presence){
            if($presence->id == $e->id){
            return back()->withErrors([
            'duplicate' => 'L\'étudiant a déjà été marqué présent',
        ]);
            }
        }
        $e -> seances()-> attach($seance);
            }
        }
    
        $seance = Seance::findOrFail($seance_id);
        foreach($seance->etudiants as $presence){
            if($presence->id == $etudiant->id){
            return back()->withErrors([
            'duplicate' => 'L\'étudiant a déjà été marqué présent',
        ]);
            }
        }
        $etudiant -> seances()-> attach($seance);
        $request->session()->flash('message', 'présence entregistrée');
        return redirect()->route('etudiant.index', $cours_id);
    }
    public function presences_index($seance_id){
        $seance = Seance::findOrFail($seance_id); 
        $presences= [];
        $absences = [];
        $cours = Cours::findOrFail($seance->cours_id);
        $i=0;
        foreach($cours->etudiants as $etudiant){
            foreach($seance -> etudiants as $present){
                if($etudiant->id==$present->id){
                    $i=1;
                    array_push($presences,$etudiant);
                } 
            }
            if($i==0){
                array_push($absences,$etudiant);
            }
            else{
                $i=0; 
            }
        }
        return view('seances.presences', ['presences'=>$presences, 'absences'=>$absences]); 
    }
    public function index($cours_id){
        $seances = Seance::where('cours_id', $cours_id)->paginate(4); 
        $cours = Cours::findOrFail($cours_id); 
        return view('seances.index', ['seances'=>$seances, 'cours'=> $cours]); 
    }
    public function presences_group($cours_id, Request $request){
        $cours = Cours::findOrFail($cours_id);
        if(isset($request->etudiants)){
        $etudiants = $request->etudiants;
        $seances = Seance::where('cours_id', $cours_id)->paginate(5);
        if($request->session()->has('presents')){
        $request->session()->forget('presents');
        $presents = $request->session()->get('presents',[]);
        
        } else{
        $presents = [];
        }
        foreach($etudiants as $etudiant_id){
        array_push($presents,  [$cours_id=>$etudiant_id]); 
        }
        $request->session()->put('presents', $presents);
        
        $group=true; 
         }else{
        return redirect()->back()->withErrors(['message' => 'Aucun étudiant n\' a été sélectionné']);

         }
        return view('seances.index', ['group'=>$group, 'seances'=>$seances, 'etudiant_id'=>$etudiant_id, 'cours'=>$cours]); 
        }
    public function presences_group_seance(Request $request,$cours_id, $seance_id){
        $cours = Cours::findOrFail($cours_id); 
        $seance= Seance::findOrFail($seance_id); 
        $etudiants_ids = $request->session()->get('presents', []); 
        if($etudiants_ids!= []){
            foreach($etudiants_ids as $c_etudiant_id){
               $etudiant_id = $c_etudiant_id[$cours_id];
                 $etudiant = Etudiant::findorFail($etudiant_id);
                 $exist = false; 
                 foreach($seance->etudiants as $present){
                     if($present->id == $etudiant->id){
                          $exist = true;
                     }
                 }
                 if($exist==false){
                     $seance->etudiants()->attach($etudiant); 
                 }
            }
        }else{
             return redirect()->back()->withErrors(['message' => 'Aucun étudiant n\' a été sélectionné']);
        }
            $request->session()->flash('message', 'présence entregistrée');
            return redirect()->route('etudiant.index', $cours_id);
    }
           
    public function edit($seance_id, $cours_id)
    {
        $seance = Seance::findOrFail($seance_id); 
       // $this -> authorize('update', $user); 
        return view('seances.edit', ['seance'=>$seance, 'cours_id'=>$cours_id]);
    }

    public function update(Request $request, $seance_id,  $cours_id)
    {
        $validated = $request->validate([
            'date_debut' => 'required|date',
            'date_fin' => 'required|date',

        ]);
         $seance = Seance::findOrFail($seance_id); 
        $seance-> date_debut= $request-> date_debut; 
        $seance -> date_fin = $request -> date_fin;
        $seance-> cours_id = $cours_id; 
        $seance -> save();
        $request->session()->flash('message', 'Séance modifié');
        return redirect()->route('seances.index', $cours_id);

    }
    public function delete(Request $request, $seance_id, $cours_id){
        $seance = Seance::findOrFail($seance_id); 
        $cours = Cours::findOrFail($cours_id); 
        $etudiants = $seance -> etudiants; 
        foreach($etudiants as $e){
            $seance -> etudiants() -> detach($e);
        }
        $seance -> cours() -> dissociate();
        $seance -> delete();
        $request->session()->flash('message', 'Séance supprimée');
        return redirect()->route('seances.index', $cours_id);
    }
}