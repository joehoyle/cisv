<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" <?php language_attributes(); ?>>

<head profile="http://gmpg.org/xfn/11">

	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

	<title><?php bloginfo('name'); ?><?php wp_title(); ?></title>

	<meta name="generator" content="WordPress <?php bloginfo('version'); ?>" /> <!-- leave this for stats please -->

	<style type="text/css" media="screen">

		@import url( <?php bloginfo('stylesheet_url'); ?> );

	</style>

    <link rel="alternate" type="application/rss+xml" title="RSS 2.0" href="<?php bloginfo('rss2_url'); ?>" />

	<link rel="alternate" type="text/xml" title="RSS .92" href="<?php bloginfo('rss_url'); ?>" />

	<link rel="alternate" type="application/atom+xml" title="Atom 0.3" href="<?php bloginfo('atom_url'); ?>" />

	<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />

    <link rel="shortcut icon" href="<?php bloginfo('template_directory'); ?>/favicon.ico" />

	<?php wp_get_archives('type=monthly&format=link'); ?>

	<?php //comments_popup_script(); // off by default ?>

	<?php wp_head(); ?>

</head>

<body>

<div id="header">

	<div id="blogname">

	<h1><a href="<?php bloginfo('url'); ?>/"><?php bloginfo('name'); ?></a></h1>

	<p><?php bloginfo('description'); ?></p>

    </div>

    

<!-- What Time Is It? If you don`t want to show dynamic daytime picture, comment or delete this-->

<div id="daypic">

<?php include (TEMPLATEPATH . '/daytime-pic.php'); ?>

</div>

<!-- End what time is -->



</div>

<div id="topmenu">

<ul>

<li><a href="<?php bloginfo('url'); ?>/">Home</a></li>

<?php wp_list_pages('title_li='); ?>

<li><a href="<?php bloginfo('rss2_url'); ?>" title="<?php _e('Syndicate this site using RSS'); ?>"><?php _e('<abbr title="Really Simple Syndication">RSS</abbr>'); ?></a></li>

</ul>

</div>

<div class="clr"></div>

<?php include (TEMPLATEPATH . '/sidebar_top.php'); ?>

<div class="clr"></div>

<!-- end header -->











