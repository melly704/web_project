@extends('layouts.trame', ['title' => 'Modifier un utilisateur'])
@section('content')
<div class="row justify-content-center">
    <div class="col-md-6 mt-5">
        <div class="row">
            <div class="col-md-12">
                <h1 class="text-center">Modifier un utilisateur</h1>
            </div>
        </div>
        <form method="POST" action="{{ route('user.update', $user->id) }}">
            @csrf
            <div class="form-group">
              <label for="nom">Nom</label>
              <input type="text" name="nom" class="form-control @error('nom') is-invalid @enderror" id="nom" value="{{ old('nom')??$user->nom}}" placeholder="Nom">

            </div>
            <div class="form-group">
              <label for="nom">Prénom</label>
              <input type="text" name="prenom" class="form-control @error('prenom') is-invalid @enderror" id="nom" value="{{ old('prenom')??$user->prenom }}" placeholder="Prénom">
            </div>
            <div class="form-group">
              <label for="nom">Login</label>
              <input type="text" name="login" class="form-control @error('login') is-invalid @enderror" id="login" value="{{ old('login')??$user->login }}" placeholder="login">
            </div>
            <div class="form-group">
                <label for="type">Role</label>
                <select class="form-control @error('login') is-invalid @enderror" id="type" name="type">
                  <option value="enseignant" {{ old('type') == 'enseignant'?"select":'' }}>enseignant</option>
                  <option value="gestionnaire" {{ old('type') == 'gestionnaire'?"select":'' }}>gestionnaire</option>
                  <option value="admin" {{ old('type') == 'admin'?"select":'' }}>admin</option>
                </select>
                @error('type')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
              </div>
             
            
            <div class="d-flex justify-content-between">
                <button type="submit" class="btn btn-primary">Enregistrer</button>
                <a href="{{ route('user.index') }}" class="btn btn-danger">Retour</a>
            </div>
          </form>
    </div>
</div> 
@endsection