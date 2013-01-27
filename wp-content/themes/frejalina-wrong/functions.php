<?php

function is_user() {
	
	global $userdata;
	get_currentuserinfo();
	
	if ($userdata->user_level > 4) {
		return true;
	}
	
}


if ( function_exists('register_sidebar') ) {
    register_sidebar(array(
        'before_widget' => '<div class="categories">',
        'after_widget' => '</div>',
        'before_title' => '<h2><em>',
        'after_title' => '</em></h2>',
    ));
    
   }
   

?>