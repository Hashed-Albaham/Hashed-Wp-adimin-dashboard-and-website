<?php

/**
* Proper way to enqueue scripts and styles
*/
function wpdocs_lms_scripts() {
    wp_enqueue_style('bootstrap-css', get_template_directory_uri().'/assets/css/bootstrap.min.css');
    wp_enqueue_style('templatemo', get_template_directory_uri() . '/assets/css/templatemo.css');
    wp_enqueue_style('custom_css', get_template_directory_uri() . '/assets/css/custom.css');
    wp_enqueue_style('font_roboto', 'https://fonts.googleapis.com/css2?family=Roboto:wght@100;200;300;400;500;700;900&display=swap');
    wp_enqueue_style('fontawesome', get_template_directory_uri() . '/assets/css/fontawesome.min.css');


    wp_enqueue_script('jquery', get_template_directory_uri() . '/assets/js/jquery-1.11.0.min.js', array(), null, true);
    wp_enqueue_script('jquery-migrate', get_template_directory_uri() . '/assets/js/jquery-migrate-1.2.1.min.js', array('jquery'), null, true);
    wp_enqueue_script('bootstrap-js', get_template_directory_uri() . '/assets/js/bootstrap.bundle.min.js', array('jquery'), null, true);
    wp_enqueue_script('templatemo', get_template_directory_uri() . '/assets/js/templatemo.js', array('jquery'), null, true);
    wp_enqueue_script('custom-js', get_template_directory_uri() . '/assets/js/custom.js', array('jquery'), null, true);
    wp_enqueue_script('slick', get_template_directory_uri() . '/assets/js/slick.min.js', array('jquery'), null, true);


}
add_action('wp_enqueue_scripts', 'wpdocs_lms_scripts');


?>