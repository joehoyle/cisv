<?php get_header(); ?>
			
				<div class="hovedfelt-venstre">
					<div class="nyhetssaker lokallag">
					<!-- Nyhetssak -->
						<div class="nyhetssak">
						<?php while ( have_posts() ) : the_post() ?>
							<div id="post-<?php the_ID(); ?>" <?php post_class('post-forside clearfix'); ?> >	
								<a href="<?php the_permalink(); ?>" title="<?php printf( __('Permalink til %s', 'cisv'), the_title_attribute('echo=0') ); ?>" rel="bookmark"><?php 
									if(has_post_thumbnail()) {
										the_post_thumbnail('nyhetssaker-thumb');
										} else {
											echo ''; }?></a>
										
								<p class="dato"><?php the_time( get_option( 'date_format' ) ); ?></p>
								<h2 class="innlegg-tittel"><a href="<?php the_permalink(); ?>" title="<?php printf( __('Permalink til %s', 'cisv'), the_title_attribute('echo=0') ); ?>" rel="bookmark"><?php the_title(); ?></a></h2>

								<div class="innlegg-innhold">	
									<?php the_excerpt (); ?>	
									<p class="forside-les-mer"><a href="<?php the_permalink(); ?>" title="<?php printf( __('Permalink til %s', 'cisv'), the_title_attribute('echo=0') ); ?>" class="more-link" rel="bookmark">Les mer <span class="meta-nav">&raquo;</span></a></p>
								</div><!-- .innlegg-innhold -->
							</div>
						<?php endwhile; ?>
						</div>
						<?php /* Bottom post navigation */ ?>
						<?php if(function_exists('wp_page_numbers')) { wp_page_numbers(); } ?>
					</div>

				</div>
				
				<?php get_sidebar(); ?>
			
			</div>
				
		<?php get_footer(); ?>
		
		