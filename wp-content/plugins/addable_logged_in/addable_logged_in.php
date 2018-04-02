<?php
   /*
   Plugin Name: Addable Logged In
   Plugin URI: http://www.ltcomms.com
   description: A plugin that controls whether user is logged in or not.
   Version: 1.0
   Author: Lewis Stevens
   Author URI: http://www.ltcomms.com
   */
   
   function addable_logged_in(){
	   if(isset($_COOKIE['cookieKey1']) && strlen($_COOKIE['cookieKey1']) > 0){
		   header('Location:http://portal.ltcomms.com');
	   }
   }
   
   add_action("wp_head", "addable_logged_in");
?>