<?php
get_header(); // выводим хеадер
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
                        <p><?=$wp_query->post->post_title ?></p>
                        <!--Выводим заголовок поста решений-->
                    </div>
                </div>
                <ul class="breadcrumbs">
                    <li class="breadcrumbs__item">
                        <a href="/" class="breadcrumbs__link">Главная</a>
                    </li>
                    <li class="breadcrumbs__item">
                        <a href="/resheniya/" class="breadcrumbs__link">Решения</a>
                    </li>
                    <li class="breadcrumbs__item">
                        <?=$wp_query->post->post_title ?>
                        <!--Выводим заголовок поста решений-->
                    </li>
                </ul>
            </div>
        </div>
        <!--/. Page Header End -->

        <!-- Page Content Begin -->
        <div class="page__content">
            <div class="container">
                <div class="row">
                    <div class="col-md-4">
                        <div id="aside-menu" class="aside-menu">
                            <div class="aside-menu__item">
                                <button class="aside-menu__link" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                    Решения банковской сферы
                                </button>
                                <div id="collapseOne" class="collapse show" data-parent="#aside-menu">
                                    <?php
                                    /* Организуем цикл в котором выводим названия и ссылки постов заданной категории*/
                                    $query = new WP_Query( array('post_type' => 'post', 'post_status' => 'publish', 'cat' => [23], 'orderby' => 'date', 'order' => 'DESC'));
                                    if ($query->have_posts()) { while ($query->have_posts()) { $query->the_post();
                                    ?>
                                    <!-- Сама html ссылка прокачана по самые яйца -->
                                    <a href="<?=get_permalink()?>" class="aside-menu__sublink"><?php the_title(); ?></a>
                                    <?php }}  ?>
                                </div>
                            </div>
                            <div class="aside-menu__item">
                                <button class="aside-menu__link" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                    Корпоративный сектор
                                </button>
                                <div id="collapseTwo" class="collapse" data-parent="#aside-menu">
                                    <?php
                                    /* Организуем цикл в котором выводим названия и ссылки постов заданной категории*/
                                    $query = new WP_Query( array('post_type' => 'post', 'post_status' => 'publish', 'cat' => [24], 'orderby' => 'date', 'order' => 'DESC'));
                                    if ($query->have_posts()) { while ($query->have_posts()) { $query->the_post();
                                        ?>
                                        <!-- Сама html ссылка прокачана по самые яйца -->
                                        <a href="<?=get_permalink()?>" class="aside-menu__sublink"><?php the_title(); ?></a>
                                    <?php }}  ?>
                                </div>
                            </div>
                            <div class="aside-menu__item">
                                <button class="aside-menu__link" data-toggle="collapse" data-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                                    Государственный сектор
                                </button>
                                <div id="collapseThree" class="collapse" data-parent="#aside-menu">
                                    <?php
                                    /* Организуем цикл в котором выводим названия и ссылки постов заданной категории*/
                                    $query = new WP_Query( array('post_type' => 'post', 'post_status' => 'publish', 'cat' => [25], 'orderby' => 'date', 'order' => 'DESC'));
                                    if ($query->have_posts()) { while ($query->have_posts()) { $query->the_post();
                                        ?>
                                        <!-- Сама html ссылка прокачана по самые яйца -->
                                        <a href="<?=get_permalink()?>" class="aside-menu__sublink"><?php the_title(); ?></a>
                                    <?php }}  ?>
                                </div>
                            </div>
                        </div>
                        <div class="aside-news">
                            <div class="aside-news__header">Последняя новость</div>
                            <?php
                            $exceptPost=0;
                            $query = new WP_Query(array('post_type' => 'post', 'post_status' => 'publish', 'posts_per_page' => 1, 'cat' => [17], 'orderby' => 'date', 'order' => 'DESC'));
                            if ($query->have_posts()) { while ($query->have_posts()) {
                            $query->the_post();
                            $date = get_the_date( "d.m.Y");
                            ?>
                                <a href="<?php the_permalink(); ?>">
                                    <img src="<?=get_the_post_thumbnail_url()?>" class="aside-news__img" alt="">
                                </a>
                                <div class="aside-news__content">
                                    <a href="<?php the_permalink(); ?>" class="aside-news__title"><?php the_title(); ?></a>
                                    <div class="aside-news__text"><?=the_excerpt_max_charlength(150)?></div>
                                    <a href="<?php the_permalink(); ?>" class="aside-news__date"><?=$date ?> / <?php the_category(', '); ?></a>
                                    <a href="<?php the_permalink(); ?>" class="button -bordered aside-news__button">Читать далее</a>
                                </div>
                            <?php $exceptPost=get_the_ID(); }} ?>
                        </div>
                        <div class="aside-news">
                            <?php
                            $post_432 = get_post( 432 );
//                            $PTitle = $post_432->post_title;
                            $PContent=$post_432->post_content;
                            $PImage = wp_get_attachment_url( get_post_thumbnail_id($post_432->ID), 'thumbnail' );
                            ?>
                            <a href="<?=$PContent ?>"><img src="<?=$PImage ?>" alt=""></a>
                        </div>
                    </div>
                    <div class="col-md-8">
                        <div class="article">
                            <h1><?=$wp_query->post->post_title ?></h1>
                            <p>
                                <?php
                                $content = apply_filters( 'the_content', $wp_query->post->post_content );
                                echo $content;
                                ?>
                            </p>
                            <h2 class="mt-4">Примеры реализации</h2>
                            <div class="row" vertical-gutter="30">
                                <div class="col-md-6">
                                    <div class="projects">
                                        <img src="<?php bloginfo('template_url'); ?>/static/img/content/reviews.png" class="projects__img" alt="">
                                        <p>BANK - казахстанский розничный системообразующий банк. Головной офис находится в Алма-Ате.</p>
                                        <strong>ИТ-поддержка производства и центрального офиса</strong>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="projects">
                                        <img src="<?php bloginfo('template_url'); ?>/static/img/content/reviews.png" class="projects__img" alt="">
                                        <p>BANK - казахстанский розничный системообразующий банк. Головной офис находится в Алма-Ате.</p>
                                        <strong>ИТ-поддержка производства и центрального офиса</strong>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="projects">
                                        <img src="<?php bloginfo('template_url'); ?>/static/img/content/reviews.png" class="projects__img" alt="">
                                        <p>BANK - казахстанский розничный системообразующий банк. Головной офис находится в Алма-Ате.</p>
                                        <strong>ИТ-поддержка производства и центрального офиса</strong>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="projects">
                                        <img src="<?php bloginfo('template_url'); ?>/static/img/content/reviews.png" class="projects__img" alt="">
                                        <p>BANK - казахстанский розничный системообразующий банк. Головной офис находится в Алма-Ате.</p>
                                        <strong>ИТ-поддержка производства и центрального офиса</strong>
                                    </div>
                                </div>
                            </div>
                            <div class="text-center mt-5">
                                <a href="javascript:void(0);" id="linkesho" onclick="document.getElementById('linkesho').style.display='none'; document.getElementById('showmore').style.display='flex'; ">Посмотреть ещё</a>
                            </div>
                            <div class="row" vertical-gutter="30" id="showmore" style="display: none;">
                                <div class="col-md-6">
                                    <div class="projects">
                                        <img src="<?php bloginfo('template_url'); ?>/static/img/content/reviews.png" class="projects__img" alt="">
                                        <p>BANK - казахстанский розничный системообразующий банк. Головной офис находится в Алма-Ате.</p>
                                        <strong>ИТ-поддержка производства и центрального офиса</strong>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="projects">
                                        <img src="<?php bloginfo('template_url'); ?>/static/img/content/reviews.png" class="projects__img" alt="">
                                        <p>BANK - казахстанский розничный системообразующий банк. Головной офис находится в Алма-Ате.</p>
                                        <strong>ИТ-поддержка производства и центрального офиса</strong>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="projects">
                                        <img src="<?php bloginfo('template_url'); ?>/static/img/content/reviews.png" class="projects__img" alt="">
                                        <p>BANK - казахстанский розничный системообразующий банк. Головной офис находится в Алма-Ате.</p>
                                        <strong>ИТ-поддержка производства и центрального офиса</strong>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="projects">
                                        <img src="<?php bloginfo('template_url'); ?>/static/img/content/reviews.png" class="projects__img" alt="">
                                        <p>BANK - казахстанский розничный системообразующий банк. Головной офис находится в Алма-Ате.</p>
                                        <strong>ИТ-поддержка производства и центрального офиса</strong>
                                    </div>
                                </div>
                            </div>
                            <form class="form -cta" method="post" action="/ajax.php">
                                <input name="operation" type="hidden" value="5">
                                <h2 class="form__title">Связаться с нами</h2>
                                <div class="row align-items-end" vertical-gutter="30">
                                    <div class="col-md-4">
                                        <div class="control mb-0">
                                            <input id='namesolution' onblur="proverkaSolution()" oninput="proverkaSolution()" type="text" name="name" class="control__input" placeholder="Имя">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="control mb-0">
                                            <input id="phonesolution" onblur="proverkaSolution()" oninput="proverkaSolution()" type="text" name="phone" class="control__input" placeholder="+7 (***) ***-**-**">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <button id="buttonsendphonesolution" type="button" onclick="getAjax1('5', document.getElementById('namesolution').value, document.getElementById('phonesolution').value, '<?=$wp_query->post->post_title ?>')" class="button -bordered form__button" data-target="#modal-3" data-toggle="modal" disabled>отправить</button>
                                    </div>
                                </div>
                            </form>
                            <script>
                                function proverkaSolution() {
                                    namesolution=nm(document.getElementById('namesolution').value);
                                    telsolution=ph(document.getElementById('phonesolution').value);
                                    if(telsolution==1 && namesolution==1) document.getElementById('buttonsendphonesolution').disabled = false; else document.getElementById('buttonsendphonesolution').disabled = true;
                                }
                                var telsolution=0;
                                var namesolution=0;
                            </script>
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
<?php
//echo "<pre>";
//var_dump($wp_query->post);
//echo "</pre>";
?>
<?php get_footer(); ?>
