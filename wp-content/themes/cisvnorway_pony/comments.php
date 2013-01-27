<?php /* The Comments Template Ñ with, er, comments! */ ?>			
			<div id="comments">
<?php /* Run some checks for bots and password protected posts */ ?>	
<?php
	$req = get_option('require_name_email'); // Checks if fields are required.
	if ( 'comments.php' == basename($_SERVER['SCRIPT_FILENAME']) )
		die ( 'Please do not load this page directly. Thanks!' );
	if ( ! empty($post->post_password) ) :
		if ( $_COOKIE['wp-postpass_' . COOKIEHASH] != $post->post_password ) :
?>
				<div class="nopassword"><?php _e('Dette innlegget er passordbeskytta. Skriv inn passord for &aring; vise kommentarer.', 'cisv') ?></div>
			</div><!-- .comments -->
<?php
		return;
	endif;
endif;
?>
 
<?php /* See IF there are comments and do the comments stuff! */ ?>						
<?php if ( have_comments() ) : ?>
 
<?php /* Count the number of comments and trackbacks (or pings) */
$ping_count = $comment_count = 0;
foreach ( $comments as $comment )
	get_comment_type() == "comment" ? ++$comment_count : ++$ping_count;
?>
 
<?php /* IF there are comments, show the comments */ ?>
<?php if ( ! empty($comments_by_type['comment']) ) : ?>
 
				<div id="comments-list" class="comments">
					<h3><?php printf($comment_count > 1 ? __('<span>%d</span> kommentarer', 'cisv') : __('<span>En</span> kommentar', 'cisv'), $comment_count) ?></h3>
 
<?php /* If there are enough comments, build the comment navigation  */ ?>					
<?php $total_pages = get_comment_pages_count(); if ( $total_pages > 1 ) : ?>
					<div id="comments-nav-above" class="comments-navigation">
								<div class="paginated-comments-links"><?php paginate_comments_links(); ?></div>
					</div><!-- #comments-nav-above -->					
<?php endif; ?>					
 
<?php /* An ordered list of our custom comments callback, custom_comments(), in functions.php   */ ?>				
					<ol>
<?php wp_list_comments('type=comment&callback=custom_comments'); ?>
					</ol>
 
<?php /* If there are enough comments, build the comment navigation */ ?>
<?php $total_pages = get_comment_pages_count(); if ( $total_pages > 1 ) : ?>					
	  			<div id="comments-nav-below" class="comments-navigation">
						<div class="paginated-comments-links"><?php paginate_comments_links(); ?></div>
	        </div><!-- #comments-nav-below -->
<?php endif; ?>					
 
				</div><!-- #comments-list .comments -->

<?php endif; /* if ( $comment_count ) */ ?>
 
<?php /* If there are trackbacks(pings), show the trackbacks  */ ?>
<?php if ( ! empty($comments_by_type['pings']) ) : ?>
 
				<div id="trackbacks-list" class="comments">
					<h3><?php printf($ping_count > 1 ? __('<span>%d</span> tilbakepinger', 'cisv') : __('<span>En</span> tilbakepinger', 'cisv'), $ping_count) ?></h3>
 
<?php /* An ordered list of our custom trackbacks callback, custom_pings(), in functions.php   */ ?>					
					<ol>
<?php wp_list_comments('type=pings&callback=custom_pings'); ?>
					</ol>				
 
				</div><!-- #trackbacks-list .comments -->			

 
<?php endif /* if ( $ping_count ) */ ?>
<?php endif /* if ( $comments ) */ ?>
 
<?php /* If comments are open, build the respond form */ ?>
<?php if ( 'open' == $post->comment_status ) : ?>
				<div id="respond">
    				<h3><?php comment_form_title( __('Legg igjen en kommentar', 'cisv'), __('Kommenter %s', 'cisv') ); ?></h3>
 
    				<div id="cancel-comment-reply"><?php cancel_comment_reply_link() ?></div>
 
<?php if ( get_option('comment_registration') && !$user_ID ) : ?>
					<p id="login-req"><?php printf(__('Du m&aring; v&aelig;re <a href="%s" title="Log in">innlogga</a> for &aring; kommnentere', 'cisv'),
					get_option('siteurl') . '/wp-login.php?redirect_to=' . get_permalink() ) ?></p>
 
<?php else : ?>
					<div class="formcontainer">	
 
 
						<form id="commentform" action="<?php echo get_option('siteurl'); ?>/wp-comments-post.php" method="post">
 
<?php if ( $user_ID ) : ?>
							<p id="login"><?php printf(__('<span class="loggedin">Logget inn som <a href="%1$s" title="Logget inn som %2$s">%2$s</a>.</span> <span class="logout"><a href="%3$s" title="Logg ut av denne kontoen">Logge ut?</a></span>', 'your-theme'),
								get_option('siteurl') . '/wp-admin/profile.php',
								wp_specialchars($user_identity, true),
								wp_logout_url(get_permalink()) ) ?></p>
 
<?php else : ?>
 
							<p id="comment-notes"><?php _e('E-postadressa di blir <em>aldri</em> publisert eller delt.', 'cisv') ?> <?php if ($req) _e('Obligatoriske felt er merka <span class="required">*</span>', 'cisv') ?></p>
 
              <div id="form-section-author" class="form-section">
								<div class="form-label"><label for="author"><?php _e('Navn', 'cisv') ?> <?php if ($req) _e('<span class="required">*</span>', 'your-theme') ?></label></div>
								<div class="form-input"><input id="author" name="author" type="text" value="<?php echo $comment_author ?>" size="30" maxlength="20" tabindex="3" /></div>
              </div><!-- #form-section-author .form-section -->

              <div id="form-section-email" class="form-section">
								<div class="form-label"><label for="email"><?php _e('E-post', 'cisv') ?> <?php if ($req) _e('<span class="required">*</span>', 'your-theme') ?></label></div>
								<div class="form-input"><input id="email" name="email" type="text" value="<?php echo $comment_author_email ?>" size="30" maxlength="50" tabindex="4" /></div>
              </div><!-- #form-section-email .form-section -->

              <div id="form-section-url" class="form-section">
								<div class="form-label"><label for="url"><?php _e('Nettside', 'cisv') ?></label></div>
								<div class="form-input"><input id="url" name="url" type="text" value="<?php echo $comment_author_url ?>" size="30" maxlength="50" tabindex="5" /></div>
              </div><!-- #form-section-url .form-section -->

<?php endif /* if ( $user_ID ) */ ?>
 
              <div id="form-section-comment" class="form-section">
								<div class="form-label"><label for="comment"><?php _e('Din kommentar', 'cisv') ?></label></div>
								<div class="form-textarea"><textarea id="comment" name="comment" cols="45" rows="8" tabindex="6"></textarea></div>
              </div><!-- #form-section-comment .form-section -->
              
<?php do_action('comment_form', $post->ID); ?>
 
							<div class="form-submit"><input id="submit" name="submit" type="submit" value="<?php _e('Legg igjen kommentar', 'cisv') ?>" tabindex="7" /><input type="hidden" name="comment_post_ID" value="<?php echo $id; ?>" /></div>
 
<?php comment_id_fields(); ?>  
 
<?php /* Just É end everything. We're done here. Close it up. */ ?>  
 
						</form><!-- #commentform -->										
					</div><!-- .formcontainer -->
<?php endif /* if ( get_option('comment_registration') && !$user_ID ) */ ?>
				</div><!-- #respond -->
<?php endif /* if ( 'open' == $post->comment_status ) */ ?>
			</div><!-- #comments -->