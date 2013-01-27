<?php

// Comment actions
add_action('edit_comment', 'backuppress_save_comment');
add_action('wp_set_comment_status', 'backuppress_update_comment_status', 10, 2);
add_action('deleted_comment', 'backuppress_delete_comment');

// Comment meta actions
add_action('added_comment_meta', 'backupress_add_comment_meta', 10, 3);
add_action('updated_comment_meta', 'backuppress_update_comment_meta', 10, 3);
add_action('deleted_comment_meta', 'backuppress_delete_comment_meta');

function backuppress_save_comment($comment_id) {
	// Get the comment
	$comment = get_comment($comment_id);

	// Make sure the initial import is complete
        $initial_complete = get_option('bup_initial_import_complete');
        if(!intval($initial_complete)) {
                backuppress_queue_action('edit', 'comment', $comment_id, json_encode($comment));
                return;
        }

        // Send
	backuppress_send_update('edit', 'comment', $comment_id, json_encode($comment));
}

function backuppress_delete_comment($comment_id) {
	// Make sure the initial import is complete
        $initial_complete = get_option('bup_initial_import_complete');
        if(!intval($initial_complete)) {
                backuppress_queue_action('delete', 'comment', $comment_id, $comment_id);
                return;
        }

        // Send
        backuppress_send_update('delete', 'comment', $comment_id, $comment_id);
}

function backuppress_update_comment_status($comment_id, $comment_status) {
	// Ignore a few statuses (delete, etc.) that are handled elsewhere
	$disallowed_statuses = array('delete');
	if(in_array($comment_status, $disallowed_statuses))
		return;

	// Get the comment
        $comment = get_comment($comment_id);

        // Make sure the initial import is complete
        $initial_complete = get_option('bup_initial_import_complete');
        if(!intval($initial_complete)) {
                backuppress_queue_action('edit', 'comment', $comment_id, json_encode($comment));
                return;
        }

        // Send
        backuppress_send_update('edit', 'comment', $comment_id, json_encode($comment));
}

function backupress_add_comment_meta($meta_id, $comment_id, $meta_key) {
	$meta = get_comment_meta($comment_id, $meta_key, true);
	$meta = (object)array('meta_id' => $meta_id, 'meta_key' => $meta_key, 'meta_value' => $meta);

        // Make sure the initial import is complete
        $initial_complete = get_option('bup_initial_import_complete');
        if(!intval($initial_complete)) {
                backuppress_queue_action('add', 'comment_meta', $meta_id, json_encode($meta));
                return;
        }

        // Send
        backuppress_send_update('add', 'comment_meta', $meta_id, json_encode($meta));;
}

function backuppress_update_comment_meta($meta_id, $comment_id, $meta_key) {
	$meta = get_comment_meta($comment_id, $meta_key, true);
	$meta = (object)array('meta_id' => $meta_id, 'meta_key' => $meta_key, 'meta_value' => $meta);

        // Make sure the initial import is complete
        $initial_complete = get_option('bup_initial_import_complete');
        if(!intval($initial_complete)) {
                backuppress_queue_action('edit', 'comment_meta', $meta_id, json_encode($meta));
                return;
        }

        // Send
        backuppress_send_update('edit', 'comment_meta', $meta_id, json_encode($meta));
}

function backuppress_delete_comment_meta($meta_id) {
	// Make sure the initial import is complete
        $initial_complete = get_option('bup_initial_import_complete');
        if(!intval($initial_complete)) {
                backuppress_queue_action('delete', 'comment_meta', $meta_id, $meta_id);
                return;
        }

        // Send
        backuppress_send_update('delete', 'comment_meta', $meta_id, $meta_id);
}

function backuppress_rollback_comment($action) {
	$data = @json_decode($action->data);
	if($data == NULL) $data = $action->data;
	switch($action->verb) {
		case 'add':
			wp_insert_comment($data);
		break;
		case 'update':
			wp_update_comment($data);
		break;
		case 'edit':
                        wp_update_comment($data);
                break;
		case 'delete':
			wp_delete_comment($action->object_id);
		break;
	}
}

function backuppress_rollback_comment_meta($action) {
        $data = @json_decode($action->data);
	if($data == NULL) $data = $action->data;
        switch($action->verb) {
                case 'add':
                        add_comment_meta($data->comment_id, $data->meta_key, $data->meta_value);
                break;
                case 'update':
                        update_comment_meta($data->comment_id, $data->meta_key, $data->meta_value);
                break;
		case 'edit':
                        update_comment_meta($data->comment_id, $data->meta_key, $data->meta_value);
                break;
                case 'delete':
                        delete_comment_meta($data->comment_id, $data->meta_key, $data->meta_value);
                break;
        }
}
