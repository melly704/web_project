@extends('layouts.trame', ['title' => 'users list'])

@section('content')

<div class="d-flex justify-content-center">
    <h1 class="text-center">Liste des cours</h1>
</div>

<div class="row justify-content-center">
    <div class="col-md-10 d-flex justify-content-between">
        <div></div>
        <a href="{{ route('cours.create') }}" class="btn btn-sm btn-primary">Ajouter</a>
    </div>
</div>
<div class="row justify-content-center mt-4">
    <div class="col-md-10">
        <table class="table table-striped">
            <thead>
              <tr>
                <th scope="col">#</th>
                <th scope="col">Intitule</th>
                <th scope="col">Created_at</th>
                <th scope="col">Updated_at</th>
                <th scope="col">Présences</th>
              </tr>
            </thead>
            <tbody>
                @php
                    $i = 0
                @endphp
                @forelse ($cours as $cours)
                @php
                    $i++
                @endphp
                    <tr>
                        <th scope="row">{{ $i }}</th>
                        <td>{{ $cours->intitule }}</td>
                        <td>{{ $cours->created_at }}</td>
                        <td>{{ $cours->updated_at }}</td>
                        <td>{{$total[$cours->id]}}/{{$nb_seances[$cours->id]}}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center">
                            Aucun cours enregistré
                        </td>
                    </tr>
                @endforelse
            </tbody>
          </table>
    </div>
</div>
<div class="row justify-content-center mt-4">

</div>
@endsection
@section('scripts')
<script>
    function deleteUser(){
        return confirm('Voulez vraiment supprimer?');
    }
 </script>
 
@endsection