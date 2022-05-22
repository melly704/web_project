@extends('layouts.trame', ['title' => 'Create a student'])

@section('content')
<div class="row justify-content-center">
    <div class="col-md-6 mt-5">
        <div class="row">
            <div class="col-md-12">
                <h1 class="text-center">Nouvel étudiant</h1>
            </div>
        </div>
        <form method="POST" action="{{ route('etudiant.store') }}">
            @csrf
            <div class="form-group">
              <label for="nom">Nom</label>
              <input type="text" name="nom" class="form-control @error('nom') is-invalid @enderror" id="nom" value="{{ old('nom') }}">
                @error('nom')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>
            <div class="form-group">
              <label for="nom">Prénom</label>
              <input type="text" name="prenom" class="form-control @error('prenom') is-invalid @enderror" value="{{ old('prenom') }}" >
                @error('prenom')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>
            <div class="form-group">
              <label for="nom">Numéro étudiant</label>
              <input type="number" name="noet" class="form-control @error('noet') is-invalid @enderror"  value="{{ old('noet') }}" >
             
            </div>
            
            <div class="d-flex justify-content-between">
                <button type="submit" class="btn btn-primary">Enregistrer</button>
                <a href="{{ route('user.index') }}" class="btn btn-danger">Retour</a>
            </div>
          </form>
    </div>
</div> 
@endsection