<?php

function is_user() {
	
	global $userdata;
	get_currentuserinfo();
	
	if ($userdata->user_level > 4) {
		return true;
	}
	
}


function theme_widgets_init() {
    register_sidebar(array(
    	'name' => 'Primary Widget Area',
    	'id' => 'primary-widget-area',
        'before_widget' => '<div class="categories">',
        'after_widget' => '</div>',
        'before_title' => '<h2><em>',
        'after_title' => '</em></h2>',
    ));

    register_sidebar(array(
    	'name' => 'Secondary Widget Area',
    	'id' => 'secondary-widget-area',
        'before_widget' => '<div class="categories">',
        'after_widget' => '</div>',
        'before_title' => '<h2><em>',
        'after_title' => '</em></h2>',
    ));
    
    register_sidebar(array(
    	'name' => 'Tertiary Widget Area',
    	'id' => 'tertiary-widget-area',
        'before_widget' => '<div class="categories">',
        'after_widget' => '</div>',
        'before_title' => '<h2><em>',
        'after_title' => '</em></h2>',
    ));
    
}

add_action( 'init', 'theme_widgets_init' );
?>
<?php
// Your Changeable header business starts here 
// No CSS, just IMG call
define('HEADER_TEXTCOLOR', '');
define('HEADER_IMAGE', '%s/images/header-1.jpg'); // %s is theme dir uri
define('HEADER_IMAGE_WIDTH', apply_filters('camp_theme_header_image_width', '940'));
define('HEADER_IMAGE_HEIGHT', apply_filters('camp_theme_header_image_height', '198'));
define( 'NO_HEADER_TEXT', true );

function camp_theme_admin_header_style() {
?>
<style type="text/css">
#headimg {
	height: <?php echo HEADER_IMAGE_HEIGHT; ?>px;
	width: <?php echo HEADER_IMAGE_WIDTH; ?>px;
}
#headimg h1, #headimg #desc {
	display: none;
}
</style>
<?php
}
add_custom_image_header('', 'camp_theme_admin_header_style');
// and thus ends the changeable header business
?>
<?php function myLoop($atts, $content = null) {
	extract(shortcode_atts(array(
		"pagination" => 'true',
		"query" => '',
		"category" => '',
	), $atts));
	global $wp_query,$paged,$post;
	$temp = $wp_query;
	$wp_query= null;
	$wp_query = new WP_Query();
	if($pagination == 'true'){
		$query .= '&paged='.$paged;
	}
	if(!empty($category)){
		$query .= '&category_name='.$category;
	}
	if(!empty($query)){
		$query .= $query;
	}
	$wp_query->query($query);
	ob_start();
	?>
	<h2><?php// echo $category; ?></h2>
	<?php while ($wp_query->have_posts()) : $wp_query->the_post(); ?>
	<div class="entry">
		<h2><a href="<?php the_permalink() ?>" rel="bookmark"><?php echo $thumbnail_image; the_title(); ?></a></h2>
	<?php the_content(); ?>
	</div>
	<?php endwhile; ?>
	<?php if(pagination == 'true'){ ?>
	<div class="navigation">
	  <div class="alignleft"><?php previous_posts_link('« Previous') ?></div>
	  <div class="alignright"><?php next_posts_link('More »') ?></div>
	</div>
	<?php } ?>
	<?php $wp_query = null; $wp_query = $temp;
	$content = ob_get_contents();
	ob_end_clean();
	return $content;
}
add_shortcode("loop", "myLoop");
?>
<?php 
function register_my_menus() {
register_nav_menus(
array(
'header-menu' => __( 'Header Menu' )
)
);
}
add_action( 'init', 'register_my_menus' );
?>
<?php
//CISV norge logo på login
function custom_login_logo() {
    echo '<style type="text/css">
        h1 a { background-image:url('.get_bloginfo('template_directory').'/images/cisv-norge-logo.png) !important; margin-bottom: 10px; }
    </style>';
}
add_action('login_head', 'custom_login_logo');
?>