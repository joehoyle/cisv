<?php

/*

Plugin Name: UnPointZero content Slider

Plugin URI: http://www.unpointzero.com/unpointzero-slider/

Description: A customizable slider for your featured content by UnPointZero WebAgency

Version: 3.2.1

Author: Jordan Matejicek - UnPointZero

Author URI: http://www.UnPointZero.com

*/

// Add thumb support
if ( function_exists( 'add_theme_support' ) ) { 
  add_theme_support( 'post-thumbnails' ); 
}

// Installation
register_activation_hook( __FILE__, 'upzSlider_activate' );

function upzSlider_activate() {
	add_option("slider-type", '1', '', 'yes');
	add_option("slider-nameorid", '0', '', 'yes');
	add_option("slider-fetch", '10', '', 'yes');
	add_option("slider-view-number", '4', '', 'yes');
	add_option("slider-title-max-char", '50', '', 'yes');
	add_option("slider-title-thumb-max-char", '50', '', 'yes');
	add_option("slider-desc-max-char", '150', '', 'yes');
	add_option("slider-bigthumb-x", '419', '', 'yes');
	add_option("slider-bigthumb-y", '248', '', 'yes');
	add_option("slider-smallthumb-x", '85', '', 'yes');
	add_option("slider-smallthumb-y", '50', '', 'yes');
	add_option("slider-display-thumb", '1', '', 'yes');
	add_option("slider-display-title", '1', '', 'yes');
	add_option("slider-display-desc", '1', '', 'yes');
	add_option("slider-mouseover-action", '0', '', 'yes');
	add_option("slider-display-adv-options", '3', '', 'yes');
	add_option("slider-nonlatin", '0', '', 'yes');
	add_option("slider-transitioneffect", 'fade', '', 'yes');	
	add_option("slider-transitiontimeout", '3000', '', 'yes');
	add_option("slider-transitionspeed", '600', '', 'yes');
	add_option("slider-contentexrpt", '0', '', 'yes');	
	add_option("slider-auto-resize-active", true, '', 'yes');	
	add_option("slider-style-width", 627, '', 'yes');	
	add_option("slider-disable-links", false, '', 'yes');	
	add_option("slider-linksonthumb", false, '', 'yes');
	add_option("slider-customthumb-metaname", "", '', 'yes');
	add_option("slider-customthumb-mini-metaname", "", '', 'yes');
	add_option("slider-customorderby", "", '', 'yes');
	
}

// Add size for WP admin ( v 1.3 )
function add_upz_thumb() {
		$slider_bigthumb_x = get_option('slider-bigthumb-x');
		$slider_bigthumb_y = get_option('slider-bigthumb-y');
		$slider_smallthumb_x = get_option('slider-smallthumb-x');
		$slider_smallthumb_y = get_option('slider-smallthumb-y');
		
if ( function_exists( 'add_image_size' ) ) { 
	add_image_size( 'upz-big', $slider_bigthumb_x, $slider_bigthumb_y,true );
	add_image_size( 'upz-small', $slider_smallthumb_x, $slider_smallthumb_y,true );
}
}


/* Page d'options */

$options_page = get_option('siteurl') . '/wp-admin/admin.php?page=unpointzero-slider/Options.php';

/* Ajout de la page d'options dans l'administration Wordpress */

function slider_options_page() {
	add_options_page('UnPointZero Content Slider Options', 'UnPointZero Slider', 'edit_plugins', 'unpointzero-slider/Options.php');
	wp_enqueue_script('tabsconfig', get_bloginfo('wpurl') . '/wp-content/plugins/unpointzero-slider/libs/admin/tabsconfig.js', array('jquery','jquery-ui-core','jquery-ui-tabs'));
	wp_enqueue_style('admin-upz-slider', get_bloginfo('wpurl') . '/wp-content/plugins/unpointzero-slider/libs/admin/style.css');
	
	//call register settings function
	add_action( 'admin_init', 'register_slidersettings' );
	
}

function register_slidersettings() {
	register_setting( 'upzslider_options', 'slider-category-id' );
	register_setting( 'upzslider_options', 'slider-view-number' );
	register_setting( 'upzslider_options', 'slider-title-max-char' );
	register_setting( 'upzslider_options', 'slider-desc-max-char' );
	register_setting( 'upzslider_options', 'slider-bigthumb-x' );
	register_setting( 'upzslider_options', 'slider-bigthumb-y' );
	register_setting( 'upzslider_options', 'slider-smallthumb-x' );
	register_setting( 'upzslider_options', 'slider-smallthumb-y' );
	register_setting( 'upzslider_options', 'slider-type' );
	register_setting( 'upzslider_options', 'slider-fetch' );
	register_setting( 'upzslider_options', 'slider-nonlatin' );
	register_setting( 'upzslider_options', 'slider-nameorid' );
	register_setting( 'upzslider_options', 'slider-display-title' );
	register_setting( 'upzslider_options', 'slider-display-desc' );
	register_setting( 'upzslider_options', 'slider-display-thumb' );
	register_setting( 'upzslider_options', 'slider-display-adv-options' );
	register_setting( 'upzslider_options', 'slider-mouseover-action' );
	register_setting( 'upzslider_options', 'slider-title-thumb-max-char' );
	register_setting( 'upzslider_options', 'slider-transitioneffect' );
	register_setting( 'upzslider_options', 'slider-transitiontimeout' );
	register_setting( 'upzslider_options', 'slider-transitionspeed' );
	register_setting( 'upzslider_options', 'slider-customslide-url-1' );
	register_setting( 'upzslider_options', 'slider-customslide-image-1' );
	register_setting( 'upzslider_options', 'slider-customslide-title-1' );
	register_setting( 'upzslider_options', 'slider-customslide-desc-1' );
	register_setting( 'upzslider_options', 'slider-customslide-pos-1' );
	register_setting( 'upzslider_options', 'slider-style-width' );
	register_setting( 'upzslider_options', 'slider-custompost-name' );
	register_setting( 'upzslider_options', 'slider-custompost-taxonomyname' );
	register_setting( 'upzslider_options', 'slider-style-featured-thumbnails-margin' );
	register_setting( 'upzslider_options', 'slider-style-text-thumbnails-margin' );
	register_setting( 'upzslider_options', 'slider-contentexrpt' );
	register_setting( 'upzslider_options', 'slider-auto-resize-active' );
	register_setting( 'upzslider_options', 'slider-disable-links' );
	register_setting( 'upzslider_options', 'slider-linksonthumb');
	register_setting( 'upzslider_options', 'slider-customthumb-metaname');
	register_setting( 'upzslider_options', 'slider-customthumb-mini-metaname');
	register_setting( 'upzslider_options', 'slider-customorderby');
}

/* Code necessaire au header du site pour bon fonctionnement du plugin */

function script_load() {
	if(get_option('slider-display-thumb')==true) {
	wp_enqueue_script('jquery-cycle', get_bloginfo('wpurl') . '/wp-content/plugins/unpointzero-slider/libs/jquery.cycle.all.min.js', array('jquery'));
	wp_enqueue_script('cycle-nav', get_bloginfo('wpurl') . '/wp-content/plugins/unpointzero-slider/libs/slidercfg.js', array('jquery'));	
		if((get_option('slider-mouseover-action')==true) && (get_option('slider-display-thumb')==true)) {
		wp_enqueue_script('upz-slider-mouseoveraction', get_bloginfo('wpurl') . '/wp-content/plugins/unpointzero-slider/libs/slider-mouseover.js', array('jquery'));
		}
	}
	else {
	wp_enqueue_script('jquery-cycle', get_bloginfo('wpurl') . '/wp-content/plugins/unpointzero-slider/libs/jquery.cycle.all.min.js', array('jquery'));
		if(get_option('slider-display-adv-options')==1 || get_option('slider-display-adv-options')==2) {
		wp_enqueue_script('cycle-nav', get_bloginfo('wpurl') . '/wp-content/plugins/unpointzero-slider/libs/cycle-nav.js', array('jquery'));
		}
		elseif(get_option('slider-display-adv-options')==0) {
		wp_enqueue_script('cycle', get_bloginfo('wpurl') . '/wp-content/plugins/unpointzero-slider/libs/cycle.js', array('jquery'));
		}
		else {
		wp_enqueue_script('cycle', get_bloginfo('wpurl') . '/wp-content/plugins/unpointzero-slider/libs/cycle.js', array('jquery'));
		}
	}
}

function slider_styles() {

	$slider_path =  get_bloginfo('wpurl')."/wp-content/plugins/unpointzero-slider/";

	if(get_option('slider-display-thumb')==true) {
	$sliderscript = "
    <link rel=\"stylesheet\" href=\"".$slider_path."css/slider.css\" type=\"text/css\" media=\"screen\" charset=\"utf-8\"/>
	";
	}
	else {
	$sliderscript = "
    <link rel=\"stylesheet\" href=\"".$slider_path."css/slider-cycle.css\" type=\"text/css\" media=\"screen\" charset=\"utf-8\"/>
	";	
	}
	echo($sliderscript);
	
	$fx = get_option('slider-transitioneffect');
	$timeout = get_option('slider-transitiontimeout');
	$transitionspeed = get_option('slider-transitionspeed');
	
	echo "<script type=\"text/javascript\">
		fx = \"$fx\";
		timeout = \"$timeout\";
		transitionspeed = \"$transitionspeed\";
		</script>";

	// AUTO RESIZING CSS STYLES
	if(get_option('slider-auto-resize-active')==true) {
		if(get_option('slider-display-thumb')==true) {
		$featured_width = get_option('slider-style-width')."px";
		$featured_height = get_option('slider-bigthumb-y')."px";
		$info_width = get_option('slider-bigthumb-x')."px";
		$nav_width = get_option('slider-style-width')-get_option('slider-bigthumb-x')."px";
		$nav_txt_width = (get_option('slider-style-width')-get_option('slider-bigthumb-x')-get_option('slider-smallthumb-x')-get_option('slider-style-text-thumbnails-margin')-get_option('slider-style-featured-thumbnails-margin'))."px";
		$thumb_left_margin = get_option('slider-style-featured-thumbnails-margin')."px";
		$thumb_right_margin = get_option('slider-style-text-thumbnails-margin')."px";
		$navigationitem_height = floor((get_option('slider-bigthumb-y'))/(get_option('slider-view-number')))."px";

		echo "
		<style type=\"text/css\">
		#featured { width: $featured_width; height:$featured_height }
		#featured ul#upz-slideshow-navigation { width:$nav_width; }
		#featured ul#upz-slideshow-navigation li { height:$navigationitem_height; }
		#featured ul#upz-slideshow-navigation li span { width:$nav_txt_width; }
		#featured .info { width:$info_width; }
		#featured ul#upz-slideshow-navigation li img.attachment-upz-small { margin-left:$thumb_left_margin; margin-right:$thumb_right_margin; }
		</style>";
		}
		else {
		$featured_width = get_option('slider-bigthumb-x')."px";
		$featured_height = get_option('slider-bigthumb-y')."px";
		$arrow_nav_bottom_position = (($featured_height/2)-25)."px";
		echo "<style type=\"text/css\">
		#featured { width: $featured_width; height:$featured_height }
		#featured-navi a span#previousslide,#featured-navi a span#nextslide { bottom:$arrow_nav_bottom_position; }";
		
		$vnumber = get_option('slider-view-number');
		for($s=0;$s<$vnumber;$s++) {
		echo ".upzslider #fragment-$s { height:$featured_height !important; width:$featured_width !important; }";
		}
		
		echo "
		</style>
		";
		}
	}
	
}



/* Récuperation des posts souhaités 

	@param int category 				:	la catégorie du post

	@param int number 					:	le nombre de news à afficher

	@param int slider_title_max_char	:	le nb de caractères max pour les titres

	@param int slider_desc_max_char		:	le nb de caractères max pour les descriptions

*/


function tronc_str($str,$limit) {
$pattern = '(?<=^|>)[^><]+?(?=<|$)';
if (((strlen($str) > $limit) || ($limit==NULL)) && (is_numeric($limit))) { 
				$content = preg_replace("#\[.*?\]#", "", $str);
				$content = strip_tags($content,'<p>');

				if(get_option('slider-nonlatin')==0 || get_option('slider-nonlatin')==NULL) {
				$content = substr($content, 0, $limit);
				$position_espace = strrpos($content, " "); 
				$content = substr($content, 0, $position_espace); 
				}
				else
				{
				$content = mb_substr($content, 0, $limit); 		
				}
				$content = $content."...";
				}
				
				else {
				$content = $str;
				$content = strip_tags($content,'<p>');
				}
				
return $content;
}


function slider_getinfo_by_cat($category,$number,$fetch,$slider_title_max_char,$slider_title_thumb_max_char,$slider_desc_max_char) {
	global $post;
	global $intername;
	global $taxonamesc;
	global $usingshort;
	$c_name = null;
	$custopost_name =null;
	if($intername!=null && $intername!="") {
		$c_name = $category;
	}
	else {
		if(get_option('slider-nameorid')=="1") {
			$c_name = $category;
		}
		else {
			$c_name_array = preg_split('/,/', $category);
			for($i=0;$i<sizeof($c_name_array);$i++) {
			$c_name.= get_cat_ID($c_name_array[$i]).",";
			}
		}	
	}
	
	if($intername!=null && $intername!="") {
	$slidetype = 3;
	}
	elseif($usingshort==1) {
	$slidetype = 1;
	}
	else {
	$slidetype = get_option('slider-type');
	}
	
	if($slidetype==1) {
		if($category!="" || $category!=0) {	
		$category = "&category=".$c_name;
		}

		else {
		$category = "";
		}
	}
	else {
		if($category!="" || $category!=0) {	
			if($intername!=null && $intername!="") {
			$taxoname = $taxonamesc;
			}
			else {
			$taxoname = get_option('slider-custompost-taxonomyname');
			}
		$category = "&".$taxoname."=\"".$c_name."\"";
		}

		else {
		$category = "";
		}
	}
	
	if($slidetype==3) {
		if($intername!=null && $intername!="") {
		$custopost_name = "&post_type=\"".$intername."\"";
		}
		else {
		$custopost_name = "&post_type=\"".get_option('slider-custompost-name')."\"";
		}
	}
	
	if((get_option('slider-customorderby')!=null) && get_option('slider-customorderby')!="") {
		$orderby = "&meta_key=";
		$orderby .= get_option('slider-customorderby');
		$orderby .= "&orderby=meta_value&order=ASC";
		
	} else { $orderby = ""; }
	$myposts = get_posts("post_status=\"publish\"&numberposts=$fetch&meta_key=_thumbnail_id$category$custopost_name$orderby");
	$postok_number = 0;
	
	foreach($myposts as $post) :
		
		$customthumbmetaname = get_option('slider-customthumb-metaname');
		
		if(($customthumbmetaname!="")&&($customthumbmetaname!=null)) {
			$custom_meta = get_post_custom($post->ID);
			$meta_customthumbname = $custom_meta[$customthumbmetaname][0];
			$customthumbmetamininame = get_option('slider-customthumb-mini-metaname');
			$meta_customthumbmininame = $custom_meta[$customthumbmetamininame][0];
		}
		else {
			$meta_customthumbname = null;
		}
		if(has_post_thumbnail($post->ID) || (($meta_customthumbname!=null) && ($meta_customthumbname!=""))) {
		if(get_option('slider-disable-links')!=true) {
		$post_perma[] = get_permalink($post->ID);
		}
		else {
		$post_perma[] = "#";
		}
		// Récuperation des options
		$title = "";
		$title = tronc_str(__($post->post_title),$slider_title_max_char);
		$post_title[] = $title;
		
		$thumb_title = "";
		$thumb_title = tronc_str(__($post->post_title),$slider_title_thumb_max_char);
		$post_thumb_title[] = $thumb_title;

		$content = "";
		$post_excerpt = get_option('slider-contentexrpt');
		if($post_excerpt==1) {
		$content = tronc_str(__($post->post_excerpt),$slider_desc_max_char);
		}
		else {
		$content = tronc_str(__($post->post_content),$slider_desc_max_char);
		}
		$post_content[] = $content;

		if(($meta_customthumbname!=null)&&($meta_customthumbname!="")) {
			$thumb[] =  $meta_customthumbname;
			$thumb_mini[] =  $meta_customthumbmininame;
		} else {
			$thumb[] =  get_the_post_thumbnail( $post->ID,'upz-big');
			$thumb_mini[] =  get_the_post_thumbnail( $post->ID,'upz-small');			
		}
		
			if(sizeof($post_title)==$number) {
			wp_reset_query();
			return array($post_perma,$post_title,$post_thumb_title,$post_content,$thumb,$thumb_mini);
			}		
			
		}
	$meta_customthumbname = null;	
	endforeach;
	wp_reset_query();
	return array($post_perma,$post_title,$post_thumb_title,$post_content,$thumb,$thumb_mini);
}



/* Récuperation des pages */
function slider_getpages($pages_id,$number,$slider_title_max_char,$slider_title_thumb_max_char,$slider_desc_max_char) {
	$p_name = preg_split('/,/', $pages_id);
	for($i=0;$i<$number;$i++) {
		if(get_option('slider-nameorid')=="1" && is_numeric($p_name[$i])) {
		$page = get_page($p_name[$i]);
		}
		else {
		$page = get_page_by_title($p_name[$i]);	
		}
		
		$customthumbmetaname = get_option('slider-customthumb-metaname');
		
		if(($customthumbmetaname!="")&&($customthumbmetaname!=null)) {
			$custom_meta = get_post_custom($page->ID);
			$meta_customthumbname = $custom_meta[$customthumbmetaname][0];
			$customthumbmetamininame = get_option('slider-customthumb-mini-metaname');
			$meta_customthumbmininame = $custom_meta[$customthumbmetamininame][0];
		}
		else {
			$meta_customthumbname = null;
		}
		
		if(has_post_thumbnail($page->ID) || (($meta_customthumbname!=null) && ($meta_customthumbname!="")) && $page->post_status=="publish") {
			if(get_option('slider-disable-links')!=true) {
			$page_perma[] = get_permalink($page->ID);
			}
			else {
			$page_perma[] = "#";
			}
			
			$title = "";
			$title = tronc_str(__($page->post_title),$slider_title_max_char);
			$page_title[] = $title;
			
			$thumb_title = "";
			$thumb_title = tronc_str(__($page->post_title),$slider_title_thumb_max_char);
			$post_thumb_title[] = $thumb_title;
			
			$content = "";
			$post_excerpt = get_option('slider-contentexrpt');
			if($post_excerpt==1) {
			$content = tronc_str(__($page->post_excerpt),$slider_desc_max_char);
			}
			else {
			$content = tronc_str(__($page->post_content),$slider_desc_max_char);
			}
			
			$page_content[] = $content;
			
		if(($meta_customthumbname!=null)&&($meta_customthumbname!="")) {
			$thumb[] =  $meta_customthumbname;
			$thumb_mini[] =  $meta_customthumbmininame;
		} else {
			$thumb[] =  get_the_post_thumbnail( $page->ID,'upz-big');
			$thumb_mini[] =  get_the_post_thumbnail( $page->ID,'upz-small');			
		}	
			
		}
	}
	wp_reset_query();
	return array($page_perma,$page_title,$post_thumb_title,$page_content,$thumb,$thumb_mini);
}

function upzslidershortcode_func($atts) {
	global $intername;
	global $taxonamesc;
	global $usingshort;
	$usingshort = 1;
	extract( shortcode_atts( array(
		'interid' => '',
		'intertype' => '',
		'taxoname' => '',
		'usingphp' => ''
	), $atts ) );
	
	if(strtolower($intertype)=="post") {
		$intertype = 1;
	}
	elseif(strtolower($intertype)=="page") {
		$intertype = 2;
	}
	elseif($intertype!=NULL && $intertype!="") {
		$intername = $intertype;
		$intertype = 3;
		$taxonamesc = $taxoname;
	}
	else {$intertype=null; $usingshort=0;}
	ob_start();
	include(WP_CONTENT_DIR .'/plugins/unpointzero-slider/Slider.php');
	$output_string = ob_get_contents();
	ob_end_clean();
	if($usingphp==true) {
	echo $output_string;
	}
	else {
	return $output_string;
	}
}


/* On ajoute les actions ... */

add_action('wp_head', 'slider_styles');
add_action('wp_footer', 'script_load');
add_action('admin_init', 'add_upz_thumb');
add_action('admin_menu', 'slider_options_page');
add_shortcode( 'upzslider', 'upzslidershortcode_func');


?>