<?php
/**
 * @package sunsettheme
 */

get_header(); ?>

<div id="primary" class="content-area">
	<main id="main" class="site-main" role="main">

		<div class="container">
            <div class="row">

                <div class="col-xs-12 col-md-10 col-lg-8 col-md-offset-1 col-lg-offset-2">

	                <?php
	                if ( have_posts() ) :

		                while ( have_posts() ) : the_post();

			                get_template_part( 'template-parts/single', get_post_format() );

		                endwhile;

		                echo sunset_post_navigation();

		                if ( comments_open() || get_comments_number() ) :

			                comments_template();

		                endif;

	                endif;
	                ?>

                </div><!-- col-xs-12 -->

            </div><!-- .row -->

		</div><!-- .container -->

	</main>
</div><!-- #primary -->

<?php get_footer(); ?>
