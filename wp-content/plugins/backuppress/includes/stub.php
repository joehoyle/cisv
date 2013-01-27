<?php

// Stub function hooks to get data from the blog for initial import
add_action('wp_ajax_nopriv_bps_initialize', '_bps_initialize');
add_action('wp_ajax_nopriv_bps_get_categories', '_bps_get_categories');
add_action('wp_ajax_nopriv_bps_get_files', '_bps_get_files');
add_action('wp_ajax_nopriv_bps_get_file', '_bps_get_file');
add_action('wp_ajax_nopriv_bps_get_posts', '_bps_get_posts');
add_action('wp_ajax_nopriv_bps_get_comments', '_bps_get_comments');
add_action('wp_ajax_nopriv_bps_get_settings', '_bps_get_settings');
add_action('wp_ajax_nopriv_bps_get_categories', '_bps_get_categories');
add_action('wp_ajax_nopriv_bps_get_users', '_bps_get_users');
add_action('wp_ajax_nopriv_bps_mark_complete', '_bps_mark_complete');
add_action('wp_ajax_nopriv_bps_get_tables', '_bps_get_tables');
add_action('wp_ajax_nopriv_bps_get_table_data', '_bps_get_table_data');
add_action('wp_ajax_nopriv_bps_get_ftp_info', '_bps_get_ftp_info');
add_action('wp_ajax_nopriv_bps_fetch_attachment', '_bps_fetch_attachment');
add_action('wp_ajax_nopriv_bps_rollback_content', '_bps_rollback_content');
add_action('wp_ajax_nopriv_bps_rollback_complete', '_bps_rollback_complete');
add_action('wp_ajax_nopriv_bps_get_errors', '_bps_get_errors');
add_action('wp_ajax_nopriv_bps_get_version', '_bps_get_version');

/* STUB FUNCTIONS */

function _bps_initialize() {
	global $wpdb;
	backuppress_verify_request();

	echo '{"files":{';

	$backup_files = get_option('bup_files', 0);
	if($backup_files) {
		// Get a list of files (including core WP files -- in wp-content, ignore plugins, themes and uploads)
		_bps_list_dir(ABSPATH);
	}

	echo '},"post_ids":[';

	// Get a list of post IDs
	$count = $wpdb->get_results("SELECT COUNT(ID) AS count FROM {$wpdb->posts} WHERE post_type != 'revision' ORDER BY ID ASC");
	$post_count = $count[0]->count;

	$started = false;
	for($i = 0; $i < $post_count; $i += 1000) {
		$posts = $wpdb->get_results("SELECT ID FROM {$wpdb->posts} WHERE post_type != 'revision' ORDER BY ID ASC LIMIT $i,1000");
		foreach($posts as $post) {
			echo ($started ? ',' : '') . $post->ID;
			$started = true;
		}
	}

	echo ']}';
	die;
}

function _bps_list_dir($dir) {
	if(substr($dir, strlen($dir) - 1, 1) == "/")
		$dir = substr($dir, 0, strlen($dir) - 1);

	// Check for this we definitely do not want
	$disallowed = array(ABSPATH . 'wp-content/uploads' => true, ABSPATH . 'wp-content/blogs.dir' => true, ABSPATH . 'wp-config.php' => true);
	if(isset($disallowed[$dir])) return;

	$return = array();
	$files = scandir($dir);
	$started = false;
	foreach($files as $file) {
		if(strpos($file, '/') !== FALSE)
			$file = basename($file);

		if(($file == '.') || ($file == '..')) continue;
		if(substr($file, 0, 1) == '.') continue;

		if(is_dir("$dir/$file")) {
			echo ($started ? ',' : '');
			echo json_encode($file);
			echo ":{";
			_bps_list_dir("$dir/$file");
			echo "}";
		}
		else {
			// Make sure it's allowed
			if(isset($disallowed["$dir/$file"])) continue;

			// Make sure we can open the file
			$fp = @fopen("$dir/$file", 'rb');
			if(!$fp) continue;
			@fclose($fp);

			$filesize = @filesize("$dir/$file");

			echo ($started ? ',' : '');
			echo json_encode($file);
			echo ":";
			$object = array('size' => $filesize, 'hash' => @md5_file("$dir/$file"));
			echo json_encode($object);
		}
		$started = true;
	}

	return($return);
}

function _bps_get_dir_size($dir) {
	$size = 0;
        $files = scandir($dir);
        foreach($files as $file) {
                if(($file == '.') || ($file == '..')) continue;
		if(substr($file, 0, 1) == '.') continue;

                if(is_dir("$dir/$file")) {
                        $size += _bps_get_dir_size("$dir/$file");
                }
                else {
                        $size += filesize("$dir/$file");
                }
        }

        return($size);
}

function _bps_human_filesize($bytes) {
	if($bytes > 1073741824) {
		return(round($bytes / 1073741824, 1) . " GB");
	}

	if($bytes > 1048576) {
		return(round($bytes / 1048576, 1) . " MB");
	}

	if($bytes > 1024) {
		return(round($bytes / 1024, 1) . " KB");
	}

	return($bytes . " B");
}

function _bps_get_posts() {
	global $wpdb;
	backuppress_verify_request();

	// Get the post IDs
	$post_ids = '';
	if(isset($_POST['post_ids'])) {
		$post_ids = @$_POST['post_ids'];
	}

	// Get the actual posts
	$posts = $wpdb->get_results("SELECT * FROM {$wpdb->posts} WHERE ID IN ($post_ids)");

	// Define default post taxonomies
        $default_taxonomies = array('category', 'post_tag', 'nav_menu_item', 'link_category', 'post_format');

	echo '[';

	// For each post, attach extra data (attachments, comments, etc.)
	$started = false;
	foreach($posts as $post) {
		// Queue up comment IDs
                $post->comment_ids = array();
                for($i = 0; $i < $post->comment_count; $i += 100) {
                        $number = min($i, $post->comment_count);
                        $comments = get_comments("number=$num&offset=$i&post_id={$post->ID}");
                        foreach($comments as $comment)
                                array_push($post->comment_ids, $comment->comment_ID);
                }

		$post->meta = $wpdb->get_results("SELECT * FROM {$wpdb->postmeta} WHERE post_id = {$post->ID}");

		// Get post tags
		$post->tags = array();
		$tags = get_the_terms($post->ID, 'post_tag');
		if(is_array($tags))
			$post->tags = $tags;

		// Get post categories
		$post->categories = array();
		$categories = get_the_terms($post->ID, 'category');
                if(is_array($categories))
                        $post->categories = $categories;

		// Get the post custom taxonomies
                $taxonomies = get_object_taxonomies($post->post_type);
                $custom_taxonomies = array();
                foreach($taxonomies as $tax) {
                        if(!in_array($tax, $default_taxonomies))
                                $custom_taxonomies[$tax] = array();
                }

                // Get custom post taxonomies
                foreach($custom_taxonomies as $tax => $blah) {
                        $custom_taxonomies[$tax] = wp_get_object_terms($post->ID, $tax);
                }
                $post->custom_taxonomies = $custom_taxonomies;

		// Add post "extras"
	        $tags = get_the_terms($post->ID, 'post_tag');
        	$post_tags = array();
	        if(is_array($tags)) {
        	        foreach($tags as $tag)
                	        array_push($post_tags, $tag->name);
	        }
        	$post->tags_input = $post_tags;

	        // Get post categories
        	$post->categories = array();
	        $categories = get_the_terms($post->ID, 'category');
        	$post_cats = array();
	        if(is_array($categories)) {
        	        foreach($categories as $cat)
                	        array_push($post_cats, $cat->cat_ID);
	        }
        	$post->post_category = $post_cats;

	        // Get the post custom taxonomies
        	$taxonomies = get_object_taxonomies($post->post_type);
	        $custom_taxonomies = array();
        	foreach($taxonomies as $tax) {
                	if(!in_array($tax, $default_taxonomies))
                        	$custom_taxonomies[$tax] = array();
        	}

	        // Get custom post taxonomies
        	foreach($custom_taxonomies as $tax => $blah) {
                	$custom_taxos = wp_get_object_terms($post->ID, $tax);
	                $customs = array();
        	        if(is_array($custom_taxos)) {
                	        foreach($custom_taxos as $term)
                        	        array_push($customs, $term->name);
                	}

	                $custom_taxonomies[$tax] = $customs;
        	}
	        $post->tax_input = $custom_taxonomies;

		if($post->post_type == 'attachment') {
			$post->attachment_url = wp_get_attachment_url($post->ID);
		}

		$post_json = ($started ? ',' : '') . json_encode($post);
		echo $post_json;
		$started = true;
	}

	echo ']';
	die;
}

function _bps_get_comments() {
	backuppress_verify_request();

	// Get the comment IDs
	global $wpdb;
        $comment_ids = array();
        if(isset($_POST['comment_ids'])) {
                $comment_ids = explode(',', @$_POST['comment_ids']);
        }

        if(!is_array($comment_ids) || !sizeof($comment_ids)) {
                echo json_encode((object)array('error' => 'Unable to get comment data.'));
                die;
        }

        $comments = array();
        foreach($comment_ids as $comment_id) {
                $comment = get_comment($comment_id);
                if(is_object($comment))
                        array_push($comments, $comment);

		$comment->comment_meta = $wpdb->get_results("SELECT * FROM {$wpdb->commentmeta} WHERE comment_id = {$comment_id}");
        }

        echo json_encode($comments);
        die;
}

function _bps_get_files() {
	backuppress_verify_request();

	$files = array();
	if(isset($_POST['files'])) {
		$files = json_decode(stripslashes($_POST['files']));
	}

	echo '{';

	$started = false;
	$path = substr(ABSPATH, 0, strlen(ABSPATH) - 1);
	foreach($files as $file) {
		$filename = $file->filename;

		$fp = fopen("{$path}{$filename}", 'rb');
		echo ($started ? ',' : '') . "\"$filename\":\"";

		$chunk_size = 15000;
                while(!feof($fp)) {
                        $contents = fread($fp, $chunk_size);
                        echo base64_encode($contents);
                }
                echo "\"";
                $started = true;
	}

	echo '}';
	die;
}

function _bps_get_file() {
	backuppress_verify_request();

	$file = @$_POST['file'];
	if(!strlen($file)) die;

	$fp = fopen(ABSPATH . $file, 'rb');
	if(!$fp) die;

	while(!feof($fp)) {
		echo fread($fp, 16384);
	}

	die;
}

function _bps_get_settings() {
	backuppress_verify_request();
	global $wpdb;

	echo "{";

	// Get the settings from the options table
	$options = $wpdb->get_results("SELECT * FROM {$wpdb->options}");
	$do_not_send = array('siteurl', 'home', 'rewrite_rules', 'category_children', 'wp_user_roles', 'db_version', 'upload_path');
	$started = false;
	foreach($options as $option) {
		if(in_array($option->option_name, $do_not_send)) continue;
		echo ($started ? ',' : '');
		echo "\"{$option->option_name}\":";
		echo json_encode($option->option_value);
		$started = true;
	}

	echo "}";
	die;
}

function _bps_get_categories() {
	backuppress_verify_request();

	$categories = get_categories('hide_empty=0&exclude=1');
	echo '{"categories":';
	echo json_encode($categories);
	echo '}';
	die;
}

function _bps_get_users() {
	backuppress_verify_request();

	echo '{"users":[';

	global $wpdb;
	$users = $wpdb->get_results("SELECT * FROM {$wpdb->users}");
	$started = false;
	foreach($users as $user) {
		$user->user_meta = $wpdb->get_results("SELECT * FROM {$wpdb->usermeta} WHERE user_id = {$user->ID}");
		echo $started ? ',' : '';
		echo json_encode($user);
		$started = true;
	}

	echo ']}';
	die;
}

function _bps_mark_complete() {
	backuppress_verify_request();

	update_option('bup_stage', 'normal');
	update_option('bup_initial_import_complete', 1);

	echo json_encode((object)array('result' => 'OK'));
	die;
}

function _bps_rollback_complete() {
	backuppress_verify_request();

	delete_option('bup_rollback_data');
	delete_option('bup_rollback_time');
	update_option('bup_stage', 'normal');

	echo json_encode((object)array('result' => 'OK'));
	die;	
}

function _bps_get_ftp_info() {
	backuppress_verify_request();

	$ftp_info = get_option('bup_ftp_info', array());
	echo json_encode($ftp_info);
	die;
}

function _bps_rollback_content() {
	backuppress_verify_request();

	// Get the data
        $data = get_option('bup_rollback_data');
	$actions = $data->results;

	if(sizeof($actions)) {
	        foreach($actions as $index => $action) {
                	$function = "backuppress_rollback_{$action->object_type}";
                        if($error = $function($action)) {
				echo json_encode((object)array('error' => "Unable to {$action->verb} {$action->object_type} to '{$action->data}"));
				die;
			}
                }
       }

	echo json_encode((object)array('result' => 'OK'));
	die;
}

function _bps_fetch_attachment() {
	backuppress_verify_request();

	// Get the data
	$data = get_option('bup_rollback_data');
	$attachments = $data->attachments;

	// Fetch the index
	$index = intval($this->post('index'));
	if(($index < 0) || ($index > (sizeof($attachments) - 1))) {
		echo json_encode((object)array('error' => "Unable to {$action->verb} {$action->object_type} to '{$action->data}"));
                die;
	}

	// Try to figure out if there's an existing file path
	$upload_dir = wp_upload_dir();

	// Parse out any existing date
	$attachment = $attachments[$index];

	// Grab the file path
	$attachment_file = get_attached_file($attachment->post_id);
	if(!$attachment_file) die;

	// Open the file for writing
	$fp = fopen($attachment_file, 'wb');
	if(!$fp) die;

	// Grab it with cURL
	$ch = curl_init($attachment->url);
        curl_setopt($ch, CURLOPT_FILE, $fp);
        curl_exec($ch);

        // Make sure everything worked
        $code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        if($code != 200) die;

        curl_close($ch);
        fclose($fp);

	echo json_encode((object)array('result' => 'OK'));
	die;
}

function _bps_get_errors() {
	backuppress_verify_request();

	$queue = get_option('bup_action_queue');
	$error = get_option('bup_last_error');

	echo json_encode((object)array('queue' => $queue, 'error' => $error));
	die;
}

function _bps_check_version() {
	backuppress_verify_request();

	if(isset($_POST['version']) && strcmp(BACKUPPRESS_VERSION, $_POST['version']))
		update_option('bup_update_available', true);

	echo json_encode((object)array('version' => BACKUPPRESS_VERSION));
	die;
}

function _bps_get_tables() {
	backuppress_verify_request();

	global $wpdb;
	$tables = $wpdb->get_results("SHOW TABLES", ARRAY_N);

	// Get the WP core tables
	$core_table_bases = array_merge(
		is_array($wpdb->tables) ? $wpdb->tables : array(), 
		is_array($wpdb->old_tables) ? $wpdb->old_tables : array(), 
		is_array($wpdb->global_tables) ? $wpdb->global_tables : array(), 
		is_array($wpdb->ms_global_tables) ? $wpdb->ms_global_tables : array()
	);

	$prefixes = array($wpdb->base_prefix);

	// Is this multi-siite? (do not back up all the other tables)
	if(defined('MULTISITE')) {
		// See if we can get the blog list
		$blogs = $wpdb->get_results("SELECT * FROM {$wpdb->blogs}");
		if(is_array($blogs)) {
			foreach($blogs as $blog) {
				if(!in_array("{$wpdb->base_prefix}{$blog->blog_id}_", $prefixes))
					array_push($prefixes, "{$wpdb->base_prefix}{$blog->blog_id}_");
			}
		}
	}

	// Create a list of all the core tables
	$core_tables = array();
	foreach($prefixes as $prefix) {
		foreach($core_table_bases as $base) {
			$core_tables["{$prefix}{$base}"] = true;
		}
	}

	// Okay, figure out which tables don't belong
	$extra_tables = array();
	foreach($tables as $table) {
		$table_name = $table[0];
		if(!isset($core_tables[$table_name])) {
			$desc = $wpdb->get_row("SHOW CREATE TABLE $table_name", ARRAY_N);
			$extra_tables[$table_name] = $desc[1];
		}
	}

	echo json_encode(array('count' => sizeof($extra_tables), 'tables' => $extra_tables));
	die;
}

function _bps_get_table_data() {
	backuppress_verify_request();

	global $wpdb;
	$tables = array();
        if(isset($_POST['tables'])) {
                $tables = explode(',', $_POST['tables']);
        }

	echo '{';
	$started = false;
	foreach($tables as $table) {
		echo $started ? ',' : '';
		echo json_encode($table);
		echo ':[';

		$table_rows = $wpdb->get_row("SELECT COUNT(*) AS count FROM `$table`");

		$started_table = false;
		for($i = 0; $i < $table_rows->count; $i += 100) {
			$rows = $wpdb->get_results("SELECT * FROM `$table` LIMIT $i,100");

			foreach($rows as $row) {
				echo $started_table ? ',' : '';
				echo json_encode($row);
				$started_table = true;
			}
		}

		echo ']';
		$started = true;
	}

	echo '}';
	die;
}
