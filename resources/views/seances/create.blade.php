@extends('layouts.trame', ['title' => 'Create a seance'])

@section('content')
<div class="row justify-content-center">
    <div class="col-md-6 mt-5">
        <div class="row">
            <div class="col-md-12">
                <h1 class="text-center">Nouvelle seance</h1>
            </div>
        </div>
        <form method="POST" action="{{ route('seance.store', $cours_id) }}">
            @csrf
            <div class="form-group">
              <label for="date_debut">Date du début</label>
              <input type="datetime-local" name="date_debut" class="form-control" id="date_debut">
            </div>
            <div class="form-group">
              <label for="date_fin">Date de la fin</label>
              <input type="datetime-local" name="date_fin" class="form-control" id="date_fin">
            </div>

            <div class="d-flex justify-content-between">
                <button type="submit" class="btn btn-primary">Enregistrer</button>
                <a href="{{ route('welcome') }}" class="btn btn-danger">Retour</a>
            </div>
          </form>
    </div>
</div> 
@endsection