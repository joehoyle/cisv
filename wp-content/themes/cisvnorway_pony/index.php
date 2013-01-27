<?php get_header(); ?>
			
			<!-- Hoved-wrapper -->
			<div id="hoved-wrapper">
				<div id="velkomsttekst-pony">
					<?php switch_to_blog(1); ?>
						<a href="/pony-express/"><img src="<?php bloginfo('template_url'); ?>/images/logo-pony-positiv.png" /></a>
					<?php restore_current_blog(); ?>
					<h2>Velkommen til <?php bloginfo( 'name' ) ?>!</h2>
					<p>Blogg om dine opplevelser og meninger fra aktiviteter i CISV med alle vennene dine!</p>		
					</div>
				<div class="hovedfelt-venstre">
					<div class="nyhetssaker">
					<!-- Nyhetssak -->
						<div class="nyhetssak">
						<?php while ( have_posts() ) : the_post() ?>
							<div id="post-<?php the_ID(); ?>" class="post-forside">				
								<p class="dato"><?php the_time( get_option( 'date_format' ) ); ?></p>
								<h2 class="innlegg-tittel"><a href="<?php the_permalink(); ?>" title="<?php printf( __('Permalink til %s', 'cisv'), the_title_attribute('echo=0') ); ?>" rel="bookmark"><?php the_title(); ?></a></h2>

								<div class="innlegg-innhold">	
<?php the_content( __( 'Les mer <span class="meta-nav">&raquo;</span>', 'your-theme' )  ); ?>
<?php wp_link_pages('before=<div class="page-link">' . __( 'Sider:', 'cisv' ) . '&after=</div>') ?>
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