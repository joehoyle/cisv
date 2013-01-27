<?php
if(!defined('ABSPATH')){
    require("../../../wp-load.php");
	$wp_upload_dir = wp_upload_dir();
	$cachdir = $wp_upload_dir['basedir'].'/ep_hashimage/';
} else {
	$cachdir = $_SERVER['DOCUMENT_ROOT'].'/wp-content/uploads/ep_hashimage';
}

if(! defined('FILE_CACHE_DIRECTORY') ) 			define ('FILE_CACHE_DIRECTORY', $cachdir);
if(! defined('ALLOW_ALL_EXTERNAL_SITES') ) 		define ('ALLOW_ALL_EXTERNAL_SITES', TRUE);
if(! defined('DEFAULT_ZC') )					define ('DEFAULT_ZC', 1);
if(! defined('FILE_CACHE_TIME_BETWEEN_CLEANS'))	define ('FILE_CACHE_TIME_BETWEEN_CLEANS', 60);
?>