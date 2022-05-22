@extends('layouts.trame', ['title' => 'students list'])
@section('content')

<div class="d-flex justify-content-center">
    <h1 class="text-center">Liste des étudiants</h1>
</div>

<div class="row justify-content-center">
    <div class="col-md-10 d-flex justify-content-between">
        <form method="post" action="{{route('etudiants.search')}}" >
            @csrf
            <input type="text" name="search" placeholder="l'étudiant">
            <input type="submit" name="valider" value="rechercher">
        </form>
        <a href="{{ route('etudiant.create') }}" class="btn btn-sm btn-primary">Ajouter</a>
    </div>
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
                <th scope="col">Présences</th>
                <th scope="col">Actions</th>
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
                           <a class="btn btn-primary" href= "{{route('presences.etudiant',[$etudiant->id])}}"> Détail</a>
                       </td>
                       <td> 
                           <a class="btn btn-info" href= "{{route('etudiant.edit', [$etudiant->id])}}"> Modifier </a>
                            <a class="btn btn-danger" href= "{{route('etudiant.delete', [$etudiant->id])}}"> Supprimer </a>

                       </td>
                        @if(isset($cours_id))
                        <td> 
                            <a class="btn btn-secondary" href= "{{route('etudiant.cours',[$etudiant->id, $cours_id])}}"> Inscrire au cours</a>
                        </td>
                        <td>

                            <div class="form-check">
                            <form method="POST" action="{{route('inscription.group', $cours_id)}}">
                             @csrf

                                <input class="form-check-input" type="checkbox" name="associations[]" value="{{$etudiant->id}}" id="flexCheckDefault">
                                <label class="form-check-label" for="flexCheckDefault">
                                    Associer
                                </label>
                            </div>
                        </td>


                       @endif

                       
                        
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
{{$etudiants->links()}}
@endsection
@section('scripts')
<script>
    function deleteUser(){
        return confirm('Voulez vraiment supprimer?');
    }
 </script>

@endsection