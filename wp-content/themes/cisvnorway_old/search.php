		<?php get_header(); ?>

			<!-- Hoved-wrapper -->
			<div id="hoved-wrapper">
				<div class="hovedfelt-venstre">
					<div class="custom_field_image">
						<img class="alignnone size-full" src="<?php bloginfo('stylesheet_directory'); ?>/images/sokeresultat-topp.jpg" alt="Eco green" />
					</div>
					<div class="breadcrumb-undersider">
						<?php if ( function_exists('yoast_breadcrumb') ) {
						yoast_breadcrumb('<p id="breadcrumb">','</p>');
						} ?>
					</div>
										
					<?php if ( have_posts() ) : ?>
					<div class="post full-bredde sokeresultat">
						<h1 class="page-title"><?php _e( 'S&oslash;keresultat: ', 'cisv' ); ?><span><?php the_search_query(); ?></span></h1>
 
					<?php global $wp_query; $total_pages = $wp_query->max_num_pages; if ( $total_pages > 1 ) { ?>
						<div id="nav-above" class="navigation">
							<div class="nav-previous"><?php next_posts_link(__( '<span class="meta-nav">&laquo;</span> Older posts', 'your-theme' )) ?></div>
							<div class="nav-next"><?php previous_posts_link(__( 'Newer posts <span class="meta-nav">&raquo;</span>', 'your-theme' )) ?></div>
						</div><!-- #nav-above -->
					<?php } ?>							
 					</div>

					<?php while ( have_posts() ) : the_post() ?>
					<div id="post-<?php the_ID(); ?>" class="post full-bredde sokeresultat">
						<h2 class="entry-title"><a href="<?php the_permalink(); ?>" title="<?php printf( __('Permalink til %s', 'your-theme'), the_title_attribute('echo=0') ); ?>" rel="bookmark"><?php the_title(); ?></a></h2>
 						<?php if ( $post->post_type == 'post' ) { ?>									
						<div class="entry-meta">
							<span class="meta-prep meta-prep-author"><?php _e('Av ', 'cisv'); ?></span>
							<span class="author vcard"><a class="url fn n" href="<?php echo get_author_link( false, $authordata->ID, $authordata->user_nicename ); ?>" title="<?php printf( __( 'Vis alle innlegg av %s', 'cisv' ), $authordata->display_name ); ?>"><?php the_author(); ?></a></span>
							<span class="meta-sep"> | </span>
							<span class="meta-prep meta-prep-entry-date"><?php _e('Publisert ', 'cisv'); ?></span>
							<span class="entry-date"><?php the_time( get_option( 'date_format' ) ); ?></span>
							<?php edit_post_link( __( 'Rediger', 'cisv' ), "<span class=\"meta-sep\">&middot;</span>\n\t\t\t\t\t\t<span class=\"edit-link\">", "</span>\n\t\t\t\t\t" ) ?>
						</div><!-- .entry-meta -->
						<?php } ?>

						<div class="entry-summary">	
							<?php the_excerpt( __( 'Les mer <span class="meta-nav">&raquo;</span>', 'cisv' )  ); ?>
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

					</div><!-- #post-<?php the_ID(); ?> -->
 
					<?php endwhile; ?>
 
					<?php global $wp_query; $total_pages = $wp_query->max_num_pages; if ( $total_pages > 1 ) { ?>
					<div id="nav-below" class="navigation">
						<div class="nav-previous"><?php next_posts_link(__( '<span class="meta-nav">&laquo;</span> Older posts', 'your-theme' )) ?></div>
						<div class="nav-next"><?php previous_posts_link(__( 'Newer posts <span class="meta-nav">&raquo;</span>', 'your-theme' )) ?></div>
					</div><!-- #nav-below -->
					<?php } ?>			
 
					<?php else : ?>
 
					<div id="post-0" class="post no-results not-found full-bredde">
						<h2 class="entry-title"><?php _e( 'Nothing Found', 'your-theme' ) ?></h2>
						<div class="entry-content">
							<p><?php _e( 'Sorry, but nothing matched your search criteria. Please try again with some different keywords.', 'your-theme' ); ?></p>
						<?php get_search_form(); ?>						
						</div><!-- .entry-content -->
					</div>
 
					<?php endif; ?>
					
				</div>
				
				<?php get_sidebar(); ?>	
		
			</div>
		
		<?php get_footer(); ?>