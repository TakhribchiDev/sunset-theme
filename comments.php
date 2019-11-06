<?php
/**
 * @package sunsettheme
 */

if ( post_password_required() ) return;

?>

<div class="comments-area">

    <?php
        if ( have_comments() ) :
    ?>

            <h2 class="comments-title">

                <?php

                printf(
                        esc_html( _nx( 'One comment on &ldquo;%2$s&rdquo;', '%1$s comments on &ldquo;%2$s&rdquo;', get_comments_number(), 'comments title', 'sunsettheme' ) ),
                        number_format_i18n( get_comments_number() ),
                        '<span>' . get_the_title() . '</span>'
                );

                ?>

            </h2>

	        <?php sunset_get_post_navigation(); ?>

            <ol class="comment-list">

		        <?php

		        $args = array(
			        'walker'            => null,
			        'max-depth'         => '',
			        'style'             => 'ol',
			        'callback'          => null,
			        'end-callback'      => null,
			        'type'              => 'all',
			        'reply_text'        => 'Reply',
			        'page'              => '',
			        'per_page'          => '',
			        'avatar_size'       => 64,
			        'reverse_top_level' => null,
			        'reverse_children'  => '',
			        'format'            => 'html5',
			        'short-ping'        => false,
			        'echo'              => true
		        );
		        wp_list_comments( $args );

		        ?>

            </ol>

	        <?php sunset_get_post_navigation(); ?>

	    <?php
	        if ( ! comments_open() && get_comments_number() ) :
	    ?>

                <p class="no-comments"><?php esc_html_e( 'Comments are closed.', 'sunsettheme' ); ?> </p>

	    <?php
            endif;
	    ?>

    <?php
        endif;
    ?>

<?php

sunset_comment_form();

?>
</div><!-- .comments-area -->
