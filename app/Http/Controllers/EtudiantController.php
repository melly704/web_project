<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Etudiant; 
use App\Models\Cours; 
use App\Models\Seance;

class EtudiantController extends Controller
{
    public function create()
    {
        return view('etudiants.create');
    }

   
    public function store(Request $request)
    {
        $validated = $request->validate([
            
            'nom' => 'required',
            'prenom' => 'required|string', 
            'noet' => 'required|Integer|unique:etudiants',
        ]);

        $etudiant = new Etudiant();
        $etudiant -> nom= $request-> nom ; 
        $etudiant -> prenom= $request-> prenom ; 
        $etudiant -> noet= $request-> noet ; 
        $etudiant-> save(); 
        $request->session()->flash('message', 'Etudiant enregistré');
        return redirect()->route('welcome');
    }
    public function inscription($cours_id){
        $etudiants = Etudiant::paginate(10);
        return view ('etudiants.index_all', ['etudiants'=> $etudiants, 'cours_id'=>$cours_id]); 
    }
    public function etudiant_cours(Request $request, $etudiant_id, $cours_id){
        $etudiant = Etudiant::findOrFail($etudiant_id); 
        $cours = Cours::findOrFail($cours_id); 
        $etudiant -> cours() -> attach($cours);
        $request->session()->flash('message', 'Etudiant enregistré');
        return redirect()->route('cours.index');
    }
    public function index($cours_id){
        $cours = Cours::findOrFail($cours_id); 
        $seances = Seance::where('cours_id', $cours_id)->get();
        $etudiants = []; 
        $nb_seances=0;
        $totaux = [];
        $presences = 0; 

        foreach($cours-> etudiants as $etudiant){ 
            array_push($etudiants, $etudiant);  
        }
        foreach($etudiants as $etudiant){
            $presences= 0;
          foreach($seances as $seance){
            foreach($seance->etudiants as $present){
            if($present->id == $etudiant-> id){
                $presences++;
            }
        } 
            }
         $totaux[$etudiant->id]=$presences;
        }


        foreach($seances as $seance){
           if($seance->date_debut<date('Y-m-d h:i:s a', time())){
              $nb_seances ++;
            }
        }
    

        return view('etudiants.index', ['nb_seances'=>$nb_seances, 'totaux'=>$totaux, 'etudiants'=> $etudiants, 'cours_id'=>$cours_id]); 
    }

   public function presence($etudiant_id, $cours_id){
        $seances = Seance::where('cours_id',$cours_id)->paginate(5);
        $cours = Cours::findOrFail($cours_id);
        return view('seances.index', ['seances'=>$seances, 'etudiant_id'=>$etudiant_id, 'cours'=>$cours]); 
    }
    
    public function index_all(){
        $etudiants = Etudiant::paginate(10);
        return view('etudiants.index_all', ['etudiants'=>$etudiants]);
    }

    public function search(Request $request){
        $recherche = $request -> search;
        $etudiants = Etudiant::where('nom', 'like', '%'.$recherche.'%')->orWhere('prenom', 'like', '%'.$recherche.'%')->paginate(5);
        return view('etudiants.index_all',['etudiants'=>$etudiants]); 
    }
    public function presences_etudiant($etudiant_id){
        $cours = [];
        $total = [];
        $etudiant = Etudiant::findOrFail($etudiant_id);
        $nb_seances= [];
        
        foreach($etudiant->cours as $c){
            array_push($cours, $c); 
        }
        foreach($cours as $c){
             $i=0;
             $presences= 0;
          foreach($c->seances as $seance){
            foreach($seance->etudiants as $present){
            if($present->id == $etudiant_id){
                $presences++;
            }
        } 
        $total[$c->id]= $presences;
        if($seance->date_debut<date('Y-m-d h:i:s a', time())){
        $i++; 
        }
    }
     $nb_seances [$c->id]= $i;
    }
        return view('cours.index_etudiant', ['cours'=>$cours,'total'=>$total,'nb_seances'=>$nb_seances ]);
    }
    public function presences_cours($cours_id){
        $cours = Cours::findOrFail($cours_id);
        $etudiants = [];
        $nb_seances =0;
        $totaux = [];
        
        foreach($cours -> etudiants as $etudiant){
             $presences=0;
             $exist =0;
            foreach($cours -> seances as $seance){
                foreach($seance-> etudiants as $present){
                    if($present->id == $etudiant->id){
                        array_push($etudiants, $etudiant);
                        $presences++;
                        }
                 
                   
                    }
                }
            $totaux[$etudiant->id]= $presences;
        }
        foreach($cours->seances as $seances){
            if($seances->date_debut<date('Y-m-d h:i:s a', time())){
             $nb_seances++;
            }
        }
        return view ('etudiants.index',['nb_seances'=>$nb_seances, 'totaux'=>$totaux, 'etudiants'=> $etudiants, 'cours_id'=>$cours_id]);  
    }


       
    public function edit($etudiant_id)
    {
        $etudiant = Etudiant::findOrFail($etudiant_id); 
       // $this -> authorize('update', $user); 
        return view('etudiants.edit', ['etudiant'=>$etudiant]);
    }

    public function update(Request $request, $etudiant_id)
    {
        $validated = $request->validate([
            'nom' => 'required',
            'prenom' => 'sometimes|string',
            'noet' => 'required|integer',

        ]);
         $etudiant = Etudiant::findOrFail($etudiant_id); 
        $etudiant-> nom= $request-> nom ; 
        $etudiant -> prenom = $request -> prenom;
        $etudiant -> noet = $request -> noet; 
        $etudiant -> save();
        $request->session()->flash('message', 'Etudiant modifié');
        return redirect()->route('etudiants.index_all');

    }
    public function delete(Request $request , $id){
        $etudiant = Etudiant::findOrFail($id); 
        $cours = $etudiant -> cours;
        foreach ($cours as $c){
            $etudiant-> cours()-> detach($c);
        }
        $seances = $etudiant -> seances; 
        foreach( $seances as $presence){
            $etudiant -> seances() -> detach ($presence); 
        }
        
        $etudiant -> delete(); 
        $request->session()->flash('message', 'Etudiant supprimé');
        return redirect()->route('etudiants.index_all');

    }

    public function inscription_group(Request $request,$cours_id){
        $associations= $_POST['associations'];
        $cours = Cours::findOrFail($cours_id); 
        foreach($associations as $key=>$etudiant_id){
            $etudiant = Etudiant::findOrFail($etudiant_id); 
            $exist = false; 
             
            foreach($cours->etudiants as $inscrit){
                if($inscrit -> id == $etudiant_id){
                    $exist = true; 
                }
            }
            if($exist == false){
                $cours->etudiants()->attach($etudiant); 
            

            }
        }

         $request->session()->flash('message', 'Les étudiants ont été inscrits avec succés ');
        return redirect()->route('cours.index');
           
        
        
    }
    public function dessociations_group(Request $request,$cours_id){
        $dessociations= $_POST['dessociations'];
        $cours = Cours::findOrFail($cours_id); 
        foreach($dessociations as $key=>$etudiant_id){
            $etudiant = Etudiant::findOrFail($etudiant_id); 
                $cours->etudiants()->detach($etudiant); 

        }

         $request->session()->flash('message', 'Les étudiants ont déssociés du cours avec succés ');
        return redirect()->route('cours.index');
           
        
        
    }

    
    public function etudiant_detach(Request $request, $etudiant_id, $cours_id){
        $etudiant = Etudiant::findOrFail($etudiant_id);
        $cours = Cours::findOrFail($cours_id);
        foreach($cours->etudiants as $e){
            if($e->id == $etudiant -> id){
                $etudiant -> cours()->detach($cours);
            }
        }
        $request->session()->flash('message', 'Etudiant déssocié');
        return redirect()->route('etudiant.index', $cours_id);
    }
}