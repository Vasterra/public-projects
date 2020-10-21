<?php get_header(); ?>
<script>
    let ids=[];
    let end=0;
</script>
    <!-- App Main Begin -->
    <main role="main" class="app__main">

        <!-- Page Begin -->
        <div class="page">

            <!-- Page Header Begin -->
            <div class="page__header" style="background-image: url('<?php bloginfo('template_url'); ?>/static/img/content/header-bg.jpg')">
                <div class="container">
                    <div class="page__header-title typed-effect">
                        <div id="js-typed-strings">
                            <p><?php echo single_cat_title( '', false ); ?></p>
                        </div>
                    </div>
                    <ul class="breadcrumbs">
                        <li class="breadcrumbs__item">
                            <a href="/" class="breadcrumbs__link">Главная</a>
                        </li>
                        <li class="breadcrumbs__item">
                            <a href="/novosti/" class="breadcrumbs__link">ПРЕСС-ЦЕНТР</a>
                        </li>
                        <li class="breadcrumbs__item">
                            <?php echo single_cat_title( '', false ); ?>
                        </li>
                    </ul>
                </div>
            </div>
            <!--/. Page Header End -->
            <!-- Page Content Begin -->
            <div class="page__content">
                <div class="container">
                    <section>
                        <div class="row" vertical-gutter="40" data-gutter="40" id="masters">
                            <?php
                            $categories = get_the_category();
                            $category_id = $categories[0]->cat_ID;
                            $query = new WP_Query(
                                array(
                                    'post_type' => 'post',
                                    'post_status' => 'publish',
                                    'posts_per_page' => 4,
                                    'cat' => [$category_id],
                                    'orderby' => 'date',
                                    'order' => 'DESC',
                                )
                            );

                            //'post__not_in' => array(get_the_ID()),
                            //'post__not_in' => [ 2, 5, 12, 14, 20 ]

                            if ($query->have_posts()) {
                                while ($query->have_posts()) {
                                    $query->the_post();
                                    $date = get_the_date( "d.m.Y");
                                    ?>
                                    <script> ids.push("<?=get_the_ID() ?>"); </script>
                                    <div class="col-md-6">
                                        <div class="news">
                                            <a href="<?php the_permalink(); ?>">
                                                <img src="<?=get_the_post_thumbnail_url()?>" class="news__img">
                                            </a>
                                            <div class="news__content">
                                                <a href="<?php the_permalink(); ?>" class="news__title"><?php the_title(); ?></a>
                                                <div class="news__text">
                                                    <?=new_excerpt_more(the_excerpt_max_charlength(150))?>
                                                </div>
                                                <a href="<?php the_permalink(); ?>" class="news__date"><?=$date ?></a> / <?php the_category(', '); ?>
                                            </div>
                                        </div>
                                    </div>
                                    <?php
                                }
                            }
                            ?>
                        </div>
                        <?php
                        $category = get_category($category_id);
                        $count = $category->category_count;
                        $stvis="";
                        if ($count<5) $stvis="display: none";
                        ?>
                        <div class="text-center mt-5" id="bider" style="<?=$stvis?>">
                            <a href="javascript:void(0);" onclick="getAjaxXXX(10, '<?=$category_id?>', ids)">Посмотреть ещё</a>
                        </div>
                    </section>
                </div>
            </div>
            <!--/. Page Content End -->
        </div>
        <!--/. Page End -->
    </main>
    <!--/. App Main End -->
<script>
    function getAjaxXXX(operation, category, ids) {
    $.ajax({
    type:'POST',
    url:'/ajax.php',
    data:{
    'operation':operation,
    'category': category,
    'ids': ids
    },
    success:function(html){
    $('#masters').append(html);
    if (end>0) document.getElementById('bider').style.display='none';
    },
    error:function(html){
    $('body').css('cursor','default');
    alert('Ошибка подключения!');
    },
    });
    }
</script>
<?php get_footer(); ?>
<?php get_footer(); ?>