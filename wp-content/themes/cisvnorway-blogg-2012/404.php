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
				<p><?php _e( 'Beklager. Vi kunne ikke finne det du var ute etter. Kanskje du kan pr&oslash;ve et s&oslash;k:', 'cisv' ); ?></p>
				<?php get_search_form(); ?>
			</div><!-- .entry-content -->
		</div><!-- #post-0 -->
	</div><!-- #hovedfelt-venstre -->

	<?php get_sidebar(); ?>	

</div><!-- #hoved-wrapper -->

<?php get_footer(); ?>