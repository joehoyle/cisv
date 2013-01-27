<?php
/*
Template Name: Kalender
*/
?>

		<?php get_header(); ?>

			<!-- Hoved-wrapper -->
			<div id="hoved-wrapper">
				<div class="hovedfelt-venstre">
					<?php the_post(); ?>
 					<div id="post-<?php the_ID(); ?>" class="post full-bredde">
 						<h1 class="innlegg-tittel"><?php the_title(); ?></h1>
						<div class="innlegg-innhold">
							<?php the_content(); ?>
							<?php wp_link_pages('before=<div class="page-link">' . __( 'Sider:', 'cisv' ) . '&after=</div>') ?>										</div><!-- .innlegg-innhold -->
					</div><!-- #post-<?php the_ID(); ?> -->	
				
				</div>
				
				<?php get_sidebar(); ?>	
		
			</div>
		
		<?php get_footer(); ?>