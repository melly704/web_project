@extends('layouts.trame', ['title' => 'Connexion'])

@section('content')
  <div class="row justify-content-center">
    <div class="col-md-6 mt-5">
        <div class="row">
            <div class="col-md-12">
                <h1 class="text-center">Connexion</h1>
            </div>
        </div>
        <form method="POST" action="{{ route('login') }}">
            @csrf
            <div class="form-group">
              <label for="login">Login</label>
              <input type="text" name="login" class="form-control @error('login') is-invalid @enderror" id="login" value="{{ old('login') }}" placeholder="Votre login">
                @error('login')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>
            <div class="form-group">
              <label for="password">Mot de passe</label>
              <input type="password" name="mdp" class="form-control @error('password') is-invalid @enderror" id="mdp" placeholder="Votre mot de passe">
            </div>
            
            <div class="d-flex justify-content-between">
                <button type="submit" class="btn btn-primary">Se connecter</button>
                <p><a href="{{ route('register') }}">Créer un compte</a></p>
            </div>
          </form>
    </div>
</div>  
@endsection
