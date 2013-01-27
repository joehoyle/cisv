<?php

// Term actions
add_action('delete_term', 'backuppress_delete_term', 10, 3);
add_action('created_term', 'backuppress_created_term', 10, 3);
add_action('edited_term', 'backuppress_edit_term');

function backuppress_created_term($term_id, $tt_id, $taxonomy) {
	// Get the term
        $term = get_term($term_id, $taxonomy);

        // Make sure the initial import is complete
        $initial_complete = get_option('bup_initial_import_complete');
        if(!intval($initial_complete)) {
                backuppress_queue_action('add', 'term', $term_id, json_encode($term));
                return;
        }

        // Send
        backuppress_send_update('add', 'term', $term_id, json_encode($term));
}

function backuppress_edit_term($term_id, $tt_id, $taxonomy) {
	// Get the term
        $term = get_term($term_id, $taxonomy);

        // Make sure the initial import is complete
        $initial_complete = get_option('bup_initial_import_complete');
        if(!intval($initial_complete)) {
                backuppress_queue_action('edit', 'term', $term_id, json_encode($term));
                return;
        }

        // Send
        backuppress_send_update('edit', 'term', $term_id, json_encode($term));
}

function backuppress_delete_term($term_id) {
	// Make sure the initial import is complete
        $initial_complete = get_option('bup_initial_import_complete');
        if(!intval($initial_complete)) {
                backuppress_queue_action('delete', 'term', $term_id, $term_id);
                return;
        }

        // Send
        backuppress_send_update('delete', 'term', $term_id, $term_id);
}

function backuppress_rollback_term($action) {
        $data = @json_decode($action->data);
	if($data == NULL) $data = $action->data;
        switch($action->verb) {
                case 'add':
			wp_insert_term($data->name, $data->taxonomy, $data);
                break;
                case 'update':
			wp_update_term($data->name, $data->taxonomy, $data);
                break;
                case 'edit':
			wp_update_term($data->name, $data->taxonomy, $data);
                break;
                case 'delete':
			wp_delete_term($data->term_id);
                break;
        }
}
