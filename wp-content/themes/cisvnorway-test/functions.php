<?php

// MAKE SIDEBARS USABLE FOR WIDGETS
function cisvnorge_widgets_init() {
	// Area 1, toppen i høyre sidebar.
	register_sidebar( array(
		'name' => __( 'Grønn stor sidekolonne (1)', 'cisvnorge' ),
		'id' => 'sidekolonne1',
		'description' => __( 'Kalenderen går her', 'cisvnorge_widgets_init' ),
		'before_widget'=>'<div class="widget-1">',
		'after_widget'=>'</div>',
		'before_title' => '<h2>',
		'before_title'=>'<h2>',
	) );
	// Area 2, midt i høyre sidebar.
	register_sidebar( array(
		'name' => __( 'Blå stor sidekolonne (2)', 'cisvnorge' ),
		'id' => 'sidekolonne2',
		'description' => __( 'Twitter går her', 'cisvnorge_widgets_init' ),
		'before_widget'=>'<div class="widget-1">',
		'after_widget'=>'</div>',
		'before_title' => '<h2>',
		'before_title'=>'<h2>',
	) );
	// Area 3, bunn i høyre sidebar.
	register_sidebar( array(
		'name' => __( 'Grå stor sidekolonne (3)', 'cisvnorge' ),
		'id' => 'sidekolonne3',
		'description' => __( 'Bunnen helt til høyre', 'cisvnorge_widgets_init' ),
		'before_widget'=>'<div class="widget-1">',
		'after_widget'=>'</div>',
		'before_title' => '<h2>',
		'before_title'=>'<h2>',
	) );
	// Area 4, topp i smal sidebar.
	register_sidebar( array(
		'name' => __( 'Første smale sidekolonne', 'cisvnorge' ),
		'id' => 'sidekolonne4',
		'description' => __( 'Toppen i smal kolonne', 'cisvnorge_widgets_init' ),
		'before_widget'=>'<div class="feed-wrapper">',
		'after_widget'=>'</div>',
		'before_title' => '<h2>',
		'before_title'=>'<h2>',
	) );
	// Area 5, nummer to i smal sidebar.
	register_sidebar( array(
		'name' => __( 'Andre smale sidekolonne', 'cisvnorge' ),
		'id' => 'sidekolonne5',
		'description' => __( 'Nummer to i smal kolonne', 'cisvnorge_widgets_init' ),
		'before_widget'=>'<div class="feed-wrapper">',
		'after_widget'=>'</div>',
		'before_title' => '<h2>',
		'before_title'=>'<h2>',
	) );
	// Area 6, nummer 3 i smal sidebar.
	register_sidebar( array(
		'name' => __( 'Tredje smale sidekolonne', 'cisvnorge' ),
		'id' => 'sidekolonne6',
		'description' => __( 'Nummer tre i smal sidekolonne', 'cisvnorge_widgets_init' ),
		'before_widget'=>'<div class="feed-wrapper">',
		'after_widget'=>'</div>',
		'before_title' => '<h2>',
		'before_title'=>'<h2>',
	) );
	// Area 7, nummer 4 i smal sidebar.
	register_sidebar( array(
		'name' => __( 'Fjerde smale sidekolonne', 'cisvnorge' ),
		'id' => 'sidekolonne7',
		'description' => __( 'Nummer fire i smal kolonne', 'cisvnorge_widgets_init' ),
		'before_widget'=>'<div class="feed-wrapper">',
		'after_widget'=>'</div>',
		'before_title' => '<h2>',
		'before_title'=>'<h2>',
	) );
}

add_action( 'widgets_init', 'cisvnorge_widgets_init' );


// Make theme available for translation
// Translations can be filed in the /languages/ directory
load_theme_textdomain( 'your-theme', TEMPLATEPATH . '/languages' );
 
$locale = get_locale();
$locale_file = TEMPLATEPATH . "/languages/$locale.php";
if ( is_readable($locale_file) )
	require_once($locale_file);
 
// Get the page number
function get_page_number() {
    if ( get_query_var('paged') ) {
        print ' | ' . __( 'Page ' , 'cisv') . get_query_var('paged');
    }
} // end get_page_number

// Custom callback to list comments in the your-theme style
function custom_comments($comment, $args, $depth) {
  $GLOBALS['comment'] = $comment;
	$GLOBALS['comment_depth'] = $depth;
  ?>
  	<li id="comment-<?php comment_ID() ?>" <?php comment_class() ?>>
  		<div class="comment-author vcard"><?php commenter_link() ?></div>
  		<div class="comment-meta"><?php printf(__('Posted %1$s at %2$s <span class="meta-sep">|</span> <a href="%3$s" title="Permalink to this comment">Permalink</a>', 'your-theme'),
  					get_comment_date(),
  					get_comment_time(),
  					'#comment-' . get_comment_ID() );
  					edit_comment_link(__('Edit', 'your-theme'), ' <span class="meta-sep">|</span> <span class="edit-link">', '</span>'); ?></div>
  <?php if ($comment->comment_approved == '0') _e("\t\t\t\t\t<span class='unapproved'>Your comment is awaiting moderation.</span>\n", 'your-theme') ?>
          <div class="comment-content">
      		<?php comment_text() ?>
  		</div>
		<?php // echo the comment reply link
			if($args['type'] == 'all' || get_comment_type() == 'comment') :
				comment_reply_link(array_merge($args, array(
					'reply_text' => __('Reply','your-theme'), 
					'login_text' => __('Log in to reply.','your-theme'),
					'depth' => $depth,
					'before' => '<div class="comment-reply-link">', 
					'after' => '</div>'
				)));
			endif;
		?>
<?php } // end custom_comments

// Custom callback to list pings
function custom_pings($comment, $args, $depth) {
       $GLOBALS['comment'] = $comment;
        ?>
    		<li id="comment-<?php comment_ID() ?>" <?php comment_class() ?>>
    			<div class="comment-author"><?php printf(__('By %1$s on %2$s at %3$s', 'your-theme'),
    					get_comment_author_link(),
    					get_comment_date(),
    					get_comment_time() );
    					edit_comment_link(__('Edit', 'your-theme'), ' <span class="meta-sep">|</span> <span class="edit-link">', '</span>'); ?></div>
    <?php if ($comment->comment_approved == '0') _e('\t\t\t\t\t<span class="unapproved">Your trackback is awaiting moderation.</span>\n', 'your-theme') ?>
            <div class="comment-content">
    			<?php comment_text() ?>
			</div>
<?php } // end custom_pings

// Produces an avatar image with the hCard-compliant photo class
function commenter_link() {
	$commenter = get_comment_author_link();
	if ( ereg( '<a[^>]* class=[^>]+>', $commenter ) ) {
		$commenter = ereg_replace( '(<a[^>]* class=[\'"]?)', '\\1url ' , $commenter );
	} else {
		$commenter = ereg_replace( '(<a )/', '\\1class="url "' , $commenter );
	}
	$avatar_email = get_comment_author_email();
	$avatar = str_replace( "class='avatar", "class='photo avatar", get_avatar( $avatar_email, 80 ) );
	echo $avatar . ' <span class="fn n">' . $commenter . '</span>';
} // end commenter_link


if ( function_exists( 'add_theme_support' ) )
	add_theme_support( 'post-thumbnails' );


//excerpt
function new_excerpt_length($length) {
	return 8;
}
add_filter('excerpt_length', 'new_excerpt_length');

function replace_excerpt($content) {
       return str_replace('[...]',
               '[...] <a href="'. get_permalink() .'">Les mer</a>',
               $content
       );
}
add_filter('the_excerpt', 'replace_excerpt');

?>
<?php add_theme_support( 'post-thumbnails' );?>