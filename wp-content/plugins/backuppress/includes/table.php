<?php

function backuppress_rollback_custom_table($action) {
	$data = @json_decode($action->data);
	$desc = $data->desc;
	$table_data = $data->data;

	global $wpdb;

	// Drop any existing table
	$wpdb->query("DROP TABLE IF EXISTS {$action->object_id}");

	// Then re-create it at this point in time
	$wpdb->query($desc);

	// Finally, re-insert the data
	foreach($table_data as $row) {
		$row_data = array();
		$vars = get_object_vars($row);
		foreach($vars as $var)
			array_push($row_data, "'" . mysql_real_escape_string($row->$var) . "'");

		$wpdb->query("INSERT INTO {$action->object_id} VALUES(" . implode(',', $row_data) . ");");
	}
}
