<?php

/**
 * @package sunsettheme
 * =========================
 *    THEME SUPPORT OPTIONS
 * =========================
 */

$options = get_option( 'post_formats' );
$formats = array( 'aside', 'gallery', 'link', 'image', 'quote', 'status', 'video', 'audio', 'chat' );
$output = array();

foreach ( $formats as $format ) {
	$output[] = ( @ $options[ $format ] ? $format : '' );
}
if ( ! empty( $options ) ) {
	add_theme_support( 'post-formats', $output );
}

$header = get_option( 'custom_header' );
if ( ! empty( $header ) ) {
	add_theme_support( 'custom-header' );
}
$background = get_option( 'custom_background' );
if ( ! empty( $background ) ) {
	add_theme_support( 'custom-background' );
}

/* Activate Nav Menu Option */
function sunset_register_nav_menu() {
	register_nav_menu( 'primary', 'Header Navigation Menu' );
}
add_action( 'after_setup_theme', 'sunset_register_nav_menu' );

add_theme_support( 'post-thumbnails' );

/* Activate HTML5 features */
add_theme_support( 'html5', array(
	'comment-list',
	'comment-form',
	'search-form',
	'gallery',
	'caption'
) );

/*
 * =========================
 *    SIDEBAR FUNCTIONS
 * =========================
 */

function sunset_sidebar_init() {

	register_sidebar( array(
		'name'          => esc_html__( 'Sunset Sidebar', 'sunsettheme' ),
		'id'            => 'sunset-sidebar',
		'description'   => 'Dynamic Right Sidebar',
		'before_widget' => '<section id="%1$s" class="sunset-widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="sunset-widget-title">',
		'after_title'   => '</h2>'
	) );

}
add_action( 'widgets_init', 'sunset_sidebar_init' );

/*
 * =========================
 *    BLOG LOOP CUSTOM FUNCTIONS
 * =========================
 */

function sunset_posted_meta() {
	$posted_on = human_time_diff( get_the_time( 'U' ), current_time( 'timestamp' ) );

	$categories = get_the_category();
	$separator = ', ';
	$output = '';
	$i = 1;

	if ( !empty($categories) ):
		foreach ( $categories as $category ):
			if ( $i > 1 ): $output .= $separator; endif;
			$output .= '<a href="' . esc_url( get_category_link( $category->term_id  ) ) . '"  alt="' . esc_attr( 'View all posts in %s', $category->name ) . '">' . esc_html( $category->name ) . '</a>';
			$i++;
		endforeach;
	endif;

	return '<span class="posted-on">Posted <a href="' . esc_url( get_permalink() ) . '">' . $posted_on . '</a> ago</span> / <span class="posted-in">' . $output . '</span>';
}

function sunset_posted_footer() {
	$comments_num = get_comments_number();
	if ( comments_open() ) {
		if ( $comments_num == 0 ) {
			$comments = __( 'No Comments' );
		} elseif ( $comments_num > 1 ) {
			$comments = __( $comments_num . ' Comments' );
		} else {
			$comments = __( '1 Comment' );
		}
		$comments = '<a class="comments-link" href="' . get_comments_link() . '">' . $comments . '  <span class="sunset-icon sunset-comment"></span></a>';
	} else {
		$comments = __( 'Comments are closed' );
	}
	return '<div class="post-footer-container"><div class="row"><div class="col-xs-12 col-sm-6">' . get_the_tag_list( '<div class="tags-list"><span class="sunset-icon sunset-tag"></span>', ' ', '</div>' ) . '</div><div class="col-xs-12 col-sm-6  text-right">'. $comments .'</div></div></div>';
}

function sunset_get_attachment( $num = 1 ) {
	$output = '';

	if ( has_post_thumbnail() && $num == 1 ):
		$output = wp_get_attachment_url( get_post_thumbnail_id( get_the_ID() ) );
	else:
		$attachments = get_posts( array(
			'post_type' => 'attachment',
			'posts_per_page' => $num,
			'post_parent' => get_the_ID()
		) );
		if ( $attachments && $num == 1 ):
			foreach ( $attachments as $attachment ):
				$output = wp_get_attachment_url( $attachment->ID );
			endforeach;
		elseif ( $attachments && $num > 1 ):
			$output = $attachments;
		endif;

		wp_reset_postdata();
	endif;

	return $output;
}

function sunset_get_embedded_media( $type = array() ) {
	$content = do_shortcode( apply_filters( 'the_content', get_the_content() ) );
	$embed = get_media_embedded_in_content( $content, $type );

	if ( in_array( 'audio', $type ) ):
		$output = str_replace( '?visual=true', '?visual=false', $embed[0] );
	else:
		$output = $embed[0];
	endif;

	return $output;
}

function sunset_get_bs_slides( $attachments ) {
	$output = array();

	$count = count( $attachments ) - 1;
	for ( $i = 0; $i <= $count; $i++ ) {
		$active = ( $i == 0 ? 'active' : '' );

		$n       = ( $i == $count ? 0 : $i + 1 );
		$nextImg = wp_get_attachment_thumb_url( $attachments[ $n ]->ID );
		$p       = ( $i == 0 ? $count : $i - 1 );
		$prevImg = wp_get_attachment_thumb_url( $attachments[ $p ]->ID );

		$output[ $i ] = array(
			'class'    => $active,
			'url'      => wp_get_attachment_url( $attachments[ $i ]->ID ),
			'next_img' => $nextImg,
			'prev_img' => $prevImg,
			'caption'  => $attachments[ $i ]->post_excerpt
		);
	}

	return $output;
}

function sunset_grab_url() {
	if ( ! preg_match( '/<a\s[^>]*?href=[\'"](.+?)[\'"]/i', get_the_content(), $links ) ) {
		return false;
	}
	return esc_url_raw( $links[1] );
}

function sunset_grab_current_uri() {

	$http = ( isset( $_SERVER['HTTPS'] ) ? 'https://' : 'http://' );
	$referer = $http . $_SERVER['HTTP_HOST'];
	$url = $referer . $_SERVER['REQUEST_URI'];

	return $url;
}

/*
 * =========================
 *    SINGLE POST CUSTOM FUNCTIONS
 * =========================
 */

function sunset_post_navigation() {

	$nav = '<div class="row">';

	$prev = get_previous_post_link( '<div class="post-link-nav"><span class="sunset-icon sunset-chevron-left"></span> %link</div>', '%title' );
	$nav .= '<div class="col-xs-12 col-sm-6 text-left"><div class="post-link-nav">' . $prev . '</div></div>';


	$next = get_next_post_link( '<div class="post-link-nav"></span>%link <span class="sunset-icon sunset-chevron-right"></div>', '%title' );
	$nav .= '<div class="col-xs-12 col-sm-6 text-right"><div class="post-link-nav">' . $next . '</div></div>';

	$nav .= '</div>';

	return $nav;
}

function sunset_share_this( $content ) {

	if ( is_single() ) {

		$title = get_the_title();
		$permalink = get_permalink();

		$twitter_handler = ( get_option( 'twitter_handler' ) ? '&amp;via=' . esc_attr( get_option( 'twitter_handler' ) ) : '' );

		$twitter = 'https://twitter.com/intetnt/tweet?text=Hey Read this: ' . $title . '&amp;url=' . $permalink . $twitter_handler;
		$facebook = 'https://www.facebook.com/sharer/sharer.php?u=' . $permalink;
		$google = 'https://plus.google.com/share?url=' . $permalink;

		$content .='<div class="sunset-shareThis"><h4>Share This</h4>';
		$content .= '<ul>';
		$content .= '<li><a href="' . $twitter . '" target="_blank" rel="nofollow"><span class="sunset-icon sunset-twitter"></span></a></li>';
		$content .= '<li><a href="' . $facebook . '" target="_blank" rel="nofollow"><span class="sunset-icon sunset-facebook"></span></a></li>';
		$content .= '<li><a href="' . $google . '" target="_blank" rel="nofollow"><span class="sunset-icon sunset-googleplus"></span></a></li>';
		$content .= '</ul></div><!-- .shareThis -->';

		return $content;

	} else {

		return $content;

	}
}
add_filter( 'the_content', 'sunset_share_this' );

function sunset_get_post_navigation() {

	//if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) :

		require ( get_template_directory() . '/inc/templates/sunset-comment-nav.php' );

	//endif;

}

function sunset_comment_form() {

	$commenter = wp_get_current_commenter();
	$consent = empty( $commenter['comment_author_email'] ) ? '' : ' checked="checked"';

	$fields = array(
		'author' => '<div class="form-group"><label for="author">' . __( 'Name', 'sunsettheme' ) .
		            '</label> <span class="required">*</span> <input id="author" name="author" type="text" class="form-control" value="' . esc_attr( $commenter['comment_author'] ) . '" required="required"/></div>',
		'email' => '<div class="form-group"><label for="email">' . __( 'Email', 'sunset-theme' ) .
		           '<span class="required">*</span> </label> <input id="email" name="email" type="text" class="form-control" value="' . esc_attr(  $commenter['comment_author_email'] ) . '" required="required" /></div>',
		'url' => '<div class="form-group"><label for="url">' . __( 'Website', 'sunsettheme' ) . '</label> <input id="url" name="url" type="text" class="form-control" value="' . esc_attr( $commenter['comment_author_url'] ) . '"/></div>',
		'cookies' => '<div class="form-group form-check"><input id="wp-comment-cookies-consent" name="wp-comment-cookies-consent" type="checkbox" class="form-check-input" value="yes"' . $consent . ' /> <label class="form-check-label" for="wp-comment-cookies-consent">' . __( 'Save my info for future comments.' ) . '</label></div>'
	);

	$args = array(
		'class_submit' => 'btn btn-block btn-lg btn-warning',
		'label_submit' => __('Submit Comment'),
		'comment_field' => '<div class="form-group"><label for="comment">' . _x( 'Comment', 'noun' ) . '</label><textarea id="comment" class="form-control" name="comment" rows="4" aria-required="true" required="required"></textarea></div>',
		'fields'       => apply_filters( 'comment_form_default_fields', $fields )
	);
	comment_form( $args );

}