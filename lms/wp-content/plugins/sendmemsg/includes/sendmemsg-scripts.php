<?php 

//add scripts

function sendMeMsg_addz_scripts(){

//css

	wp_enqueue_style('sendMeMsg-main-style', plugins_url(__FILE__ ,'/includes/sendmemsg-scripts.php'));

// java script



}
add_action('wp_enqueue_scripts','sendMeMsg_addz_scripts');