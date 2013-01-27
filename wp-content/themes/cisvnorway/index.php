<?php get_header(); ?>
			
			<!-- Hoved-wrapper -->
			<div id="hoved-wrapper">
				<div class="hovedfelt-venstre">
					<div class="hovedsak">
						<?php if ( dynamic_sidebar('slider_on_frontpage') ) : ?>
							<div id="post-hovedsak-slider">
								<?php dynamic_sidebar('slider_on_frontpage'); ?>
							</div><!-- #slider-in-top -->
						<?php endif; ?>
						<div class="post-hovedsak">
						<?php if ( function_exists( 'get_smooth_slider' ) ) {
     get_smooth_slider(); } ?>
						<img src="http://cisv.no/files/2012/09/aarsmøte.jpg" />
						</div>
					</div>
					<div class="nyhetssaker">
					<!-- Nyhetssak -->
						<div class="nyhetssak">
						<?php while ( have_posts() ) : the_post() ?>
							<div id="post-<?php the_ID(); ?>" class="post-forside">				
								<h2 class="innlegg-tittel"><a href="<?php the_permalink(); ?>" title="<?php printf( __('Permalink til %s', 'cisv'), the_title_attribute('echo=0') ); ?>" rel="bookmark"><?php the_title(); ?></a></h2>
								<div class="innlegg-featured-image"><a href="<?php the_permalink(); ?>" title="<?php printf( __('Permalink til %s', 'cisv'), the_title_attribute('echo=0') ); ?>" rel="bookmark">
								<?php 
								if ( has_post_thumbnail() ) { // check if the post has a Post Thumbnail assigned to it.
								  the_post_thumbnail( array(420,420) );
								} 
								?>
								</a></div>
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
					<div id="smal-kollonne">
						<?php if(dynamic_sidebar('sidekolonne4') ) : else : ?>
						<div class="blogg-wrapper"><a class="pony-ikon-link" href="/pony-express/">G&aring; til bloggen her!</a>
							<p>Blogg om dine opplevelser og meninger fra aktiviteter i CISV med alle vennene dine!</p>
							<p><a href="/pony-express/">G&aring; til bloggen her!</a></p>
						</div>
						<?php endif; ?>
						<?php if(dynamic_sidebar('sidekolonne5') ) : else : ?>
						<?php endif; ?>
						
						<?php if(dynamic_sidebar('sidekolonne6') ) : else : ?>
 						<?php endif; ?>
 						
						<?php if(dynamic_sidebar('sidekolonne7') ) : else : ?>
 						<?php endif; ?>
					</div>
				</div>
				<div class="velkomsttekst">
					<h2>Velkommen til CISV Norge!</h2>
					<p>CISV er en religi&oslash;st og politisk uavhengig barne- og ungdomsorganisasjon som arbeider for fred ved &aring; skape st&oslash;rre forst&aring;else mellom mennesker fra ulike kulturer og nasjoner.</p>
				</div>
					
				<?php get_sidebar(); ?>
			
			</div>
				
		<?php get_footer(); ?>