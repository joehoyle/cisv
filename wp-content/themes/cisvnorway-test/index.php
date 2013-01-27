<?php get_header(); ?>
			
			<!-- Hoved-wrapper -->
			<div id="hoved-wrapper">
				<div class="hovedfelt-venstre">
					<div class="hovedsak">
						<div class="post-hovedsak">
						<?php if ( function_exists( 'get_smooth_slider' ) ) {
     get_smooth_slider(); } ?>
						</div>
					</div>
					<div class="nyhetssaker">
					<!-- Nyhetssak -->
						<div class="nyhetssak">
						<?php while ( have_posts() ) : the_post() ?>
							<div id="post-<?php the_ID(); ?>" class="post-forside">				
								<h2 class="innlegg-tittel"><a href="<?php the_permalink(); ?>" title="<?php printf( __('Permalink til %s', 'cisv'), the_title_attribute('echo=0') ); ?>" rel="bookmark"><?php the_title(); ?></a></h2>

								<div class="innlegg-innhold">
									<?php 
									if ( has_post_thumbnail() ) { // check if the post has a Post Thumbnail assigned to it.
									  the_post_thumbnail();
									} 
									?>
<?php the_content( __( 'Les mer <span class="meta-nav">&raquo;</span>', 'your-theme' )  ); ?>
<?php wp_link_pages('before=<div class="page-link">' . __( 'Sider:', 'cisv' ) . '&after=</div>') ?>
								</div><!-- .innlegg-innhold -->
							</div>
						<?php endwhile; ?>
						</div>
						<?php /* Bottom post navigation */ ?>
						<?php if(function_exists('wp_page_numbers')) { wp_page_numbers(); } ?>
					</div>
					<div id="smal-kollonne">
						<!--<?php // if ( function_exists('dynamic_sidebar') && dynamic_sidebar(4) ) : else : ?>-->
						<?php if(dynamic_sidebar('sidekolonne6') ) : else : ?>
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
						<div class="feed-wrapper">
							<p>Hold deg oppdatert p&aring; hva som skjer i CISV:</p>
							<ul>
								<li><a href="http://www.facebook.com/organisasjonskonsulenten" class="ikon-facebook">CISV p&aring; Facebook</a></li>
								<li><a href="<?php bloginfo('rss2_url'); ?>" class="ikon-rss">Nyheter via RSS</a></li>
							</ul>
						</div>
					</div>
				</div>
				<div class="velkomsttekst">
					<h2>Velkommen til CISV Norge!</h2>
					<p>CISV er en religi&oslash;st og politisk uavhengig barne- og ungdomsorganisasjon som arbeider for fred ved &aring; skape st&oslash;rre forst&aring;else mellom mennesker fra ulike kulturer og nasjoner.</p>
				</div>
					
				<?php get_sidebar(); ?>
			
			</div>
				
		<?php get_footer(); ?>