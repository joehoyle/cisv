<?php

define('BACKUPPRESS_API_ENDPOINT', 'https://api.getbackuppress.com/');

// Verify a request coming from the 23press server by signature
function backuppress_verify_request($die = true) {
	// Get the public and private key
        $public_key = get_option('bup_public_key');
        $private_key = get_option('bup_private_key');

        // Get the request ready for signing
        $timestamp = intval($_REQUEST['timestamp']);
        $expected = base64_encode(hash_hmac('sha256', "$public_key|$timestamp", $private_key, true));

	// Make sure we have the right API key
	if(strcmp($public_key, $_REQUEST['key'])) {
		if($die) die;
		return(false);
	}


	// Make sure the request is recent (10 minutes)
	if($timestamp < (time() - 600)) {
		if($die) die;
		return(false);
	}

	if(strcmp($expected, $_REQUEST['signature'])) {
		if($die) die;
		return(false);
	}

	return(true);
}

/* Update function */
function backuppress_send_update($verb, $object_type, $object_id, $data) {
	$post_vars = array(
		'verb' => $verb,
		'object_type' => $object_type,
		'object_id' => $object_id,
                'data' => $data,
        );

	$data = API_Request::fetch('backup', 'update', 'POST', $post_vars);
        if(!is_object($data)) {
                // Something went wrong, queue it up
                backuppress_queue_action($verb, $object_type, $object_id, $data);

                update_option('bup_last_error', array('time' => time(), 'code' => $code, 'error' => $return));
		return(false);
        }

	return(true);
}

/* API Rquest class */

class API_Request {
	private $public_key, $private_key, $error;

	function __construct($public_key, $private_key) {
		$this->public_key = $public_key;
		$this->private_key = $private_key;
	}

	function validate($request) {
		// Check the signature against the user's API key pair
		if(!strlen(@$_REQUEST['key']) || !strlen(@$_REQUEST['timestamp']) || !strlen(@$_REQUEST['signature'])) {
			$this->error = 'Invalid parameters.';
			return(false);
		}

		$public_key = $_REQUEST['key'];
		$timestamp = $_REQUEST['timestamp'];
		$signature = $_REQUEST['signature'];

		// Verify that the public key matches
		if(strcmp($public_key, $this->public_key)) {
			$this->error = 'Mismatched public key.';
			return(false);
		}

		// Verify the signature
		$expected_hash = base64_encode(hash_hmac('sha256', "$public_key|$timestamp", $this->private_key, true));
		if(strcmp($expected_hash, $signature)) {
			$this->error = 'Invalid signature.';
			return(false);
		}

		return($data);
	}

	function getLastError() {
		return($this->error);
	}

	static function fetch($resource, $function = '', $method = 'GET', $args = array()) {
                // Build the URL
                $timestamp = time();
                $url = BACKUPPRESS_API_ENDPOINT . $resource;
                $url .= strlen($function) ? "/$function" : '';

                // Get the current domain
                $parts = explode('.', $_SERVER['HTTP_HOST']);
                $current_domain = $parts[sizeof($parts) - 2] . '.' . $parts[sizeof($parts) - 1];

                // Construct the signature
                $args['key'] = get_option('bup_public_key');
                $private_key = get_option('bup_private_key');
                $args['timestamp'] = time();
                $args['signature'] = base64_encode(hash_hmac('sha256', "/$resource" . (strlen($function) ? "/$function" : '') . "|{$args['timestamp']}", $private_key, true));

                // If necessary, build the argument string
                $argstr = '';
                if($method == 'GET') {
                        foreach($args as $k => $v) {
                                $argstr .= "$k=" . urlencode($v) . "&";
                        }
                        $url .= "?$argstr";
                }

                // cURL request
                $ch = curl_init($url);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);
                if($method == 'POST')
                        curl_setopt($ch, CURLOPT_POSTFIELDS, $args);

                // Make the request
                $return = curl_exec($ch);

                // Check the returned data
                $code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
                if($code != 200) {
                        error_log("API call returned non-200 code $code at $timestamp: $method $url with params " . serialize($args) . " and returned $return");
                        return(false);
                }

                // Check for proper JSON
                $data = json_decode($return);
                if(!$data) {
                        error_log("API call returned non-decodeable JSON at $timestamp: $method $url with params " . serialize($args) . " returned $return");
                        return(false);
                }

		// Check for a valid status and data
                if(isset($data->error)) {
                        error_log("API call returned an error at $timestamp: $method $url with params " . serialize($args) . " error {$data->error}");
                }

                return($data);
        }
}
