		<?php get_header(); ?>

			<!-- Hoved-wrapper -->
			<div id="hoved-wrapper">
				<div class="hovedfelt-venstre">
					<div class="breadcrumb-undersider">
						<?php if ( function_exists('yoast_breadcrumb') ) {
						yoast_breadcrumb('<p id="breadcrumb">','</p>');
						} ?>
					</div>
					<div id="post-0" class="post error404 not-found full-bredde">

						<h1 class="entry-title"><?php _e( 'Ikke funnet', 'cisv' ); ?></h1>
						<div class="entry-content">
							<p><?php _e( 'Beklager. Vi kunne ikke finne det du var ute etter.', 'cisv' ); ?></p>
							<p><?php if (smart404_has_suggestions()) : ?>
							Kanskje du kan prøve en av disse?<br />
							<?php smart404_suggestions(); ?><br />
							Eller kanskje et søk?
							<?php get_search_form(); ?>
							<?php endif; ?></p>
						</div><!-- .entry-content -->
					</div>
				</div>
				
				<?php get_sidebar(); ?>	
		
			</div>
		
		<?php get_footer(); ?>