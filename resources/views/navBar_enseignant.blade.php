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
        <a class="nav-link"  href = "{{route('cours.enseignant')}}">Mes cours</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href= "{{route('logout')}}">Déconnexion</a>
      </li>
    </ul>
  </div>
</nav>