<?php
/**
 *
 * @package sunsettheme
 *
 *	========================
 *		WIDGET CLASS
 *	========================
 */

class Sunset_Profile_Widget extends WP_Widget {

	// Setup widget name, description, etc...
	public function __construct() {

		$widget_options = array(
			'classname'     => 'sunset-profile-widget',
			'description'   => 'Custom Sunset Profile Widget',
		);

		parent::__construct( 'sunset-profile', 'Sunset Profile', $widget_options );
	}

	// Back-end display of the widget
	public function form( $instance ) {

		echo '<p><strong>No options for this Widget!</strong><br>You can control fields of this Widget from this <a href="./admin.php?page=sunset_admin_settings">This Page</a></p>';
	}

	// Front-end display of the widget
	public function widget( $args, $instance ) {

		$picture     = esc_attr( get_option( 'profile_picture' ) );
		$first_name  = esc_attr( get_option( 'first_name' ) );
		$last_name   = esc_attr( get_option( 'last_name' ) );
		$full_name   = $first_name . ' ' . $last_name;
		$description = esc_attr( get_option( 'user_description' ) );

		$twitter_icon  = esc_attr( get_option( 'twitter_handler' ) );
		$facebook_icon = esc_attr( get_option( 'facebook_handler' ) );
		$gplus_icon    = esc_attr( get_option( 'gplus_handler' ) );

		echo $args['before_widget'];

		?>
		<div class="text-center">
			<div class="image-container">
				<div class="profile-picture" id="profile-picture-preview" style="background-image: url(<?php print ( @ $picture ? $picture : 'http://sunset.test/wp-content/themes/sunset-theme/img/profile_placeholder.jpg' ); ?>)">
				</div>
			</div>
			<h1 class="sunset-username"><?php print $full_name; ?></h1>
			<h2 class="sunset-description"><?php print $description; ?></h2>
			<div class="icons-wrapper">
				<?php  if ( ! empty( $twitter_icon ) ) : ?>
					<a href="https://twitter.com/<?php echo $twitter_icon ?>" target="_blank"><span class="sunset-icon-sidebar sunset-icon sunset-twitter"></span></a>
				<?php endif;
				if ( ! empty( $gplus_icon ) ) : ?>
				<a href="https://plus.google.com/u/0/+<?php echo $gplus_icon ?>" target="_blank"><span class="sunset-icon-sidebar  sunset-icon-sidebar-gplus sunset-icon sunset-googleplus"></span></a>
				<?php endif;
				if ( ! empty( $facebook_icon ) ) : ?>
					<a href="https://facebook.com/<?php echo $facebook_icon ?>" target="_blank"><span class="sunset-icon-sidebar sunset-icon sunset-facebook"></span></a>
				<?php endif; ?>
			</div>
		</div>
		<?php

		echo $args['after_widget'];
	}

}

add_action( 'widgets_init', function() {
	register_widget( 'Sunset_Profile_Widget' );
} );

/*
 * Edit default wordpress widgets
 */
function sunset_tag_cloud_font_change( $args ) {
	$args['smallest'] = 8;
	$args['largest'] = 8;

	return $args;
}

add_filter( 'widget_tag_cloud_args', 'sunset_tag_cloud_font_change' );

function sunset_list_categories_output_change( $links ) {

	$links = str_replace( '</a> (', '</a><span>', $links);
	$links = str_replace( ')', '</span>', $links );

	return $links;
}
add_filter( 'wp_list_categories', 'sunset_list_categories_output_change' );

/*
 * Save posts views
 */
function sunset_save_post_views( $postID ) {
	$metaKey = 'sunset_post_views';
	$views = get_post_meta( $postID, $metaKey, true );

	$count = ( empty( $views ) ? 0 : $views );
	$count++;

	update_post_meta( $postID, $metaKey, $count);

}
remove_action( 'wp_head', 'adjacent_posts_rel_link_wp_head' );

/*
 * Popular posts widget
 */
class Sunset_Popular_Posts_Widget extends WP_Widget {

	// Setup widget name, description, etc...
	public function __construct() {

		$widget_options = array(
			'classname'     => 'sunset-popular-posts-widget',
			'description'   => 'Popular Posts Widget',
		);

		parent::__construct( 'sunset_popular_posts', 'Sunset Popular Posts', $widget_options );
	}

	// Back-end display of the widget
	public function form( $instance ) {

		$title = ( !empty( $instance['title'] ) ? $instance['title'] : 'Popular Posts' );
		$total = ( !empty( $instance['total'] ) ? absint( $instance['total'] ) : 4 );

		$output = '<p>';
		$output .= '<label for="' . esc_attr( $this->get_field_id( 'title' ) ) . '">Title:</label>';
		$output .= '<input type="text" class="widefat" id="' . esc_attr( $this->get_field_id( 'title' ) ) . '" name="' . esc_attr( $this->get_field_name( 'title' ) ) . '" value="' . esc_attr( $title ) . '">';
		$output .= '<p>';
		$output .= '<label for="' . esc_attr( $this->get_field_id( 'total' ) ) . '">Number of Posts:</label>';
		$output .= '<input type="text" class="widefat" id="' . esc_attr( $this->get_field_id( 'total' ) ) . '" name="' . esc_attr( $this->get_field_name( 'total' ) ) . '" value="' . esc_attr( $total ) . '">';
		$output .= '</p>';

		echo $output;

	}

	// Update widget
	public function update( $new_instance, $old_instance ) {

		$instance = array();
		$instance['title'] = ( ! empty( $new_instance['title'] ) ? strip_tags( $new_instance['title'] ) : '' );
		$instance['total'] = ( ! empty( $new_instance['total'] ) ? absint( $new_instance['total'] ) : 0 );

		return $instance;
	}


	// Front-end display of the widget
	public function widget( $args, $instance ) {

		$total = $instance['total'];

		$posts_args = array(
			'post_type'         => 'post',
			'posts_per_page'    => $total,
			'meta_key'          => 'sunset_post_views',
			'orderby'           => 'meta_value_num',
			'order'             => 'DESC'
		);

		$posts_query = new WP_Query( $posts_args );

		echo $args[ 'before_widget' ];

		if ( !empty( $instance[ 'title' ] ) ):

			echo $args[ 'before_title' ] . apply_filters( 'widget_title', $instance['title'] ) . $args[ 'after_title' ];

		endif;

		if ( $posts_query->have_posts() ):

//			echo '<ul>';

			while ( $posts_query->have_posts() ): $posts_query->the_post();

				echo '<div class="media">';
				echo '<div class="media-left"><img class="media-object" src="' . get_template_directory_uri(). '/img/post-' . ( get_post_format() ? get_post_format() : 'standard' ) . '.png" alt=""></div>';
				echo '<div class="media-body"><a href="' . get_the_permalink() . '">' . get_the_title() . '</a></div>';
				echo '<div class="media-meta"><div class="row"><div class="shares-num text-right col-md-6"><span class="sunset-icon sunset-share"></span> ' . get_comments_number( get_the_id() ) . 'K SHARES</div><div class="comments-num text-left col-md-6"><span class="sunset-icon sunset-comment"></span> ' . get_comments_number( get_the_id() ) . ' COMMENTS</div></div></div>';
				echo '</div>';

			endwhile;

//			echo '</ul>';

		endif;

		echo $args[ 'after_widget' ];

	}

}

add_action( 'widgets_init', function() {
	register_widget( 'Sunset_Popular_Posts_Widget' );
});