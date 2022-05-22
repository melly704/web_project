@extends('layouts.trame', ['title' => 'students list'])

@section('content')

<div class="d-flex justify-content-center">
    <h1 class="text-center">Liste des étudiants</h1>
</div>


<div class="row justify-content-center mt-4">
    <div class="col-md-10">
        <table class="table table-striped">
            <thead>
              <tr>
                <th scope="col">#</th>
                <th scope="col">Nom</th>
                <th scope="col">Prenom</th>
                <th scope="col">Noet</th>
                <th scope="col">Actions</th>
                <th scope="col">Totaux présences</th>
              </tr>
            </thead>
            <tbody>
                @php
                    $i = 0
                @endphp
                @forelse ($etudiants as $etudiant)
                @php
                    $i++
                @endphp
                    <tr>
                        <th scope="row">{{ $i }}</th>
                        <td>{{ $etudiant->nom }}</td>
                        <td>{{ $etudiant->prenom }}</td>
                        <td>{{ $etudiant->noet }}</td>
                       <td>
                            @if(Auth::user()->type == 'gestionnaire')
                                 <a class="btn btn-sm btn-warning" href="{{route('etudiant.detach',[$etudiant->id, $cours_id])}}"> Dessocier</a>
                                              
                           
                            <div class="form-check">
                            <form method="POST" action="{{route('dessociations.group', $cours_id)}}">
                             @csrf

                                <input class="form-check-input" type="checkbox" name="dessociations[]" value="{{$etudiant->id}}" id="flexCheckDefault">
                                <label class="form-check-label" for="flexCheckDefault">
                                    Dessocier
                                </label>
                            </div>
                            @else
                         <a class="btn btn-sm btn-success" href= "{{route('etudiant.present',[$etudiant->id, $cours_id])}}"> pointage individuel</a>
                         <div class="form-check form-switch">
                            <form method="POST" action="{{route('presences.group', $cours_id)}}">
                                @csrf
                            <input class="form-check-input" type="checkbox" name='etudiants[]' value="{{$etudiant->id}}"id="flexSwitchCheckDefault">
                            <label class="form-check-label" for="flexSwitchCheckDefault">present</label>
                         </div>
                         @endif
                       </td>
                       <td>
                          
                           {{$totaux[$etudiant->id]}}/{{$nb_seances}}
                        <td>
                       
                        
                    </tr>
                    
                @empty
                    <tr>
                        <td colspan="6" class="text-center">
                            Aucun étudiant enregistré
                        </td>
                    </tr>
                @endforelse
            </tbody>
          </table>
        <div class="row justify-content-end">
       <button type="submit" class="btn btn-primary">Enregistrer</button>
        </div>
         
           </form>
  
    </div>
</div>
<div class="row justify-content-center mt-4">

</div>
@endsection
@section('scripts')
<script>
    function deleteUser(){
        return confirm('Voulez vraiment supprimer?');
    }
 </script>
 
@endsection