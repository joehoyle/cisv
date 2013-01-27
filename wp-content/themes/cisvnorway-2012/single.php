		<?php get_header(); ?>

			<!-- Hoved-wrapper -->
			<div id="hoved-wrapper">
				<div class="hovedfelt-venstre">
					<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
					<div class="custom_field_image">
						
					</div>

					<div id="post-<?php the_ID(); ?>" <?php post_class('full-bredde'); ?>>

						<h1 class="innlegg-tittel"><?php the_title(); ?></h1>
						<?php the_content(); ?>
						<?php wp_link_pages('before=<div class="page-link">' . __( 'Sider:', 'cisv' ) . '&after=</div>') ?>
					</div>
					<div id="post-meta">
						<p>Publisert <?php the_date() ?>, <?php the_time() ?> &middot; Kategori: <?php the_category(', ') ?></p>
						<p><?php the_tags( 'Merker: ', ', ', ''); ?></p>					
					</div>
					<div id="nav-below" class="navigation">
						<div class="nav-previous"><?php previous_post_link( '%link', '<span class="meta-nav">&laquo;</span> %title' ) ?></div>
						<div class="nav-next"><?php next_post_link( '%link', '%title <span class="meta-nav">&raquo;</span>' ) ?></div>
					</div><!-- #nav-below -->					
					<?php comments_template('', true); ?>
					<?php endwhile; else: ?>
						<p>Beklager, ingen innlegg funnet.</p>
					<?php endif; ?>
				</div>
				
				<?php get_sidebar(); ?>	
		
			</div>
		
		<?php get_footer(); ?>