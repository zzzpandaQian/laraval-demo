<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">

  <head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

{!! SEOMeta::generate() !!}

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Bootstrap core CSS -->
    <link rel='stylesheet' href="{{ asset('css/bootstrap.css') }}" type='text/css' media='all' />

    <!-- Swiper CSS -->
    <link rel='stylesheet' href="{{ asset('css/swiper.min.css') }}" type='text/css' media='all' />
    <link rel='stylesheet' href="{{ asset('css/animate.min.css') }}" type='text/css' media='all' />

    <!-- Custom fonts for this template -->
    <link rel='stylesheet' href="{{ asset('css/font-awesome.css') }}" type='text/css' media='all' />

    <!-- Custom styles for this template -->
    <link rel='stylesheet' href="{{ asset('css/custom.css') }}" type='text/css' media='all' />

    @yield('js-head')
  </head>

  <body id="page-top">


    @yield('header')

    @yield('content')

    @include('web.partials.footer')

    @yield('footer-bot')

    <!-- Bootstrap core JavaScript -->
    <script type='text/javascript' src="{{ asset('js/jquery.min.js') }}"></script>
    <script type='text/javascript' src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>

    <!-- Plugin JavaScript -->
    <script type='text/javascript' src="{{ asset('js/jquery.easing.min.js') }}"></script>

    <script type='text/javascript' src="{{ asset('js/jqBootstrapValidation.min.js') }}"></script>
    <script type='text/javascript' src="{{ asset('js/layer/layer.js') }}"></script>

    <!-- Swiper JavaScript -->
    <script type='text/javascript' src="{{ asset('js/swiper.min.js') }}"></script>
    <script type='text/javascript' src="{{ asset('js/swiper.animate.min.js') }}"></script>

    <!-- Custom scripts -->
    <script src="{{ asset('js/custom.js') }}"></script>

    @yield('js')

  </body>

</html>
