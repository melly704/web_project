@extends('layouts.trame', ['title' => 'teachers list'])
@section('content')

<div class="d-flex justify-content-center">
    <h1 class="text-center">Liste des enseignants</h1>
</div>

<div class="row justify-content-center">
    <div class="col-md-10 d-flex justify-content-between">
        <div></div>
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
                <th scope="col">Type</th>
                <th scope="col">Actions</th>
              </tr>
            </thead>
            <tbody>
                @php
                    $i = 0
                @endphp
                @forelse ($enseignants as $enseignant)
                @php
                    $i++
                @endphp
                    <tr>
                        <th scope="row">{{ $i }}</th>
                        <td>{{ $enseignant->nom }}</td>
                        <td>{{ $enseignant->prenom }}</td>
                        <td>{{ $enseignant->type }}</td>
                        @if(isset($cours_id))
                        <td>
                             <a class="btn btn-sm btn-secondary" href= "{{route('enseignant.cours',[$enseignant->id , $cours_id])}}"> Associer au cours </a>
                             <a class="btn btn-sm btn-danger" href= "{{route('enseignant.dettach',[$enseignant->id, $cours_id])}}"> Dessocier  </a>
                        
                        </td>  
                          
                        @endif
                        
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center">
                            Aucun Enseignant enregistré
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