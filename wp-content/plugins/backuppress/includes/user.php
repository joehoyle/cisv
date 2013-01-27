<?php

// User actions
add_action('profile_update', 'backuppress_update_user');
add_action('user_register', 'backuppress_add_user');
add_action('deleted_user', 'backuppress_delete_user');

// User meta actions
add_action('added_user_meta', 'backupress_add_user_meta', 10, 3);
add_action('updated_user_meta', 'backuppress_update_user_meta', 10, 3);
add_action('deleted_user_meta', 'backuppress_delete_user_meta');

function backuppress_add_user($user_id) {
	// Get the user
	$user = get_userdata($user_id);

        // Make sure the initial import is complete
        $initial_complete = get_option('bup_initial_import_complete');
        if(!intval($initial_complete)) {
                backuppress_queue_action('add', 'user', $user_id, json_encode($user));
                return;
        }

        // Send
        backuppress_send_update('add', 'user', $user_id, json_encode($user));
}

function backuppress_update_user($user_id) {
	// Get the user
       $user = get_userdata($user_id);

        // Make sure the initial import is complete
        $initial_complete = get_option('bup_initial_import_complete');
        if(!intval($initial_complete)) {
                backuppress_queue_action('edit', 'user', $user_id, json_encode($user));
                return;
        }

        // Send
        backuppress_send_update('edit', 'user', $user_id, json_encode($user));
}

function backuppress_delete_user($user_id) {
	// Make sure the initial import is complete
        $initial_complete = get_option('bup_initial_import_complete');
        if(!intval($initial_complete)) {
                backuppress_queue_action('delete', 'user', $user_id, $user_id);
                return;
        }

        // Send
        backuppress_send_update('delete', 'user', $user_id, $user_id);
}

function backupress_add_user_meta($meta_id, $user_id, $meta_key) {
	$meta = get_user_meta($user_id, $meta_key);
	$meta = (object)array('meta_id' => $meta_id, 'meta_key' => $meta_key, 'meta_value' => $meta);

        // Make sure the initial import is complete
        $initial_complete = get_option('bup_initial_import_complete');
        if(!intval($initial_complete)) {
                backuppress_queue_action('add', 'user_meta', $meta_id, json_encode($meta));
                return;
        }

        // Send
        backuppress_send_update('add', 'user_meta', $meta_id, json_encode($meta));
}

function backuppress_update_user_meta($meta_id, $user_id, $meta_key) {
        $meta = get_user_meta($user_id, $meta_key);
	$meta = (object)array('meta_id' => $meta_id, 'meta_key' => $meta_key, 'meta_value' => $meta);

        // Make sure the initial import is complete
        $initial_complete = get_option('bup_initial_import_complete');
        if(!intval($initial_complete)) {
                backuppress_queue_action('edit', 'user_meta', $meta_id, json_encode($meta));
                return;
        }

        // Send
        backuppress_send_update('edit', 'user_meta', $meta_id, json_encode($meta));
}

function backuppress_delete_user_meta($meta_id) {
	// Make sure the initial import is complete
        $initial_complete = get_option('bup_initial_import_complete');
        if(!intval($initial_complete)) {
                backuppress_queue_action('delete', 'user_meta', $meta_id, $meta_id);
                return;
        }

        // Send
        backuppress_send_update('delete', 'user_meta', $meta_id, $meta_id);
}

function backuppress_rollback_user($action) {
        $data = @json_decode($action->data);
	if($data == NULL) $data = $action->data;
        switch($action->verb) {
                case 'add':
			unset($data->ID);
			wp_insert_user($data);
                break;
                case 'update':
			wp_update_user($data);
                break;
                case 'edit':
			wp_update_user($data);
                break;
                case 'delete':
			wp_delete_user($data->ID);
                break;
        }
}

function backuppress_rollback_user_meta($action) {
        $data = @json_decode($action->data);
        if($data == NULL) $data = $action->data;
        switch($action->verb) {
                case 'add':
			add_user_meta($data->user_id, $data->meta_key, $data->meta_value);
                break;
                case 'update':
			update_user_meta($data->user_id, $data->meta_key, $data->meta_value);
                break;
                case 'edit':
			update_user_meta($data->user_id, $data->meta_key, $data->meta_value);
                break;
                case 'delete':
			delete_user_meta($data->user_id, $data->meta_key);
                break;
        }
}
