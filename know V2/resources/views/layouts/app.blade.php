<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Бесконечность не предел</title>
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">

    <!-- Styles -->
    <style>
        html, body {
            background-color: #fff;
            color: #636b6f;
            font-family: 'Nunito', sans-serif;
            font-weight: 200;
            margin: 0;
        }

        .buttonZZ {
            height: 18px;
            width: 20px;
            font-size: 10px;
            margin-top: 5px;
            border: 0px;
            background: #3490dc;
            color: white;
            box-shadow: 0px 0px 6px 0px #3f9ae5;
        }

        .titleCategory {
            font-family: 'Righteous', cursive;
            position: relative;
            color: #3CA1D9;
            display: inline-block;
            border-bottom: 2px solid;
            font-size: 3em;
            padding: 11px 60px;
            margin: 0;
            line-height: 1;
            width: 100%;
        }

        .titlesubcategory {
            box-shadow: -11px 0px 0px 2px #adb5bd;
            margin-left: 11px;
        }

        .standButton {
            width: 100%;
            margin-top: 5px;
            border: 0px;
            background: #3490dc;
            color: white;
            box-shadow: 0px 0px 6px 0px #3f9ae5;
            font-size: 10px;
        }

        .inpx {
            width: 100%;
            margin-bottom: 0px;
            font-size: 10px;
        }

        .d9 h3 {
            text-align: left;
            padding: 0 0 6px 10px;
            border-left: 10px solid #adb5bd;
            border-bottom: 2px solid #dee2e6;
        }

        .flex-center {
            align-items: center;
            justify-content: center;
        }

        .position-ref {
            position: relative;
        }

        .top-right {
            position: relative;
            left: 10px;
            top: 0px;
            background: white;
            width: 100%;
            padding-top: 5px;
            margin-bottom: 30px
        }

        .content {
            text-align: center;
        }

        .title {
            font-size: 84px;
        }

        .links > a {
            color: #636b6f;
            padding: 0 25px;
            font-size: 18px;
            font-weight: 600;
            letter-spacing: .1rem;
            text-decoration: none;
            text-transform: uppercase;
        }

        .m-b-md {
            margin-bottom: 30px;
        }

        .fixedComponentsAdd {
            position: fixed;
            z-index: 1000;
            bottom: 0;
            padding: 20px;
            background: white;
        }

        .contBlock {
            margin-top: 60px;
        }

        .sorter {
            width: 38px;
            text-align: center;
            font-size: 13px;
            vertical-align: top;
        }

        .buttonX {
            font-size: 13px;
            text-align: center;
            height: 27px;
        }
    </style>
    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body>
<div class="container">
    @yield('menu')
    @yield('content')
</div>
</body>
</html>
