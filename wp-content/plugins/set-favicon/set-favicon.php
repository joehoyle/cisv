<?php
/*
Plugin Name: Alex Set Favicon
Plugin URI: http://anthony.strangebutfunny.net/my-plugins/alex-set-favicon/
Description: Alex Set Favicon allows any user to easily set and update their favicon.
Version: 6.0
Author: Alex and Anthony Zbierajewski
Author URI: http://www.strangebutfunny.net/
license: GPL 
*/
add_option('alex_set_favicon_value', 'nothing');
add_action('wp_head', 'alex_set_favicon_do');
add_action('login_head', 'alex_set_favicon_do');
add_action('admin_head', 'alex_set_favicon_do');
add_action('admin_menu', 'alex_set_favicon_menu');
function alex_set_favicon_do(){
echo '<!-- Begin Alex Favicon --><link rel="icon" href="' . get_option('alex_set_favicon_value') . '"><!-- End Alex Favicon -->';
}
function alex_set_favicon_menu(){
add_options_page( 'Set Favicon', 'Set Favicon', 'manage_options', 'alex-set-favicon', 'alex_set_favicon_admin');
}
function alex_set_favicon_admin(){
	echo '<div class="wrap">';
	if(isset($_REQUEST["alex_favicon_value"])){
	update_option('alex_set_favicon_value', $_REQUEST["alex_favicon_value"]);
	echo '<b>Settings Updated!</b>';
	}
	echo '<p>Go to your <a href="upload.php">Media</a> area, and upload a new file. Copy then paste the file url below then click Save Changes. Alternatively, you can upload them anywhere and paste the URL below.</p>';
	echo '<p><form name="alex_favicon" action="" method="post"></p>';
	echo '<p>Favicon Path: <input type="text" name="alex_favicon_value" value="' . get_option('alex_set_favicon_value') . '" /></p>';
	echo '<p><input type="submit" class="button-primary" value="Save Changes" /></p>';
	echo '<p></form></p>';
	echo 'Please visit my site <a href="http://www.strangebutfunny.net/">http://www.strangebutfunny.net/</a>';
	echo '</div>';
}
?>