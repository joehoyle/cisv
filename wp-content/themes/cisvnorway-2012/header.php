<!DOCTYPE html>
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

	<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />

	<script type="text/javascript">
	function go()
	{
	window.location=document.getElementById("menu").value;
	}
	</script>

	<?php wp_head(); ?>
</head>
<body>
	<div id="wrapper" class="hfeed">
		<div id="kontainer">
			<!-- Topp-wrapper -->
			<div id="topp-wrapper">
				<h1 id="blogg-tittel"><span><a href="<?php echo home_url() ?>" title="Gå til hovedsiden til <?php bloginfo( 'name' ) ?>" rel="home"><?php bloginfo( 'name' ) ?></a></span></h1>
				<div class="skip-link"><a href="#hoved-wrapper" title="<?php _e( 'Hopp til innhold', 'cisv' ) ?>"><?php _e( 'Hopp til innhold', 'cisv' ) ?></a></div>
				<div id="topp-meta">
					<div id="introtekst">
						<p>CISV er en religiøst og politisk uavhengig barne- og ungdomsorganisasjon som arbeider for fred ved å skape større forståelse mellom mennesker fra ulike kulturer og nasjoner.</p>
					</div>
					<div id="sok">
					 <a href="#" class="show"><img src="<?php bloginfo('stylesheet_directory'); ?>/images/ikon-sok-av.png" /></a>
						<a href="#" class="hide" title="Lukk søkeboksen">Lukk</a>
						<form id="searchform" method="get" action="<?php echo home_url(); ?>">
							<p><input type="text" name="s" id="searchbox" value=""/>
							<input name="S&oslash;k" type="image" value="<?php esc_attr_e('S&oslash;k'); ?>" src="<?php bloginfo('stylesheet_directory'); ?>/images/ikon-sok-aktiv.png" id="searchbutton"/></p>
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
			<?php if ( !is_home() ) { ?>
			<div class="breadcrumb-undersider">
				<?php if ( function_exists('yoast_breadcrumb') ) {
				yoast_breadcrumb('<p id="breadcrumb">','</p>');
				} ?>
			</div>
			<?php } ?>