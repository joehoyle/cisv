
<p>We have started the rollback of your blog; you can track the progress of that process on this page, but you don't have to stay on this page and can come back at any time.</p>

<p><b>Rollback Progress:</b></p>

<table width="50%">
 <tr>
  <td>Files</td>
  <td width="100"><span id="status_files">-</span></td>
 </tr>
 <tr>
  <td>Content</td>
  <td width="100"><span id="status_categories">-</span></td>
 </tr>
 <tr>
  <td>Attachments</td>
  <td width="100"><span id="status_settings">-</span></td>
 </tr>
</table>

<script type="text/javascript">

stages = new Array('files', 'content', 'attachments', 'complete');

function _bup_check_status() {
        jQuery.ajax({
                url: '<?php echo get_bloginfo('home'); ?>/wp-admin/admin-ajax.php?action=bup_rollback_status',
                type: 'GET',
                success: function(data) {
                        json = false;
                        try {
                                json = jQuery.parseJSON(data);
                        } catch(err) {
                                alert('Unable to parse returned JSON.');
                                return;
                        }

                        if('error' in json) {
                                alert(json['error']);
                                return;
                        }

			if(json['error_str'].length) {
				alert(json['error_str'] + ' Please contact support.');
				return;
			}

                        if(json['stage'] == 'complete') {
                                window.location = window.location + '&restore=1';
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
