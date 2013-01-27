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
	<h2 class="storytitle"><a href="<?php the_permalink() ?>" rel="bookmark"><?php the_title(); ?></a></h2>
    <?php the_date('','<small>','</small>'); ?><br /><?php the_author() ?><br />
	<div class="storycontent">
	<?php the_content(__('(Read more...)')); ?>
	


        </div>


<div class="meta"><?php _e("Posted in:"); ?> <?php the_category(',') ?> <br /> <?php the_tags(__('Tags: '), ', '); ?> <br /> <?php edit_post_link(__('Edit this')); ?></div>
	<div class="feedback">
	<?php wp_link_pages(); ?>
	<?php comments_popup_link(__('No Comments (0)'), __('1 Comment'), __('% Comments')); ?>
	</div>
<p>&nbsp;</p>
</div>
<?php comments_template(); // Get wp-comments.php template ?>
<?php endwhile; else: ?>
<p><?php _e('Sorry, no posts .'); ?></p>

<?php endif; ?>

<center>
<?php posts_nav_link(' &#8212; ', __('&laquo; Newer Entries'), __('Older Entries &raquo;')); ?>
</center>
<br />
<?php include (TEMPLATEPATH . '/sidebar_bottom_center.php'); ?>


</div>
	</div>
	<div id="rightcolumn">
	<?php include (TEMPLATEPATH . '/sidebar_right.php'); ?>
	</div>
    <div class="clr"></div>
</div>
<div class="clr"></div>
<?php get_footer(); ?>

