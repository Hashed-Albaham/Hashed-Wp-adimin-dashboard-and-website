<?php 
/*
* Plugin name: sendMeMsg
* Description: sendMeMsg is widget that display Whatsapp send message button to your'e direct account , you will enter your'e desire title and whatsapp number account and you ready to go .
* Author: ofek nakar 
* Version: 1.0.0
* Plugin URI: /sendMeMsg
* Author URI: https://www.whoisofek.in
* Text Domain:  sendMeMsg
* License: GPLv2 or later
* License URI: https://www.gnu.org/licenses/gpl-2.0.html

*/
if(!defined('ABSPATH')){
  exit;
}

// load scripts from another file
require_once(plugin_dir_path(__FILE__).'/includes/sendmemsg-scripts.php');
require_once(plugin_dir_path(__FILE__).'/includes/sendmemsg-class.php');

function register_sendmemsg(){
	register_widget('SendMe_Msg_Widget');
}
add_action('widgets_init','register_sendmemsg');


?>