@extends('layouts.trame', ['title' => 'Create a course'])

@section('content')
<div class="row justify-content-center">
    <div class="col-md-6 mt-5">
        <div class="row">
            <div class="col-md-12">
                <h1 class="text-center">Nouveau cours</h1>
            </div>
        </div>
        <form method="POST" action="{{ route('cours.store') }}">
            @csrf
            <div class="form-group">
              <label for="intitule">Intitulé</label>
              <input type="text" name="intitule" class="form-control" id="intitule">
            <div class="d-flex justify-content-between">
                <button type="submit" class="btn btn-primary">Enregistrer</button>
                <a href="{{ route('welcome') }}" class="btn btn-danger">Retour</a>
            </div>
          </form>
    </div>
</div> 
@endsection