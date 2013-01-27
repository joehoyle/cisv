<link type="text/css" rel="stylesheet" media="screen" href="<?php global $plugin_url; echo $plugin_url; ?>/css/bup.css" />

<?php $data = get_option('bup_rollback_data'); $changes = $data->results; $changed_files = $data->files; ?>

<h3>Restore</h3>

<?php if(strlen($bup_error_str)) : ?><p class="error"><?php echo $bup_error_str; ?></p><?php endif; ?>
<p>Please confirm that you want to make the following changes: (<a href="" onclick="jQuery('.action').attr('checked', 'true'); return false;">Select all</a> | <a href="" onclick="jQuery('.action').removeAttr('checked'); return false;">De-select all</a>)</p>

<form action="" method="post">
 <?php foreach($changes as $index => $change) : ?>
 <p><input class="action" type="checkbox" name="actions[]" value="<?php echo $index; ?>" checked="true" /> <?php echo ucwords($change->verb); ?> <?php echo $change->object_type; ?> "<?php echo $change->object_id; ?>"</p>
 <?php endforeach; ?>
 <?php foreach($changed_files as $file) : ?>
 <p><input class="action" type="checkbox" name="files[]" value="<?php echo $file; ?>"  checked="true" /> Roll back file <?php echo $file; ?></p>
 <?php endforeach; ?>
 <input type="hidden" name="bp-action" value="rollback-confirm" />
 <input type="hidden" name="wpnonce" value="<?php echo wp_create_nonce('rollback-confirm-' . md5(serialize($changes))); ?>" />
 <input type="submit" class="button-primary" value="Roll back" /> <input type="button" class="button" value="Cancel" onclick="window.location='<?php echo remove_query_arg('rollback'); ?>';" />
</form>

