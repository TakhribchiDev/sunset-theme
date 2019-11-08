<?php

/**
 * @package sunsettheme
 *
 * =========================
 *    SHORTCODE OPTIONS
 * =========================
 */

function sunset_tooltip( $atts, $content = null ) {

	// get the attributes
	$atts = shortcode_atts(
		array(
		'placement' => 'top',
		'title' => ''
		),
		$atts,
		'tooltip'
	);

	// Return HTML
	$title = ( $atts['title'] == '' ? $content : $atts['title'] );

	return '<sapn class="sunset-tooltip" data-toggle="tooltip" data-placement="' . $atts['placement'] . '" title="' . $title . '">' . $content . '</sapn>';

}

add_shortcode( 'tooltip', 'sunset_tooltip' );

function sunset_popover( $atts, $content = null ) {

	// get the attributes
	$atts = shortcode_atts(
		array(
			'placement' => 'top',
			'title'     => '',
			'trigger'   => 'click',
			'content'   => ''
		),
		$atts,
		'popover'
	);

	// Return HTML
	return '<span class="sunset-popover" data-container="body" data-toggle="popover" title="' . $atts['title'] . '" data-placement="' . $atts['placement'] . '" data-content="' . $atts['content'] . '" data-trigger="' . $atts['trigger'] . '">' . $content . '</span>';
}
add_shortcode( 'popover', 'sunset_popover' );

// Contact form shortcode
/**
 * @param $atts
 * @param null $content
 */
function sunset_contact_form( $atts, $content = null ) {
	// get the attributes
	$atts = shortcode_atts(
		array(),
		$atts,
		'contact_form'
	);

	// Return HTML
	ob_start();
	include 'templates/contact-form.php';
	return ob_get_clean();
}
add_shortcode( 'contact_form', 'sunset_contact_form');