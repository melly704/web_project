@extends('layouts.trame')

@section('content')

@auth
@if(Auth::user()->isConfirmed())
Bonjour {{Auth::user()->login}}
@else
 <h1> Your count is not yet confirmed by the admin </h> 
@endif  
@endauth
@guest
<div class="row justify-content-center mt-4">
    <div class="col-md-10">
<a href="{{route('login')}}"> Connexion </a>
<a href= "{{route('register')}}"> Inscription </a> 
    </div>
</div>
@endguest
@endsection