<?php
/*
Plugin Name: Blogroll Widget with RSS Feeds
Description: Displays the recent posts of your blogroll links via RSS Feeds in a customizable sidebar widget
Plugin URI:  http://www.officetrend.de/2684/wordpress-plugin-blogroll-widget-with-rss-feeds/
Version:     2.2
Author:      Tanja Preu&szlig;e
Author URI:  http://www.officetrend.de/

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation; either version 2 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.
*/

Class Blogroll_Widget_RSS Extends WP_Widget {

	function Blogroll_Widget_RSS() {
		if (function_exists('load_plugin_textdomain'))
        load_plugin_textdomain('blogroll-widget-rss', PLUGINDIR.'/'.dirname(plugin_basename(__FILE__)).'/languages', dirname(plugin_basename(__FILE__)).'/languages');

		$widget_ops = array('classname' => 'blogroll_widget_rss', 
						'description' => __( 'The recent posts of your blogroll links', 'blogroll-widget-rss') );
		$control_ops = array( 'width' => 400);
		$this->WP_Widget ( 'blogroll_widet_rss', 'Blogroll Widget with RSS Feeds', $widget_ops, $control_ops);
	}
	
	function widget($args, $instance) {
		extract($args);
		
		echo $before_widget;
		
		$title = empty($instance['title']) ? '&nbsp;' : apply_filters('widget_title', $instance['title']);
		if ( !empty( $title ) ) { echo $before_title . $title . $after_title; };
		
		$category = isset($instance['category']) ? $instance['category'] : false;

		$item_order = empty( $instance['item_order'] ) ? 'link_name ASC' : $instance['item_order'];	
		$show_image = empty( $instance['show_image'] ) ? 'show-no-images' : $instance['show_image'];
		$show_link = $instance['show_link'] ? '1' : '0';
		$show_link_nf = $instance['show_link_nf'] ? '1' : '0';
		$shorten_feedlink = $instance['shorten_feedlink'] ? '1' : '0';
		$feed_link_nf = $instance['show_link_nf'] ? '1' : '0';
		$show_summary = $instance['show_summary'] ? '1' : '0';
		
		if ( !$show_items = (int) $instance['show_items'] )
			$show_items = -1;
        elseif ( $show_items < -1 )
			$show_items = -1;
			
		if ( !$thumb_size = (int) $instance['thumb_size'] )
			$thumb_size = 50;
        elseif ( $thumb_size < 10 )
			$thumb_size = 50;
			
		if ( !$feed_items = (int) $instance['feed_items'] )
			$feed_items = 1;
        elseif ( $feed_items > 10 )
			$feed_items = 10;
		elseif ( $feed_items < 1 )
			$feed_items = 1;
		
		if ( !$s_f_length = (int) $instance['s_f_length'] )
			$s_f_length = 20;
		elseif ( $s_f_length < 1 )
			$s_f_length = 1;
			
		if ( !$summary_length = (int) $instance['summary_length'] )
			$summary_length = 100;
		else if ( $summary_length < 10 )
			$summary_length = 10;
		else if ( $summary_length > 999 )
			$summary_length = 999;	
						
		show_blogroll_widget_rss( $instance );
		
		echo $after_widget;
	}
	
	function update($new_instance, $old_instance) {
		$instance = $old_instance;
		$new_instance = wp_parse_args( (array) $new_instance, array( 
			'title' => '',
			'show_items' => -1,
			'category' => false,
			'item_order' => 'link_name ASC',
			'show_image' => 'show-no-images',
			'thumb_size' => 50,
			'show_link' => 0,
			'show_link_nf' => 0,
			'feed_items' => 1,
			'shorten_feedlink' => 0,
			's_f_length' => 20,
			'feed_link_nf' => 0,
			'show_summary' => 0,
			'summary_length' => 100 ) ); 
		$instance['title'] = strip_tags($new_instance['title']);
		$instance['show_items'] = (int) $new_instance['show_items'];
		$instance['category'] = intval($new_instance['category']);
		$instance['item_order'] = htmlspecialchars($new_instance['item_order']);
		$instance['show_image'] = htmlspecialchars($new_instance['show_image']);
		$instance['thumb_size'] = (int) $new_instance['thumb_size'];
		$instance['show_link'] = $new_instance['show_link'] ? 1 : 0;
		$instance['show_link_nf'] = $new_instance['show_link_nf'] ? 1 : 0;
		$instance['feed_items'] = (int) $new_instance['feed_items'];
		$instance['shorten_feedlink'] = $new_instance['shorten_feedlink'] ? 1 : 0;
		$instance['s_f_length'] = (int) $new_instance['s_f_length'];
		$instance['feed_link_nf'] = $new_instance['feed_link_nf'] ? 1 : 0;
		$instance['show_summary'] = $new_instance['show_summary'] ? 1 : 0;				
		$instance['summary_length'] = (int) $new_instance['summary_length'];
		
		return $instance;
	}

	function form($instance) {			
		$instance = wp_parse_args( (array) $instance, array( 
			'title' => '',
			'show_items' => -1,
			'category' => false,
			'item_order' => 'link_name ASC',
			'show_image' => 'show-no-images',
			'show_link' => 0,
			'thumb_size' => 50,
			'show_link_nf' => 0,
			'feed_items' => 1,
			'shorten_feedlink' => 0,
			's_f_length' => 20,
			'feed_link_nf' => 0,
			'show_summary' => 0,
			'summary_length' => 100 ) );
		$title = strip_tags($instance['title']);
		$link_cats = get_terms( 'link_category');
		$item_order = htmlspecialchars($instance['item_order']);
		$show_image = htmlspecialchars($instance['show_image']);
		$show_link = $instance['show_link'] ? 'checked="checked"' : '';
		$show_link_nf = $instance['show_link_nf'] ? 'checked="checked"' : '';
		$shorten_feedlink = $instance['shorten_feedlink'] ? 'checked="checked"' : '';
		$feed_link_nf = $instance['feed_link_nf'] ? 'checked="checked"' : '';
		$show_summary = $instance['show_summary'] ? 'checked="checked"' : '';
		
		if ( !$show_items = (int) $instance['show_items'] )
			$show_items = -1;
        elseif ( $show_items < -1 )
			$show_items = -1;
        
        if ( !$thumb_size = (int) $instance['thumb_size'] )
			$thumb_size = 50;
        elseif ( $thumb_size < 10 )
			$thumb_size = 50;
		
		if ( !$feed_items = (int) $instance['feed_items'] )
			$feed_items = 1;
        elseif ( $feed_items > 10 )
			$feed_items = 10;
		 elseif ( $feed_items < 1 )
			$feed_items = 1;
		
		if ( !$s_f_length = (int) $instance['s_f_length'] )
			$s_f_length = 20;
		elseif ( $s_f_length < 1 )
			$s_f_length = 1;
			
        if ( !$summary_length = (int) $instance['summary_length'] )
			$summary_length = 100;
		else if ( $summary_length < 10 )
			$summary_length = 10;
		else if ( $summary_length > 999 )
			$summary_length = 999;

?>
		<p>
			<small><?php _e('Make sure, that you have entered the right RSS Addresses to your links in the Links Subpanel. Otherwise this plugin will not work correctly. No item is shown when a wrong or no RSS Address is entered!', 'blogroll-widget-rss');?></small>
		</p>
		
		<p style="border-bottom:1px solid #DFDFDF;"><strong><?php _e('Widget Settings:', 'blogroll-widget-rss');?></strong></p>
		
		<p>
			<label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:', 'blogroll-widget-rss');?></label>
			<input id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $instance['title']; ?>" size="50" />
		</p>
		
		<p>
			<label for="<?php echo $this->get_field_id('show_items'); ?>"><?php _e('Display items:', 'blogroll-widget-rss');?></label>
		    <input id="<?php echo $this->get_field_id('show_items'); ?>" name="<?php echo $this->get_field_name('show_items'); ?>" type="text" value="<?php echo $show_items; ?>" size="3" />
			<span class="description"><small><?php _e(' (-1 will display all items)', 'blogroll-widget-rss'); ?></small></span>
		</p>
		
		<p>
			<?php _e('Display items from link category:', 'blogroll-widget-rss');?>
			<label for="<?php echo $this->get_field_id('category'); ?>" class="screen-reader-text"><?php _e('Select Link Category', 'blogroll-widget-rss'); ?></label>
			<select style="width: 150px;" id="<?php echo $this->get_field_id('category'); ?>" name="<?php echo $this->get_field_name('category'); ?>">
			<option value=""><?php _e('All Links', 'blogroll-widget-rss'); ?></option>
				<?php
				foreach ( $link_cats as $link_cat ) {
					echo '<option value="' . intval($link_cat->term_id) . '"'
						. ( $link_cat->term_id == $instance['category'] ? ' selected="selected"' : '' )
						. '>' . $link_cat->name . "</option>\n";
				}
				?>
			</select>
		</p>
		
		<p>
			<?php _e('Item order:', 'blogroll-widget-rss');?>
			<label for="<?php echo $this->get_field_id('item_order'); ?>" class="screen-reader-text"><?php _e('Select Item Order', 'blogroll-widget-rss'); ?></label>
			<select id="<?php echo $this->get_field_id('item_order'); ?>" name="<?php echo $this->get_field_name('item_order'); ?>">
				<option value="link_name ASC"<?php echo ($item_order === 'link_name ASC' ? ' selected="selected"' : '' ); ?>><?php _e('Link Name Ascending', 'blogroll-widget-rss'); ?></option>
				<option value="link_name DESC"<?php echo ($item_order === 'link_name DESC' ? ' selected="selected"' : '' ); ?>><?php _e('Link Name Descending', 'blogroll-widget-rss'); ?></option>
				<option value="link_id ASC"<?php echo ($item_order === 'link_id ASC' ? ' selected="selected"' : '' ); ?>><?php _e('Link ID Ascending', 'blogroll-widget-rss'); ?></option>
				<option value="link_id DESC"<?php echo ($item_order === 'link_id DESC' ? ' selected="selected"' : '' ); ?>><?php _e('Link ID Descending', 'blogroll-widget-rss'); ?></option>
				<option value="rand()"<?php echo ($item_order === 'rand()' ? ' selected="selected"' : '' ); ?>><?php _e('Random Order', 'blogroll-widget-rss'); ?></option>
			</select>
			<span class="description"><br /><small>&nbsp;&nbsp;&nbsp;<?php _e('("Random Order" is recommended for less than all items)', 'blogroll-widget-rss'); ?></small></span>
		</p>
		
		<p style="border-bottom:1px solid #DFDFDF;"><strong><?php _e('Items Configuration:', 'blogroll-widget-rss'); ?></strong></p>
		
		<table width="400">
			<tr>
			<td colspan="2">
				<p>
					<?php _e('Show link images:', 'blogroll-widget-rss');?>
					<label for="<?php echo $this->get_field_id('show_image'); ?>" class="screen-reader-text"><?php _e('Select if you want to show images', 'blogroll-widget-rss'); ?></label>
					<select id="<?php echo $this->get_field_id('show_image'); ?>" name="<?php echo $this->get_field_name('show_image'); ?>">
						<option value="show-no-images"<?php echo ($show_image === 'show-no-images' ? ' selected="selected"' : '' ); ?>><?php _e('Show no images', 'blogroll-widget-rss'); ?></option>
						<option value="show-my-own-images"<?php echo ($show_image === 'show-my-own-images' ? ' selected="selected"' : '' ); ?>><?php _e('Show my own images', 'blogroll-widget-rss'); ?></option>
						<option value="create-thumbnails"<?php echo ($show_image === 'create-thumbnails' ? ' selected="selected"' : '' ); ?>><?php _e('Create and show thumbnails (not recommended!)', 'blogroll-widget-rss'); ?></option>
					</select>
				</p>
				
				<p style="padding-left:25px;">
					<input id="<?php echo $this->get_field_id('thumb_size'); ?>" name="<?php echo $this->get_field_name('thumb_size'); ?>" type="text" value="<?php echo $thumb_size; ?>" size="3" />
					<label for="<?php echo $this->get_field_id('thumb_size'); ?>"><?php _e('Pixel (image size)', 'blogroll-widget-rss');?></label>
				</p>
			</td>
			</tr>
			
			<tr>
			<td colspan="2">
				<p style="margin-left:10px; margin-right:10px; border-bottom:1px dotted #DFDFDF;"></p>
			</td>
			</tr>
			
			<tr>
			<td width="55%">
				<p>
					<input class="checkbox" type="checkbox" <?php echo $show_link; ?> id="<?php echo $this->get_field_id( 'show_link' ); ?>" name="<?php echo $this->get_field_name( 'show_link' ); ?>" />
					<label for="<?php echo $this->get_field_id( 'show_link' ); ?>"><?php _e('Show blogroll links ?', 'blogroll-widget-rss'); ?></label>
				</p>
			</td>
			<td width="45%">
				<p>
					<input class="checkbox" type="checkbox" <?php echo $show_link_nf; ?> id="<?php echo $this->get_field_id( 'show_link_nf' ); ?>" name="<?php echo $this->get_field_name( 'show_link_nf' ); ?>" />
					<label for="<?php echo $this->get_field_id( 'show_link_nf' ); ?>"><?php _e('Add rel="nofollow" ?', 'blogroll-widget-rss'); ?></label>
				</p>
			</td>
			</tr>
			
			<tr>
			<td colspan="2">
				<p style="margin-left:10px; margin-right:10px; border-bottom:1px dotted #DFDFDF;"></p>
			</td>
			</tr>
			
			<tr>
			<td width="55%">
				<p>
					<label for="<?php echo $this->get_field_id('feed_items'); ?>"><?php _e('Display feed post links:', 'blogroll-widget-rss');?></label>
					<input id="<?php echo $this->get_field_id('feed_items'); ?>" name="<?php echo $this->get_field_name('feed_items'); ?>" type="text" value="<?php echo $feed_items; ?>" size="2" />
					<span class="description"><small><br /><?php _e('(between 1 and 10)', 'blogroll-widget-rss'); ?></small></span>
				</p>
				<p>
					<input class="checkbox" type="checkbox" <?php echo $shorten_feedlink; ?> id="<?php echo $this->get_field_id( 'shorten_feedlink' ); ?>" name="<?php echo $this->get_field_name( 'shorten_feedlink' ); ?>" />
					<label for="<?php echo $this->get_field_id( 'shorten_feedlink' ); ?>"><?php _e('Shorten feed post link text ?', 'blogroll-widget-rss'); ?></label>
				</p>
			</td>
			<td width="45%">
				<p>
					<input class="checkbox" type="checkbox" <?php echo $feed_link_nf; ?> id="<?php echo $this->get_field_id( 'feed_link_nf' ); ?>" name="<?php echo $this->get_field_name( 'feed_link_nf' ); ?>" />
					<label for="<?php echo $this->get_field_id( 'feed_link_nf' ); ?>"><?php _e('Add rel="nofollow" ?', 'blogroll-widget-rss'); ?></label>
				</p>
				<br />
				<p>
					<label for="<?php echo $this->get_field_id('s_f_length'); ?>"><?php _e('shorten to', 'blogroll-widget-rss');?></label>
					<input id="<?php echo $this->get_field_id('s_f_length'); ?>" name="<?php echo $this->get_field_name('s_f_length'); ?>" type="text" value="<?php echo $s_f_length; ?>" size="2" />
					<?php _e('characters', 'blogroll-widget-rss');?>
				</p>
			</td>
			</tr>
			
			<tr>
			<td colspan="2">
				<p style="margin-left:10px; margin-right:10px; border-bottom:1px dotted #DFDFDF;"></p>
			</td>
			</tr>
			
			<tr>
			<td width="55%">
				<p>
					<input class="checkbox" type="checkbox" <?php echo $show_summary; ?> id="<?php echo $this->get_field_id( 'show_summary' ); ?>" name="<?php echo $this->get_field_name( 'show_summary' ); ?>" />
					<label for="<?php echo $this->get_field_id( 'show_summary' ); ?>"><?php _e('Show feed post excerpts ?', 'blogroll-widget-rss'); ?></label>
				</p>
			</td>
			<td width="45%">
				<p>
					<input id="<?php echo $this->get_field_id('summary_length'); ?>" name="<?php echo $this->get_field_name('summary_length'); ?>" type="text" value="<?php echo $summary_length; ?>" size="3" />
					<label for="<?php echo $this->get_field_id('summary_length'); ?>"><?php _e('Characters for excerpts', 'blogroll-widget-rss'); ?></label>
					<span class="description"><small><?php _e('(between 10 and 999)', 'blogroll-widget-rss'); ?></small></span>
				</p>
			</td>
			</tr>
			
			<tr>
			<td colspan="2">
				<p style="margin-left:10px; margin-right:10px; border-bottom:1px dotted #DFDFDF;"></p>
			</td>
			</tr>
			
		</table>
		
<?php
	}
}
 
add_action('widgets_init', create_function('', 'return register_widget("Blogroll_Widget_RSS");'));

function br_w_r_shorten($string, $length) {
	$suffix = '...';
	$short_desc = trim(str_replace(array("\r","\n", "\t"), ' ', strip_tags($string)));
	$desc = trim(substr($short_desc, 0, $length));
	$lastchar = substr($desc, -1, 1);
	if ($lastchar == '.' || $lastchar == '!' || $lastchar == '?') $suffix='';
	$desc .= $suffix;
	return $desc;
}

function br_w_r_t_shorten($string, $length) {
	$suffix = '...';
	$short_tit = trim(str_replace(array("\r","\n", "\t"), ' ', strip_tags($string)));
	$tit = trim(substr($short_tit, 0, $length));
	$lastchar = substr($tit, -1, 1);
	if ($lastchar == '.' || $lastchar == '!' || $lastchar == '?') $suffix='';
	$tit .= $suffix;
	return $tit;
}

function show_blogroll_widget_rss( $args = array() ) {
	$default_args = array ( 
		'show_items' => -1 , 
		'category' => false,
		'item_order' => 'link_name ASC',
		'show_image' => 'show-no-images',
		'thumb_size' => 50,
		'show_link' => 0,
		'show_link_nf' => 0,
		'feed_items' => 1,
		'shorten_feedlink' => 0,
		's_f_length' => 20,
		'feed_link_nf' => 0,
		'show_summary' => 0,
		'summary_length' => 100);
	$args = wp_parse_args( $args, $default_args );
	extract( $args );
	
	$show_items = (int) $show_items;
	$thumb_size = (int) $thumb_size;
	$show_link = (int) $show_link;
	$show_link_nf = (int) $show_link_nf;          
	$feed_items = (int) $feed_items;
	$shorten_feedlink = (int) $shorten_feedlink;
	$s_f_length = (int) $s_f_length;
	$feed_link_nf = (int) $feed_link_nf;
	$show_summary = (int) $show_summary;
	$summary_length = (int) $summary_length;
	
	global $wpdb;
		
	if ( $category != 0 )
		$qu_cat_t = " AND tt.term_id = $category ";
		
	$queryString = "
		SELECT * FROM $wpdb->links
		INNER JOIN $wpdb->term_relationships AS tr ON ($wpdb->links.link_id = tr.object_id)
		INNER JOIN $wpdb->term_taxonomy as tt ON tt.term_taxonomy_id = tr.term_taxonomy_id
		WHERE $wpdb->links.link_visible = 'Y'
		 AND $wpdb->links.link_rss != ''
		 AND tt.taxonomy = 'link_category'
		 $qu_cat_t
		Order by $item_order";
	if ( $show_items != -1)
		$queryString .= " LIMIT $show_items";
		
	$blbm_links = $wpdb->get_results($queryString);
	
	if (empty($blbm_links)) {
	
		echo '<ul><li>';
		_e('No RSS Addresses are entered to your links in the Links SubPanel, therefore no items can be shown!', 'blogroll-widget-rss');
		echo '</li></ul>';
		
	} else {
	
		add_filter( 'wp_feed_cache_transient_lifetime', create_function( '$a', 'return 1800;' ) );
		include_once(ABSPATH . WPINC . '/feed.php');
		
		echo '<ul>';
	
		foreach ($blbm_links as $blbm_link) :	
			
			echo '<li>';
			
			if ( $show_image != "show-no-images" ) { 
				$thumb_h = $thumb_size/4;
				$thumb_height = $thumb_h*3;
				if ( $show_image == "show-my-own-images" && $blbm_link->link_image != "" ) {
				echo '<div style="float:left; margin:3px 3px 0 0;">
					<img style="width:'.$thumb_size.'px;" 
					src="'.$blbm_link->link_image.'" alt="'.$blbm_link->link_name.'" title="'.$blbm_link->link_name.'" />
					</div>';
				}
			
				if ( $show_image == "create-thumbnails" ) { 
				echo '<div style="float:left; margin:3px 3px 0 0;">
					<img style="width:'.$thumb_size.'px; height:'.$thumb_height.'px;" 
					src="http://www.m-software.de/screenshot/Screenshot.png?url='.$blbm_link->link_url.'&commingsoonimg=http%3A%2F%2Fwww.m-software.de%2Fuploads%2Fcommingsoon.png" 
					alt="'.$blbm_link->link_name.'" title="'.$blbm_link->link_name.'"/>
					</div>';
				}
			}
					
			$blbm_target = $blbm_link->link_target;
			
			if ( $show_link ) {
				echo '<a ';
				if ( $blbm_target ) { 
					echo 'target="'.$blbm_target.'" ';
				}
				if ( $show_link_nf ) { 
					echo 'rel="nofollow" ';
				}
				echo 'href="'.$blbm_link->link_url.'">'.$blbm_link->link_name.'</a><br />';
			}
			
			$blbm_url = esc_attr($blbm_link->link_rss);			
			$blbm_rss = fetch_feed($blbm_url);
			
			if ( is_wp_error($blbm_rss) ) {	
				$filestring = file_get_contents($blbm_url);
					$startpos = 0;
						while ($pos = strpos($filestring, "application/rss+xml", $startpos)) {
						$string = substr($filestring, $pos, strpos($filestring, "/>", $pos +1)  - $pos);
						$startpos = $pos + 1;
					}
					$startpos = 0;
						while ($pos = strpos($string, 'href="', $startpos)) {
						$blbm_url = substr(substr($string, $pos + 6), 0, strpos(substr($string, $pos + 6), '"'));
						$startpos = $pos + 1;
					}
					$blbm_rss = fetch_feed($blbm_url);
					
					if (is_wp_error($blbm_rss)) {
						//echo $rss->get_error_message().'<br />';
						//echo __( 'An error has occurred; the feed is probably down. Try again later.' ) . '</li>';
						if ( $show_image != "show-no-images" ) {
							echo'<div style="clear:both; margin-bottom:3px;"></div>';
						}
						echo '</li>';
						unset($blbm_rss);
						continue;
					}
			} 
			
			if ( !is_wp_error($blbm_rss) ) {
				
				if ( $feed_items < 1 )
					$feed_items = 1;
			
				$blbm_rss_items = $blbm_rss->get_items( 0, $blbm_rss->get_item_quantity($feed_items) ); 
				
				foreach ( $blbm_rss_items as $item ) : 	
					
					$tit_l = $item->get_title();
					$tit_c = strlen($tit_l);
					
					echo '<a ';
						if ( $blbm_target ) { 
							echo 'target="'.$blbm_target.'" ';
						}
					//echo '<a target="_blank" ';
						
					if ( $feed_link_nf ) { 
						echo 'rel="nofollow" ';
					}
					
					if ( $shorten_feedlink && $tit_c > $s_f_length) { 
						$tit = br_w_r_t_shorten($item->get_title(),$s_f_length);
						echo 'href="'.$item->get_permalink().'">'.$tit.'</a>';
					} else {
						echo 'href="'.$item->get_permalink().'">'.$item->get_title().'</a>';
					}
					
					if ( $show_summary ) { 
						$desc = br_w_r_shorten($item->get_description(),$summary_length);
						echo ': <cite>'.$desc.'</cite>';
					}
						
					echo '<br />';
						
				endforeach;
											
				if ( $show_image != "show-no-images" ) {
					echo'<div style="clear:both;"></div>';
				}
				
				echo'</li>';

			}
		
		endforeach;
		
		echo '</ul>';
		
		if ( $show_image == "create-thumbnails") {
			echo'<div align="center"><small>
				<a target="_blank" rel="nofollow" href="http://www.m-software.de/thumbshots.html">Thumbnails by M-Software.de
				</a></small></div>';
		}
		
		//$blbm_rss->__destruct(); 
		unset($blbm_rss);
		
		remove_filter( 'wp_feed_cache_transient_lifetime', create_function( '$a', 'return 1800;' ) );	
		
	}	
}

?>