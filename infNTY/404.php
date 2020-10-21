<?php
/**
 * The template for displaying 404 pages (not found)
 *
 * @link https://codex.wordpress.org/Creating_an_Error_404_Page
 *
 * @package WordPress
 * @subpackage Twenty_Seventeen
 * @since 1.0
 * @version 1.0
 */

get_header(); ?>
    <!-- App Main Begin -->
    <main role="main" class="app__main">

        <!-- Page Begin -->
        <div class="page">

            <!-- Page Header Begin -->
            <div class="page__header" style="background-image: url('<?php bloginfo('template_url'); ?>/static/img/content/header-bg.jpg')">
                <div class="container">
                    <div class="page__header-title typed-effect">
                        <div id="js-typed-strings">
                            <p>Ошибка 404</p>
                        </div>
                    </div>
                    <ul class="breadcrumbs">
                        <li class="breadcrumbs__item">
                            <a href="/" class="breadcrumbs__link">Главная</a>
                        </li>
                        <li class="breadcrumbs__item">
                            Ошибка 404
                        </li>
                    </ul>
                </div>
            </div>
            <!--/. Page Header End -->

            <!-- Page Content Begin -->
            <?php
            $post_616 = get_post( 616 );
            $PTitle616 = $post_616->post_title;
            $PContent616=apply_filters( 'the_content', $post_616->post_content );
            $dpole616 = get_post_meta( $post_616->ID, 'active' );

            $post_614 = get_post( 614 );
            $PTitle614 = $post_614->post_title;
            $PContent614=apply_filters( 'the_content', $post_614->post_content );

            if ((int)$dpole616[0]>0) echo $PContent616; else echo $PContent614;
            ?>
            <!--/. Page Content End -->

        </div>
        <!--/. Page End -->

    </main>
    <!--/. App Main End -->
<?php
get_footer();
?>