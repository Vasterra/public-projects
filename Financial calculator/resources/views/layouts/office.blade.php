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
        <div class="pt-3 pb-4 mb-5 bg-white top__line nav__office">
        	<div class="container">
                <div class="row align-items-center">
                    <div class="col-2"> 
                        <h1 class="h3 m-0 _red">modellax</h2>                        
                    </div>
                    <div class="col-7">
                        <a href="{{ route('office') }}" class="d-inline-block mr-3 _red">{{ __('Profile') }}</a>                        
                        <a href="{{ route('office-forecasts') }}" class="d-inline-block mr-3 _red">{{ __('Forecasts') }}</a>
                        <a href="{{ route('office-comments') }}" class="d-inline-block mr-3 _red">{{ __('Comments') }}</a>
                    </div>                   
                    <div class="col-3">    	            
                        <div class="text-right">
                            <span class="d-inline-block mr-3 font-italic _red">Hello, {{ Auth::user()->name }}!</span>
                            <a href="{{ route('home') }}" class="d-inline-block mr-3 _red">{{ __('Home') }}</a>
                            <form method="POST" action="{{ route('logout') }}" class="d-inline-block">
                                @csrf
                                <a href="{{ route('logout') }}" onclick="event.preventDefault();this.closest('form').submit();" class="_red">
                                    {{ __('Logout') }}
                                </a>
                            </form>
                        </div>    	            
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