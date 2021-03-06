<!DOCTYPE html html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
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
	<link href="http://cloud.webtype.com/css/a070fa7c-4835-4432-81c7-a32abd9c8de6.css" rel="stylesheet" type="text/css" />
	<script src="http://www.cisv.no/wp-content/themes/cisvnorway-2012/js/jquery-1.6.4.js" type="text/javascript"></script>
	<script src="http://www.cisv.no/wp-content/themes/cisvnorway-2012/js/jquery.js" type="text/javascript"></script>
	<?php restore_current_blog(); ?>
	<link rel="stylesheet" type="text/css" href="<?php bloginfo('stylesheet_url'); ?>" />
 
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
				<h1 id="blogg-tittel"><span><a href="<?php bloginfo( 'url' ) ?>/" title="Gå til hovedsiden til <?php bloginfo( 'name' ) ?>" rel="home"><?php bloginfo( 'name' ) ?></a></span></h1>
				<div class="skip-link"><a href="#hoved-wrapper" title="<?php _e( 'Hopp til innhold', 'cisv' ) ?>"><?php _e( 'Hopp til innhold', 'cisv' ) ?></a></div>
				<div id="topp-meta">
					<div id="introtekst">
						<p>CISV er en religiøst og politisk uavhengig barne- og ungdomsorganisasjon som arbeider for fred ved å skape større forståelse mellom mennesker fra ulike kulturer og nasjoner.</p>
					</div>
					<div id="sok">
					 <a href="#" class="show"><img src="<?php bloginfo('template_url'); ?>/images/ikon-sok-av.png" /></a>
						<a href="#" class="hide" title="Lukk søkeboksen">Lukk</a>
						<form id="searchform" method="get" action="<?php bloginfo('home'); ?>">
        					<p><input type="text" name="s" id="searchbox" value=""/>
        					<input name="S&oslash;k" type="image" value="<?php esc_attr_e('S&oslash;k'); ?>" src="<?php bloginfo('template_url'); ?>/images/ikon-sok-aktiv.png" id="searchbutton"/></p>
						</form>
					</div>
				</div>
				<div id="hovedmeny">
					<ul>
						<li class="startside page_item"><a href="/" title="<?php bloginfo( 'name' ) ?>" rel="home">Hovedside</a></li>
						<?php wp_list_pages( 'title_li&sort_column=menu_order&depth=1&exclude=165,239'); ?>
					</ul>
				</div>
			</div>
				<?php restore_current_blog(); ?>
		
			<!-- Hoved-wrapper -->
			<div id="hoved-wrapper">
				<?php if ( is_home() ) { ?>
				<div id="slider-felt" class="lokallag">
					<div class="hovedsak">
						<div class="post-hovedsak">
							<img src="<?php header_image(); ?>" height="<?php echo get_custom_header()->height; ?>" width="<?php echo get_custom_header()->width; ?>" alt="" />
						</div>
					</div>
					<div id="start" class="front">
						<div class="introtekst">
							<?php if ( function_exists('dynamic_sidebar') && dynamic_sidebar(4) ) : else : ?>
						Velkommen til
							<span><?php bloginfo( 'name' ) ?></span>
							Dette er lokallagsiden til <?php bloginfo( 'name' ) ?>. Her finner du informasjon om det som 
skjer der du bor!
						<?php endif; ?>
						</div>
					</div>
				</div>
				<?php } ?>
				<div id="lokallagmeny">
					<ul>
						<li class="startside page_item"><a href="<?php bloginfo( 'url' ) ?>/" title="<?php bloginfo( 'name' ) ?>" rel="home"><?php bloginfo( 'name' ) ?></a></li>
						<?php wp_list_pages( 'title_li&sort_column=menu_order&depth=1&exclude=165,239'); ?>
					</ul>
				</div>

			<?php if ( !is_home() ) { ?>
			<div class="breadcrumb-undersider">
				<?php if ( function_exists('yoast_breadcrumb') ) {
				yoast_breadcrumb('<p id="breadcrumb">','</p>');
				} ?>
			</div>
			<?php } ?>