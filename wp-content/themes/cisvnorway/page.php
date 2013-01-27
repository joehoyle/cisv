			<?php get_header(); ?>

			<!-- Hoved-wrapper -->
			<div id="hoved-wrapper">
				<div class="hovedfelt-venstre">
					<?php the_post(); ?>
					<div class="custom_field_image">
						<?php if ( has_post_thumbnail() ) the_post_thumbnail(''); ?>
					</div>
					<div id="venstremeny">
<?php
if ($post->post_parent == 0) {
$children = wp_list_pages("title_li=&child_of=".$post->ID."&echo=0");
$parentpage = $wpdb->get_row("SELECT ID, post_title, post_name FROM $wpdb->posts WHERE ID = '".$post->ID."'");
}
if ($post->post_parent != 0) {
$next_post_parent = $post->post_parent;
while ($next_post_parent != 0) {
$children = wp_list_pages("title_li=&child_of=".$next_post_parent."&echo=0");
$parentpage = $wpdb->get_row("SELECT ID, post_title, post_parent, post_name FROM $wpdb->posts WHERE ID = '".$next_post_parent."'");
$next_post_parent = $parentpage->post_parent;
}
}
?>
<?php if ($children) { ?>
<ul>
<?php echo $children; ?>
</ul>
<?php } ?>


						
										
											</div>
					<div class="venstrespalte-wrapper">
						
					</div>
 					<div id="post-<?php the_ID(); ?>" class="post">
 						<h1 class="innlegg-tittel"><?php the_title(); ?></h1>
						<div class="innlegg-innhold">
							<?php the_content(); ?>
							<?php wp_link_pages('before=<div class="page-link">' . __( 'Sider:', 'cisv' ) . '&after=</div>') ?>								</div><!-- .innlegg-innhold -->
					</div><!-- #post-<?php the_ID(); ?> -->	
				
				</div>
				
				<?php get_sidebar(); ?>	
		
			</div>
		
		<?php get_footer(); ?>