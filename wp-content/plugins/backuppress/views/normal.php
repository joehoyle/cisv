<link type="text/css" rel="stylesheet" media="screen" href="<?php global $plugin_url; echo $plugin_url; ?>/css/bup.css" />

<?php
// Check the health of the backup
$status = 'ready';
$queue = get_option('bup_action_queue', array());
if(sizeof($queue))
	$status = 'warning';

// Make sure the oldest queued action isn't older than 24 hours
$oldest = time();
foreach($queue as $action) {
	if($action->timestamp < $oldset) $oldest = $action->timestamp;
}

if($oldest < (time() - (60*60*24)))
	$status = 'error';

?>

<?php switch($status) : 
	case 'ready': ?>
<p class="bup-message ready">Your backup is up to date.</p>
<?php	break;
	case 'warning': ?>
<p class="bup-message warning">Your backup is feeling a little sluggish, but should be back to normal in a little bit.</p>
<?php	break;
	case 'error': ?>
<p class="bup-message error">Your backup is out of sync. Please contact support if this message persists for more than 24 hours.</p>
<?php	break; endswitch; ?>

<?php $md5 = md5_file(ABSPATH . '/wp-config.php'); $last = get_option('bup_config_download'); if(strcmp($md5, $last)) : ?>
<div class="error" id="message"><p>We see that you have not download the most recent copy of your wp-config.php file.  You should <a href="<?php echo $_SERVER['REQUEST_URI'] . '&config_download=1'; ?>">download it now</a> and store it somewhere safe on your computer. Once you've downloaded it, refresh to get rid of this message.</p></div>
<?php endif; ?>

<?php if(get_option('bup_update_available', false)) : ?>
<div class="updated" id="message"><p>A new version of BackupPress is available. You can download it at <a href="http://getbackuppress.com/">getbackuppress.com</a>.</p></div>
<?php endif; ?>

<div class="metabox-holder" id="dashboard-widgets">
 <div style="width:50%;" class="postbox-container" id="postbox-container-1">
  <div class="meta-box-sortables">
   <div class="postbox">
    <h3 class="hndle"><span>Quick Stats</span></h3>
    <div class="inside">
     <p class="stat">This blog has been backed up since <b><?php echo date('F j, Y', $bup_stats->start_date); ?></b>.</p>
     <p class="stat">We've backed up <b><?php echo $bup_stats->total_changes; ?> content changes</b> (including settings).<p>
     <p class="stat">The last recorded change was on <b><?php echo date('F j, Y', $bup_stats->last_content_change); ?></b> at <b><?php echo date("g:i A", $bup_stats->last_content_change); ?> UTC.</b></p>
     <p class="stat">We've also backed up <b><?php echo $bup_stats->total_attachments; ?> attachments</b> totalling <b><?php echo _bps_human_filesize($bup_stats->total_attachments_size); ?>.</b></p>
     <p class="stat <?php if(strcmp($md5, $last)) echo 'last'; ?>">Finally, we've backed up <b><?php echo $bup_stats->total_files; ?> files and file revisions</b> totalling <b><?php echo _bps_human_filesize($bup_stats->total_filesize); ?></b>.</p>
     <?php if(!strcmp($md5, $last)) : ?><p class="stat last">You have downloaded the most recent config file. <a href="<?php echo $_SERVER['REQUEST_URI'] . '&config_download=1'; ?>">Download it again</a>.</p><?php endif; ?>
    </div>
   </div>
  </div>
 </div>
 <div style="width:50%;" class="postbox-container" id="postbox-container-2">
  <div class="meta-box-sortables">
   <div class="postbox">
    <h3 class="hndle"><span>Restore</span></h3>
    <div class="inside">

<?php if(strlen($bup_error_str)) : ?>
<p class="error"><?php echo $bup_error_str; ?></p>
<?php endif; ?>

<?php $default_rollback_date = mktime(0, 0, 0, date('n'), date('j')); ?>
<p>In order to restore your blog to a previous version, please pick a date and time to roll back to. You will be shown a list of things we're going to change <b>before</b> we change anything:</p>

<form action="" method="post">
 <table width="100%">
  <tr>
   <td width="120">Rollback to:</td>
   <td>
    <select name="month">
     <?php for($i = 1; $i <= 12; $i++) : if(!isset($_POST['month'])) $_POST['month'] = date('n', $default_rollback_date); ?>
     <option value="<?php echo $i; ?>"<?php if(@$_POST['month'] == $i) echo ' selected'; ?>><?php echo date('F', mktime(0, 0, 0, $i, 1)); ?></option>
     <?php endfor; ?>
    </select>
    <select name="day">
     <?php for($i = 1; $i <= 31; $i++) : if(!isset($_POST['day'])) $_POST['day'] = date('j', $default_rollback_date); ?>
     <option value="<?php echo $i; ?>"<?php if(@$_POST['day'] == $i) echo ' selected'; ?>><?php echo $i; ?></option>
     <?php endfor; ?>
    </select>
    <select name="year">
     <?php for($i = date('Y'); $i >= date('Y') - 1; $i--) : if(!isset($_POST['year'])) $_POST['year'] = date('Y', $default_rollback_date); ?>
     <option value="<?php echo $i; ?>"<?php if(@$_POST['year'] == $i) echo ' selected'; ?>><?php echo $i ?></option>
     <?php endfor; ?>
    </select>
    <select name="time">
     <?php for($i = 0; $i <= 23; $i++) : ?>
     <option value="<?php echo $i; ?>"<?php if(@$_POST['time'] == $i) echo ' selected'; ?>><?php echo date('g:i A', mktime($i, 0, 0)); ?></option>
     <?php endfor; ?>
    </select>
   </td>
  </tr>
  <tr>
   <td>Rollback:</td>
   <td>
    <input type="checkbox" value="content" name="items[]" <?php if(@in_array('content', @$_POST['items'])) echo 'checked="true"'; ?> /> Content (settings, media, posts, etc.)<br />
    <input type="checkbox" value="files" name="items[]" <?php if(@in_array('files', @$_POST['items'])) echo 'checked="true"'; ?> onclick="document.getElementById('ftp-info').style.display = (this.checked == true) ? 'table' : 'none';" /> Files
   </td>
  </tr>
 </table>
 <table id="ftp-info" style="display:<?php if(@in_array('files', @$_POST['items'])) echo 'table'; else echo 'none'; ?>">
   <tr>
    <td width="120">FTP Host:</td>
    <td><input type="text" size="30" value="<?php echo htmlentities(@$_POST['ftp_host']); ?>" name="ftp_host" /></td>
   </tr>
   <tr>
    <td>FTP Port:</td>
    <td><input type="text" size="10" value="<?php echo strlen(@$_POST['ftp_port']) ? htmlentities(@$_POST['ftp_port']) : '21'; ?>" name="ftp_port" /></td>
   </tr>
   <tr>
    <td>FTP Username:</td>
    <td><input type="text" size="30" value="<?php echo htmlentities(@$_POST['ftp_user']); ?>" name="ftp_user" /></td>
   </tr>
   <tr>
    <td>FTP Password:</td>
    <td><input type="password" size="30" value="<?php echo htmlentities(@$_POST['ftp_pass']); ?>" name="ftp_pass" /></td>
   </tr>
 </table><br />
 <input type="hidden" name="bp-action" value="rollback" />
 <input type="hidden" name="wpnonce" value="<?php echo wp_create_nonce('rollback'); ?>" />
 <input type="submit" value="Get Actions" />
</form>

    </div>
   </div>
  </div>
 </div>
</div>
