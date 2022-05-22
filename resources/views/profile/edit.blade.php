@extends('layouts.trame', ['title' => 'Modifier le profile'])


@section('content')
<div class="row justify-content-center">
    <div class="col-md-6 mt-5">
        <div class="row">
            <div class="col-md-12">
                <h1 class="text-center">Modifier votre profile</h1>
            </div>
        </div>
        <form method="POST" action="{{ route('profile.update', $user->id) }}">
            @csrf
            <div class="form-group">
                <label for="type">Nom</label>
                <input type="text" name="nom" class="form-control" id="nom" value="{{old('nom')}}">
            </div>
            <div class="form-group">
                <label for="type">Prenom</label>
                <input type="text" name="prenom" class="form-control" id="prenom" value="{{old('prenom')}}">
            </div>
            <div class="form-group">
                <label for="type">Nouveau mot de passe</label>
                <input type="password" name="mdp" class="form-control" id="mdp">
              </div>
              <div class="form-group">
                <label for="password"> Confirmation du mot de passe</label>
                <input type="password" name="mdp_confirmation" class="form-control" id="mdp">
              </div>
             
            
            <div class="d-flex justify-content-between">
                <button type="submit" class="btn btn-primary">Enregistrer</button>
                <a href="{{route('welcome') }}" class="btn btn-danger">Retour</a>
            </div>
          </form>
    </div>
</div> 
@endsection