<?php get_header(); ?>
<?php
$fblnk = get_post_meta( 566, 'fblink' )[0];
$lklnk = get_post_meta( 566, 'linkedinlink' )[0];
?>
        <!-- App Main Begin -->
        <main role="main" class="app__main">

            <!-- Page Begin -->
            <div class="page">

                <!-- Page Header Begin -->
                <div class="page__header" style="background-image: url('<?php bloginfo('template_url'); ?>/static/img/content/header-bg.jpg')">
                    <div class="container">
                        <div class="page__header-title typed-effect">
                            <div id="js-typed-strings">
                                <p>Контакты</p>
                            </div>
                        </div>
                        <ul class="breadcrumbs">
                            <li class="breadcrumbs__item">
                                <a href="/" class="breadcrumbs__link">Главная</a>
                            </li>
                            <li class="breadcrumbs__item">
                                Контакты
                            </li>
                        </ul>
                    </div>
                </div>
                <!--/. Page Header End -->

                <!-- Page Content Begin -->
                <div class="page__content">
                    <div class="container">
                        <div class="contacts2">
                            <div class="row no-gutters">
                                <div class="col-lg-4">
                                    <div class="contacts2__left">
                                        <form class="form">
                                            <h2 class="form__title">Написать нам</h2>
                                            <div class="control">
                                                <input type="text" onblur="proverka()" oninput="proverka()" id="kontaktpagename" name="name" class="control__input" placeholder="Имя">
                                            </div>
                                            <div class="control">
                                                <input type="text" onblur="proverka()" oninput="proverka()" id="kontaktpagephone" name="phone" class="control__input" placeholder="+7 (***) ***-**-**">
                                            </div>
                                            <div class="control">
                                                <input type="text" onblur="proverka()" id="kontaktpageemail" oninput="proverka()" name="email" class="control__input" placeholder="Email">
                                            </div>
                                            <div class="control mt-md-3">
                                                <textarea onblur="proverka()" oninput="proverka()" id="kontaktpagemessage" class="control__input -textarea" placeholder="Сообщение"></textarea>
                                            </div>
                                            <div class="text-center mt-4">
                                                <button id="buttonsendd" type="button" onclick="getAjaxContactForm('2', document.getElementById('kontaktpagename').value, document.getElementById('kontaktpagemessage').value, document.getElementById('kontaktpagephone').value, document.getElementById('kontaktpageemail').value);" class="button -bordered form__button" data-target="#modal-3" data-toggle="modal" disabled>отправить</button>
                                            </div>
                                        </form>
                                        <div class="contacts2__info">
                                            Республика Казахстан, г. Алматы, пр. Достык 117/6, 6 этаж
                                            <br>Почтовый индекс: 050059
                                            <br>+7 (727) 262 08 26
                                            <br>info@infin-it.kz
                                        </div>
                                        <ul class="social contacts2__social">
                                            <li class="social__item">
                                                <a href="<?=$fblnk?>" class="social__link">
                                                    <i class="fa fa-facebook"></i>
                                                </a>
                                            </li>
                                            <li class="social__item">
                                                <a href="<?=$lklnk?>" class="social__link">
                                                    <i class="fa fa-linkedin"></i>
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="col-lg-8">
                                    <div class="contacts2__map">
                                        <a class="dg-widget-link" href="http://2gis.kz/almaty/firm/9429940001487142/center/76.956892,43.22389/zoom/16?utm_medium=widget-source&utm_campaign=firmsonmap&utm_source=bigMap">Посмотреть на карте Алматы</a><div class="dg-widget-link"><a href="http://2gis.kz/almaty/center/76.956892,43.22389/zoom/16/routeTab/rsType/bus/to/76.956892,43.22389╎Prime Source, информационно-внедренческая компания?utm_medium=widget-source&utm_campaign=firmsonmap&utm_source=route">Найти проезд до Prime Source, информационно-внедренческая компания</a></div><script charset="utf-8" src="https://widgets.2gis.com/js/DGWidgetLoader.js"></script><script charset="utf-8">new DGWidgetLoader({"width":"100%","height":"100%","borderColor":"#a3a3a3","pos":{"lat":43.22389,"lon":76.956892,"zoom":16},"opt":{"city":"almaty"},"org":[{"id":"9429940001487142"}]});</script><noscript style="color:#c00;font-size:16px;font-weight:bold;">Виджет карты использует JavaScript. Включите его в настройках вашего браузера.</noscript>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!--/. Page Content End -->

            </div>
            <!--/. Page End -->

        </main>
        <!--/. App Main End -->

    <script>
        function proverka() {
            nameCF=nm(document.getElementById('kontaktpagename').value);
            messCF=nm(document.getElementById('kontaktpagemessage').value);
            tel=ph(document.getElementById('kontaktpagephone').value);
            email=ff(document.getElementById('kontaktpageemail').value);
            if(email==1 && tel==1 && nameCF==1 && messCF==1) document.getElementById('buttonsendd').disabled = false; else document.getElementById('buttonsendd').disabled = true;
        }
        var email=0;
        var tel=0;
        var nameCF=0;
        var messCF=0;

    </script>
<?php get_footer(); ?>