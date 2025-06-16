<?php

/**
* Proper way to enqueue scripts and styles
*/
function wpdocs_lms_scripts() {
    // Theme stylesheet.
    wp_enqueue_style( 'lms-style', get_stylesheet_uri() );

    // Styles
    wp_enqueue_style('bootstrap-css', LMS_THEME_ASSETS_URI . '/css/bootstrap.min.css');
    wp_enqueue_style('templatemo', LMS_THEME_ASSETS_URI . '/css/templatemo.css', array('bootstrap-css'));
    wp_enqueue_style('custom_css', LMS_THEME_ASSETS_URI . '/css/custom.css', array('templatemo'));
    wp_enqueue_style('fontawesome', LMS_THEME_ASSETS_URI . '/css/fontawesome.min.css');
    wp_enqueue_style('lms-roboto-font', 'https://fonts.googleapis.com/css2?family=Roboto:wght@100;200;300;400;500;700;900&display=swap', array(), null);

    // Slick CSS (assuming it's in assets/css/)
    wp_enqueue_style( 'slick-css', LMS_THEME_ASSETS_URI . '/css/slick.min.css');
    wp_enqueue_style( 'slick-theme-css', LMS_THEME_ASSETS_URI . '/css/slick-theme.css', array('slick-css'));

    // WordPress bundled jQuery
    wp_enqueue_script('jquery');

    // Scripts (loaded in footer - true by default for wp_enqueue_script)
    wp_enqueue_script('bootstrap-js', LMS_THEME_ASSETS_URI . '/js/bootstrap.bundle.min.js', array('jquery'), null, true);
    wp_enqueue_script('templatemo', LMS_THEME_ASSETS_URI . '/js/templatemo.js', array('jquery', 'bootstrap-js'), null, true);
    wp_enqueue_script('custom-js', LMS_THEME_ASSETS_URI . '/js/custom.js', array('jquery'), null, true);

    // Slick JS (assuming it's in assets/js/)
    wp_enqueue_script('slick', LMS_THEME_ASSETS_URI . '/js/slick.min.js', array('jquery'), null, true);

    // Comments reply script
    if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
        wp_enqueue_script( 'comment-reply' );
    }
}
add_action('wp_enqueue_scripts', 'wpdocs_lms_scripts');


?>