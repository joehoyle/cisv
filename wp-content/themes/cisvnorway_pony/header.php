<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" <?php language_attributes(); ?>>
<head profile="http://gmpg.org/xfn/11">
    <title><?php
        if ( is_single() ) { single_post_title(); }       
        elseif ( is_home() || is_front_page() ) { bloginfo('name'); print get_page_number(); }
        elseif ( is_page() ) { single_post_title(''); }
        elseif ( is_search() ) { bloginfo('name'); print ' | S&oslash;keresultat for ' . wp_specialchars($s); get_page_number(); }
        elseif ( is_404() ) { bloginfo('name'); print ' | Ikke funnen'; }
        else { bloginfo('name'); wp_title('|'); get_page_number(); }
    ?></title>
 
	<meta http-equiv="content-type" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>" />
 	<?php switch_to_blog(1); ?>
	<link rel="stylesheet" type="text/css" href="<?php bloginfo('stylesheet_url'); ?>" />
	<link rel="stylesheet" type="text/css" media="screen" href="<?php bloginfo('template_directory'); ?>/pony.css" />
	<?php restore_current_blog(); ?>
 
	<?php if ( is_singular() ) wp_enqueue_script( 'comment-reply' ); ?>
 
	<?php wp_head(); ?>
 
	<link rel="alternate" type="application/rss+xml" href="<?php bloginfo('rss2_url'); ?>" title="<?php printf( __( '%s latest posts', 'your-theme' ), wp_specialchars( get_bloginfo('name'), 1 ) ); ?>" />
	<link rel="alternate" type="application/rss+xml" href="<?php bloginfo('comments_rss2_url') ?>" title="<?php printf( __( '%s latest comments', 'your-theme' ), wp_specialchars( get_bloginfo('name'), 1 ) ); ?>" />
	<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />	
</head>
<body>
	<div id="wrapper" class="hfeed">
		<div id="kontainer">
			<!-- Topp-wrapper -->
			<?php switch_to_blog(1); ?>
			<div id="topp-wrapper">
				<h1 id="blogg-tittel"><span><a href="<?php bloginfo( 'url' ) ?>/" title="<?php bloginfo( 'name' ) ?>" rel="home"><?php bloginfo( 'name' ) ?></a></span></h1>
				<div class="skip-link"><a href="#hoved-wrapper" title="<?php _e( 'Hopp til innhold', 'cisv' ) ?>"><?php _e( 'Hopp til innhold', 'cisv' ) ?></a></div>
				<div id="mini-topp-meny">
					<a href="http://cisv.hypersys.no/mypage/">Min side</a> &middot; 
					<a href="/cisv-norge/kontakt-oss/">Kontakt</a> &middot;  
					<a href="#">Sidekart</a>
				</div>
				<div id="sok-og-lokallag">
					<div id="sok">
						<form id="searchform" method="get" action="<?php bloginfo('home'); ?>">
        					<p><input type="text" name="s" id="searchbox" value=""/>
        					<input name="S&oslash;k" type="image" value="<?php esc_attr_e('S&oslash;k'); ?>" src="<?php bloginfo('stylesheet_directory'); ?>/images/ikon-sok.png" id="searchbutton"/></p>
						</form>
					</div>
					<div id="lokallag">
						<ul>
						<li><a href="#"><strong>Velg lokallag:</strong></a>
						<ul><?php listem($blog_limit='', $name_or_url='name', $begin_wrap='<li>', $end_wrap = '</li>', $order_by='alpha') ?></ul></li></ul>
					</div>
				</div>
				<div id="hovedmeny">
					<ul>
						<li class="startside page_item"><a href="/" title="<?php bloginfo( 'name' ) ?>" rel="home">Startside</a></li>
						<?php wp_list_pages( 'title_li&sort_column=menu_order&depth=1&exclude=165,239'); ?>
					</ul>
				</div>
				<?php restore_current_blog(); ?>
			</div>
			<?php if ( !is_home() ) { ?>
			<div class="breadcrumb-undersider">
				<?php if ( function_exists('yoast_breadcrumb') ) {
				yoast_breadcrumb('<p id="breadcrumb">','</p>');
				} ?>
			</div>
			<?php } ?>
