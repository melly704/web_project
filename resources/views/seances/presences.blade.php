@extends('layouts.trame', ['title' => 'students list'])
@section('content')

<div class="d-flex justify-content-center">
    <h1 class="text-center">Liste du pointage</h1>
</div>

<div class="row justify-content-center">
    <div class="col-md-10 d-flex justify-content-between">
        <div></div>
        <a href="{{ route('seance.create', $cours->id)) }}" class="btn btn-sm btn-primary">Ajouter</a>
    </div>
</div>
<div class="row justify-content-center mt-4">
    <div class="col-md-10">
        <table class="table table-striped">
            <thead>
              <tr>
                <th scope="col">Présences</th>
                <th scope="col">Absences</th>
              </tr>
            </thead>
            <tbody>
               <tr>
                   <td>
                       <table class="table table-striped">
                           <thead>
                               <tr>
                                    <th scope="col"> Nom </th>
                                    <th scope= "col"> Prénom </th>
                                    <th scope= "col"> Noet</th>
                               </tr>
                           </thead>
                           <tbody>
                               @foreach($presences as $presence)
                               <tr>
                                   <td> {{$presence -> nom}} </td>
                                   <td> {{$presence -> prenom}}</td>
                                   <td> {{$presence -> noet}} </td>
                               </tr>
                               @endforeach
                           </tbody>
                       </table>
                   </td>
                    <td>
                       <table class="table table-striped">
                           <thead>
                               <tr>
                                    <th scope="col"> Nom </th>
                                    <th scope= "col"> Prénom </th>
                                    <th scope= "col"> Noet</th>
                               </tr>
                           </thead>
                           <tbody>
                               @foreach($absences as $absence)
                               <tr>
                                   <td> {{$absence -> nom}} </td>
                                   <td> {{$absence  -> prenom}}</td>
                                   <td> {{$absence  -> noet}} </td>
                               </tr>
                               @endforeach
                           </tbody>
                       </table>
                   </td>
               </tr>
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