<?php get_header();
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
                        <p><?php the_title(); ?></p>
                    </div>
                </div>
                <ul class="breadcrumbs">
                    <li class="breadcrumbs__item">
                        <a href="/" class="breadcrumbs__link">Главная</a>
                    </li>
                    <li class="breadcrumbs__item">
                        <?php the_title(); ?>
                    </li>
                </ul>
            </div>
        </div>
        <!--/. Page Header End -->
        <!-- Page Content Begin -->
        <div class="page__content">
            <div class="container">
			<section>
				<?php if (have_posts()): while (have_posts()): the_post(); ?>
					<?php the_content(); ?>
				<?php endwhile; endif; ?>
			</section>
            </div>
        </div>
        <!--/. Page Content End -->
    </div>
    <!--/. Page End -->
</main>
<!--/. App Main End -->
<?php get_footer(); ?>
