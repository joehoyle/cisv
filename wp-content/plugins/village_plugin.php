<?php

/*
Plugin Name: CISV Village
Plugin URI: http://www.complay.no/villageplugin
Description: Changes the wordpress behaviour to better suit villages.
Version: 1.0
Author: Henning Holgersen
Author URI: http://www.complay.no

Copyright 2008  Henning Holgersen  (email : henning@holgersen.net)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation; either version 2 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA

*/

//add_action(user_register,make_level);
//global $redirect_to 
//$redirect_to = 'index.php';

register_activation_hook( __FILE__, 'cisv_setup' );

function cisv_setup() {

	global $wpdb;
	$table = $wpdb->prefix . 'posts';
	$maxpage = $wpdb->get_var("SELECT max(ID) FROM $table");
	$maxpage = $maxpage+2;

	// GALLERY
	$conf_post = array();
	$conf_post['post_title'] = 'Gallery';
	$conf_post['post_content'] = "[gallery ID=\"$maxpage\" size=\"medium\" columns=\"2\"]";
	$conf_post['post_status'] = 'publish';
	$conf_post['post_author'] = '1';
	$conf_post['post_category'] = array(0);	
	$conf_post['post_type'] = 'page';
	wp_insert_post($conf_post);

	$userdata = get_usermeta('1', 'user_level');
	update_usermeta(1,'user_level','10');


	// CONFIRMATION POST
	$conf_post = array();
	$conf_post['post_title'] = 'Hello world!';
	$conf_post['post_content'] = 'Welcome to WordPress, CISV edition. Now that you have set up your website, you can start filling it with all the content for your village (perhaps you want to start by deleting this post and writing something new). The site is still just like a normal Wordpress Blog, and most of the help found at <a href="http://www.wordpress.org">Wordpress.org</a> is still applicable. The most noticable differences are the following:<br />1. No one can view this site without being logged in - and to be logged in they need to be granted access (or to be a very serious hacker).<br />2. Users logged in as <i>subscriber</i> can not modify their settings. This means you as the administrator can create a single username for all your guests, and feel safe that they won\'t do much damage.';
	$conf_post['post_status'] = 'publish';
	$conf_post['post_author'] = '1';
	$conf_post['post_category'] = array(0);
	wp_insert_post($conf_post);


// PEOPLE PAGE
	$conf_post = array();
	$conf_post['post_title'] = 'leaders';
	$conf_post['post_content'] = 'Here, all the staff, leaders and JCs can write a few lines about themselves, and perhaps post a picture if they want to. To edit this page you need to be more than a subscriber, and it is recommended to give the leaders and JCs access as <i>editor</i>.';
	$conf_post['post_status'] = 'publish';
	$conf_post['post_author'] = '1';
	$conf_post['post_category'] = array(0);
	$conf_post['post_type'] = 'page';
	wp_insert_post($conf_post);

}


// FUNCTIONS TO RESTRICT ACCESS

// checks that everyone has logged in
add_action('init', 'check_login');

function check_login() {

	$uri = 'wp-login.php';
	$self = basename($_SERVER['SCRIPT_FILENAME']);
	if (!is_user_logged_in()) {

		if ($uri != $self) {
			auth_redirect();
		}
	}
		
	if (defined('WP_ADMIN')) {
		if (!is_user2()) {
		wp_redirect(get_option('siteurl'));
		}
	}
}

// destroys RSS feeds, very ugly but it works.
function fb_disable_feed() {  
	wp_die( __('This site is password protected, and the RSS feeds are therefore disabled.') );  
}  
  
add_action('do_feed', 'fb_disable_feed', 1);  
add_action('do_feed_rdf', 'fb_disable_feed', 1);  
add_action('do_feed_rss', 'fb_disable_feed', 1);  
add_action('do_feed_rss2', 'fb_disable_feed', 1);  
add_action('do_feed_atom', 'fb_disable_feed', 1);  

// Checks to see if a user is more than "subscriber"
function is_user2() {
	
	if (current_user_can('edit_posts')) {
		return true;
	} else {
		return false;
	}
	
}


// CREATE WIDGET TO REPLACE NORMAL DASHBOARD WIDGET !!!

class my_widget {

    function display() {
        // print some HTML for the widget to display here.
        
	
        echo "<div class=\"categories\">";
        echo "<h2><em>Dashboard</em></h2>";
        echo "<ul>";
        if (current_user_can('edit_posts')) {
        wp_register();
        }
        echo "<li>";
        wp_loginout();
        echo "</li>";
        echo "</ul>";
        //echo "<canvas id=\"canvas\" width=\"150\" height=\"150\" onclick=\"draw();\">Get it going!</canvas>";
        echo "</div>";
    }
}

register_sidebar_widget('CISV Widget', array('my_widget', 'display'));


?>