		<?php get_header(); ?>

			<!-- Hoved-wrapper -->
			<div id="hoved-wrapper">
				<div class="hovedfelt-venstre">
					<?php if (have_posts()) : ?>

 	  <?php $post = $posts[0]; // Hack. Set $post so that the_date() works. ?>
 	  <?php /* If this is a category archive */ if (is_category()) { ?>
		<h1 class="pagetitle">Arkiv for kategorien &#8216;<?php single_cat_title(); ?>&#8217;</h1>
 	  <?php /* If this is a tag archive */ } elseif( is_tag() ) { ?>
		<h1 class="pagetitle">Innlegg merket &#8216;<?php single_tag_title(); ?>&#8217;</h1>
 	  <?php /* If this is a daily archive */ } elseif (is_day()) { ?>
		<h1 class="pagetitle">Arkiv for <?php the_time('F jS, Y'); ?></h1>
 	  <?php /* If this is a monthly archive */ } elseif (is_month()) { ?>
		<h1 class="pagetitle">Arkiv for <?php the_time('F, Y'); ?></h1>
 	  <?php /* If this is a yearly archive */ } elseif (is_year()) { ?>
		<h1 class="pagetitle">Arkiv for <?php the_time('Y'); ?></h1>
	  <?php /* If this is an author archive */ } elseif (is_author()) { ?>
		<h1 class="pagetitle">Forfatterarkiv</h1>
 	  <?php /* If this is a paged archive */ } elseif (isset($_GET['paged']) && !empty($_GET['paged'])) { ?>
		<h1 class="pagetitle">Bloggarkiv</h1>
 	  <?php } ?>
				
					
 					<div id="post-<?php the_ID(); ?>" class="post full-bredde">
 						<?php while (have_posts()) : the_post(); ?>
 						<h2 id="post-<?php the_ID(); ?>"><a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title_attribute(); ?>"><?php the_title(); ?></a></h2>
						<p class="tid">Publisert: <?php the_time('l j. F Y, H.i') ?></p>
						<div class="entry">
							<?php the_excerpt() ?>
						</div>

						<p class="kategori">Kategori: <?php the_category(', ') ?> &middot; <?php edit_post_link('Rediger', '', ' &middot; '); ?>  <?php comments_popup_link('Ingen kommentarer &#187;', 'En kommentar &#187;', '% kommentarer &#187;'); ?></p>
						<?php endwhile; ?>
						<?php else :

							if ( is_category() ) { // If this is a category archive
								printf("<h2 class='center'>Beklager, men det er ikke noen innlegg i denne kategorien enda.</h2>", single_cat_title('',false));
							} else if ( is_date() ) { // If this is a date archive
								echo("<h2>Beklager, men det er ikke noen innlegg med denne datoen.</h2>");
							} else if ( is_author() ) { // If this is a category archive
								$userdata = get_userdatabylogin(get_query_var('author_name'));
								printf("<h2 class='center'>Beklager, men det er ikke noen innlegg fra %s enda.</h2>", $userdata->display_name);
							} else {
								echo("<h2 class='center'>Ingen innlegg funnet.</h2>");
							}
							get_search_form();

						endif;
						?>
					</div><!-- #post-<?php the_ID(); ?> -->	
				</div>

				<?php get_sidebar(); ?>	
		
			</div>
		
		<?php get_footer(); ?>
		
	