@extends('layouts.trame', ['title' => 'users list'])
@section('content')

<div class="d-flex justify-content-center">
    <h1 class="text-center">Liste des utilisateurs</h1>
</div>
<div class="d-flex justify-content-center">
    @if (session()->has('message'))
        <div class="alert alert-success text-center mt-4">
            {{ session()->get('message') }}
        </div>
    @endif
</div>
<div class="row justify-content-center">
    <div class="col-md-10 d-flex justify-content-between">
        <div>
        <a href="{{ route('user.create') }}" class="btn btn-sm btn-primary">Ajouter</a>
        <form method="post" action="{{route('users.search')}}" >
            @csrf
            <input type="text" name="search" placeholder="recherche">
            <input type="submit" name="valider" value="rechercher">
        </form>
        </div>
      
        <div class="dropdown">
             <button class="btn btn-primary btn-lg dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Filtrer par type
            </button>
            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                        <a href="{{ route('enseignants.index_type') }}" class="dropdown-item">Enseignants</a>
                        <a href="{{route('gestionnaires.index_type')}}" class="dropdown-item" >Gestionnaires</a>
             </div>
        </div>
    </div>
</div>
<div class="row justify-content-center mt-4">
    <div class="col-md-10">
        <table class="table table-striped">
            <thead>
              <tr>
                <th scope="col">#</th>
                <th scope="col">Nom</th>
                <th scope="col">Prenom</th>
                <th scope="col">login</th>
                <th scope="col">Type</th>
                <th scope="col">Actions</th>
              </tr>
            </thead>
            <tbody>
                @php
                    $i = 0
                @endphp
                @forelse ($users as $user)
                @php
                    $i++
                @endphp
                    <tr>
                        <th scope="row">{{ $i }}</th>
                        <td>{{ $user->nom }}</td>
                        <td>{{ $user->prenom }}</td>
                        <td>{{ $user->login }}</td>
                        <td>{{ $user->type }}</td>
                        @if($user -> type == NULL)
                        <td>
                        <a class="btn btn-sm btn-primary" href="{{ route('user.edit', $user->id)}}">Accepter</a>
                        <a class="btn btn-sm btn-danger" href="{{ route('user.deny', $user->id) }}">Refuser</a>
                        </td>
                        @endif
                        <td>
                        <a class="btn btn-info" href="{{ route('user.edit', $user->id) }}">Modifier</a>
                        <a class="btn btn-danger" href="{{ route('user.delete', $user->id) }}">Supprimer</a>


                        </td>
                        
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center">
                            Aucun utilisateur enregistré
                        </td>
                    </tr>
                @endforelse
            </tbody>
          </table>
    </div>
</div>
<div class="row justify-content-center mt-4">

</div>
{{$users->links()}}
@endsection
@section('scripts')
<script>
    function deleteUser(){
        return confirm('Voulez vraiment supprimer?');
    }
 </script>
 
@endsection