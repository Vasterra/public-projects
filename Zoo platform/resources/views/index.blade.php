<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Laravel') }}</title>
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css"
          integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.5.0.js"
            integrity="sha256-r/AaFHrszJtwpe+tHyNi/XCfMxYpbsRg2Uqn0x3s2zc=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/vue/dist/vue.js"></script>
    <script src="https://unpkg.com/axios/dist/axios.min.js"></script>
    <style>
        .modalWin {
            width: 100%;
            height: 100%;
            position: fixed;
            z-index: 10000;
            left: 0px;
            background: white;
            top: 0px;
        }
    </style>
</head>
<body>
<div id="app" class="container">
    <div class="row">
        <div class="col-md-12" style="background: beige;">
            @if (Route::has('login'))
                @auth
                    <div class="container">
                        <div class="row">
                            <div class="col-11">
                                <a href="{{ url('/home') }}">Админ панель</a>
                            </div>
                            <div class="col-1">
                                <form id="logout-form" action="{{ route('logout') }}" method="POST">
                                    @csrf
                                    <input type="submit" value="Выход">
                                </form>
                            </div>
                        </div>
                    </div>
                @else
                    <a href="{{ route('login') }}">Авторизация</a>
                @endauth
            @endif
        </div>
        <div class="col-md-12" style="background: bisque;">
            <div class="container">
                <div class="row">
                    <div class="col-md-2" style="margin: 5px;">
                        <button v-on:click="getAnimalsCat(0)"> Все категории</button>
                    </div>
                    <div v-for="Category in animalsCategories" class="col-md-2" style="margin: 5px;">
                        <div>
                            <button v-on:click="getAnimalsCat(Category.id)" v-html="Category.name"></button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-12" style="background: beige;">
            <div class="container">
                <div class="row">
                    <div class="col-md-2" style="margin: 5px;">
                        <button v-on:click="getAnimals(0)">Все виды</button>
                    </div>
                    <div v-for="View in animalsViews" class="col-md-2" style="margin: 5px;">
                        <button v-on:click="getAnimals(View.id)" v-html="View.name"></button>
                    </div>
                </div>
            </div>
        </div>
        <div v-for="animal in animals" class="col-md-4">
            <div>
                <h3 v-html="animal.name"></h3>
                <p v-html="animal.description" style="height: 50px; overflow: hidden;"></p>
                <button v-on:click="getModal(1, animal.name, animal.description)"
                        style="width: 100%; margin-bottom: 10px;"> Подробнее
                </button>
                <button v-on:click="getAnimalsCat(animal.category.id)"
                        v-html="'Категория: '+animal.category.name"></button>
                <button v-on:click="getAnimals(animal.view.id)" v-html="'Вид: '+animal.view.name"></button>
            </div>
        </div>
    </div>
    <!-- Модалка-->
    <div v-show="condition" class="modalWin">
        <div class="container">
            <div class="row">
                <div class="col-11"></div>
                <div class="col-1">
                    <h4 v-on:click="getModal(0, '', '')" style="color: black; cursor: default; font-size: 50px;">X</h4>
                </div>
                <div class="col-12">
                    <h1 style="text-align: center; font-size: 50px;">@{{ xTitle }}</h1>
                    <p style="font-size: 20px;">@{{xDescription}}</p>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    var app = new Vue( {
        el: '#app',
        data: {
            animals: '',
            animalsViews: '',
            animalsCategories: '',
            condition: 0,
            xTitle: 'v',
            xDescription: 'v'
        },
        mounted() {
            axios.get( '/animal' ).then( response => ( this.animals = response.data ) );
            axios.get( '/animal_view' ).then( response => ( this.animalsViews = response.data ) );
            axios.get( '/animal_category' ).then( response => ( this.animalsCategories = response.data ) );
        },
        methods: {
            getAnimals: function ( id ) {
                axios.get( '/animal_view/' + id ).then( response => ( this.animals = response.data ) );
            },
            getAnimalsCat: function ( id ) {
                axios.get( '/animal_category/' + id ).then( response => ( this.animals = response.data ) );
            },
            getModal: function ( x, xTitle, xDescription ) {
                this.condition = x;
                this.xTitle = xTitle;
                this.xDescription = xDescription;
            },
        }
    } );
</script>

</body>
</html>
