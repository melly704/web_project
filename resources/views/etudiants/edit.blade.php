@extends('layouts.trame', ['title' => 'Modifier un étudiant'])

@section('content')
<div class="row justify-content-center">
    <div class="col-md-6 mt-5">
        <div class="row">
            <div class="col-md-12">
                <h1 class="text-center">Modifier un étudiant</h1>
            </div>
        </div>
        <form method="POST" action="{{ route('etudiant.update', $etudiant->id) }}">
            @csrf
            <div class="form-group">
              <label for="nom">Nom</label>
              <input type="text" name="nom" class="form-control @error('nom') is-invalid @enderror" id="nom" value="{{ old('nom')??$etudiant->nom}}" placeholder="Nom">

            </div>
            <div class="form-group">
              <label for="nom">Prénom</label>
              <input type="text" name="prenom" class="form-control @error('prenom') is-invalid @enderror" id="nom" value="{{ old('prenom')??$etudiant->prenom }}" placeholder="Prénom">
            </div>
            <div class="form-group">
              <label for="nom">Noet</label>
              <input type="number" name="noet" class="form-control @error('noet') is-invalid @enderror" id="noet" value="{{ old('noet')??$etudiant->noet }}" placeholder="Noet">
            </div>
             
            
            <div class="d-flex justify-content-between">
                <button type="submit" class="btn btn-primary">Enregistrer</button>
                <a href="{{ route('etudiants.index_all') }}" class="btn btn-danger">Retour</a>
            </div>
          </form>
    </div>
</div> 
@endsection