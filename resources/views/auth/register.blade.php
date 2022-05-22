
@extends('layouts.trame', ['title' => 'Ajouter un utilisateur'])
@section('content')
<div class="row justify-content-center">
    <div class="col-md-6 mt-5">
        <div class="row">
            <div class="col-md-12">
                <h1 class="text-center">Nouvel utilisateur</h1>
            </div>
        </div>
        <form method="POST">
            @csrf
            <div class="form-group">
             Nom
              <input type="text" name="nom" class="form-control" id="nom" value="{{ old('nom') }}">
            </div>
            <div class="form-group">
            Prénom
              <input type="text" name="prenom" class="form-control" value="{{ old('prenom') }}" >
            </div>
            <div class="form-group">
             Login
              <input type="text" name="login" class="form-control"  value="{{ old('login') }}" >
            </div>
         
            <div class="form-group">
            Mot de passe
                <input type="password" name="mdp" class="form-control"  id="mdp">
            </div>
              <div class="form-group">
            Confirmation du mot de passe 
                <input type="password" name="mdp_confirmation" class="form-control" id="mdp_confirmation" placeholder="Confirmez le mot de passe">
              </div>
            
            <div class="d-flex justify-content-between">
                <button type="submit" class="btn btn-primary">Enregistrer</button>
            </div>
          </form>
    </div>
</div> 
@endsection
