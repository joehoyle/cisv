<?php
/*
Template Name: Nyhetsside
*/
?>

		<?php get_header(); ?>

			<!-- Hoved-wrapper -->
			<div id="hoved-wrapper">
				<div class="hovedfelt-venstre">
					<?php the_post(); ?>
					<div class="custom_field_image">
					</div>
					
 					<div id="post-<?php the_ID(); ?>" class="post full-bredde">
 						<h1 class="innlegg-tittel"><?php the_title(); ?></h1>
						<div class="innlegg-innhold">
							<?php the_content(); ?>
							<?php wp_link_pages('before=<div class="page-link">' . __( 'Sider:', 'cisv' ) . '&after=</div>') ?>
						</div><!-- .innlegg-innhold -->
					</div><!-- #post-<?php the_ID(); ?> -->	
					
					<?php //query_posts('paged='.$paged);
					$temp = $wp_query;
					$wp_query= null;
					   $wp_query = new WP_Query();
					   $wp_query->query('showposts=10'.'&paged='.$paged);
					?>
					
					<div class="nyhetssaker full-bredde">
					<!-- Nyhetssak -->
						<div class="nyhetssak">
						<?php while ($wp_query->have_posts()) : $wp_query->the_post(); ?>
					    	<div id="post-<?php the_ID(); ?>" class="post-forside">	
								<h2 class="innlegg-tittel"><a href="<?php the_permalink(); ?>" title="<?php printf( __('Permalink til %s', 'cisv'), the_title_attribute('echo=0') ); ?>" rel="bookmark"><?php the_title(); ?></a></h2>
					    		<div class="innlegg-innhold">	
									<?php the_excerpt (''); ?>
								</div><!-- .innlegg-innhold -->
								<p class="dato"><?php the_time( get_option( 'date_format' ) ); ?> &middot; <a href="<?php the_permalink(); ?>" title="<?php printf( __('Permalink til %s', 'cisv'), the_title_attribute('echo=0') ); ?>" rel="bookmark">Les mer</a></p>

							</div>

						<?php endwhile; ?>
						<?php if(function_exists('wp_page_numbers')) { wp_page_numbers(); } ?>
						<?php $wp_query = null; $wp_query = $temp;?>
						</div>
					</div>
				</div>
			<?php get_sidebar(); ?>	
			</div>
		<?php get_footer(); ?>