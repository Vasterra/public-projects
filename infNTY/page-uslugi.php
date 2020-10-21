<?php get_header(); ?>
    <!-- App Main Begin -->
    <main role="main" class="app__main">

        <!-- Page Begin -->
        <div class="page">

            <!-- Page Header Begin -->
            <div class="page__header" style="background-image: url('<?php bloginfo('template_url'); ?>/static/img/content/header-bg.jpg')">
                <div class="container">
                    <div class="page__header-title typed-effect">
                        <div id="js-typed-strings">
                            <p>Услуги</p>
                        </div>
                    </div>
                    <ul class="breadcrumbs">
                        <li class="breadcrumbs__item">
                            <a href="/" class="breadcrumbs__link">Главная</a>
                        </li>
                        <li class="breadcrumbs__item">
                            Услуги
                        </li>
                    </ul>
                </div>
            </div>
            <!--/. Page Header End -->

            <!-- Page Content Begin -->
            <div class="page__content">
                <div class="container">
                    <div class="row" data-gutter="20">
                        <?php
                        $query = new WP_Query(
                            array(
                                'post_type' => 'post',
                                'post_status' => 'publish',
                                'posts_per_page' => 9,
                                'cat' => [8],
                                'post__not_in' => array(get_the_ID()),
                                'orderby' => 'date',
                                'order' => 'DESC',
                            )
                        );
                        if ($query->have_posts()) {
                            while ($query->have_posts()) {
                                $query->the_post();
                                $dpole = get_post_meta( get_the_ID(), 'vid' );
                                $icon = get_post_meta( get_the_ID(), 'icon' );
                                if ((int)$dpole[0] > 0) $style=" -inverted"; else $style="";
                                if ($icon[0]!='') $ic=$icon[0]; else $ic="features-icon-1.svg";
                                ?>
                                <div class="col-md-6 col-lg-4">
                                    <a href="<?=get_permalink()?>" class="features__item<?=$style?>">
                                        <img src="<?php bloginfo('template_url'); ?>/static/img/general/<?=$ic?>" class="features__icon" alt="">
                                        <div class="features__title"><?php the_title(); ?></div>
                                        <div class="features__text"><?=the_excerpt_max_charlength(150)?></div>
                                        <div class="features__link">Подробнее</div>
                                        <div class="features__background" style="background-image: url('<?=get_the_post_thumbnail_url()?>"></div>
                                    </a>
                                </div>
                                <?php
                            }
                        }
                        ?>
                    </div>
                            <form class="form contacts__form">
                                <h2 class="form__title">Написать нам</h2>
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="control">
                                            <input type="text" id="resheniyaname" name="name" class="control__input" placeholder="Имя">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="control">
                                            <input type="text" id="resheniyaphone" name="phone" class="control__input" placeholder="+7 (***) ***-**-**">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="control">
                                            <input type="text" id="resheniyaemail" name="email" class="control__input" placeholder="Email">
                                        </div>
                                    </div>
                                </div>
                                <div class="control mt-md-3">
                                    <textarea id="resheniyamessage" class="control__textarea" placeholder="Сообщение"></textarea>
                                </div>
                                <div class="text-center">
                                    <button type="button" onclick="getAjaxContactForm('2', document.getElementById('resheniyaname').value, document.getElementById('resheniyamessage').value, document.getElementById('resheniyaphone').value, document.getElementById('resheniyaemail').value);" data-target="#modal-3" data-toggle="modal" class="button -bordered form__button">отправить</button>
                                </div>
                            </form>
                </div>
            </div>
            <!--/. Page Content End -->

        </div>
        <!--/. Page End -->

    </main>
    <!--/. App Main End -->
<?php get_footer(); ?>