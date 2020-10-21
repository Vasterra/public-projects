<?php get_header(); ?>
<?php global $p123; ?>
<script>
    let ids=[];
    let end=0;
    let ids2=[];
    let end2=0;
    let ids3=[];
    let end3=0;
    let ids4=[];
    let end4=0;
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
                <div class="page__topbar">
                    <ul class="nav tabs">
                        <li class="tabs__item">
                            <a class="tabs__link active" id="t1" href="/novosti/#" role="tab">Новости</a>
                        </li>
                        <li class="tabs__item">
                            <a class="tabs__link" id="t2" href="/novosti/#sobitiya" role="tab">События</a>
                        </li>
                        <li class="tabs__item">
                            <a class="tabs__link" id="t3" href="/novosti/#meropriyatiya" role="tab">Мероприятия</a>
                        </li>
                        <li class="tabs__item">
                            <a class="tabs__link" id="t4" href="/novosti/#smionas" role="tab">СМИ о нас</a>
                        </li>
                    </ul>
                    <!--<div class="category-select dropdown">
                    <a href="#" class="category-select__link" data-toggle="dropdown">Новости</a>
                    <div class="dropdown-menu category-select__menu">
                        <a href="#" class="category-select__sublink">Все категории</a>
                        <a href="#" class="category-select__sublink">Корпоративный сектор</a>
                        <a href="#" class="category-select__sublink">Государственный сектор</a>
                    </div>
                </div>-->
                    <button type="button" class="button -bordered page__topbar-button" data-target="#modal-1" data-toggle="modal">контакт с pr-службой</button>
                </div>
                <div class="tab-content">
                    <div class="tab-pane active" id="tabs-1" role="tabpanel">

                        <div class="row" vertical-gutter="40" data-gutter="40" id="pizdez1">
                            <?php
                            $query = new WP_Query(
                                array(
                                    'post_type' => 'post',
                                    'post_status' => 'publish',
                                    'posts_per_page' => 4,
                                    'cat' => [17],  //1 7 8
                                    'orderby' => 'date',
                                    'order' => 'DESC',
                                )
                            );


                            if ($query->have_posts()) {
                                while ($query->have_posts()) {
                                    $query->the_post();
                                    $date = get_the_date( "d.m.Y");
                                    ?>
                                    <script> ids.push("<?=get_the_ID() ?>"); </script>
                                    <div class="col-md-6">
                                        <div class="news">
                                            <a href="<?php the_permalink(); ?>">
                                                <img src="<?=get_the_post_thumbnail_url()?>" class="news__img" alt="123">
                                            </a>
                                            <div class="news__content">
                                                <a href="<?php the_permalink(); ?>" class="news__title"><?php the_title(); ?></a>
                                                <div class="news__text">
                                                    <?=new_excerpt_more(the_excerpt_max_charlength(150))?>
                                                </div>
                                                <a href="<?php the_permalink(); ?>" class="news__date"><?=$date ?></a> /
                                                <?php
                                                $categories = get_the_category( get_the_ID() );
                                                $i=1;
                                                foreach ($categories as $ct) {
                                                    $hash=", ";
                                                    if($i==1) $hash="";
                                                    echo $hash.$ct->name;
                                                    $i++;
                                                }
                                                ?>
                                            </div>
                                        </div>
                                    </div>
                                    <?php
                                }
                            }
                            ?>
                        </div>
                        <?php
                        $category = get_category(17);
                        $count = $category->category_count;
                        $stvis="";
                        if ($count<5) $stvis="display: none";
                        ?>
                        <div class="text-center mt-5" id="ebat1" style="<?=$stvis?>">
                            <a href="javascript:void(0);" onclick="getAjaxViebu(10, '17', ids, '#pizdez1', 'ebat1')">Показать еще</a>
                        </div>
                    </div>
                    <div class="tab-pane" id="tabs-2" role="tabpanel">
                        <div class="row" vertical-gutter="40" data-gutter="40" id="pizdez2">
                            <?php
                            $query = new WP_Query(
                                array(
                                    'post_type' => 'post',
                                    'post_status' => 'publish',
                                    'posts_per_page' => 4,
                                    'cat' => [7],  //1 7 8
                                    'orderby' => 'date',
                                    'order' => 'DESC',
                                )
                            );


                            if ($query->have_posts()) {
                                while ($query->have_posts()) {
                                    $query->the_post();
                                    $date = get_the_date( "d.m.Y");
                                    ?>
                                    <script> ids2.push("<?=get_the_ID() ?>"); </script>
                                    <div class="col-md-6">
                                        <div class="news">
                                            <a href="<?php the_permalink(); ?>">
                                                <img src="<?=get_the_post_thumbnail_url()?>" class="news__img" alt="123">
                                            </a>
                                            <div class="news__content">
                                                <a href="<?php the_permalink(); ?>" class="news__title"><?php the_title(); ?></a>
                                                <div class="news__text">
                                                    <?=new_excerpt_more(the_excerpt_max_charlength(150))?>
                                                </div>
                                                <a href="<?php the_permalink(); ?>" class="news__date"><?=$date ?></a> /
                                                <?php
                                                $categories = get_the_category( get_the_ID() );
                                                $i=1;
                                                foreach ($categories as $ct) {
                                                    $hash=", ";
                                                    if($i==1) $hash="";
                                                    echo $hash.$ct->name;
                                                    $i++;
                                                }
                                                ?>
                                            </div>
                                        </div>
                                    </div>
                                    <?php
                                }
                            }
                            ?>
                        </div>
                        <?php
                        $category = get_category(7);
                        $count = $category->category_count;
                        $stvis="";
                        if ($count<5) $stvis="display: none";
                        ?>
                        <div class="text-center mt-5" id="ebat2" style="<?=$stvis?>">
                            <a href="javascript:void(0);" onclick="getAjaxViebu(11, '7', ids2, '#pizdez2', 'ebat2')">Показать еще</a>
                        </div>
                    </div>
                    <div class="tab-pane" id="tabs-3" role="tabpanel">
                        <div class="row" vertical-gutter="40" data-gutter="40" id="pizdez3">
                            <?php
                            $query = new WP_Query(
                                array(
                                    'post_type' => 'post',
                                    'post_status' => 'publish',
                                    'posts_per_page' => 4,
                                    'cat' => [18],  //1 7 8
                                    'orderby' => 'date',
                                    'order' => 'DESC',
                                )
                            );


                            if ($query->have_posts()) {
                                while ($query->have_posts()) {
                                    $query->the_post();
                                    $date = get_the_date( "d.m.Y");
                                    ?>
                                    <script> ids3.push("<?=get_the_ID() ?>"); </script>
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
                                                <a href="<?php the_permalink(); ?>" class="news__date"><?=$date ?></a> /
                                                <?php
                                                $categories = get_the_category( get_the_ID() );
                                                $i=1;
                                                foreach ($categories as $ct) {
                                                    $hash=", ";
                                                    if($i==1) $hash="";
                                                    echo $hash.$ct->name;
                                                    $i++;
                                                }
                                                ?>
                                            </div>
                                        </div>
                                    </div>
                                    <?php
                                }
                            }
                            ?>
                        </div>
                        <?php
                        $category = get_category(18);
                        $count = $category->category_count;
                        $stvis="";
                        if ($count<5) $stvis="display: none";
                        ?>
                        <div class="text-center mt-5" id="ebat3" style="<?=$stvis?>">
                            <a href="javascript:void(0);" onclick="getAjaxViebu(12, '18', ids3, '#pizdez3', 'ebat3')">Показать еще</a>
                        </div>
                    </div>
                    <div class="tab-pane" id="tabs-4" role="tabpanel">
                        <div class="row" vertical-gutter="40" data-gutter="40" id="pizdez4">
                            <?php
                            $query = new WP_Query(
                                array(
                                    'post_type' => 'post',
                                    'post_status' => 'publish',
                                    'posts_per_page' => 4,
                                    'cat' => [19],  //1 7 8
                                    'orderby' => 'date',
                                    'order' => 'DESC',
                                )
                            );


                            if ($query->have_posts()) {
                                while ($query->have_posts()) {
                                    $query->the_post();
                                    $date = get_the_date( "d.m.Y");
                                    ?>
                                    <script> ids4.push("<?=get_the_ID() ?>"); </script>
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
                                                <a href="<?php the_permalink(); ?>" class="news__date"><?=$date ?></a> /
                                                <?php
                                                $categories = get_the_category( get_the_ID() );
                                                $i=1;
                                                foreach ($categories as $ct) {
                                                    $hash=", ";
                                                    if($i==1) $hash="";
                                                    echo $hash.$ct->name;
                                                    $i++;
                                                }
                                                ?>
                                            </div>
                                        </div>
                                    </div>
                                    <?php
                                }
                            }
                            ?>
                        </div>
                        <?php
                        $category = get_category(19);
                        $count = $category->category_count;
                        $stvis="";
                        if ($count<5) $stvis="display: none";
                        ?>
                        <div class="text-center mt-5" id="ebat4" style="<?=$stvis?>">
                            <a href="javascript:void(0);" onclick="getAjaxViebu(13, '19', ids4, '#pizdez4', 'ebat4')">Показать еще</a>
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
    function hashKoder(hash) {
        switch (hash) {
            //       case "#story": alert(1); break;
            case "#sobitiya":
                document.getElementById('t2').className='tabs__link active';
                document.getElementById('tabs-2').style.display="block";
                document.getElementById('t1').className='tabs__link';
                document.getElementById('tabs-1').style.display="none";
                document.getElementById('t3').className='tabs__link';
                document.getElementById('tabs-3').style.display="none";
                document.getElementById('t4').className='tabs__link';
                document.getElementById('tabs-4').style.display="none";
                break;
            case "#meropriyatiya":
                document.getElementById('t3').className='tabs__link active';
                document.getElementById('tabs-3').style.display="block";
                document.getElementById('t1').className='tabs__link';
                document.getElementById('tabs-1').style.display="none";
                document.getElementById('t2').className='tabs__link';
                document.getElementById('tabs-2').style.display="none";
                document.getElementById('t4').className='tabs__link';
                document.getElementById('tabs-4').style.display="none";
                break;
            case "#smionas":
                document.getElementById('t2').className='tabs__link';
                document.getElementById('tabs-2').style.display="none";
                document.getElementById('t3').className='tabs__link';
                document.getElementById('tabs-3').style.display="none";
                document.getElementById('t1').className='tabs__link';
                document.getElementById('tabs-1').style.display="none";
                document.getElementById('t4').className='tabs__link active';
                document.getElementById('tabs-4').style.display="block";
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

    function getAjaxViebu(operation, category, ids, idtab, idbutton) {
        $.ajax({
            type:'POST',
            url:'/ajax.php',
            data:{
                'operation':operation,
                'category': category,
                'ids': ids
            },
            success:function(html){
                $(idtab).append(html);
                switch (idbutton) {
                    case 'ebat1': if (end>0) document.getElementById(idbutton).style.display='none'; break;
                    case 'ebat2': if (end2>0) document.getElementById(idbutton).style.display='none'; break;
                    case 'ebat3': if (end3>0) document.getElementById(idbutton).style.display='none'; break;
                    case 'ebat4': if (end4>0) document.getElementById(idbutton).style.display='none'; break;
                }
           },
            error:function(html){
                $('body').css('cursor','default');
                alert('Ошибка подключения!');
            },
        });
    }
</script>
<?php get_footer(); ?>
