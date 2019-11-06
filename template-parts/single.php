<?php
/**
 * @package sunsettheme
 * -- Single Post Template
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<header class="entry-header text-center">

		<?php the_title( '<h1 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h1>' );?>

		<div class="entry-meta">
			<?php echo sunset_posted_meta(); ?>
		</div>
	</header>

	<div class="entry-content clearfix">

		<?php the_content(); ?>

	</div><!-- .entry-content -->

	<div class="entry-footer">
		<?php echo sunset_posted_footer(); ?>
	</div><!-- .entry-footer -->

</article>