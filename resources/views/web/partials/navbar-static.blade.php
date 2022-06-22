<!-- Navigation -->
<nav class="navbar navbar-expand-md navbar-dark fixed-top bg-dark fixed-top" id="mainNav">
  <a class="navbar-brand" href="{{ route('home') }}"><img class="img-fluid" src="{{ asset('images/logo.png') }}" alt=""></a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
    aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav mr-auto">
      <li class="nav-item">
        <a class="nav-link js-scroll-trigger" href="{{ route('single-page') }}#services">Services</a>
      </li>
      <li class="nav-item">
        <a class="nav-link js-scroll-trigger" href="{{ route('single-page') }}#team">Team</a>
      </li>
      <li class="nav-item">
        <a class="nav-link js-scroll-trigger" href="{{ route('single-page') }}#contact">Contact</a>
      </li>
    </ul>
    <form class="form-inline my-2 my-lg-0">
      <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search">
      <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
    </form>
  </div>
</nav>
