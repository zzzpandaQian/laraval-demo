<!-- Navigation -->
<nav class="navbar navbar-expand-md navbar-dark fixed-top bg-dark fixed-top" id="mainNav">
  <a class="navbar-brand" href="{{ route('home') }}"><img class="img-fluid" src="{{ asset('images/logo.png') }}" alt=""></a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
    aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav mr-auto">
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">新闻</a>
        <div class="dropdown-menu" aria-labelledby="dropdown06">
          <a class="dropdown-item js-scroll-trigger" href="{{ route('news') }}#news">新闻中心</a>
          <a class="dropdown-item" href="{{ route('news2') }}">新闻列表 V2</a>
        </div>
      </li>
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">案例</a>
        <div class="dropdown-menu" aria-labelledby="dropdown06">
          <a class="dropdown-item js-scroll-trigger" href="{{ route('portfolio') }}">案例列表</a>
        </div>
      </li>
      <li class="nav-item">
        <a class="nav-link js-scroll-trigger" href="{{ route('home') }}#services">Services</a>
      </li>
      <li class="nav-item">
        <a class="nav-link js-scroll-trigger" href="{{ route('example.modals') }}">Portfolio</a>
      </li>
      <li class="nav-item">
        <a class="nav-link js-scroll-trigger" href="{{ route('about') }}">About</a>
      </li>
      <li class="nav-item">
        <a class="nav-link js-scroll-trigger" href="{{ route('home') }}#team">Team</a>
      </li>
      <li class="nav-item">
        <a class="nav-link js-scroll-trigger" href="{{ route('home') }}#contact">Contact</a>
      </li>
      <li class="nav-item">
        <a class="nav-link js-scroll-trigger" href="{{ route('faqs') }}">FAQ</a>
      </li>
      @if(!request()->user())
        <li class="nav-item">
          <a class="nav-link js-scroll-trigger" href="{{ route('login') }}">登录</a>
        </li>
        <li class="nav-item">
          <a class="nav-link js-scroll-trigger" href="{{ route('register') }}">注册</a>
        </li>
      @else
        <li class="nav-item">
          <a class="nav-link js-scroll-trigger" href="{{ route('user.index') }}">{{ request()->user()->name }}</a>
        </li>
        <li class="nav-item">
          <a class="nav-link js-scroll-trigger" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"><i class="flaticon-exit-to-app-button mr-1"></i>退出</a>
          <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
              {{ csrf_field() }}
          </form>
        </li>
      @endif
    </ul>
    <form class="form-inline my-2 my-lg-0">
      <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search">
      <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
    </form>
  </div>
</nav>
