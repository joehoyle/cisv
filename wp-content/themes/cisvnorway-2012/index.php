<?php get_header(); ?>
			
			<!-- Hoved-wrapper -->
			<div id="hoved-wrapper" class="clearfix">
				
				<div id="slider-felt">
					<div class="hovedsak">
						<div class="post-hovedsak">
							<?php if(dynamic_sidebar('sidekolonne12') ) : else : ?>
							<?php endif; ?>
						</div>
					</div>
					<div id="start" class="front">
						<div class="logginn">
							<p>
							<?php if(dynamic_sidebar('sidekolonne8a') ) : else : ?>
								Logg inn p&aring;
								<a href="http://cisv.hypersys.no/mypage/">mine sider</a>
								&mdash; eller &mdash;
								<a href="http://cisv.no/cisv-norge/bli-medlem/">bli medlem!</a>
							<?php endif; ?>
							</p>
						</div>
						<div class="uthevet">
							<p><?php if(dynamic_sidebar('sidekolonne8b') ) : else : ?>
								Sjekk v&aring;re spennende
								<a href="<?php bloginfo( 'url' ) ?>/aktiviteter/">aktiviteter</a>
								for alle aldre!
							<?php endif; ?>
							</p>
						</div>
					</div>
				</div>

				
				<div class="hovedfelt-venstre">
					<div class="nyhetssaker front">
						<!-- Nyhetssaker start -->
		
						
						
						<!-- Nyhetssaker fra CISV Norge start -->
						<div class="nyhetssak">
							<?php if(dynamic_sidebar('sidekolonne11') ) : else : ?>
								<h3><span>CISV Norge</span></h3>
						<?php while ( have_posts() ) : the_post() ?>
							<div id="post-<?php the_ID(); ?>" class="post-forside">				
								<h2 class="innlegg-tittel"><a href="<?php the_permalink(); ?>" title="<?php printf( __('Permalink til %s', 'cisv'), the_title_attribute('echo=0') ); ?>" rel="bookmark"><?php the_title(); ?></a></h2>
								<div class="innlegg-featured-image"><a href="<?php the_permalink(); ?>" title="<?php printf( __('Permalink til %s', 'cisv'), the_title_attribute('echo=0') ); ?>" rel="bookmark">
								<?php 
								if ( has_post_thumbnail() ) { // check if the post has a Post Thumbnail assigned to it.
								  the_post_thumbnail( array(220,220) );
								} 
								?>
								</a></div>
								<div class="innlegg-innhold">
									<?php the_excerpt (); ?>	
									<p class="forside-les-mer"><a href="<?php the_permalink(); ?>" title="<?php printf( __('Les mer av %s', 'cisv'), the_title_attribute('echo=0') ); ?>" class="more-link" rel="bookmark">Les mer <span class="meta-nav">&raquo;</span></a></p>
								</div><!-- .innlegg-innhold -->
							</div>
						<?php endwhile; ?>
						
						<?php /* Bottom post navigation */ ?>
						<?php if(function_exists('wp_page_numbers')) { wp_page_numbers(); } ?>
							<?php endif; ?>
								
						</div> <!-- Nyhetssaker fra CISV Norge slutt -->	
						
						<!-- Nyhetssaker fra prosjektblogger start -->
						<div class="nyhetssak">
							<?php if(dynamic_sidebar('sidekolonne9') ) : else : ?>
								<h3><span>Prosjektblogger</span></h3>
								Ingen innlegg funnet.
							<?php endif; ?>
								
						</div> <!-- Nyhetssaker fra prosjektblogger slutt -->	
						
						<!-- Nyhetssaker fra fylkeslag start -->
						<div class="nyhetssak siste">
							<?php if(dynamic_sidebar('sidekolonne10') ) : else : ?>
								<h3><span>Fylkeslag</span></h3>
								Ingen innlegg funnet.
							<?php endif; ?>
						</div> <!-- Nyhetssaker fra fylkeslag slutt -->						
						
						
						</div>
				</div>
							
				<?php get_sidebar(); ?>
			
			</div>
				
		<?php get_footer(); ?>