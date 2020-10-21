<?php
get_header();
$dpole = get_post_meta( $wp_query->post->ID, 'kontakt' );
?>
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
                        <a href="/about/#vacancy" class="breadcrumbs__link">Вакансии</a>
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
                <div class="row">
                    <div class="col-md-8">
                        <div class="article">
                            <?php
                            $content = apply_filters( 'the_content', $wp_query->post->post_content );
                            echo $content;
                            ?>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="aside-news">
                            <div class="aside-news__header">Другие вакансии</div>
                            <div class="aside-news__content">
                                <?php
                                $query = new WP_Query( array( 'post_type' => 'post', 'post_status' => 'publish',
                                        'posts_per_page' => 3,
                                        'cat' => [20],  //1 7 8
                                        'post__not_in' => array($wp_query->post->ID),
                                        'orderby' => 'date',
                                        'order' => 'DESC',
                                    )
                                );
                                if ($query->have_posts()) {
                                while ($query->have_posts()) {
                                    $query->the_post();
                                    ?>
                                    <a href="<?php the_permalink(); ?>" class="aside-news__item">
                                        <div class="aside-news__item-title"><?php the_title(); ?></div>
                                        <div class="aside-news__item-text">
                                            <p><?php the_excerpt(); ?> </p>
                                        </div>
                                    </a>
                                    <?php
                                }}
                                ?>
                            </div>
                        </div>
                        <div class="aside-news">
                            <div class="aside-news__header">Контактная информация:</div>
                            <div class="aside-news__content">
                                <div class="aside-news__text">
                                    <?=$dpole[0] ?>
                                </div>
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
<?php
//echo "<pre>";
//var_dump($wp_query->post);
//echo "</pre>";
?>
<?php get_footer(); ?>
