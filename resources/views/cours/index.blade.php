@extends('layouts.trame', ['title' => 'users list'])

@section('content')

<div class="d-flex justify-content-center">
    <h1 class="text-center">Liste des cours</h1>
</div>

<div class="row justify-content-center">
    <div class="col-md-10 d-flex justify-content-between">
        <div>
        <form method="post" action="{{route('cours.search')}}" >
            @csrf
            <input type="text" name="search" placeholder="intitulé">
            <input type="submit" name="valider" value="rechercher">
        </form>
        </div>
        <a href="{{ route('cours.create') }}" class="btn btn-sm btn-primary">Ajouter</a>

    </div>
</div>
<div class="row justify-content-center mt-4">
    <div class="col-md-10">
        <table class="table table-striped">
            <thead>
              <tr>
                <th scope="col">#</th>
                <th scope="col">Intitule</th>
                <th scope="col">Created_at</th>
                <th scope="col">Updated_at</th>
                <th scope="col">Actions</th>
                <th scope= "col">Présences </th>
              </tr>
            </thead>
            <tbody>
                @php
                    $i = 0
                @endphp
                @forelse ($cours as $cours)
                @php
                    $i++
                @endphp
                    <tr>
                        <th scope="row">{{ $i }}</th>
                        <td>{{ $cours->intitule }}</td>
                        <td>{{ $cours->created_at }}</td>
                        <td>{{ $cours->updated_at }}</td>

                        
                         @if(Auth::user()->type == 'gestionnaire')

                         @if(isset($cours1_id))
                         <td>
                               <a class="btn btn-secondary" href= "{{route('paste.associations',$cours->id)}}"> Coller associations </a>
                         </td>
                         @else
                        <td> 
                                <div class="btn-group">
                                    <button type="button" class="btn btn-warning dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    Enseignants
                                </button>
                                <div class="dropdown-menu">
                                    <a class="dropdown-item" href= "{{route('enseignant.index', $cours->id)}}">Liste</a>
                                    <a class="dropdown-item" href= "{{route('enseignant.inscription', $cours->id)}}">Ajout enseignant</a>
                                </div>
                                </div>
                               <div class="btn-group">
                                <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    Séances
                                </button>
                                <div class="dropdown-menu">
                                    <a class="dropdown-item" href= "{{route('seances.index', $cours->id)}}">Liste</a>
                                    <a class="dropdown-item" href= "{{route('seance.create', $cours->id)}}">Créer une séance</a>
                                </div>
                                </div>
                                <div class="btn-group">
                                    <button type="button" class="btn btn-danger dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    Etudiants
                                </button>
                                <div class="dropdown-menu">
                                    <a class="dropdown-item" href= "{{route('etudiant.index', $cours->id)}}">Liste</a>
                                    <a class="dropdown-item" href= "{{route('etudiant.inscription', $cours->id)}}">Associer étudiant</a>
                                </div>
                                </div>
                                 <a class="btn btn-secondary" href= "{{route('copy.associations', $cours->id)}}"> Copier Asso</a>

                                
                        </td>
                        @endif
                        <td>
                             <a class="btn btn-info" href= "{{route('presences.cours',$cours->id)}}"> Liste de pointage</a>
                         </td>
                        @endif
                        @if(Auth::user()->type == 'enseignant')
                        <td> 
                            <a class="btn btn-sm btn-secondary" href= "{{route('etudiant.index', $cours->id)}}"> Etudiants</a>
                            <a class="btn btn-sm btn-secondary" href= "{{route('seances.index', $cours->id)}}"> Séances</a>
                        </td>
                       
                        @endif
                        @if(Auth::user() ->type == 'admin')
                        <td>
                            <a href= "{{route('cours.delete', $cours->id)}}" class="btn btn btn-danger" > Supprimer</a>
                            <a href= "{{route('cours.edit', $cours->id)}}" class="btn btn btn-primary" > Modifier</a>

                        </td>
                        @endif
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center">
                            Aucun cours enregistré
                        </td>
                    </tr>
                @endforelse
            </tbody>
          </table>
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