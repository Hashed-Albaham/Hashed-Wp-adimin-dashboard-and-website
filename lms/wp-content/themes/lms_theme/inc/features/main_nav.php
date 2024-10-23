<?php
// Register a new navigation menu
function add_Main_Nav() {
    register_nav_menu('header-menu', __('Header Menu'));
}
// Hook to the init action hook, run our navigation menu function
add_action('init', 'add_Main_Nav');

?>