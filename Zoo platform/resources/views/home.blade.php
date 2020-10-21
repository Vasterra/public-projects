<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Gentelella Alela! | </title>
    <!-- NProgress -->
    <link href="{{ asset("vendors/nprogress/nprogress.css")}}" rel="stylesheet">
    <!-- iCheck -->
    <link href="{{ asset("vendors/iCheck/skins/flat/green.css")}}" rel="stylesheet">
    <!-- Bootstrap -->
    <link href="{{ asset("vendors/bootstrap/dist/css/bootstrap.min.css")}}" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="{{ asset("vendors/font-awesome/css/font-awesome.min.css")}}" rel="stylesheet">
    <!-- NProgress -->
    <link href="{{ asset("vendors/nprogress/nprogress.css")}}" rel="stylesheet">
    <!-- Animate.css -->
    <link href="{{ asset("vendors/animate.css/animate.min.css")}}" rel="stylesheet">

    <!-- Custom Theme Style -->
    <link href="{{ asset("build/css/custom.min.css")}}" rel="stylesheet">

    <script src="https://cdn.jsdelivr.net/npm/vue/dist/vue.js"></script>
    <script src="https://unpkg.com/axios/dist/axios.min.js"></script>
</head>

<body class="nav-md">
<div class="container body" id="app">
    <div class="main_container">
        <div class="col-md-3 left_col">
            <div class="left_col scroll-view">
                <div class="navbar nav_title" style="border: 0;">
                    <a href="index.html" class="site_title"><i class="fa fa-paw"></i> <span>Gentelella Alela!</span></a>
                </div>

                <div class="clearfix"></div>

                <!-- menu profile quick info -->
                <div class="profile clearfix">
                    <div class="profile_info" style="width: 100%;">
                        <span>Здорова</span>
                        <h2>{{ Auth::user()->name }}</h2>
                    </div>
                </div>
                <!-- /menu profile quick info -->

                <br/>

                <!-- sidebar menu -->
                <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
                    <div class="menu_section">
                        <h3>General</h3>
                        <ul class="nav side-menu">
                            <li><a><i class="fa fa-home"></i> Зоопарк <span class="fa fa-chevron-down"></span></a>
                                <ul class="nav child_menu">
                                    <li><a href="/home">Животные</a></li>
                                </ul>
                            </li>
                        </ul>
                    </div>
                </div>
                <!-- /sidebar menu -->

                <!-- /menu footer buttons -->
                <div class="sidebar-footer hidden-small">
                    <a data-toggle="tooltip" data-placement="top" title="Settings">
                        <span class="glyphicon glyphicon-cog" aria-hidden="true"></span>
                    </a>
                    <a data-toggle="tooltip" data-placement="top" title="FullScreen">
                        <span class="glyphicon glyphicon-fullscreen" aria-hidden="true"></span>
                    </a>
                    <a data-toggle="tooltip" data-placement="top" title="Lock">
                        <span class="glyphicon glyphicon-eye-close" aria-hidden="true"></span>
                    </a>
                    <a data-toggle="tooltip" data-placement="top" title="Logout" href="{{ route('logout') }}"
                       onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        <span class="glyphicon glyphicon-off" aria-hidden="true"></span>
                    </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>

                </div>
                <!-- /menu footer buttons -->
            </div>
        </div>

        <!-- top navigation -->
        <div class="top_nav">
            <div class="nav_menu">
                <div class="nav toggle">
                    <a id="menu_toggle"><i class="fa fa-bars"></i></a>
                </div>
                <nav class="nav navbar-nav">
                    <ul class=" navbar-right">
                        <li class="nav-item dropdown open" style="padding-left: 15px;">
                            <a href="javascript:;" class="user-profile dropdown-toggle" aria-haspopup="true"
                               id="navbarDropdown" data-toggle="dropdown" aria-expanded="false">
                                <img src="images/img.jpg" alt="">John Doe
                            </a>
                            <div class="dropdown-menu dropdown-usermenu pull-right" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item" href="javascript:;"> Profile</a>
                                <a class="dropdown-item" href="javascript:;">
                                    <span class="badge bg-red pull-right">50%</span>
                                    <span>Settings</span>
                                </a>
                                <a class="dropdown-item" href="javascript:;">Help</a>
                                <a class="dropdown-item" href="login.html"><i class="fa fa-sign-out pull-right"></i> Log
                                    Out</a>
                            </div>
                        </li>

                        <li role="presentation" class="nav-item dropdown open">
                            <a href="javascript:;" class="dropdown-toggle info-number" id="navbarDropdown1"
                               data-toggle="dropdown" aria-expanded="false">
                                <i class="fa fa-envelope-o"></i>
                                <span class="badge bg-green">6</span>
                            </a>
                            <ul class="dropdown-menu list-unstyled msg_list" role="menu"
                                aria-labelledby="navbarDropdown1">
                                <li class="nav-item">
                                    <a class="dropdown-item">
                                        <span class="image"><img src="images/img.jpg" alt="Profile Image"/></span>
                                        <span>
                            <span>John Smith</span>
                            <span class="time">3 mins ago</span>
                          </span>
                                        <span class="message">
                            Film festivals used to be do-or-die moments for movie makers. They were where...
                          </span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="dropdown-item">
                                        <span class="image"><img src="images/img.jpg" alt="Profile Image"/></span>
                                        <span>
                            <span>John Smith</span>
                            <span class="time">3 mins ago</span>
                          </span>
                                        <span class="message">
                            Film festivals used to be do-or-die moments for movie makers. They were where...
                          </span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="dropdown-item">
                                        <span class="image"><img src="images/img.jpg" alt="Profile Image"/></span>
                                        <span>
                            <span>John Smith</span>
                            <span class="time">3 mins ago</span>
                          </span>
                                        <span class="message">
                            Film festivals used to be do-or-die moments for movie makers. They were where...
                          </span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="dropdown-item">
                                        <span class="image"><img src="images/img.jpg" alt="Profile Image"/></span>
                                        <span>
                            <span>John Smith</span>
                            <span class="time">3 mins ago</span>
                          </span>
                                        <span class="message">
                            Film festivals used to be do-or-die moments for movie makers. They were where...
                          </span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <div class="text-center">
                                        <a class="dropdown-item">
                                            <strong>See All Alerts</strong>
                                            <i class="fa fa-angle-right"></i>
                                        </a>
                                    </div>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </nav>
            </div>
        </div>
        <!-- /top navigation -->

        <!-- page content -->
        <div class="right_col" role="main">
            <div class="">
                <div class="page-title">
                    <div class="title_left">
                        <h3>Наши животные</h3>
                        <a href="#" v-on:click="ShowNew(1)" class="btn btn-primary btn-xs"><i class="fa fa-folder"></i>
                            Добавить нового </a>
                    </div>

                    <div class="title_right">
                        <div class="col-md-5 col-sm-5   form-group pull-right top_search">
                            <div class="input-group">
                                <input type="text" class="form-control" placeholder="Search for...">
                                <span class="input-group-btn">
                      <button class="btn btn-secondary" type="button">Go!</button>
                    </span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="clearfix"></div>

                <div class="row">
                    <div class="col-md-12">
                        <div class="x_panel">
                            <div class="x_title">
                                <h2>Животные</h2>
                                <ul class="nav navbar-right panel_toolbox">
                                    <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                                    </li>
                                    <li class="dropdown">
                                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button"
                                           aria-expanded="false"><i class="fa fa-wrench"></i></a>
                                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                            <a class="dropdown-item" href="#">Settings 1</a>
                                            <a class="dropdown-item" href="#">Settings 2</a>
                                        </div>
                                    </li>
                                    <li><a class="close-link"><i class="fa fa-close"></i></a>
                                    </li>
                                </ul>
                                <div class="clearfix"></div>
                            </div>
                            <div class="x_content">

                                <div class="x_content" v-show="conditionNew">
                                    <br/>
                                    <form class="form-horizontal form-label-left">

                                        <div class="form-group row ">
                                            <label class="control-label col-md-3 col-sm-3 ">Кличка животного</label>
                                            <div class="col-md-9 col-sm-9 ">
                                                <input type="text" class="form-control" v-model:value="xTitle"
                                                       placeholder="Кличка животного">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="control-label col-md-3 col-sm-3 ">Описание</label>
                                            <div class="col-md-9 col-sm-9 ">
                                                <textarea class="form-control" rows="3" v-model:value="xDescription"
                                                          placeholder="Описание"></textarea>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="control-label col-md-3 col-sm-3 ">Вид </label>
                                            <div class="col-md-9 col-sm-9 ">
                                                <select class="form-control" v-model="selectedView">
                                                    <option v-for="View in animalsViews" v-bind:value="View.id">@{{
                                                        View.name }}
                                                    </option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="control-label col-md-3 col-sm-3 ">Категория </label>
                                            <div class="col-md-9 col-sm-9 ">
                                                <select class="form-control" v-model="selectedCategory">
                                                    <option v-for="Category in animalsCategories"
                                                            v-bind:value="Category.id">@{{ Category.name }}
                                                    </option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="ln_solid"></div>
                                        <div class="form-group">
                                            <div class="col-md-9 col-sm-9  offset-md-3">
                                                <button v-on:click="getModalEdit(0, '', '', '', '', 0)" type="button"
                                                        class="btn btn-primary">Cancel
                                                </button>
                                                <button
                                                    v-on:click="postInsert(xTitle, xDescription, selectedCategory, selectedView)"
                                                    class="btn btn-success">Submit
                                                </button>
                                            </div>
                                        </div>

                                    </form>
                                </div>

                                <div class="x_content" v-show="conditionEdit">
                                    <br/>
                                    <form class="form-horizontal form-label-left">

                                        <div class="form-group row ">
                                            <label class="control-label col-md-3 col-sm-3 ">Кличка животного</label>
                                            <div class="col-md-9 col-sm-9 ">
                                                <input type="text" class="form-control" v-model:value="xTitle"
                                                       placeholder="Кличка животного">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="control-label col-md-3 col-sm-3 ">Описание</label>
                                            <div class="col-md-9 col-sm-9 ">
                                                <textarea class="form-control" rows="3" v-model:value="xDescription"
                                                          placeholder="Описание"></textarea>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="control-label col-md-3 col-sm-3 ">Вид </label>
                                            <div class="col-md-9 col-sm-9 ">
                                                <select class="form-control" v-model="selectedView">
                                                    <option v-for="View in animalsViews" v-bind:value="View.id">@{{
                                                        View.name }}
                                                    </option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="control-label col-md-3 col-sm-3 ">Категория </label>
                                            <div class="col-md-9 col-sm-9 ">
                                                <select class="form-control" v-model="selectedCategory">
                                                    <option v-for="Category in animalsCategories"
                                                            v-bind:value="Category.id">@{{ Category.name }}
                                                    </option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="ln_solid"></div>
                                        <div class="form-group">
                                            <div class="col-md-9 col-sm-9  offset-md-3">
                                                <button v-on:click="getModalEdit(0, '', '', '', '', 0)" type="button"
                                                        class="btn btn-primary">Cancel
                                                </button>
                                                <button
                                                    v-on:click="postEdit(xTitle, xDescription, selectedCategory, selectedView, xidAnimal)"
                                                    class="btn btn-success">Submit
                                                </button>
                                            </div>
                                        </div>

                                    </form>
                                </div>

                                <!-- зверинец -->
                                <div class="x_content" v-show="condition">
                                    <div class="col-md-7 col-sm-7 ">
                                        <div class="product-image">
                                            <img src="images/prod-1.jpg" alt="..."/>
                                        </div>
                                    </div>
                                    <div class="col-md-5 col-sm-5 " style="border:0px solid #e5e5e5;">
                                        <h3 class="prod_title">@{{ xTitle }}</h3>
                                        <span
                                            style="border: 1px solid; padding: 3px; margin: 10px;">ВИД: @{{ xVid }}</span>
                                        <span style="border: 1px solid; padding: 3px; margin: 10px;">КАТЕГОРИЯ: @{{ xCat }}</span><br>
                                        <p style="margin-top: 20px;">@{{ xDescription }}</p>
                                        <div class="product_gallery">
                                            <a>
                                                <img src="images/prod-2.jpg" alt="..."/>
                                            </a>
                                            <a>
                                                <img src="images/prod-3.jpg" alt="..."/>
                                            </a>
                                            <a>
                                                <img src="images/prod-4.jpg" alt="..."/>
                                            </a>
                                            <a>
                                                <img src="images/prod-5.jpg" alt="..."/>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <!-- зверинец конец-->
                                <!-- start project list -->
                                <table class="table table-striped projects">
                                    <thead>
                                    <tr>
                                        <th style="width: 20%">Кличка</th>
                                        <th style="width: 20%">Вид</th>
                                        <th style="width: 20%">Категория</th>
                                        <th style="width: 40%">Редактор</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr v-for="animal in animals">
                                        <td v-html="animal.name"></td>
                                        <td v-html="animal.view.name"></td>
                                        <td v-html="animal.category.name"></td>
                                        <td>
                                            <a href="#"
                                               v-on:click="getModal(1, animal.name, animal.description, animal.view.name, animal.category.name, animal.id_category, animal.id_wiew)"
                                               class="btn btn-primary btn-xs"><i class="fa fa-folder"></i> View </a>
                                            <a href="#"
                                               v-on:click="getModalEdit(1, animal.name, animal.description, animal.id_category, animal.id_wiew, animal.id)"
                                               class="btn btn-info btn-xs"><i class="fa fa-pencil"></i> Edit </a>
                                            <a href="#" v-on:click="postDelete(animal.id)"
                                               class="btn btn-danger btn-xs"><i class="fa fa-trash-o"></i> Delete </a>
                                        </td>
                                    </tr>

                                    </tbody>
                                </table>
                                <!-- end project list -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- /page content -->

        <!-- footer content -->
        <footer>
            <div class="pull-right">
                Gentelella - Bootstrap Admin Template by <a href="">Colorlib</a>
            </div>
            <div class="clearfix"></div>
        </footer>
        <!-- /footer content -->
    </div>
</div>

<!-- jQuery -->
<script src="{{ asset("vendors/jquery/dist/jquery.min.js")}}"></script>
<!-- Bootstrap -->
<script src="{{ asset("vendors/bootstrap/dist/js/bootstrap.bundle.min.js")}}"></script>
<!-- FastClick -->
<script src="{{ asset("vendors/fastclick/lib/fastclick.js")}}"></script>
<!-- NProgress -->
<script src="{{ asset("vendors/nprogress/nprogress.js")}}"></script>
<!-- bootstrap-progressbar -->
<script src="{{ asset("vendors/bootstrap-progressbar/bootstrap-progressbar.min.js")}}"></script>

<!-- Custom Theme Scripts -->
<script src="{{ asset("build/js/custom.min.js")}}"></script>
<script>
    var app = new Vue( {
        el: '#app',
        data: {
            animals: '',
            animalsViews: '',
            animalsCategories: '',
            condition: 0,
            conditionEdit: 0,
            conditionNew: 0,
            xTitle: 'v',
            xDescription: 'v',
            xVid: '',
            xCat: '',
            selectedCategory: 0,
            selectedView: 0,
            xidAnimal: 0

        },
        mounted() {
            axios.get( '/animal' ).then( response => ( this.animals = response.data ) );
            axios.get( '/animal_view' ).then( response => ( this.animalsViews = response.data ) );
            axios.get( '/animal_category' ).then( response => ( this.animalsCategories = response.data ) );
        },
        methods: {
            getModal: function ( x, xTitle, xDescription, vid, cat, catSlug, vidSlug ) {
                this.xTitle = xTitle;
                this.xDescription = xDescription;
                this.xVid = vid;
                this.xCat = cat;
                this.selectedCategory = catSlug;
                this.selectedView = vidSlug;
                this.condition = x;
                this.conditionEdit = 0;
                this.conditionNew = 0;
            },
            getModalEdit: function ( x, xTitle, xDescription, catSlug, vidSlug, id ) {
                this.xTitle = xTitle;
                this.xDescription = xDescription;
                this.selectedCategory = catSlug;
                this.selectedView = vidSlug;
                this.xidAnimal = id;
                this.conditionNew = 0;
                this.conditionEdit = x;
                this.condition = 0;
            },
            postEdit: function ( xTitle, xDescription, catSlug, vidSlug, id ) {
                this.xTitle = xTitle;
                this.xDescription = xDescription;
                this.selectedCategory = catSlug;
                this.selectedView = vidSlug;
                this.conditionEdit = 0;
                this.conditionNew = 0;
                this.condition = 0;
                axios.put( "/animal/" + id, {
                    'name': xTitle,
                    'description': xDescription,
                    'id_category': catSlug,
                    'id_wiew': vidSlug
                } ).then( ( response ) => {
                    console.log( response.data );
                    this.animals = response.data;
                } )
                     .catch( ( error ) => {
                             console.log( error );
                         }
                     );
            },
            postDelete: function ( id ) {
                this.conditionEdit = 0;
                this.condition = 0;
                this.conditionNew = 0;
                axios.post( '/animal/' + id, { _method: 'delete' } )
                     .then( ( response ) => {
                         console.log( response.data );
                         this.animals = response.data;
                     } )
                     .catch( ( error ) => {
                         console.log( error );
                     } );
            },
            postInsert: function ( xTitle, xDescription, catSlug, vidSlug ) {
                this.xTitle = xTitle;
                this.xDescription = xDescription;
                this.selectedCategory = catSlug;
                this.selectedView = vidSlug;
                this.conditionEdit = 0;
                this.conditionNew = 0;
                this.condition = 0;
                axios.post( '/animal', {
                    'name': xTitle,
                    'description': xDescription,
                    'id_category': catSlug,
                    'id_wiew': vidSlug
                } )
                     .then( ( response ) => {
                         console.log( response.data );
                         this.animals = response.data;
                     } )
                     .catch( ( error ) => {
                         console.log( error );
                     } );
            },
            ShowNew: function ( id ) {
                this.conditionEdit = 0;
                this.condition = 0;
                this.conditionNew = id;
                this.xTitle = '';
                this.xDescription = '';
                this.selectedCategory = 'default';
                this.selectedView = 'default';

            },
        }
    } );
</script>
</body>
</html>
