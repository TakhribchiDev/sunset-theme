<?php
/**
 * @package sunsettheme
 * -- Image Post Format
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class( 'sunset-format-image' ); ?>>
	<?php $featured_image = sunset_get_attachment(); ?>
    <header class="entry-header text-center background-image" style="background-image: url(<?php echo $featured_image; ?>);">

		<?php the_title( '<h1 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h1>' );?>

        <div class="entry-meta">
			<?php echo sunset_posted_meta(); ?>
        </div>

        <div class="entry-excerpt image-caption">
			<?php the_excerpt(); ?>
        </div><!-- .entry-excerpt -->

    </header>

	<div class="entry-footer">
		<?php echo sunset_posted_footer(); ?>
	</div><!-- .entry-footer -->

</article>