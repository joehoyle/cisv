<?php
/*
Plugin Name: WordPress Wufoo Integration
Plugin URI: http://mintreaction.com
Description: Integrate Wufoo forms with your WordPress-powered site.
Author: Bryan Koch and Austin Matzko (Mint Reaction)
Author URI: http://mintreaction.com
Version: 1.0
*/


if ( version_compare( PHP_VERSION, '5.2.0') >= 0 ) {

	require_once dirname( __FILE__ ) . DIRECTORY_SEPARATOR . 'includes' . DIRECTORY_SEPARATOR . 'core.php';
	
} else {
	
	function wufoo_integration_php_version_message()
	{
		?>
		<div id="wufoo-integration-warning" class="updated fade error">
			<p>
				<?php 
				printf(
					__('<strong>ERROR</strong>: Your WordPress site is using an outdated version of PHP, %s.  Version 5.2 of PHP is required to use the Wufoo Integration plugin. Please ask your host to update.', 'wufoo-integration'),
					PHP_VERSION
				);
				?>
			</p>
		</div>
		<?php
	}

	add_action('admin_notices', 'wufoo_integration_php_version_message');
}

function wufoo_integration_init_event()
{
	load_plugin_textdomain('wufoo-integration', null, dirname( __FILE__ ) . DIRECTORY_SEPARATOR . 'includes' . DIRECTORY_SEPARATOR . 'l10n');
}

add_action('init', 'wufoo_integration_init_event');
