<?php
function enqueue_styles() {
    wp_enqueue_style( 'whitesquare-style', get_stylesheet_uri());
    wp_register_style('font-style', 'http://fonts.googleapis.com/css?family=Oswald:400,300');
    wp_enqueue_style( 'font-style');
}
add_action('wp_enqueue_scripts', 'enqueue_styles');

function enqueue_scripts () {
    wp_register_script('html5-shim', 'http://html5shim.googlecode.com/svn/trunk/html5.js');
    wp_enqueue_script('html5-shim');
}
add_action('wp_enqueue_scripts', 'enqueue_scripts');
if (function_exists('add_theme_support')) {
    add_theme_support('menus');
}
if (!function_exists('mytheme_setup')):
    function mytheme_setup(){
        add_theme_support('post-thumbnails');
        set_post_thumbnail_size(1200, 9999);
        add_theme_support( 'post-thumbnails', array( 'post', 'page' ) );
    }
endif;
add_action('after_setup_theme', 'mytheme_setup');
function new_excerpt_more($more) {

    global $post;

    return " <a class='intro-news__link' href='". get_permalink($post->ID) . "'>Подробнее</a>";

}
/**
 * Настройка SMTP
 *
 * @param PHPMailer $phpmailer объект мэилера
 */
function mihdan_send_smtp_email( PHPMailer $phpmailer ) {
    $phpmailer->isSMTP();
    $phpmailer->Host       = SMTP_HOST;
    $phpmailer->SMTPAuth   = SMTP_AUTH;
    $phpmailer->Port       = SMTP_PORT;
    $phpmailer->Username   = SMTP_USER;
    $phpmailer->Password   = SMTP_PASS;
    $phpmailer->SMTPSecure = SMTP_SECURE;
    $phpmailer->From       = SMTP_FROM;
    $phpmailer->FromName   = SMTP_NAME;
}
add_action( 'phpmailer_init', 'mihdan_send_smtp_email' );

remove_action( 'wp_head', 'feed_links',  2 );
remove_action( 'wp_head',  'feed_links_extra',  3 );
remove_action( 'wp_head',  'rsd_link' );
remove_action( 'wp_head',  'wlwmanifest_link' );
remove_action( 'wp_head',  'index_rel_link' );
remove_action( 'wp_head', 'parent_post_rel_link', 10, 0 );
remove_action( 'wp_head', 'start_post_rel_link', 10, 0 );
remove_action( 'wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0 );
remove_action( 'wp_head', 'wp_generator' );
remove_action( 'wp_head', 'wp_shortlink_wp_head', 10, 0 );
function advanced_search_query($query) {

    if($query->is_search()) {

        // tag search
        if (isset($_GET['tag'])) {
        //    $query->set('tag', 'qr');
        }
        return $query;
    }

}
add_action('pre_get_posts', 'advanced_search_query', 1000);