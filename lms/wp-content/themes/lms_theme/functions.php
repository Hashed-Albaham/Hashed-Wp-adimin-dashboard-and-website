<?php
// Define constants
if (!defined('LMS_THEME_INC')) {
    define('LMS_THEME_INC', get_template_directory() . '/inc');
}
if (!defined('LMS_THEME_ASSETS_URI')) {
    define('LMS_THEME_ASSETS_URI', get_template_directory_uri() . '/assets');
}

include_once(get_template_directory()."/config.php"); // Keep for now, will modify its content later
include_once(LMS_THEME_INC.'/helpers/enqueue_scripts.php');
include_once(LMS_THEME_INC.'/helpers/helepers_functions.php');
include_once(LMS_THEME_INC.'/features/main_nav.php');
include_once(LMS_THEME_INC.'/shortcodes/index.php');

// Add theme support
add_theme_support( 'title-tag' );
add_theme_support( 'post-thumbnails' );
add_theme_support( 'automatic-feed-links' );
add_theme_support( 'html5', array('search-form', 'comment-form', 'comment-list', 'gallery', 'caption', 'style', 'script') );

// Register navigation menus
function lms_theme_register_menus() {
    register_nav_menus(array(
        'primary_menu' => esc_html__('Primary Menu (Header)', 'lms_theme'),
        'footer_products_menu' => esc_html__('Footer Products Menu', 'lms_theme'),
        'footer_info_menu' => esc_html__('Footer Info Menu', 'lms_theme'),
    ));
}
add_action('after_setup_theme', 'lms_theme_register_menus');

// Load text domain for translation
function lms_theme_load_textdomain() {
    load_theme_textdomain('lms_theme', get_template_directory() . '/languages');
}
add_action('after_setup_theme', 'lms_theme_load_textdomain');










/*

    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/templatemo.css">
    <link rel="stylesheet" href="assets/css/custom.css">

    <!-- Load fonts style after rendering the layout styles -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Roboto:wght@100;200;300;400;500;700;900&display=swap">
    <link rel="stylesheet" href="assets/css/fontawesome.min.css">

*/
//register short code
?>