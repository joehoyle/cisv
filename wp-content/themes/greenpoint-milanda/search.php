<?php get_header(); ?>

<div id="content">
    <div id="leftcolumn">
	<?php include (TEMPLATEPATH . '/sidebar_left.php'); ?>
	</div>
	<div id="middlecolumn">
    <div class="entry">
    
    <?php include (TEMPLATEPATH . '/sidebar_top_center.php'); ?>
    
    <div class="post">
<h2 class="pagetitle">Search results:</h2>
		<?php if (have_posts()) : ?>

 	  

		<div class="navigation">
			<div class="alignleft"><?php next_posts_link('&laquo; Older Entries') ?></div>
			<div class="alignright"><?php previous_posts_link('Newer Entries &raquo;') ?></div>
		</div>

		<?php while (have_posts()) : the_post(); ?>
	
				<h3 id="post-<?php the_ID(); ?>"><a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title_attribute(); ?>"><?php the_title(); ?></a></h3>
				<small><?php the_time('l, F jS, Y') ?></small>
				
					<?php the_excerpt(); ?>
				
				<p class="postmetadata"><?php the_tags('Tags: ', ', ', '<br />'); ?> Posted in <?php the_category(', ') ?> | <?php edit_post_link('Edit', '', ' | '); ?>  <?php comments_popup_link('No Comments &#187;', '1 Comment &#187;', '% Comments &#187;'); ?></p>

			

		<?php endwhile; ?>

		<div class="navigation">
			<div class="alignleft"><?php next_posts_link('&laquo; Older Entries') ?></div>
			<div class="alignright"><?php previous_posts_link('Newer Entries &raquo;') ?></div>
		</div>

	<?php else : ?>

		<h2 class="center">Sorry, Not Found. Try Google...</h2>
		

	<?php endif; ?>
    <br />
    <?php include (TEMPLATEPATH . '/sidebar_bottom_center.php'); ?>
    
    </div>
    </div>
	</div>

	<div id="rightcolumn">

	<?php include (TEMPLATEPATH . '/sidebar_right.php'); ?>

	</div>

</div>
<div class="clr"></div>

<?php get_footer(); ?>
