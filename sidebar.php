<?php
/**
 * @package sunsettheme
 */

if ( ! is_active_sidebar( 'sunset-sidebar' ) )
	return;
?>
    <nav class="text-center visible-xs">
		<?php
		wp_nav_menu( array(
			'theme_location'    => 'primary',
			'container'         => false,
			'menu_class'        => 'nav navbar-nav navbar-collapse',
			'walker'            => new Sunset_Walker_Nav_Primary()
		) );
		?>
    </nav>

<aside  id="secondary" class="widget-area" role="complementary">

	<?php dynamic_sidebar( 'sunset-sidebar' ); ?>

</aside>
