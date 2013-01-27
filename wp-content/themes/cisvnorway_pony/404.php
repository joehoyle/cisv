				<div id="post-0" class="post error404 not-found">
					<h1 class="entry-title"><?php _e( 'Not Found', 'your-theme' ); ?></h1>
					<div class="entry-content">
						<p><?php _e( 'Apologies, but we were unable to find what you were looking for. Perhaps searching will help.', 'your-theme' ); ?></p>
	<?php get_search_form(); ?>
					</div><!-- .entry-content -->
				</div><!-- #post-0 -->
				
				
				
				
		<?php get_header(); ?>

			<!-- Hoved-wrapper -->
			<div id="hoved-wrapper">
				<div class="hovedfelt-venstre">
					<img class="alignnone size-full wp-image-1736" src="images/nyheter/eksempelbilde-02.png" alt="Eco green" />
					<div class="breadcrumb-undersider">
						<p>Du er her: <a href="index.html">Startside</a> / <a href="engasjer-deg.html">Engasjer deg</a></p>
					</div>
					<div id="venstremeny-engasjer-deg">
						<ul>
							<li class="current_page_item"><a href="engasjer-deg.html">Engasjer deg</a></li>
							<li><a href="barn-unge.html">Barn &amp; unge</a></li>
							<li><a href="">Leder</a></li>
							<li><a href="">Foreldre</a></li>
						</ul>
					</div>
					<div id="post-0" class="post error404 not-found">

						<h1 class="entry-title"><?php _e( 'Ikke funnet', 'cisv' ); ?></h1>
						<div class="entry-content">
							<p><?php _e( 'Beklager. Vi kunne ikke finne det du var ute etter. Kanskje du kan pr&oslash;ve et s&oslash;k :', 'cisv' ); ?></p>
							<?php get_search_form(); ?>
						</div><!-- .entry-content -->
					</div>
				</div>
				
				<?php get_sidebar(); ?>	
		
			</div>
		
		<?php get_footer(); ?>