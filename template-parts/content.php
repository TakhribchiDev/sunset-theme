<?php
/**
 * @package sunsettheme
 * -- Standard Post Format
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<header class="entry-header text-center">

		<?php the_title( '<h1 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h1>' );?>

		<div class="entry-meta">
			<?php echo sunset_posted_meta(); ?>
		</div>
	</header>

	<div class="entry-content">
		<?php if ( sunset_get_attachment() ):
        ?>
			<a class="standard-featured-link" href="<?php the_permalink(); ?>">
                <div class="standard-featured background-image" style="background-image: url(<?php echo sunset_get_attachment(); ?>);"></div>
            </a>
		<?php endif; ?>

        <div class="entry-excerpt">
            <?php the_excerpt(); ?>
        </div><!-- .entry-excerpt -->

        <div class="button-container text-center">
            <a href="<?php the_permalink(); ?>" class="btn btn-sunset"><?php _e( 'Read More' ); ?></a>
        </div><!-- .button-container-->
	</div><!-- .entry-content -->

    <div class="entry-footer">
        <?php echo sunset_posted_footer(); ?>
    </div><!-- .entry-footer -->

</article>