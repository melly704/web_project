<!DOCTYPE html>
<head>
    <meta charset="utf-8">
    <title>@yield('title')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css"
    rel="stylesheet"
    integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl"
    crossorigin="anonymous">
    <link rel="stylesheet"  href="//netdna.bootstrapcdn.com/bootstrap/3.1.1/css/bootstrap.min.css">
</head>
<body>
    <style>
        body{
                margin:0px;
                background-color: white;
                background-size: cover;
                background-image: url("upec.jpg");
                filter: brightness(1);
               
                font-size: 20px;
                font-weight: bold; 
        }
    </style>
    @auth
    @if(Auth::user()->type == 'admin')
    @include('navBar_admin')
    @endif
    @if(Auth::user()->type == 'gestionnaire')
    @include('navBar_gestionnaire')
    @endif
    @if(Auth::user()->type == 'enseignant')
    @include('navBar_enseignant')
    @endif
    @endauth
    @yield('content')

    @if( session()->has('etat'))
        <p class="etat">{{session()->get('etat')}}</p>

    @endif
        @if (session()->has('message'))
        <div class="alert alert-success text-center mt-4">
            {{ session()->get('message') }}
        </div>
    @endif
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-b5kHyXgcpbZJO/tY9Ul7kGkf1S0CWuKcCD38l8YkeH8z8QjE0GmW1gYU5S9FOnJ0"
    crossorigin="anonymous">
    </script>
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
    <script src="//netdna.bootstrapcdn.com/bootstrap/3.1.1/js/bootstrap.min.js"></script>



    @if ($errors->any())
        <div class="error">
            <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
            </ul>
        </div>
    @endif

</body>
</html>