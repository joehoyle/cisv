<?php

/*
Plugin Name: Save404
Plugin URI:
Description: Save a record from the times your users encounter a 404-error, so you know the extent of the problem, where the errors come from, and are able to redirect common 404-errors.
Version: 1.0
Author: 
Author URI: 
*/

/*  Copyright 2010 Nobody

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

// Some definitions
global $wpdb;
define('SAVE404_ERRORS', $wpdb->prefix . 'save404_log');
define('SAVE404_SUMMARY', $wpdb->prefix . 'save404');
define('USER_LEVEL_TO_ACCESS', 5);

// The main function, which runs on a redirect, and saves the data
function save404_main() {
	
	if(is_404()) {
		global $wpdb;
		
		$url = htmlspecialchars($_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']);
		$referrer = htmlspecialchars($_SERVER['HTTP_REFERRER']);
		
		// CHECK TO SEE IF IT HAS A REDIRECT
		$sql = "SELECT * FROM " . SAVE404_SUMMARY . " WHERE URL = '" . $url . "' ORDER BY id ASC LIMIT 1";
		$row = $wpdb->get_row($sql);
		
		if ($row->id > 0) {
			wp_redirect($row->redirect, 301);
		}
	
		// SAVE 404 TO LOG
		
		$errordata = array('URL' => $url, 'referrer' => $referrer, 'time' => time());
		$wpdb->insert(SAVE404_ERRORS, $errordata);
	
	
		// SAVE 404 TO SUMMARY
		$q = "SELECT * FROM " . SAVE404_SUMMARY . " WHERE URL = '" . $url . "' ORDER BY id DESC LIMIT 1";

		$results = $wpdb->get_row($q);
		if ($results->id == '') {
			$wpdb->insert(SAVE404_SUMMARY, array('URL' => $url, 'count' => 1));
		} else {
			$new_count = $results->count + 1;
			$wpdb->update(SAVE404_SUMMARY, array('count' => $new_count), array('id' => $results->id));
		
		}
	}
}


// Gets called in save404_save_summary if $_POST['redirect'] and $_POST['id'] is set
function save404_save_redirect($url, $id) {

	global $wpdb;
	$altered_rows = $wpdb->update(SAVE404_SUMMARY, array('redirect' => $url), array('id' => $id));

}


// Provides the interface for seeing 404s and adding redirects
function save404_save_summary() {
	// Check that person can edit
	//if(!);
	
	if (isset($_POST['redirect']) && isset($_POST['id']) ) {
	
		save404_save_redirect($_POST['redirect'], $_POST['id']);
	
	}
	
	if(htmlspecialchars($_GET['scope']) == 'all') {
		$query = "SELECT * FROM " . SAVE404_SUMMARY . " ORDER BY count DESC LIMIT 20";
	} else {
		$query = "SELECT * FROM " . SAVE404_SUMMARY . " WHERE ISNULL(redirect) ORDER BY count DESC LIMIT 20";
	}

	global $wpdb;
	
	$results = $wpdb->get_results($query);

	
	?>
	<div class="wrap">
	<h2>Faulty URLs</h2>
	
	<ul class="subsubsub">
	<?php echo('<li><a href="' . get_bloginfo('wpurl') . '/wp-admin/admin.php?page=save404-stats"'); 
	echo('>Without redirect</a> | ');
	// <span class="count">(' . $all	. ')</span> | </li>
	echo('<li><a href="' . get_bloginfo('wpurl') . '/wp-admin/admin.php?page=save404-stats&scope=all"');
	echo('>All</a>'); 
	// <span class="count">(' . $all	. ')</span> | </li>'
	?>
	
	</ul>
	
	<table class="widefat" cellspacing="0">
	<thead><tr>
	<th>URL</th>
	<th>Hits</th>
	<th>Redirect to</th>
	<th>Notes</th>
	</tr></thead>
	<tbody>
	<?php
	foreach ($results as $result) {
		echo "<tr>";
		echo "<td>" . $result->URL . "</td>";
		// echo " - ";
		echo "<td>" . $result->count . "</td>";
		?>
		<td><form action="<?php bloginfo('url'); ?>/wp-admin/admin.php?page=save404-stats" method="post"><input type="text" name="redirect" value="<?php echo $result->redirect ?>" />
		<input type="hidden" value="<?php echo $result->id; ?>" name="id"><input type="submit" value="Endre" class="button" /></td></form> <td><?php 
		if ($_POST['redirect'] == $result->redirect && $_POST['id'] == $result->id) {
			echo "Redirect successful!";
		}
		?>
		
		</td></tr>
		
		<?php
	}
	?>
	</tbody></table></div>
	
	<?php
}

// ALPHA-stage development, remove from production versions
function save404_alternate() {

	if (isset($_POST['redirect']) && isset($_POST['id']) ) {
	
		save404_save_redirect($_POST['redirect'], $_POST['id']);
	
	}


	global $wpdb;
	$query = "SELECT id, URL, referrer, count(stupidvar) as count, FROM " . SAVE404_ERRORS . " GROUP BY referrer";
	$results = $wpdb->query($query);

	
	?>
	<div class="wrap">
	<h2>Faulty URLs</h2>
	<table class="widefat" cellspacing="0">
	<thead><tr>
	<th>URL</th>
	<th>Count</th>
	<th>Redirect to</th>
	<th>           </th>
	</tr></thead>
	<tbody>
	<?php
	foreach ($results as $result) {
		echo "<tr>";
		echo "<td>" . $result->URL . "</td>";
		// echo " - ";
		echo "<td>" . $result->count . "</td>";
		?>
		<td><form action="<?php bloginfo('url'); ?>/wp-admin/admin.php?page=save404-stats" method="post"><input type="text" name="redirect" value="<?php echo $result->redirect ?>" />
		<input type="hidden" value="<?php echo $result->id; ?>" name="id"><input type="submit" value="Endre" class="button" /></td></form> <td><?php 
		if ($_POST['redirect'] == $result->redirect && $_POST['id'] == $result->id) {
			echo "Redirect successfuly stored!";
		}
		?>
		
		</td></tr>
		
		<?php
	}
	?>
	</tbody></table></div>
	
	<?php

		
		
}


// Adds the admin menues and options
function save404_admin_stuff() {
	add_menu_page('Save404 Admin', 'Save404', USER_LEVEL_TO_ACCESS, 'save404-stats', 'save404_save_summary');
//	add_options_page( 'Save 404', 'Save404', USER_LEVEL_TO_ACCESS, __FILE__, 'save404_options' );
}

/*
function save404_options() {
	
	$s4o = get_options('save404_settings');
	
	?>
	<div class="wrap">
	<h2>Save404 options</h2>
	
	</div>
<?php
}
*/

function save404_install() {
	global $wpdb;
	
	$charset_collate = '';
	if(version_compare(mysql_get_server_info(), '4.1.0', '>=')) {
		if(!empty($wpdb->charset)) {
			$charset_collate = "DEFAULT CHARACTER SET $wpdb->charset";
		}
		if(!empty($wpdb->collate)) {
			$charset_collate .= " COLLATE $wpdb->collate";
		}
	}
	
	$sql = "CREATE TABLE " . SAVE404_SUMMARY . " (
	id INTEGER(6) AUTO_INCREMENT,
	URL TEXT,
	count INTEGER(6),
	redirect TEXT,
	PRIMARY KEY (id)
	) $charset_collate";
	
	
	$wpdb->query($sql);
	
	$sql_errors = "CREATE TABLE " . SAVE404_ERRORS . " (
	id INTEGER(6) AUTO_INCREMENT,
	URL TEXT,
	referrer TEXT,
	time INTEGER(11),
	PRIMARY KEY (id)
	) $charset_collate";
	
	$wpdb->query($sql_errors);

}

function save404_uninstall() {
	global $wpdb;
	
	$sql = "DROP TABLE IF EXISTS "
	 . SAVE404_SUMMARY . ", "
	 . SAVE404_ERRORS;
	
	$wpdb->query($sql);

}


add_action( 'template_redirect', 'save404_main');
add_action( 'admin_menu', 'save404_admin_stuff' );
register_activation_hook(__FILE__, 'save404_install');
register_uninstall_hook(__FILE__, 'save404_uninstall');
?>