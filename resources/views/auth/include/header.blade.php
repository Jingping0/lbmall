<nav class="navbar navbar-expand-lg bg-light">
    <div class="container-fluid">
      <a class="navbar-brand" href="#">{{ config('app.name') }}</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarText">
        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
          <li class="nav-item">
            <a class="nav-link active" aria-current="page" href="#">Home</a>
          </li>
          @auth
          <li class="nav-item">
            <a class="nav-link" href="{{ route('logout') }}">Logout</a>
          </li> 
          @else
          <li class="nav-item">
            <a class="nav-link" href="{{ route('login') }}">Login</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="{{ route('registration') }}">Registration</a>
          </li>  
          @endauth         
        </ul>
        <span class="navbar-text">@auth {{ auth()->user()->username }}@endauth
          
        </span>
        </div>
      </div>
    </div>
  </nav>