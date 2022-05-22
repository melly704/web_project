@extends('layouts.trame', ['title' => 'Create a user'])

@section('content')
<div class="row justify-content-center">
    <div class="col-md-6 mt-5">
        <div class="row">
            <div class="col-md-12">
                <h1 class="text-center">Nouvel utilisateur</h1>
            </div>
        </div>
        <form method="POST" action="{{ route('user.store') }}">
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
              <label for="nom">Login</label>
              <input type="text" name="login" class="form-control @error('login') is-invalid @enderror"  value="{{ old('login') }}" >
                @error('login')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
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
            <div class="form-group">
                <label for="password">Mot de passe</label>
                <input type="password" name="mdp" class="form-control @error('password') is-invalid @enderror" id="password" placeholder="Votre mot de passe">
                  @error('password')
                      <small class="text-danger">{{ $message }}</small>
                  @enderror
              </div>
              <div class="form-group">
                <label for="password_confirmation">Confirmez</label>
                <input type="password" name="mdp_confirmation" class="form-control @error('password_confirmation') is-invalid @enderror" id="password_confirmation" placeholder="Confirmez le mot de passe">
                  @error('password_confirmation')
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