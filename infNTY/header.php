<?php
function the_excerpt_max_charlength( $charlength ){
    $excerpt = get_the_excerpt();
    $charlength++;

    if ( mb_strlen( $excerpt ) > $charlength ) {
        $subex = mb_substr( $excerpt, 0, $charlength - 5 );
        $exwords = explode( ' ', $subex );
        $excut = - ( mb_strlen( $exwords[ count( $exwords ) - 1 ] ) );
        if ( $excut < 0 ) {
            echo mb_substr( $subex, 0, $excut );
        } else {
            echo $subex;
        }
        echo '...';
    } else {
        echo $excerpt;
    }
}
?>
<!doctype html>
<html class="no-js" lang="ru">

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title><?php wp_title(''); ?> <?php if ($_SERVER['REQUEST_URI']=="/") bloginfo('name'); ?></title>
    <meta content="<?php bloginfo('description'); ?>" name="description">
    <meta content="" name="keywords">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <meta name="format-detection" content="telephone=no">
    <!-- This make sence for mobile browsers. It means, that content has been optimized for mobile browsers -->
    <meta name="HandheldFriendly" content="true">

    <!-- Stylesheet -->
    <link href="<?php bloginfo('template_url'); ?>/static/css/main.min.css" rel="stylesheet" type="text/css">
    <link href="<?php bloginfo('template_url'); ?>/static/css/separate-css/custom.css" rel="stylesheet" type="text/css">

    <!--  Open Graph Tags -->
    <meta property="og:title" content="<?php wp_title(''); ?> <?php if ($_SERVER['REQUEST_URI']=="/") bloginfo('name'); ?>" />
    <meta property="og:url" content="" />
    <meta property="og:image" content="" />
    <meta property="og:image:type" content="image/jpeg" />
    <meta property="og:image:width" content="500" />
    <meta property="og:image:height" content="300" />
    <meta property="twitter:description" content="" />
    <link rel="image_src" href="" />

    <meta property="og:description" content="<?php bloginfo('description'); ?>">
    <meta name="description" content="<?php bloginfo('description'); ?>" />
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700" rel="stylesheet">

    <!-- Favicons -->
    <link rel="icon" type="image/png" href="<?php bloginfo('template_url'); ?>/favicon.ico">

    <script>
        (function(H){H.className=H.className.replace(/\bno-js\b/,'js')})(document.documentElement)
    </script>
    <!--[if lt IE 9 ]>
    <script src="<?php bloginfo('template_url'); ?>/static/js/separate-js/html5shiv-3.7.2.min.js" type="text/javascript"></script>
    <script src="<?php bloginfo('template_url'); ?>/static/js/separate-js/respond.min.js" type="text/javascript"></script>
    <meta content="no" http-equiv="imagetoolbar">
    <![endif]-->
    <style>
        .navigation__link > a {
            color: #000;
            text-transform: uppercase;
            outline: none;
        }
        .navigation__link > a .-active, .navigation__link > a:focus, .navigation__link > a:hover {
            color: #1a73e8;
            text-decoration: none;
        }
        a
        {
            color: #000;
        }
        a:hover {
            color: #c4c4c4;
            text-decoration: none;
        }
        .menu__link > a {
            text-transform: uppercase;
            color: #fff;
            font-weight: 700;
            margin-bottom: .9375rem;
            display: block;
        }
        .menu__link2 > a {
            font-weight: 400;
            text-transform: none;
            margin-bottom: .3125rem;
            color: #fff;
            display: block;
        }
        .menu__link > a:hover {
            color: #fff;
            text-decoration: none;
            opacity: .8;
        }
        .menu__link2 > a:hover {
            color: #fff;
            text-decoration: none;
            opacity: .8;
        }
        .ttt > a{
            color:#1a73e8;
        }
        .sub-menu
        {
            margin: 0;
            padding: 0 0 .625rem .9375rem;
            text-indent: 0;
            list-style: none;
            list-style-position: outside;
        }
        .menu__link:hover {
            color: #fff;
            text-decoration: none;
            opacity: 1 !important;
        }
    </style>
    <?php wp_head(); ?>
</head>

<body style="background: #f9f9f9">
<?php
$fblnk = get_post_meta( 566, 'fblink' )[0];
$lklnk = get_post_meta( 566, 'linkedinlink' )[0];
?>
<div class="menu">
    <div class="menu__col">
        <button type="button" class="menu__close">Закрыть</button>
        <div class="menu__inner">
            <form class="menu__search" id="searchform" method="get" action="<?php echo home_url('/'); ?>">
                <input type="search" class="menu__search-input" name="s" value="<?php the_search_query(); ?>">
                <button type="submit" class="menu__search-button" value="Search">Искать</button>
            </form>
            <?php
            wp_nav_menu(array('menu' => 'popupmemu1', 'menu_class' => 'menu__list'));
            ?>
            <div class="menu__footer">
                <div class="menu__info">
                    <p><strong>Алматы</strong>
                    </p>
                    <a href="tel:+77272620826" class="menu__phone">+7 (727) 262 08 26</a>
                </div>
                <div class="menu__social">
                    <a href="<?=$fblnk?>" class="menu__footer-link -facebook"></a>
                    <a href="<?=$lklnk?>" class="menu__footer-link -linkedin"></a>
                </div>
            </div>
        </div>
    </div>
    <div class="menu__overlay"></div>
</div>

<!-- App Begin -->
<div class="app">

    <!-- App Wrapper Begin -->
    <div class="app__wrapper">

        <?php
        $transperent="";
        if ($_SERVER['REQUEST_URI']=="/")
        {
            $transperent=" -transparent";
        }
        ?>
        <!-- Header Begin -->
        <header class="header<?=$transperent ?>">
            <div class="container header__container">
                <a href="/" class="logo" title="infin-it">Infin-it</a>
                <div class="header__right">
                        <?php
                        wp_nav_menu(array('menu' => 'menue', 'menu_class' => 'navigation'));
                        ?>
                    <button type="button" class="burger jsBurgerMenu">
                        <span class="burger__item"></span>
                    </button>
                </div>
            </div>
        </header>
        <!--/. Header end -->
