<?php get_header(); ?>
<div id="content">
	<div id="leftcolumn">
	<?php include (TEMPLATEPATH . '/sidebar_left.php'); ?>
	</div>
		<div id="middlecolumn">
        <div class="entry">
        
        <?php include (TEMPLATEPATH . '/sidebar_top_center.php'); ?>
        
		<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
		<div class="post" id="post-<?php the_ID(); ?>">
		<h2><?php the_title(); ?></h2>
			
				<?php the_content('<p class="serif">Read the rest of this page &raquo;</p>'); ?>
				<?php wp_link_pages(array('before' => '<p><strong>Pages:</strong> ', 'after' => '</p>', 'next_or_number' => 'number')); ?>
			</div>
		
	<?php endwhile; endif; ?>
	<?php edit_post_link('Edit this', '<p>', '</p>'); ?>
    <br />
    <?php include (TEMPLATEPATH . '/sidebar_bottom_center.php'); ?>
    
	</div>
   </div>
	<div id="rightcolumn">
	<?php include (TEMPLATEPATH . '/sidebar_right.php'); ?>
	</div>
    </div>
<div class="clr"></div>

<?php get_footer(); ?>