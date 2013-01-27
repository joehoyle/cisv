<?php
/*
Plugin Name: Listem
Plugin URI: http://www.wpmudev.org/project/listem
Description: Developed off of List-All plug-in for WordPress MU created by Andrew Billits (http://www.wpmudev.org/project/list-all). This is an updated version that allows ordering alphabetically as well. Creates a list of all blogs on a WPMU site
Author: Vernon Kesner
Author URI: http://www.kesnerdesigns.net
Version: 0.1
*/

function listem($blog_limit='', $name_or_url='name', $begin_wrap='<li>', $end_wrap='</li>', $order_by='alpha') {
	global $wpdb;
	
	/* potential order by's:  updated, first_created, last_created, alpha (default) */
	
	//let's query for blogs first to be sure we want to list them
	$blog_count = $wpdb->get_var("SELECT count(*) FROM ".$wpdb->blogs);
	if(($blog_count == 0) || ($blog_count == 1)) {
		//if only one, don't display main blog
		echo $begin_wrap."There are currently no active sub-blogs".$end_wrap;
	}
	else {
		//there are blogs so let's get them ready to show
		//is there a limit set
		if($blog_limit != '') $limit = "LIMIT $blog_limit";
		else $limit = '';
		//is there an order by we should include in query? This would be updated, first_created, last_created
		if($order_by == 'updated') $order = " ORDER BY last_updated DESC";
		elseif($order_by == 'first_created') $order = " ORDER BY blog_id ASC ";
		elseif($order_by == 'last_created') $order = " ORDER BY blog_id DESC ";
		else $order = '';
		$blog_list = $wpdb->get_results("SELECT blog_id, last_updated FROM ".$wpdb->blogs." WHERE 
		public = '1' AND archived='0' AND mature='0' AND spam='0' AND deleted='0'
		$order $limit", ARRAY_A);
		//total blog count
		$blog_count = count($blog_list);
		//new array to hold blog info
		$bloginfo = array();
		//loop through blogs and put in array and get domain/name info and add to array
		for($i=0;$i<$blog_count;$i++) {
			$bloginfo[$i]['bid'] = $blog_list[$i]['blog_id'];
			$bloginfo[$i]['last_updated'] = $blog_list[$i]['last_updated'];
			//get blog name and domain
			$bloginfo[$i]['name'] = get_blog_option($bloginfo[$i]['bid'], 'blogname');
			$bloginfo[$i]['url'] = get_blog_option($bloginfo[$i]['bid'], 'siteurl');
			
		}
		//unless order_by is alpha we can leave order as is
		if($order_by == 'alpha') {
			//rearrange array so that it's in alphabetical order by blog_name or blog_url whichever is chosen
			if($name_or_url == 'name') $bloginfo = msort($bloginfo, 'name');
			else $bloginfo = msort($bloginfo, 'url');
		}
		//output list
		for($i=0;$i<$blog_count;$i++) {
			echo $begin_wrap."<a href='".$bloginfo[$i]['url']."'>";
			if($name_or_url == 'url') echo $bloginfo[$i]['url'];
			else echo $bloginfo[$i]['name'];
			echo "</a>".$end_wrap."\n";
		}
	}
	
}

//function for sorting array alphabetically -> sorting code from http://us.php.net/manual/en/function.sort.php#80276
function msort($array, $id="id", $sort_ascending=true) {
	$temp_array = array();
	while(count($array)>0) {
		$lowest_id = 0;
		$index=0;
		foreach ($array as $item) {
			if (isset($item[$id])) {
				if ($array[$lowest_id][$id]) {
					if (strtolower($item[$id]) < strtolower($array[$lowest_id][$id])) {
			    			$lowest_id = $index;
					}
				}
			}
			$index++;
		}
		$temp_array[] = $array[$lowest_id];
		$array = array_merge(array_slice($array, 0,$lowest_id), array_slice($array, $lowest_id+1));
	}
	if ($sort_ascending) {
		return $temp_array;
	} else {
		return array_reverse($temp_array);
	}
}

?>