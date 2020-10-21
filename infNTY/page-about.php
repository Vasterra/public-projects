<?php get_header(); ?>
<!-- App Main Begin -->
<?php
$fblnk = get_post_meta( 566, 'fblink' )[0];
$lklnk = get_post_meta( 566, 'linkedinlink' )[0];
?>
<main role="main" class="app__main">
<!-- Page Begin -->
    <div class="page">

        <!-- Page Header Begin -->
        <div class="page__header" style="background-image: url('<?php bloginfo('template_url'); ?>/static/img/content/header-bg.jpg')">
            <div class="container">
                <div class="page__header-title typed-effect">
                    <div id="js-typed-strings">
                        <p>О компании</p>
                    </div>
                </div>
                <ul class="breadcrumbs">
                    <li class="breadcrumbs__item">
                        <a href="/" class="breadcrumbs__link">Главная</a>
                    </li>
                    <li class="breadcrumbs__item">
                        О компании
                    </li>
                </ul>
            </div>
        </div>
        <!--/. Page Header End -->

        <!-- Page Content Begin -->
        <div class="page__content">
            <div class="container">
                <div class="page__topbar">
                    <ul class="nav tabs">
                        <li class="tabs__item">
                            <a class="tabs__link active" id="t1" href="/about/#history" role="tab">Компания</a>
                        </li>
                        <li class="tabs__item">
                            <a class="tabs__link" id="t2" href="/about/#team" role="tab">Руководство</a>
                        </li>
                        <li class="tabs__item">
                            <a class="tabs__link" id="t3" href="/about/#reviews" role="tab">Отзывы</a>
                        </li>
                        <li class="tabs__item">
                            <a class="tabs__link" id="t4" href="/about/#vacancy" role="tab">Вакансии</a>
                        </li>
                        <li class="tabs__item">
                            <a class="tabs__link" id="t5" href="/about/#contacts" role="tab">Контакты</a>
                        </li>
                    </ul>
                </div>
                <div class="tab-content">
                    <div class="tab-pane active" id="tabs-1" role="tabpanel">
                        <div class="about">
                            <?php
                            $post_388 = get_post( 388 );
                            $PTitle = $post_388->post_title;
                            $PContent=apply_filters( 'the_content', $post_388->post_content );
                            $PImage = wp_get_attachment_url( get_post_thumbnail_id($post_388->ID), 'thumbnail' );
                            $dpoleSotrudniki = get_post_meta( $post_388->ID, 'sotrudniki' );
                            $dpoleProekti = get_post_meta( $post_388->ID, 'proekti' );
                            $dpolePartneri = get_post_meta( $post_388->ID, 'partneri' );
                            $dpoletext10let = get_post_meta( $post_388->ID, 'text10let' );
                            $dpolecifra10let = get_post_meta( $post_388->ID, 'cifra10let' );
                            $dpolefooteraboutus = get_post_meta( $post_388->ID, 'footeraboutus' );
                            ?>
                            <div class="about__left">
                                <img src="<?php bloginfo('template_url'); ?>/static/img/content/p5.png" class="about__img" alt="">
                            </div>
                            <!-- <div class="text-center"><img src="<?php bloginfo('template_url'); ?>/static/img/content/notes.png" class="about__notes" alt=""></div> -->
                            <div class="about__content">
                                <div class="about__top-content">
                                    <img src="<?php bloginfo('template_url'); ?>/static/img/content/infin.png" alt="">
                                    <div class="about__top-stats">
                                        <?=$dpolecifra10let[0] ?> +
                                        <br>
                                        <span><?=$dpoletext10let[0] ?></span>
                                    </div>
                                </div>
                                <div class="about__text">
                                    <?=$PContent?>
                                </div>
                                <div class="about__stats">
                                    <div class="about__stats-item">
                                        <?=$dpoleSotrudniki[0] ?> +
                                        <br>
                                        <span>сотрудников</span>
                                    </div>
                                    <div class="about__stats-item">
                                        <?=$dpoleProekti[0] ?> +
                                        <br>
                                        <span>проектов</span>
                                    </div>
                                    <div class="about__stats-item">
                                        <?=$dpolePartneri[0] ?> +
                                        <br>
                                        <span>партнеров</span>
                                    </div>
                                </div>
                            </div>
                            <img src="<?=$PImage?>" class="my-3" alt="">
                            <?=$dpolefooteraboutus[0] ?>
                        </div>
                    </div>
                    <div class="tab-pane" id="tabs-2" role="tabpanel">
                        <div class="row" vertical-gutter="60">
                            <?php
                            $query = new WP_Query(array('post_type' => 'post', 'post_status' => 'publish', 'cat' => [28], 'orderby' => 'date', 'order' => 'DESC'));
                            if ($query->have_posts()) { while ($query->have_posts()) {
                                $query->the_post();
                                $status = get_post_meta( get_the_ID(), 'status' );
                                //if ($icon[0]!='') $ic=$icon[0]; else $ic="";
                                ?>
                                <div class="col-sm-6 col-lg-3">
                                    <div class="team">
                                        <div class="team__avatar">
                                            <img src="<?=get_the_post_thumbnail_url()?>" alt="">
                                        </div>
                                        <div class="team__header">
                                            <div class="team__name"><?php the_title(); ?></div>
                                            <div class="team__position"><?=$status[0]?></div>
                                        </div>
                                        <div class="team__body">
                                            <?php the_content(); ?>
                                        </div>
                                    </div>
                                </div>
                            <?php }} ?>
                        </div>
                    </div>
                    <div class="tab-pane" id="tabs-3" role="tabpanel">
                        <?php
                        $query = new WP_Query(array('post_type' => 'post', 'post_status' => 'publish', 'cat' => [27], 'orderby' => 'date', 'order' => 'DESC'));
                        if ($query->have_posts()) { while ($query->have_posts()) {
                            $query->the_post();
                            $icon = get_post_meta( get_the_ID(), 'icon' );
                            //if ($icon[0]!='') $ic=$icon[0]; else $ic="";
                            ?>

                            <div class="reviews mb-3 mb-md-4">
                                <div class="reviews__img lg">
                                    <img src="<?=get_the_post_thumbnail_url()?>" data-src="<?=get_the_post_thumbnail_url()?>" alt="">
                                </div>
                                <div class="reviews__content">
                                    <div class="reviews__header">
                                        <div class="reviews__title"><?php the_title(); ?></div>
                                        <img src="<?=$icon[0]?>" class="reviews__logo" alt="">
                                    </div>
                                    <div class="spoiler">
                                        <div class="spoiler__inner jsSpoilerInner" data-height="100">
                                            <p><?php the_content(); ?></p>
                                        </div>
                                        <button type="button" class="spoiler__more jsSpoilerMore" data-open="Читать полностью" data-close="Скрыть">Читать полностью</button>
                                    </div>
                                </div>
                            </div>
                            <?php }} ?>
                    </div>
                    <div class="tab-pane" id="tabs-4" role="tabpanel">
                        <div class="row" vertical-gutter="30">
                            <?php
                            global $paged3;
                            if ( get_query_var('paged') )
                                $my_page = get_query_var('paged');
                            else {
                                if ( get_query_var('page') )
                                    $my_page = get_query_var('page');
                                else
                                    $my_page = 1;
                                set_query_var('paged', $my_page);
                                $paged3 = $my_page;
                            }


                            $query = new WP_Query(
                                array(
                                    'post_type' => 'post',
                                    'post_status' => 'publish',
                                    'cat' => [20],  //1 7 8
                                    'post__not_in' => array(get_the_ID()),
                                    'orderby' => 'date',
                                    'order' => 'DESC',
                                    'paged' => $my_page
                                )
                            );


                            if ($query->have_posts()) {
                                while ($query->have_posts()) {
                                    $query->the_post();
                                    $date = get_the_date( "d.m.Y");
                                    ?>

                                    <div class="col-md-6 col-lg-4">
                                        <div class="vacancy">
                                            <a href="<?php the_permalink(); ?>" class="vacancy__title"><?php the_title(); ?></a>
                                            <div class="vacancy__content">
                                                <div class="vacancy__text">
                                                    <p>
                                                        <?php the_excerpt(); ?>                                                    </p>
                                                </div>
                                                <a href="<?php the_permalink(); ?>" class="vacancy__link">Читать полностью</a>
                                            </div>
                                        </div>
                                    </div>
                                    <?php
                                }
                                if(function_exists('wp_pagenavi')) {
                                    ?>
                                    <div class="col-md-12">
                                        <?php
                                        wp_pagenavi(array('query' => $query));
                                        ?>
                                    </div>
                                    <?php
                                    $wp_query = null;
                                    $wp_query = $query;
                                }
                                wp_reset_postdata();
                            }
                            ?>
                        </div>
                    </div>
                    <div class="tab-pane" id="tabs-5" role="tabpanel">
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
    function hashKoder(hash) {
        switch (hash) {
            //       case "#story": alert(1); break;
            case "#team":
                document.getElementById('t2').className='tabs__link active';
                document.getElementById('tabs-2').style.display="block";
                document.getElementById('t1').className='tabs__link';
                document.getElementById('tabs-1').style.display="none";
                document.getElementById('t3').className='tabs__link';
                document.getElementById('tabs-3').style.display="none";
                document.getElementById('t4').className='tabs__link';
                document.getElementById('tabs-4').style.display="none";
                document.getElementById('t5').className='tabs__link';
                document.getElementById('tabs-5').style.display="none";
                break;
            case "#reviews":
                document.getElementById('t3').className='tabs__link active';
                document.getElementById('tabs-3').style.display="block";
                document.getElementById('t1').className='tabs__link';
                document.getElementById('tabs-1').style.display="none";
                document.getElementById('t2').className='tabs__link';
                document.getElementById('tabs-2').style.display="none";
                document.getElementById('t4').className='tabs__link';
                document.getElementById('tabs-4').style.display="none";
                document.getElementById('t5').className='tabs__link';
                document.getElementById('tabs-5').style.display="none";
                break;
            case "#vacancy":
                document.getElementById('t2').className='tabs__link';
                document.getElementById('tabs-2').style.display="none";
                document.getElementById('t3').className='tabs__link';
                document.getElementById('tabs-3').style.display="none";
                document.getElementById('t1').className='tabs__link';
                document.getElementById('tabs-1').style.display="none";
                document.getElementById('t4').className='tabs__link active';
                document.getElementById('tabs-4').style.display="block";
                document.getElementById('t5').className='tabs__link';
                document.getElementById('tabs-5').style.display="none";
                break;
            case "#contacts":
                document.getElementById('t2').className='tabs__link';
                document.getElementById('tabs-2').style.display="none";
                document.getElementById('t3').className='tabs__link';
                document.getElementById('tabs-3').style.display="none";
                document.getElementById('t1').className='tabs__link';
                document.getElementById('tabs-1').style.display="none";
                document.getElementById('t4').className='tabs__link';
                document.getElementById('tabs-4').style.display="none";
                document.getElementById('t5').className='tabs__link active';
                document.getElementById('tabs-5').style.display="block";
                break;
            default:
                document.getElementById('tabs-1').style.display="block";
                document.getElementById('t1').className='tabs__link active';
                document.getElementById('t2').className='tabs__link';
                document.getElementById('tabs-2').style.display="none";
                document.getElementById('t3').className='tabs__link';
                document.getElementById('tabs-3').style.display="none";
                document.getElementById('t4').className='tabs__link';
                document.getElementById('tabs-4').style.display="none";
                document.getElementById('t5').className='tabs__link';
                document.getElementById('tabs-5').style.display="none";
                break;
        }
    }

    var hash = window.location.hash;
    hashKoder(hash);

    function locationHashChanged() {
        var hash = window.location.hash;
        hashKoder(hash);
    }

    function changeHash(h)
    {
        window.location.hash=h;
        var hash = window.location.hash;
        hashKoder(hash);
    }
    window.onhashchange = locationHashChanged;
</script>

<?php get_footer(); ?>
