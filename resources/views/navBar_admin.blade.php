<nav class="navbar navbar-expand-lg navbar-light" style="background-color: red">
  <a class="navbar-brand" href="#"><img src="/logo.png" alt="" width="50" height="30"></a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="navbarNavDropdown">
    <ul class="navbar-nav">
      <li class="nav-item active">
        <a class="nav-link" href="{{route('profile.edit')}}"> Profile</a>
 <span class="sr-only">(current)</span></a>
      </li>
      <li class="nav-item">
        <a class="nav-link"  href= "{{route('user.index')}}">Utilisateurs</a>
      </li>
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          Cours
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
          <a class="dropdown-item" href= "{{route('cours.index')}}">Liste</a>
          <a class="dropdown-item" href="{{ route('cours.create') }}">Créer un cours</a>
        </div>
      </li>
      <li class="nav-item">
        <a class="nav-link" href= "{{route('logout')}}">Déconnexion</a>
      </li>
    </ul>
  </div>
</nav>