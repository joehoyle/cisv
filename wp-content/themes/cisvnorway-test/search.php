		<?php get_header(); ?>

			<!-- Hoved-wrapper -->
			<div id="hoved-wrapper">
				<div class="hovedfelt-venstre">
					<div class="custom_field_image">
						<img class="alignnone size-full" src="<?php bloginfo('stylesheet_directory'); ?>/images/sokeresultat-topp.jpg" alt="Eco green" />
					</div>
						<?php
$wp_query->query_vars["posts_per_page"] = 20;
$wp_query->get_posts();
?>				
					<?php if ( have_posts() ) : ?>
					

					<div class="post full-bredde">
						<h1 class="page-title"><?php _e( 'S&oslash;keresultat: ', 'cisv' ); ?><span><?php the_search_query(); ?></span></h1>
						<p>S&oslash;ket p&aring; <?php /* Search Count */ $allsearch = &new WP_Query("s=$s&showposts=-1"); $key = wp_specialchars($s, 1); $count = $allsearch->post_count; _e(''); _e('<strong>'); echo $key; _e('</strong>'); _e(' ga '); echo $count . ' '; _e('funn:'); wp_reset_query(); ?></p>
										
 					</div>
				
					<?php while ( have_posts() ) : the_post() ?>
					<div class="sokeresultat"><div id="post-<?php the_ID(); ?>">
						<h2 class="entry-title"><a href="<?php the_permalink(); ?>" title="<?php printf( __('Permalink til %s', 'your-theme'), the_title_attribute('echo=0') ); ?>" rel="bookmark"><?php the_title(); ?></a></h2>
 						<?php if ( $post->post_type == 'post' ) { ?>	
						<?php } ?>

						<div class="entry-summary">	
							<?php the_excerpt( __('')  ); ?>
							<?php wp_link_pages('before=<div class="page-link">' . __( 'Pages:', 'your-theme' ) . '&after=</div>') ?>
						</div><!-- .entry-summary -->
						
						
 
						<?php if ( $post->post_type == 'post' ) { ?>									
						<div class="entry-utility">
							<span class="cat-links"><span class="entry-utility-prep entry-utility-prep-cat-links"><?php _e( 'Publisert i ', 'your-theme' ); ?></span><?php echo get_the_category_list(', '); ?></span>
							<span class="meta-sep"> &middot; </span>
							<?php the_tags( '<span class="tag-links"><span class="entry-utility-prep entry-utility-prep-tag-links">' . __('Tagged ', 'your-theme' ) . '</span>', ", ", "</span>\n\t\t\t\t\t\t<span class=\"meta-sep\">|</span>\n" ) ?>
							<span class="comments-link"><?php comments_popup_link( __( 'Legg igjen en kommentar', 'cisv' ), __( 'En kommentar', 'cisv' ), __( '% kommentarer', 'cisv' ) ) ?></span>
							<?php edit_post_link( __( 'Rediger', 'cisv' ), "<span class=\"meta-sep\">&middot;</span>\n\t\t\t\t\t\t<span class=\"edit-link\">", "</span>\n\t\t\t\t\t\n" ) ?>
						</div><!-- #entry-utility -->	
						<?php } ?>					

					</div><!-- #post-<?php the_ID(); ?> --></div>
 
					<?php endwhile; ?>
				<?php /* Bottom post navigation */ ?>
						<?php if(function_exists('wp_page_numbers')) { wp_page_numbers(); } ?>		
 
					<?php else : ?>
 
					<div id="post-0" class="post no-results not-found full-bredde">
						<h1 class="entry-title"><?php _e( 'Ingenting funnet', 'cisv' ) ?></h1>
						<div class="entry-content">
							<p><?php _e( 'Beklager. Vi kunne ikke finne det du var ute etter. Kanskje du kan pr&oslash;ve et nytt s&oslash;k:', 'cisv' ); ?></p>
						<div id="sok">
						<form id="searchform" method="get" action="<?php bloginfo('home'); ?>">
        					<p><input type="text" name="s" id="searchbox" value=""/>
        					<input name="S&oslash;k" type="image" value="<?php esc_attr_e('S&oslash;k'); ?>" src="<?php bloginfo('stylesheet_directory'); ?>/images/ikon-sok.png" id="searchbutton"/></p>
						</form>
					</div>						
						</div><!-- .entry-content -->
					</div>
 
					<?php endif; ?>
					
				</div>
				
				<?php get_sidebar(); ?>	
		
			</div>
		
		<?php get_footer(); ?>