<?php
/**
Plugin Name: Featured-video
Plugin URI: http://www.to-wonder.com/featured-video
Description: Select a featured video instead of an image.
Version: 1.5.4
Author: Luc Princen (To Wonder)
Author URI: http://www.to-wonder.com

    Copyright 2011 To Wonder Multimedia  (email : luc@to-wonder.com)
*/


add_action('admin_menu', 'fv_meta_register');
add_action('save_post', 'fv_meta_save');
add_shortcode( 'featured-video', 'fv_do_post_video' );	



function fv_meta_register(){
	$post_types = get_post_types(array("public" => true));
	foreach ($post_types as $post_type) {
		add_meta_box("fv_meta", 'Featured video', "fv_meta_html", $post_type, "side", "low");
	}	
		
	wp_enqueue_style('fv_video_style', plugins_url().'/featured-video/style.css');
	wp_enqueue_script('fv_video_script', plugins_url().'/featured-video/script.js');
	wp_localize_script('fv_video_script', 'JSvars', array( 'url' => plugins_url().'/featured-video'));
	
}


function fv_meta_html(){
	wp_nonce_field( plugin_basename( __FILE__ ), 'fv_meta_nonce');

	if(isset($_GET['post'])){		
		$post_id = $_GET['post'];
	}else{
		global $post;
		$post_id = $post->ID;
	}
	
	$video = get_post_meta($post_id, 'fv_video', true);
	$v_id = get_post_meta($post_id, 'fv_video_id', true);
	$v_img = get_post_meta($post_id, 'fv_video_img', true);
		
	if($video == null){
		$video = 'Paste your YouTube or Vimeo url';
	}
		
	?>
	<?php if($v_img != ''):?>
		<div id="featured_video_preview" style="display:block">
			<img src="<?php echo plugins_url()?>/featured-video/spinner.gif" id="spinner" style="display:none"/>
			<img src="<?php echo $v_img?>" width="100px" id="theimg">
		</div>
	<?php else:?>
		<div id="featured_video_preview" style="display:block">
			<img src="<?php echo plugins_url()?>/featured-video/spinner.gif" id="spinner" style="display:none"/>
			<img src="<?php echo plugins_url()?>/featured-video/vimeo.jpg" width="100px" id="theimg">
			
		</div>
	<?php endif;?>
	<textarea id="fv_textarea" name="fv_video" style="width:100%;height:100px"><?php echo $video ?></textarea>
	<input type="hidden" name="fv_video_id" value="<?php echo $v_id?>" id="vid_id"/>
	<input type="hidden" name="fv_video_img" value="<?php echo $v_img?>" id="vid_img"/>
	<?php
}


function fv_meta_save($post_id){
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) 
  		return;

	if ( !wp_verify_nonce( $_POST['fv_meta_nonce'], plugin_basename( __FILE__ ) ) )
  		return;
	
	update_post_meta($post_id, 'fv_video', $_POST['fv_video']);
	update_post_meta($post_id, 'fv_video_id', $_POST['fv_video_id']);
	update_post_meta($post_id, 'fv_video_img', $_POST['fv_video_img']);
	return;
}



/*
	Get-functions:
*/

function fv_do_post_video($atts){
	
	if(isset($atts['width'])){
		$w = $atts['width'];
	}else{
		$w = '560';
	}
	if(isset($atts['height'])){
		$h = $atts['height'];
	}else{
		$h = '315';
	}
	
	if(has_post_video()){
		the_post_video($w, $h);
	}
	
}


function has_post_video($pid = null){
	if($pid == null){
		global $post;
		$pid = $post->ID;
	}
	
	$id = get_post_meta($pid, 'fv_video_id', true);
	if($id == null || empty($id)){
		return false;
	}else{
		return true;
	}
}

function the_post_video($width = '560', $height = '315', $wmode = 'transparent', $allowfullscreen = true){
	
	global $post;
	$id = get_post_meta($post->ID, 'fv_video_id', true);
	$video = get_post_meta($post->ID, 'fv_video', true);
	$width = strval($width);
	$height = strval($height);

	if($id != null){
		if(is_vimeo($video)){
			$fs = get_allow_full_screen($allowfullscreen, true);
			echo '<iframe src="http://player.vimeo.com/video/'.$id.'" width="'.$width.'" height="'.$height.'" frameborder="0" '.$fs.'></iframe>';
		}else{
			$fs = get_allow_full_screen($allowfullscreen);
			echo '<iframe width="'.$width.'" height="'.$height.'" src="http://www.youtube.com/embed/'.$id.'?wmode='.$wmode.'" frameborder="0" '.$fs.'></iframe>';
		}
	}
}




function get_the_post_video($pid = null, $width = '560', $height = '315', $wmode = 'transparent', $allowfullscreen = true){

	if($pid == null){
		global $post;
		$pid = $post->ID;
	}
	
	$id = get_post_meta($pid, 'fv_video_id', true);
	$video = get_post_meta($pid, 'fv_video', true);
	$width = strval($width);
	$height = strval($height);

	echo $video;
	if($id != null){
		if(is_vimeo($video)){
			$fs = get_allow_full_screen($allowfullscreen, true);
			echo '<iframe src="http://player.vimeo.com/video/'.$id.'" width="'.$width.'" height="'.$height.'" frameborder="0" '.$fs.'></iframe>';
		}else{
			$fs = get_allow_full_screen($allowfullscreen);
			echo '<iframe width="'.$width.'" height="'.$height.'" src="http://www.youtube.com/embed/'.$id.'?wmode='.$wmode.'" frameborder="0" '.$fs.'></iframe>';
		}
	}
	
	return false;
}


function get_allow_full_screen($allow, $isvimeo = false){
	if($allow == true){
		if($isvimeo == 'false'){
			return 'webkitAllowFullScreen mozallowfullscreen allowFullScreen';
		}else{
			return 'allowfullscreen';
		}		
	}
	return false;
}


function the_post_video_thumbnail($id = null){
	if($id == null){
		global $post;
		$id = $post->ID;
	}
	
	$img_src = get_post_meta($id, 'fv_video_img', true);
	if($img_src != null){
		echo '<img src="'.$img_src.'">';
	}	
}

function get_the_post_video_thumbnail($id = null){
	if($id == null){
		global $post;
		$id = $post->ID;
	}

	$img_src = get_post_meta($id, 'fv_video_img', true);
	if($img_src != null){
		return '<img src="'.$img_src.'">';
	}
	
	return false;	
}

function the_post_video_image($id = null){
	if($id == null){
		global $post;
		$id = $post->ID;
	}

	$img_src = get_post_meta($id, 'fv_video_img', true);
	$img_src = str_replace('1.jpg', '0.jpg', $img_src);
	if($img_src != null){
		echo '<img src="'.$img_src.'">';
	}	
	
}

function get_the_post_video_image($id = null){
	if($id == null){
		global $post;
		$id = $post->ID;
	}

	$img_src = get_post_meta($id, 'fv_video_img', true);
	$img_src = str_replace('1.jpg', '0.jpg', $img_src);
	if($img_src != null){
		return '<img src="'.$img_src.'">';
	}
	
	return false;
}

function is_vimeo($string){
	if(substr($string, 0, 12) == 'http://vimeo' || substr($string, 0, 16) == 'http://www.vimeo' || substr($string, 0, 13) == 'https://vimeo' || substr($string, 0, 17) == 'https://www.vimeo') return true;
	return false;
}

?>