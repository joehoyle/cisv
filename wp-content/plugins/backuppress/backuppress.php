<?php
/*
Plugin Name: BackupPress
Plugin URI: http://www.getbackuppress.com/
Description: The easiest way to back up your WordPress blog!
Author: 23press
Author URI: http://www.23press.com/
Version: 1.0.14
*/

define('BACKUPPRESS_VERSION', '1.0.9');
define('BUP_AJAX_TIMEOUT', 20);

$cwd = dirname(__FILE__);
$plugin_url = str_replace(ABSPATH, get_bloginfo('home') . '/', $cwd);

include("$cwd/includes/api_request.php");
include("$cwd/includes/stub.php");
include("$cwd/includes/misc.php");
include("$cwd/includes/post.php");
include("$cwd/includes/option.php");
include("$cwd/includes/comment.php");
include("$cwd/includes/user.php");
include("$cwd/includes/term.php");
include("$cwd/includes/table.php");

/* HOOKS */

// General stuff (processing forms, menu stuff, etc.)
add_action('init', 'backuppress_process', 100);
add_action('init', 'backuppress_process_queue');
add_action('admin_menu', 'backuppress_init');
add_action('wp_ajax_bup_check_status', 'backuppress_get_status');
add_action('wp_ajax_bup_rollback_status', 'backuppress_rollback_status');
add_action('admin_notices', 'backuppress_notices');
register_activation_hook( __FILE__, 'backuppress_activate');
register_deactivation_hook(__FILE__, 'backuppress_deactivate');

/* FUNCTIONS */

function backuppress_activate() {
	delete_option('bup_public_key');
	delete_option('bup_private_key');
	delete_option('bup_stage');
	delete_option('bup_files');
	delete_option('bup_initial_stage');
	delete_option('bup_initial_import_complete');
	delete_option('bup_last_id');
	delete_option('bup_ftp_info');
	delete_option('bup_last_error');
	delete_option('bup_action_queue');
	delete_option('bup_changed_files');
	delete_option('bup_config_download');
	delete_option('bup_update_available');
}

function backuppress_notices() {
	$option = get_option('bup_deactivated', false);
	$initial_complete = get_option('bup_initial_import_complete', false);
	$admin_url = str_replace(home_url(), '', admin_url('admin.php?page=backuppress'));

	if(!$initial_complete && (substr($_SERVER["PHP_SELF"], -11) == 'plugins.php')) {
		if($option)
			echo '<div class="updated" id="message"><p>Thanks for re-activating BackupPress! You will need to re-sync your blog by visting the <a href="' . admin_url('admin.php?page=backuppress') . '">BackupPress page</a>.</p></div>';
		else
			echo '<div class="updated" id="message"><p>Welcome to BackupPress. To get started, you will need to do an initial backup of your blog by visting the <a href="' . admin_url('admin.php?page=backuppress') . '">BackupPress page</a>.</p></div>';
	}
}

function backuppress_deactivate() {
	update_option('bup_deactivated', time());
}

function backuppress_init() {
        if(function_exists('add_menu_page')) {
                add_menu_page(__('BackupPress'), __('BackupPress'), 'manage_options', 'backuppress', 'backuppress_admin', plugin_dir_url( __FILE__ ) . 'images/backuppress_icon.png', 3);
        }
}

function backuppress_queue_action($verb, $object_type, $object_id, $data, $time = 0) {
	if($time == 0) $time = time();

	$queue = get_option('bup_action_queue');
	if(!$queue)
		$queue = array();

	array_push($queue, (object)array('verb' => $verb, 'object_type' => $object_type, 'object_id' => $object_id, 'data' => $data, 'timestamp' => $time));
	update_option('bup_action_queue', $queue);
}

function backuppress_get_status() {
	$data = API_Request::fetch('backup', 'status', 'POST');
	echo json_encode($data); die;
}

function backuppress_rollback_status() {
	$data = API_Request::fetch('restore', 'status', 'POST');
        echo json_encode($data); die;
}

function backuppress_process_queue() {
	$last_error = get_option('bup_last_error', array());

	// If it's been less than 5 minutes, don't try again yet
	if(@$last_error['time'] > (time() - 300)) return;

	// If the queue is empty, nevermind
	$queue = get_option('bup_action_queue', array());
	if(!is_array($queue) || !sizeof($queue)) return;

	// Empty the queue to eliminate race conditions
        update_option('bup_action_queue', array());

	// Process the queue
	for($i = sizeof($queue) - 1; $i >= 0; $i--) {
		$post_vars = array(
	                'verb' => $queue[$i]->verb,
			'object_type' => $queue[$i]->object_type,
			'object_id' => $queue[$i]->object_id,
        	        'data' => $queue[$i]->data,
			'time' => $queue[$i]->timestamp,
	        );

		$data = API_Request::fetch('backup', 'update', 'POST', $post_vars);
		if(!is_object($data)) {
                	// Something went wrong, bail out
        	        update_option('bup_last_error', array('time' => time(), 'code' => $code, 'error' => $return));
			break;
        	}

		array_splice($queue, $i, 1);
	}

	// If there's anything left if the queue it didn't get processed, put it back
	foreach($queue as $item) {
		backuppress_queue_action($item->verb, $item->object_type, $item->object_id, $item->data, $item->timestamp);
	}
}

$bup_error_str = false;
$bup_stats = false;
function backuppress_process() {
	global $bup_error_str, $bup_stats;
	if($_GET['page'] == 'backuppress') {
                wp_deregister_script('jquery');
                wp_register_script('jquery', 'https://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js');
        }

	if(isset($_GET['config_download'])) {
		update_option('bup_config_download', md5_file(ABSPATH . '/wp-config.php'));
    		header("Content-Disposition: attachment; filename=wp-config.php");
		header("Content-Type: text/plain");

		readfile(ABSPATH . '/wp-config.php');
		die;
	}

	if(isset($_POST['bp-action'])) {
		switch($_POST['bp-action']) {
			case 'login':
				if(wp_verify_nonce($_POST['_wpnonce'], 'login')) {
					$domain_parts = parse_url(get_bloginfo('home'));
					$ch = curl_init('https://api.23press.com/v2/user/auth');
					curl_setopt($ch, CURLOPT_TIMEOUT, 20);
					curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
					curl_setopt($ch, CURLOPT_POSTFIELDS, array(
						'user' => $_POST['email'],
						'pass' => $_POST['password'],
						'url' => site_url(),
						'product' => 'bup',
					));
					$return = curl_exec($ch);
					$data = @json_decode($return);
					if(!is_object($data)) {
						$bup_error_str = 'Unable to decode JSON respone.';
                                                return;
					}

					if(strlen(@$data->error)) {
						$bup_error_str = "Unable to login: {$data->error}";
						return;
					}

					if(!strlen(@$data->public_key) || !strlen(@$data->private_key)) {
						$bup_error_str = 'The API did not send back a valid API key. Please contact <a href="mailto:support@23press.com">support</a>.';
						return;
					}

					update_option('bup_public_key', $data->public_key);
					update_option('bup_private_key', $data->private_key);

					$data = API_Request::fetch('blog', 'register', 'POST');
					if(!is_object($data)) {
						$bup_error_str = 'Unable to fetch blog backup status. Please contact 23press support.';
						return;
       					}

					update_option('bup_stage', get_option('bup_deactivated') ? 'resync' : 'start');
					wp_redirect(@$_SERVER['REQUEST_URI']); die;
				}
				break;
			case 'start-backup':
				if(wp_verify_nonce($_POST['_wpnonce'], 'start-backup')) {
					$data = API_Request::fetch('backup', 'start', 'POST');
					if(!is_object($data)) {
						$bup_error_str = "An error occured: $return";
						return;
					}

					if(isset($data->error)) {
						$bup_error_str = "An error occured: {$data->error}";
						return;
					}

					$backup_files = 1;
					if(isset($_POST['backup_files']))
						$backup_files = intval($_POST['backup_files']);

					// Update the applicable options
                                        update_option('bup_stage', 'initial');
					update_option('bup_initial_stage', 'queued');
					update_option('bup_last_id', 0);
					update_option('bup_files', $backup_files);

	                                wp_redirect(@$_SERVER['REQUEST_URI']); die;
				}
				break;
			case 'rollback':
				if(wp_verify_nonce($_POST['wpnonce'], 'rollback')) {
					if(!sizeof(@$_POST['items'])) {
						$bup_error_str = 'You must choose to restore content, files or both.';
						return;
					}

					// Check that we're restoring to a date after this backup was created
					$bup_stats = API_Request::fetch('backup', 'stats', 'POST');
					if(!is_object($bup_stats)) {
						$bup_error_str = 'Unable to fetch backup stats. Please contact support.';
						return;
					}

					$rollback_timestamp = mktime($_POST['time'], 0, 0, $_POST['month'], $_POST['day'], $_POST['year']);
					if(intval($bup_stats->start_date) > $rollback_timestamp) {
						$bup_error_str = 'Cannot restore to before the backup existed. Please choose a day/time after ' . date("F j, Y H:i A", $bup_stats->start_date);
						return;
					}

					// First, try to make an FTp connection, make sure the info is right
        				if(in_array('files', $_POST['items'])) {
						// Get user account details
						$user = API_Request::fetch('user', '');
						if(!is_object($user)) {
							$bup_error_str = 'Unable to fetch encryption data. Please contact support.';
                                                        return;
						}

						// Encrypt the FTP details
						$ftp_info = array('host' => $_POST['ftp_host'], 'port' => $_POST['ftp_port'], 'user' => $_POST['ftp_user'], 'pass' => $_POST['ftp_pass']);
						$ftp_str = json_encode($ftp_info);

						$iv = mcrypt_create_iv(mcrypt_get_iv_size(MCRYPT_3DES, 'cbc'), MCRYPT_RAND);
						$iv_str = base64_encode($iv);

						$hash = strlen($user->password) ? $user->password : $user->old_password;
						error_log($hash);
						$ftp_str = mcrypt_encrypt(MCRYPT_3DES, substr($hash, 0, mcrypt_get_key_size(MCRYPT_3DES, 'cbc')), $ftp_str, 'cbc', $iv);

						$ftp_test = API_Request::fetch('test', 'ftp', 'POST', array('data' => base64_encode($ftp_str), 'iv' => $iv_str, 'hash' => md5(file_get_contents(ABSPATH . '/wp-config.php'))));
						if(!is_object($ftp_test)) {
                                                        $bup_error_str = 'Unable to test FTP details. Please verify the information is correct and try again.';
                                                        return;
                                         	}

						if(isset($ftp_test->error)) {
							$bup_error_str = 'FTP connection test failed: ' . $ftp_test->error;
                                                        return;
						}
	
						// Save FTP info	
						update_option('bup_ftp_info', $iv_str . base64_encode($ftp_str));
					}

					// Additional info
					$post_vars = array(
						'rollback_timestamp' => mktime($_POST['time'], 0, 0, $_POST['month'], $_POST['day'], $_POST['year']),
						'types' => implode(',', $_POST['items']),
					);

					// Get the list of stuff to rollback
					$data = API_Request::fetch('backup', 'changes', 'POST', $post_vars);
	                                if(!is_object($data)) {
        	                                $bup_error_str = 'Unable to fetch a list of items to rollback. Please contact 23press support.';
                	                        return;
                        	        }

					if(!sizeof($data->results) && !sizeof($data->files)) {
						$bup_error_str = 'There are no items to restore.';
						return;
					}

					// Save changes/action info DB
					update_option('bup_rollback_time', $post_vars['rollback_timestamp']);
					update_option('bup_rollback_data', $data);

					// Redirect to rollback page
					wp_redirect(site_url() . $_SERVER['REQUEST_URI'] . '&rollback=1');
				}
				break;
			case 'rollback-confirm':
				$rollback_timestamp = get_option('bup_rollback_time');
				$data = get_option('bup_rollback_data');
				$actions = $data->results;
				if(wp_verify_nonce($_POST['wpnonce'], 'rollback-confirm-' . md5(serialize($actions)))) {
					// Process file changes
					if(sizeof(@$_POST['files'])) {
						// Make the call to do the file restoration
						$data = API_Request::fetch('restore', 'start', 'POST', array(
							'rollback_timestamp' => $rollback_timestamp, 
							'files' => json_encode($_POST['files']),
							'attachments' => sizeof($data->attachments),
							'config_hash' => md5(file_get_contents(ABSPATH . '/wp-config.php')),
						));
						if(!is_object($data)) {
							$bup_error_str = 'Error restoring files. Please contact support.';
							return;
						}

						if(isset($data->error)) {
							$bup_error_str = 'Error doing file restore: ' . $data->error;
							return;
						}

						update_option('bup_stage', 'rolling');
						wp_redirect(remove_query_arg('rollback'));
					}
					else {
					
					}
				}
				break;
		}
	}
}

function backuppress_admin() {
	global $bup_error_str, $bup_stats;
	$state = isset($_GET['rollback']) ? 'rollback' : get_option('bup_stage');

	$no_status_states = array('start', 'initial', 'resync');
	if($state && !in_array($state, $no_status_states) && !is_object($bup_stats)) {
		$bup_stats = API_Request::fetch('backup', 'stats', 'POST');
	}
?>
<div class="wrap">
 <h2><img src="<?php echo plugin_dir_url( __FILE__ ) . '/images/backuppress_icon_large.png'; ?>" align="absmiddle" /> BackupPress</h2>
 <?php 
	switch($state):
		case false:
			include('views/login.php');
			break;
		case 'start':
			include('views/start.php');
			break;
		case 'initial':
			include('views/initial.php');
			break;
		case 'normal':
			include('views/normal.php');
			break;
		case 'resync':
			include('views/resync.php');
			break;
		case 'rollback':
			include('views/rollback.php');
			break;
		case 'rolling':
			include('views/rolling.php');
			break;
	endswitch;
 ?>
</div>
<?php
}
