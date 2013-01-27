<p>We have started doing an initial backup of your blog; you can track the progress of that process on this page, but you don't have to stay on this page and can come back at any time.</p>

<p><b>Initial Backup Progress:</b></p>

<table width="50%">
 <tr>
  <td>Files</td>
  <td width="100"><span id="status_files">-</span></td>
 </tr>
 <tr>
  <td>Settings</td>
  <td width="100"><span id="status_settings">-</span></td>
 </tr>
 <tr>
  <td>Categories</td>
  <td width="100"><span id="status_categories">-</span></td>
 </tr>
  <tr>
  <td>Users</td>
  <td width="100"><span id="status_users">-</span></td>
 </tr>
 <tr>
  <td>Posts</td>
  <td width="100"><span id="status_posts">-</span></td>
 </tr>
 <tr>
  <td>Comments</td>
  <td width="100"><span id="status_comments">-</span></td>
 </tr>
 <tr>
  <td>Attachments</td>
  <td width="100"><span id="status_attachments">-</span></td>
 </tr>
</table>

<script type="text/javascript">

stages = new Array('queued', 'started', 'files', 'settings', 'categories', 'users', 'posts', 'comments', 'attachments', 'complete');

function _bup_check_status() {
	jQuery.ajax({
		url: '<?php echo get_bloginfo('home'); ?>/wp-admin/admin-ajax.php?action=bup_check_status',
		type: 'GET',
		success: function(data) {
			json = false;
			try {
				json = jQuery.parseJSON(data);
			} catch(err) {
				alert(data);
				return;
			}

			if(typeof(json) != 'object') {
				alert(data);
				return;
			}

			if(json['stage'] == 'complete') {
                                window.location = window.location;
                                return;
                        }

			for(i = 0; i < stages.length; i++) {
				if(json['stage'] == stages[i]) {
					jQuery('#status_'+stages[i]).html(json['progress']+'%');
					setTimeout('_bup_check_status();', 2000);
					return;
				}
				else {
					jQuery('#status_'+stages[i]).html('Done');
				}
			}

			setTimeout('_bup_check_status();', 5000);
		}
	});
}

setTimeout('_bup_check_status();', 5000);
</script>
