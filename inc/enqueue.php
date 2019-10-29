<?php
/**
 * @package sunsettheme
 *
 * ==============================
 *    ADMIN ENQUEUE FUNCTIONS
 * ==============================
 */

function sunset_load_admin_scripts( $hook ) {
	// Register CSS admin section
	wp_register_style( 'raleway-admin', 'https://fonts.googleapis.com/css?family=Raleway:200,300,400,500&display=swap' );
	wp_register_style( 'sunset-admin', get_template_directory_uri() . '/css/sunset.admin.min.css', array(), '1.0.0', 'all' );

	// Register Script Admin Section
	wp_register_script( 'sunset-admin-script', get_template_directory_uri() . '/js/sunset.admin.js', array( 'jquery' ), '1.0.0', true );

	$pages_array = array(
		'toplevel_page_sunset_admin_settings',
		'sunset_page_sunset_theme',
		'sunset_page_sunset_theme_contact',
		'sunset_page_sunset_theme_css'
	);

	if ( in_array( $hook, $pages_array )) {

		wp_enqueue_style( 'raleway-admin' );
		wp_enqueue_style( 'sunset-admin' );

	}

	if ( $hook == 'toplevel_page_sunset_admin_settings' ) {
		wp_enqueue_media();


		wp_enqueue_script( 'sunset-admin-script' );

	} else if ( $hook == 'sunset_page_sunset_theme_css' ) {
		wp_enqueue_style( 'ace-editor', get_template_directory_uri() . '/css/sunset.ace.min.css', array(), '1.0.0', 'all' );

		wp_enqueue_script( 'ace-editor', get_template_directory_uri() . '/js/ace/ace.js', array( 'jquery' ), '1.4.6', true );
		wp_enqueue_script( 'sunset-custom-css-script', get_template_directory_uri() . '/js/sunset.custom_css.js', array( 'jquery' ), '1.0.0', true );

	} else { return; }
}
add_action( 'admin_enqueue_scripts', 'sunset_load_admin_scripts' );

/*
 * ==============================
 *    FRONT-END ENQUEUE FUNCTIONS
 * ==============================
 */

function sunset_load_scripts() {
	wp_enqueue_style( 'bootstrap', get_template_directory_uri() . '/css/bootstrap.min.css', array(), '3.4.1', 'all' );
	wp_enqueue_style( 'sunset', get_template_directory_uri() . '/css/sunset.min.css', array(), '1.0.0', 'all' );
	wp_enqueue_style( 'raleway', 'https://fonts.googleapis.com/css?family=Raleway:200,300,400,500&display=swap' );

	wp_deregister_script( 'jquery' );
	wp_register_script( 'jquery', get_template_directory_uri() . '/js/jquery.js', false, '3.4.1', true );
	wp_enqueue_script( 'jquery' );
	wp_enqueue_script('bootstrap', get_template_directory_uri() . '/js/bootstrap.min.js', array('jquery'), '3.3.6',true );
	wp_enqueue_script('sunset', get_template_directory_uri() . '/js/sunset.js', array('jquery'), '1.0.0',true );
}
add_action( 'wp_enqueue_scripts', 'sunset_load_scripts' );