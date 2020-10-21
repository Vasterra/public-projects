<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Wholistically Healthy</title>
    <link rel="shortcut icon" href="favicon_16x.png">
    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <style>
        h2, .h2 {
            font-size: 1.0rem;
        }

        p {
            margin-top: 0;
            margin-bottom: 0;
        }

        .navbar-brand {
            font-size: 1rem;
        }

        .dropdown-menu {
            padding: 2px 19px;
        }
    </style>
</head>
<body>
<div id="app">
    <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
        <div class="container">
            <div class="row">
                <div class="col-md-4 col-sm-12">
                    <a href="{{ url('/') }}" style="width: 340px; margin-right: 40px;">
                        <img src="/logo.png" style="width: 100%;">
                    </a>
                </div>

            <div class="col-md-8 col-sm-12">
                <div style="float: left">
                    <a class="navbar-brand" href="{{route('roadwarriar')}}">Road Warriar</a>
                    <a class="navbar-brand" href="/orders">Orders</a>
                    <a class="navbar-brand" href="/products">Products</a>
                </div>

                <div style="float: left">
                    <button type="button" onclick="update()" style="margin-left: 5px; margin-right: 5px;">Update</button>

                    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
                            aria-controls="navbarSupportedContent" aria-expanded="false"
                            aria-label="{{ __('Toggle navigation') }}" style="margin-left: 5px; margin-right: 5px;">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                </div>

                <div class="dropdown" style="float: left">
                    <a type="button" class="navbar-brand" id="dropdownMenuButton" data-toggle="dropdown"
                       aria-haspopup="true" aria-expanded="false">
                        Print Labels ▼
                    </a>
                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                        <a class="navbar-brand" href="{{route('allpdf')}}" target="_blank">Print all labels</a>
                        <a class="navbar-brand" href="{{route('allpdfcurrent')}}" target="_blank">
                            Print labels: {{date("d.m.Y", strtotime('monday last week +9 hour'))}} - {{date("d.m.Y", strtotime('monday this week +9 hour'))}}
                        </a>
                        <a class="navbar-brand" href="{{route('allpdfnext')}}" target="_blank">
                            Print labels: {{date("d.m.Y", strtotime('monday this week +9 hour'))}} - {{date("d.m.Y", strtotime('monday next week +9 hour'))}}
                        </a>
                    </div>
                </div>

                <div class="dropdown" style="float: left">
                    <a type="button" class="navbar-brand" id="dropdownCookButton" data-toggle="dropdown"
                       aria-haspopup="true" aria-expanded="false">
                        Cook ▼
                    </a>
                    <div class="dropdown-menu" aria-labelledby="dropdownCookButton">
                        <a class="navbar-brand" href="/cook">Cook All</a><br>
                        <a class="navbar-brand" href="/cookcurrent">
                            Cook: {{date("d.m.Y", strtotime('monday last week +9 hour'))}} - {{date("d.m.Y", strtotime('monday this week +9 hour'))}}
                        </a>
                        <a class="navbar-brand" href="/cooknext">
                            Cook: {{date("d.m.Y", strtotime('monday this week +9 hour'))}} - {{date("d.m.Y", strtotime('monday next week +9 hour'))}}
                        </a>
                        <a class="navbar-brand" href="/cookdecomposition">Cook All decomposition</a>
                        <a class="navbar-brand" href="/cookcurrentdecomposition">
                            Cook decomposition: {{date("d.m.Y", strtotime('monday last week +9 hour'))}} - {{date("d.m.Y", strtotime('monday this week +9 hour'))}}
                        </a>
                        <a class="navbar-brand" href="/cooknextdecomposition">
                            Cook decomposition: {{date("d.m.Y", strtotime('monday this week +9 hour'))}} - {{date("d.m.Y", strtotime('monday next week +9 hour'))}}
                        </a>
                    </div>
                </div>

                <div class="collapse navbar-collapse" id="navbarSupportedContent" style="float: left">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav mr-auto">

                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <!-- Authentication Links -->
                        @guest
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                            </li>
                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                                </li>
                            @endif
                        @else
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button"
                                   data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }} <span class="caret"></span>
                                </a>

                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                          style="display: none;">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
            </div>
        </div>
    </nav>

    <main class="py-4">
        @yield('content')
    </main>
</div>
<script>
    function update() {
        window.location.reload();
    }
    setInterval(update, 1800000);
</script>
</body>
</html>
