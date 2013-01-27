<?php

// Option actions
add_action('added_option', 'backuppress_save_option');
add_action('updated_option', 'backuppress_save_option');
add_action('deleted_option', 'backuppress_delete_option');

function backuppress_save_option($option_name) {
        // Do not back up certain options
        $disallowed_options = array('rewrite_rules', 'bup_last_error', 'bup_action_queue', 'bup_stage', 'cron', 'bup_changed_files', 'bup_rollback_data', 'bup_rollback_time', 'bup_deactivated', 'bup_files');
        if(in_array($option_name, $disallowed_options))
                return;

	// Also disallow transients
	$disallowed_prefixes = array('_site_transient_', '_transient_');
	foreach($disallowed_prefixes as $prefix) {
		if(!strcmp(substr($option_name, 0, strlen($prefix)), $prefix))
			return;
	}

	// Get the option
        $option = get_option($option_name);

	// Make sure the initial import is complete
        $initial_complete = get_option('bup_initial_import_complete');

	if(!intval($initial_complete)) {
                backuppress_queue_action('update', 'option', $option_name, maybe_serialize($option));
                return;
        }

        // Send
        if(!function_exists('backuppress_send_update')) return;
        backuppress_send_update('update', 'option', $option_name, maybe_serialize($option));
}

function backuppress_delete_option($option_name) {
        // Do not back up certain options
        $disallowed_options = array('rewrite_rules', 'bup_last_error', 'bup_action_queue', 'bup_changed_files', 'bup_rollback_data', 'bup_rollback_time', 'bup_deactivated', 'bup_files');
        if(in_array($option_name, $disallowed_options))
                return;

	// Also disallow transients
        $disallowed_prefixes = array('_site_transient_', '_transient_');
        foreach($disallowed_prefixes as $prefix) {
                if(!strcmp(substr($option_name, 0, strlen($prefix)), $prefix))
                        return;
        }

	// Make sure the initial import is complete
        $initial_complete = get_option('bup_initial_import_complete');
	if(!intval($initial_complete)) {
                backuppress_queue_action('delete', 'option', $option_name, $option_name);
                return;
        }

        // Send
        if(!function_exists('backuppress_send_update')) return;
        backuppress_send_update('delete', 'option', $option_name, $option_name);
}

function backuppress_rollback_option($action) {
	$data = @json_decode($action->data);
	if($data == NULL) $data = $action->data;
	if(!is_object($data)) $data = (object)array('option_value' => $data);
        switch($action->verb) {
                case 'add':
                        add_option($action->object_id, $data->option_value);
                break;
                case 'update':
                        update_option($action->object_id, $data->option_value);
                break;
                case 'edit':
                        update_option($action->object_id, $data->option_value);
                break;
                case 'delete':
                        delete_option($action->object_id);
                break;
        }
}
