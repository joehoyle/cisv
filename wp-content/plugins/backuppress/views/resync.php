<?php if(strlen($bup_error_str)): ?><div id="message" class="updated"><p><?php echo $bup_error_str; ?></p></div><?php endif; ?>

<p>Welcome back! Since it's been a while since your last backup, we'll need to get you all caught up.  This will likely take quite a while, but after you start the process, you can close this window, leave and come back at any time to check the status.</p>
<p>To get started, simply click the "Start Sync" button below. If you want to set more advanced options, click the show link below.</p>
<form action="" method="post">
 <input type="hidden" name="bp-action" value="start-backup" />
 <input type="hidden" name="_wpnonce" value="<?php echo wp_create_nonce('start-backup'); ?>" />
 <p><input type="submit" class="button-primary" value="Start Sync" /></p>
 <p><b>Advanced Options</b> (<a href="#" onclick="toggleAdvanced(); return false;" id="advanced-link">show</a>)</p>
 <div id="advanced-options" style="display:none;">
  <p>Back up files: <input type="radio" name="backup_files" value="1" checked="true" /> Yes &nbsp; <input type="radio" name="backup_files" value="0" /> No</p>
 </div>
</form>

<script type="text/javascript">
function toggleAdvanced() {
	if(jQuery('#advanced-options').css('display') == 'none') {
		jQuery('#advanced-link').html('hide');
		jQuery('#advanced-options').css('display', 'block');
	}
	else {
		jQuery('#advanced-link').html('show');
                jQuery('#advanced-options').css('display', 'none');
	}
}
</script>
