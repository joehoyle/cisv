jQuery(document).ready(function($){
	//smart empty:
	jQuery('#fv_textarea').click(function(){
		if(jQuery(this).val() == 'Paste your YouTube or Vimeo url'){
			jQuery(this).val('');
			jQuery(this).focus();
			jQuery(this).bind('blur', function(){
				if(jQuery(this).val() == ''){
					jQuery(this).val('Paste your YouTube or Vimeo url');
				}
			})
		}
	})
	
	jQuery('#fv_textarea').change(function(){
		var value = jQuery(this).val();
		if(value != ''){
			if(value.substring(1, 7) == 'iframe'){
				jQuery('#featured_video_preview').hide();
				jQuery('#spinner').show();
				jQuery('.error').remove();
				jQuery('#theimg').remove();
				jQuery('#featured_video_preview').fadeIn('fast');
				var code = value.split('/embed/');
				code = code[1].split('"');
				
				jQuery('#featured_video_preview').append('<img src="http://img.youtube.com/vi/'+code[0]+'/1.jpg" style="display:none" id="theimg">');
				jQuery('#spinner').hide();
				jQuery('#theimg').fadeIn('slow');
				jQuery('#vid_id').val(code[0]);
				jQuery('#vid_img').val('http://img.youtube.com/vi/'+code[0]+'/1.jpg');
			}else if(value.substring(0, 4) == 'http'){
			
				if(value.substring(0, 12) == 'http://vimeo' || value.substring(0,16) == 'http://www.vimeo' || value.substring(0, 13) == 'https://vimeo' || value.substring(0,17) == 'https://www.vimeo'){
					var code = value.split('vimeo.com/');
					code = code[1];
					if(code != ''){
						jQuery('#spinner').hide();
						jQuery('.error').remove();
						jQuery('#theimg').attr('src', JSvars.url+'/vimeo.jpg');						
						jQuery('#vid_id').val(code);
						jQuery('#vid_img').val(JSvars.url+'/vimeo.jpg');
					}
				}else if(value.substring(0, 14 == 'http://youtu') || value.substring(0,18) == 'http://www.youtube' || value.substring(0, 15 == 'https://youtu') || value.substring(0,19) == 'https://www.youtube'){
					var code = value.split('?v=');
					code = code[1].split('&');
					code = code[0];
					if(code != ''){
						jQuery('#spinner').show();
						jQuery('.error').remove();
						jQuery('#theimg').attr('src', 'http://img.youtube.com/vi/'+code+'/1.jpg');						
						jQuery('#spinner').hide();
						jQuery('#vid_id').val(code);
						jQuery('#vid_img').val('http://img.youtube.com/vi/'+code+'/1.jpg');
					}
				}				
				
			}else{
				jQuery('#theimg').remove();
				jQuery('#spinner').hide();
				jQuery('#featured_video_preview').append('<p class="error">This isn\'t a valid YouTube embedcode / URL</p>');
				jQuery('#featured_video_preview').fadeIn('slow');
			}			
		}else{
			jQuery('#vid_id').val('');
			jQuery('#vid_img').val('');
		}
	});	
});