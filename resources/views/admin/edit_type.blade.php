@extends('layouts.trame', ['title' => 'type update'])
@section('content')
<div class="row justify-content-center">
    <div class="col-md-6 mt-5">
        <div class="row">
            <div class="col-md-12">
                <h1 class="text-center">Mettre à jour le type</h1>
            </div>
        </div>
        <form method="POST" action="{{ route('user.update', $user->id) }}">
            @csrf
            <div class="form-group">
                <label for="type">Type</label>
                <select class="form-control" id="type" name="type">
                  <option value="enseignant" {{ old('type') == 'enseignant'?"select":'' }}>enseignant</option>
                  <option value="gestionnaire" {{ old('type') == 'gestionnaire'?"select":'' }}>gestionnaire</option>
                </select>
                @error('type')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>
             
            
            <div class="d-flex justify-content-between">
                <button type="submit" class="btn btn-primary">Enregistrer</button>
                <a href="{{route('welcome') }}" class="btn btn-danger">Retour</a>
            </div>
          </form>
    </div>
</div> 
@endsection