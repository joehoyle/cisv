			<?php get_header(); ?>

			<!-- Hoved-wrapper -->
			<div id="hoved-wrapper">
				<div class="hovedfelt-venstre">
					<?php the_post(); ?>
					<div class="custom_field_image">

					</div>
					<div id="venstremeny">
					<?php
if(!$post->post_parent){
	// will display the subpages of this top level page
	$children = wp_list_pages("title_li=&child_of=".$post->ID."&echo=0");
}else{
	// diplays only the subpages of parent level
	$children = wp_list_pages("title_li=&child_of=".$post->post_parent."&echo=0");
	
	if($post->ancestors)
	{
		// now you can get the the top ID of this page
		// wp is putting the ids DESC, thats why the top level ID is the last one
		$ancestors = end($post->ancestors);
		$children = wp_list_pages("title_li=&child_of=".$ancestors."&echo=0");
		// you will always get the whole subpages list
	}
}

if ($children) { ?>
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