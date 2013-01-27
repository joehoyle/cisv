<?php
/*
Template Name: Framsidetest
*/
?>
<?php get_header(); ?>
			
			<!-- Hoved-wrapper -->
			<div id="hoved-wrapper" class="clearfix">
				
				<div id="slider-felt">
					<div class="hovedsak">
						<div class="post-hovedsak">
							<img src="<?php header_image(); ?>" height="<?php echo get_custom_header()->height; ?>" width="<?php echo get_custom_header()->width; ?>" alt="" />

						</div>
					</div>
					<div id="start" class="front">
						<div class="logginn">Logg inn p&aring;
						<a href="http://cisv.hypersys.no/mypage/">mine sider</a>
						&mdash; eller &mdash;
						<a href="http://cisv.no/cisv-norge/bli-medlem/">bli medlem!</a>
						</div>
						<div class="uthevet">
							<?php if(dynamic_sidebar('sidekolonne8') ) : else : ?>
							Sjekk v&aring;re spennende
							<a href="<?php bloginfo( 'url' ) ?>/aktiviteter/">aktiviteter</a>
							for alle aldre!
						<?php endif; ?>
						</div>
					</div>
				</div>

				
				<div class="hovedfelt-venstre">
					<div class="nyhetssaker front">
					<!-- Nyhetssaker start -->
						<div class="nyhetssak">
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
									<p class="forside-les-mer"><a href="<?php the_permalink(); ?>" title="<?php printf( __('Permalink til %s', 'cisv'), the_title_attribute('echo=0') ); ?>" class="more-link" rel="bookmark">Les mer <span class="meta-nav">&raquo;</span></a></p>
								</div><!-- .innlegg-innhold -->
							</div>
						<?php endwhile; ?>
						</div> <!-- Nyhetssaker slutt -->
						
							<!-- Nyhetssaker fra prosjektblogger start -->
						<div class="nyhetssak">
							<h3><span>Prosjektblogger</span></h3>
							<?php if(dynamic_sidebar('sidekolonne9') ) : else : ?>
								Ingen innlegg funnet.
							<?php endif; ?>
						</div> <!-- Nyhetssaker fra prosjektblogger slutt -->	
						
						<!-- Nyhetssaker fra fylkeslag start -->
						<div class="nyhetssak siste">
							<h3><span>Fylkeslag</span></h3>
						</div> <!-- Nyhetssaker fra fylkeslag slutt -->						
						
						
						</div>
				</div>
							
				<?php get_sidebar(); ?>
			
			</div>
				
		<?php get_footer(); ?>