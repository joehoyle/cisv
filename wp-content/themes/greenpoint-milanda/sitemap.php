<?php
/*
Template Name: Sitemap
*/
?>
<?php get_header(); ?>
<div id="content">	
<div class="entry">
<?php include (TEMPLATEPATH . '/sidebar_top_center.php'); ?>		
<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
	
<h2 class="widgettitle"><?php the_title(); ?></h2>	
	<p><strong><a href="<?php bloginfo('url'); ?>" title="<?php bloginfo('name'); ?>">Home</a></strong></p>
<div class="sitemapitem">

<h3 class="widgettitle">All entries:</h3>
        <ul>
	<?php $archive_query = new WP_Query('showposts=1000');
		while ($archive_query->have_posts()) : $archive_query->the_post(); ?>
	<li><a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title(); ?>"><?php the_title(); ?></a></li>
					<?php endwhile; ?>
	</ul>
</div>
<div class="sitemapitem">
<h3 class="widgettitle">All pages:</h3>
	<ul>
	<?php wp_list_pages('title_li='); ?>
	</ul>
</div>
<div class="sitemapitem">
<h3 class="widgettitle">Archives by Months:</h3>
	<ul>
	<?php wp_get_archives('type=monthly'); ?>
	</ul>
</div>
<div class="sitemapitem">
<h3 class="widgettitle">Archives by Categories:</h3>
	<ul>
	<?php wp_list_categories('title_li=0'); ?>
	</ul>
</div>
<div class="sitemapitem">
<h3 class="widgettitle">Bookmarks:</h3>
	<ul>
	<?php wp_list_bookmarks(); ?>
	</ul>
</div>
<div class="sitemapitem">
<h3 class="widgettitle">Tags:</h3>
	<?php wp_tag_cloud(''); ?>
</div>
			
			<div class="clr"></div>
			<?php endwhile; endif; ?>
            <?php include (TEMPLATEPATH . '/sidebar_bottom_center.php'); ?>
            </div>
	</div>
<?php get_footer(); ?>