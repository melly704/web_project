@extends('layouts.trame', ['title' => 'students list'])
@section('content')

<div class="d-flex justify-content-center">
    <h1 class="text-center">Liste des séances</h1>
</div>

<div class="row justify-content-center">
    <div class="col-md-10 d-flex justify-content-between">
        <div></div>
        <a href="{{ route('seance.create', $cours->id) }}" class="btn btn-sm btn-primary">Ajouter</a>
    </div>
</div>
<div class="row justify-content-center mt-4">
    <div class="col-md-10">
        <table class="table table-striped">
            <thead>
              <tr>
                <th scope="col">#</th>
                <th scope="col">Cours</th>
                <th scope="col">Date début</th>
                <th scope="col">Date fin</th>
                <th scope="col">Actions</th>
              </tr>
            </thead>
            <tbody>
                @php
                    $i = 0
                @endphp
                @forelse ($seances as $seance)
                @php
                    $i++
                @endphp
                    <tr>
                        <th scope="row">{{ $i }}</th>
                        <td>{{ $cours->intitule}}</td>
                        <td>{{ $seance->date_debut }}</td>
                        <td>{{ $seance->date_fin }}</td>
                        
                        @if(isset($etudiant_id))
                        @if(isset($group))
                        <td>
                        <a class="btn btn-sm btn-success" href= "{{route('presences.group.seance',[ $cours->id, $seance->id])}}"> Selectionner</a>
                        </td>
                        @else
                       <td>
                         <a class="btn btn-sm btn-success" href= "{{route('etudiant.present.seance',[$etudiant_id, $cours->id, $seance->id])}}"> Selectionner</a>
                       </td>
                       @endif
                        @else
                         @if(Auth::user()->type == 'enseignant' || Auth::user()->type == 'gestionnaire'  )
                       <td>
                        <a class="btn btn-sm btn-info" href= "{{route('presences.index',$seance->id)}}"> Liste de pointage</a>
                        @if(Auth::user()->type == 'gestionnaire')
                        <a  class="btn btn-sm btn-secondary" href= "{{route('seance.edit', [$seance->id, $cours->id])}}"> Modifier</a>
                        <a  class="btn btn-sm btn-danger" href= "{{route('seance.delete', [$seance->id, $cours->id])}}"> Supprimer</a>
                        @endif
                       </td>
                       @endif
                        @endif
                    </tr>
                    
                @empty
                    <tr>
                        <td colspan="6" class="text-center">
                            Aucune seance pour ce cours
                        </td>
                    </tr>
                @endforelse
            </tbody>
          </table>
    </div>
</div>
<div class="row justify-content-center mt-4">

</div>
{{$seances->links()}}
@endsection
@section('scripts')
<script>
    function deleteUser(){
        return confirm('Voulez vraiment supprimer?');
    }
 </script>
 
@endsection