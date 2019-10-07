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
	add_theme_support( 'custom-header', $output );
}
$background = get_option( 'custom_background' );
if ( ! empty( $background ) ) {
	add_theme_support( 'custom-background', $output );
}

/* Activate Nav Menu Option */
function sunset_register_nav_menu() {
	register_nav_menu( 'primary', 'Header Navigation Menu' );
}
add_action( 'after_setup_theme', 'sunset_register_nav_menu' );
