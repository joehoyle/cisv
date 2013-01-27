<?php

// Post actions
add_action('save_post', 'backuppress_save_post');
add_action('deleted_post', 'backuppress_delete_post');
add_action('trashed_post', 'backuppress_trash_post');
add_action('untrashed_post', 'backuppress_untrash_post');
add_action('add_attachment', 'backuppress_save_post');
add_action('edit_attachment', 'backuppress_save_post');

// Meta actions
add_action('added_post_meta', 'backupress_add_post_meta', 10, 3);
add_action('updated_post_meta', 'backuppress_update_post_meta', 10, 3);
add_action('deleted_post_meta', 'backuppress_delete_post_meta');

function backuppress_save_post($post_id) {
        // Don't save auto-saves
        if(defined('DOING_AUTOSAVE')) return;

	global $wpdb;
	$post = $wpdb->get_row("SELECT * FROM {$wpdb->posts} WHERE ID = $post_id");
        $disallowed_types = array('revision');
        if(in_array($post->post_type, $disallowed_types))
                return;

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

	$initial_complete = get_option('bup_initial_import_complete');
        if(!intval($initial_complete)) {
                backuppress_queue_action('edit', 'post', $post_id, json_encode($post));
                return;
        }

        // Send
	backuppress_send_update('edit', 'post', $post_id, json_encode($post));
}

function backuppress_delete_post($post_id) {
	// Make sure the initial import is complete
	$initial_complete = get_option('bup_initial_import_complete');
        if(!intval($initial_complete)) {
                backuppress_queue_action('delete', 'post', $post_id, $post_id);
                return;
        }

	// Send
	backuppress_send_update('delete', 'post', $post_id, $post_id);
}

function backuppress_trash_post($post_id) {
	global $wpdb;
        $post = $wpdb->get_row("SELECT * FROM {$wpdb->posts} WHERE ID = $post_id");

        $disallowed_types = array('revision');
        if(in_array($post->post_type, $disallowed_types))
                return;

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

	// Make sure the initial import is complete
        $initial_complete = get_option('bup_initial_import_complete');
        if(!intval($initial_complete)) {
                backuppress_queue_action('edit', 'post', $post_id, json_encode($post));
                return;
        }

        // Send
        backuppress_send_update('edit', 'post', $post_id, json_encode($post));
}

function backuppress_untrash_post($post_id) {
	global $wpdb;
        $post = $wpdb->get_row("SELECT * FROM {$wpdb->posts} WHERE ID = $post_id");

        $disallowed_types = array('revision');
        if(in_array($post->post_type, $disallowed_types))
                return;

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

	// Make sure the initial import is complete
        $initial_complete = get_option('bup_initial_import_complete');
        if(!intval($initial_complete)) {
                backuppress_queue_action('edit', 'post', $post_id, json_encode($post));
                return;
        }

        // Send
        backuppress_send_update('edit', 'post', $post_id, json_encode($post));
}

function backupress_add_post_meta($meta_id, $post_id, $meta_key) {
	// Ignore AJAX stuff
	if(defined('DOING_AJAX')) return;

	$meta = get_post_meta($post_id, $meta_key);
	$meta = (object)array('meta_id' => $meta_id, 'meta_key' => $meta_key, 'meta_value' => $meta);

	// Make sure the initial import is complete
        $initial_complete = get_option('bup_initial_import_complete');
        if(!intval($initial_complete)) {
                backuppress_queue_action('add', 'post_meta', $meta_id, json_encode($meta));
                return;
        }

        // Send
        backuppress_send_update('add', 'post_meta', $meta_id, json_encode($meta));
}

function backuppress_update_post_meta($meta_id, $post_id, $meta_key) {
	// Ignore AJAX stuff
        if(defined('DOING_AJAX')) return;

        $meta = get_post_meta($post_id, $meta_key);
	$meta = (object)array('meta_id' => $meta_id, 'meta_key' => $meta_key, 'meta_value' => $meta);

        // Make sure the initial import is complete
        $initial_complete = get_option('bup_initial_import_complete');
        if(!intval($initial_complete)) {
                backuppress_queue_action('edit', 'post_meta', $meta_id, json_encode($meta));
                return;
        }

        // Send
        backuppress_send_update('edit', 'post_meta', $meta_id, json_encode($meta));
}

function backuppress_delete_post_meta($meta_id) {
	// Ignore AJAX stuff
        if(defined('DOING_AJAX')) return;

        // Make sure the initial import is complete
        $initial_complete = get_option('bup_initial_import_complete');
        if(!intval($initial_complete)) {
                backuppress_queue_action('delete', 'post_meta', $meta_id, $meta_id);
                return;
        }

        // Send
        backuppress_send_update('delete', 'post_meta', $meta_id, $meta_id);
}

function backuppress_rollback_post($action) {
        $data = @json_decode($action->data);
	if($data == NULL) $data = $action->data;
        switch($action->verb) {
                case 'add':
			unset($data->ID);
			wp_insert_post($data);
                break;
                case 'update':
			wp_insert_post($data);
                break;
                case 'edit':
			wp_insert_post($data);
                break;
                case 'delete':
			wp_delete_post($action->object_id);
                break;
        }
}

function backuppress_rollback_post_meta($action) {
        $data = @json_decode($action->data);
	if($data == NULL) $data = $action->data;
        switch($action->verb) {
                case 'add':
			add_post_meta($data->post_id, $data->meta_key, $data->meta_value);
                break;
                case 'update':
			update_post_meta($data->post_id, $data->meta_key, $data->meta_value);
                break;
                case 'edit':
			update_post_meta($data->post_id, $data->meta_key, $data->meta_value);
                break;
                case 'delete':
			delete_post_meta($data->post_id, $data->meta_key);
                break;
        }
}
