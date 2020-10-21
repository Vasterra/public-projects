<?php
get_header();
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
                    </div>
                </div>
                <ul class="breadcrumbs">
                    <li class="breadcrumbs__item">
                        <a href="/" class="breadcrumbs__link">Главная</a>
                    </li>
                    <li class="breadcrumbs__item">
                        <a href="/uslugi/" class="breadcrumbs__link">Услуги</a>
                    </li>
                    <li class="breadcrumbs__item">
                        <?=$wp_query->post->post_title ?>
                    </li>
                </ul>
            </div>
        </div>
        <!--/. Page Header End -->

        <!-- Page Content Begin -->
        <div class="page__content">
            <div class="container">
                <div class="article">
                    <div class="article__img">
                        <img src="<?=get_the_post_thumbnail_url()?>" alt="">
                    </div>
                    <p><?php
                        $content = apply_filters( 'the_content', $wp_query->post->post_content );
                        echo $content;
                        ?></p>
                </div>
            </div>
        </div>
        <!--/. Page Content End -->

    </div>
    <!--/. Page End -->

</main>
<!--/. App Main End -->

<?php get_footer(); ?>
