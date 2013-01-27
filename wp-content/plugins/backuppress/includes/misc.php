<?php

function backup_rough_size() {
	global $wpdb;

	// Get file sizes
	$filesize = _bps_get_dir_size(ABSPATH);

	// Get post sizes - includes attachment sizes
	$post_sizes = 0;
	$count = $wpdb->get_results("SELECT COUNT(ID) AS count FROM {$wpdb->posts} WHERE post_type != 'revision'");
	for($i = 0; $i < $count[0]->count; $i += 100) {
		$end = $i + 100;
		$posts = $wpdb->get_results("SELECT * FROM {$wpdb->posts} WHERE post_type != 'revision' LIMIT $i,$end");
		foreach($posts as $post) {
			$postjson = json_encode($post);
			$post_sizes += strlen($postjson);
			unset($postjson);

			if($post->post_type == 'attachment') {
				$post_sizes += @filesize(get_attached_file($post->ID));
			}
		}
	}

	return($post_sizes + $filesize);
}
