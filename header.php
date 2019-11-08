<?php
/**
 * This is the template for the header of sunset theme
 *
 * @package sunsettheme
 */
?>

<!DOCTYPE html>
<html  <?php language_attributes(); ?>>
<head>
    <title><?php bloginfo('site-title'); ?></title>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="http://gmpg.org/xfn/11">
	<?php if ( is_singular() && pings_open( get_queried_object() ) ): ?>
		<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>">
	<?php  endif; ?>
	<?php wp_head(); ?>

    <?php
        $custom_css = esc_attr( get_option( 'custom_css' ) );
        if ( ! empty( $custom_css ) ) :
            echo '<style type="text/css">' . $custom_css . '</style>';
        endif;
    ?>
</head>
<body <?php body_class(); ?> >

<div class="sunset-sidebar sidebar-closed"><!-- .sidebar-closed -> Add this class on production to this div -->

    <div class="sunset-sidebar-container">

        <a class="js-toggleSidebar sidebar-close">
            <span class="sunset-icon sunset-close"></span>
        </a>

        <div class="sidebar-scroll">

			<?php get_sidebar(); ?>

        </div><!-- .sidebar-scroll -->

    </div><!-- .sunset-sidebar-container -->

</div><!-- .sunset-sidebar -->

<div class="sidebar-overlay js-toggleSidebar"></div>

<div class="container-fluid">

    <div class="row">

        <header class="header-container text-center background-image" style="background-image: url( <?php header_image(); ?> )">

            <a class="js-toggleSidebar sidebar-open">
                <span class="sunset-icon sunset-menu"></span>
            </a>

            <div class="header-content table">
                <div class="table-cell">
                    <h1 class="site-title">
                        <span class="sunset-icon sunset-logo"></span>
                        <span class="hide"><?php bloginfo( 'name' ); ?></span>
                    </h1>
                    <h2 class="site-description"><?php bloginfo( 'description' ); ?></h2>
                </div>
            </div>

            <div class="nav-container hidden-xs">
                <nav class="navbar navbar-sunset">
			        <?php
			        wp_nav_menu( array(
				        'theme_location'    => 'primary',
				        'container'         => false,
				        'menu_class'        => 'nav navbar-nav',
				        'walker'            => new Sunset_Walker_Nav_Primary()
			        ) );
			        ?>
                </nav>
            </div><!-- .nav-container -->

        </header><!-- .header-container -->

    </div><!-- .row -->

</div> <!-- .container-fluid -->