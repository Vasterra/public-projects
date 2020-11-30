<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

        <meta name="csrf-token" content="{{ csrf_token() }}">

        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
        <link rel="stylesheet" href="{{ asset('css/app.css') }}">
        <title>modellax</title>
    </head>
    <body class="bg_color">
    <div id="app">
        <div class="pt-3 pb-3 mb-5 bg-white top__line">
        	<div class="container">
                <div class="row align-items-center">
                    <div class="col-2"> 
                        <h1 class="h3 m-0 _red">modellax</h2>                        
                    </div>
                    <div class="col-7"> 
                        <data-select-company></data-select-company>
                    </div>
                    <div class="col-3">
    	            @if (Route::has('login'))
    	                <div class="text-right">
    	                    @auth
                                @if (Auth::user()->hasRole( config('app.roleAdmin')))
                                    <a href="{{ route('dashboard') }}" class="d-inline-block mr-3 _red">Dashboard</a>
                                @endif
                                @if (Auth::user()->hasRole( config('app.roleUser')))
                                    <span class="d-inline-block mr-3 font-italic _red">Hello, {{ Auth::user()->name }}!</span>
                                    <a href="{{ route('office') }}" class="d-inline-block mr-3 _red">{{ __('Office') }}</a>
                                    <form method="POST" action="{{ route('logout') }}" class="d-inline-block">
                                        @csrf
                                        <a href="{{ route('logout') }}" onclick="event.preventDefault();this.closest('form').submit();" class="_red">
                                            {{ __('Logout') }}
                                        </a>
                                    </form>
                                @endif                           
    	                    @else
    	                        <a href="{{ route('login') }}" class="d-inline-block mr-3 _red">{{ __('Login') }}</a>
    	                        @if (Route::has('register'))
    	                            <a href="{{ route('register') }}" class="d-inline-block _red">{{ __('Register') }}</a>
    	                        @endif
    	                    @endif
    	                </div>
    	            @endif
                    </div>
                </div>
            </div>                      
        </div>
        <div class="container">
            @yield('content')
        </div>
    </div>
        
    <script src="{{ mix('js/app.js') }}"></script>
    </body>
</html>