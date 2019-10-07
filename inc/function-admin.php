<?php

/**
 * @package sunsettheme
 * =========================
 *    ADMIN PAGE
 * =========================
 */

function sunset_add_admin_page() {
	// Generate Sunset Admin Page
	add_menu_page(
		'Sunset Theme Options',
		'Sunset',
		'manage_options',
		'sunset_admin_settings',
		'sunset_theme_create_page',
		get_template_directory_uri() . '/img/sunset-icon.png',
		110 );

	// Generate Sunset Admin Sub Pages
	add_submenu_page(
		'sunset_admin_settings',
		'Sunset Sidebar Options',
		'Sidebar',
		'manage_options',
		'sunset_admin_settings',
		'sunset_theme_create_page'
	);
	add_submenu_page(
		'sunset_admin_settings',
		'Sunset Theme Options',
		'Theme Options',
		'manage_options',
		'sunset_theme',
		'sunset_theme_support_page'
	);
	add_submenu_page(
		'sunset_admin_settings',
		'Sunset Contact Form',
		'Contact Form',
		'manage_options',
		'sunset_theme_contact',
		'sunset_theme_contact_form_page'
	);
	add_submenu_page(
		'sunset_admin_settings',
		'Sunset CSS Options',
		'Custom CSS',
		'manage_options',
		'sunset_theme_css',
		'sunset_theme_settings_page'
	);

	// Activate Custom Settings
	add_action( 'admin_init', 'sunset_custom_settings' );

}
// Bind sunset them admin page generation to admin_menu hook
add_action( 'admin_menu', 'sunset_add_admin_page' );

function sunset_custom_settings() {
	// Sunset sidebar settings
	register_setting( 'sunset-settings-group','profile_picture' );
	register_setting( 'sunset-settings-group','first_name' );
	register_setting( 'sunset-settings-group','last_name' );
	register_setting( 'sunset-settings-group', 'user_description' );
	register_setting( 'sunset-settings-group','twitter_handler',  'sunset_sanitize_twitter_handler');
	register_setting( 'sunset-settings-group','facebook_handler' );
	register_setting( 'sunset-settings-group','gplus_handler' );

	add_settings_section( 'sunset-sidebar-options', 'Sidebar Options', 'sunset_sidebar_options', 'sunset_admin_settings' );

	add_settings_field( 'sidebar-profile-picture', 'Profile Picture', 'sunset_sidebar_profile', 'sunset_admin_settings', 'sunset-sidebar-options' );
	add_settings_field( 'sidebar-name', 'Full Name', 'sunset_sidebar_name', 'sunset_admin_settings', 'sunset-sidebar-options' );
	add_settings_field( 'sidebar-description', 'Desctiption', 'sunset_sidebar_description', 'sunset_admin_settings', 'sunset-sidebar-options' );
	add_settings_field( 'sidebar-twitter', 'Twitter handler', 'sunset_sidebar_twitter', 'sunset_admin_settings', 'sunset-sidebar-options' );
	add_settings_field( 'sidebar-facebook', 'Facebook handler', 'sunset_sidebar_facebook', 'sunset_admin_settings', 'sunset-sidebar-options' );
	add_settings_field( 'sidebar-gplus', 'Google+ handler', 'sunset_sidebar_gplus', 'sunset_admin_settings', 'sunset-sidebar-options' );

	// Theme Support Options
	register_setting('sunset-theme-support', 'post_formats' );
	register_setting('sunset-theme-support', 'custom_header' );
	register_setting('sunset-theme-support', 'custom_background' );

	add_settings_section( 'sunset-theme-options', 'Theme Options', 'sunset_theme_options', 'sunset_theme' );

	add_settings_field( 'post_formats', 'Post Formats', 'sunset_post_formats', 'sunset_theme', 'sunset-theme-options', ['label_for' => 'post_formats'] );
	add_settings_field( 'custom_header', 'Custom Header', 'sunset_custom_header', 'sunset_theme', 'sunset-theme-options', ['label_for' => 'custom_header'] );
	add_settings_field( 'custom_background', 'Custom Background', 'sunset_custom_background', 'sunset_theme', 'sunset-theme-options', ['label_for' => 'custom_background'] );

	// Contact Form Options
	register_setting( 'sunset-contact-options', 'activate_contact' );

	add_settings_section( 'sunset-contact-section', 'Contact Form', 'sunset_contact_section', 'sunset_theme_contact' );

	add_settings_field( 'activate_contact',  'Activate Contact Form', 'sunset_activate_contact_form', 'sunset_theme_contact', 'sunset-contact-section', ['label_for' => 'activate_contact']);

	// Custom CSS Options
	register_setting( 'sunset-custom-css-options', 'custom_css', 'sunset_sanitize_custom_css' );

	add_settings_section( 'sunset-custom-css-section', 'Custom CSS', 'sunset_custom_css_section_callback', 'sunset_theme_css' );

	add_settings_field( 'custom_css', 'Insert your Custom CSS', 'sunset_custom_css_callback', 'sunset_theme_css', 'sunset-custom-css-section' );
}

// Sidebar Settings Functions
function sunset_sidebar_options() {
	echo 'Customize your sidebar information';
}

function sunset_sidebar_profile() {
	$picture = esc_attr( get_option( 'profile_picture' ) );
	if ( empty( $picture ) ) {
		echo '<input type="button" class="button secondary" value="Upload Profile Picture" id="upload-button"><input type="hidden" id="profile-picture" name="profile_picture" value="' . $picture . '"/>';
	} else {
		echo '<input type="button" class="button secondary" value="Replace Profile Picture" id="upload-button"><input type="button" class="button secondary" value="Remove" id="remove-button">';
	}
}

function sunset_sidebar_name() {
	$first_name = esc_attr( get_option( 'first_name' ) );
	$last_name = esc_attr( get_option( 'last_name' ) );
	echo '<input type="text" name="first_name" value="' . $first_name . '" placeholder="First Name"/><input type="text" name="last_name" value="' . $last_name . '" placeholder="Last Name" />';
}

function sunset_sidebar_description() {
	$description = esc_attr( get_option( 'user_description' ) );
	echo '<input type="text" name="user_description" value="' . $description . '" placeholder="Description"/><p class="description">Write something smart</p>';
}

function sunset_sidebar_twitter() {
	$twitter = esc_attr( get_option( 'twitter_handler' ) );
	echo '<input type="text" name="twitter_handler" value="' . $twitter . '" placeholder="Twitter handler"/><p class="description">Input your twitter username without the @ character</p>';
}

function sunset_sidebar_facebook() {
	$facebook = esc_attr( get_option( 'facebook_handler' ) );
	echo '<input type="text" name="facebook_handler" value="' . $facebook . '" placeholder="Facebook handler"/>';
}

function sunset_sidebar_gplus() {
	$gplus = esc_attr( get_option( 'gplus_handler' ) );
	echo '<input type="text" name="gplus_handler" value="' . $gplus . '" placeholder="Google+ handler"/>';
}

// Sidebar Options Sanitization
function sunset_sanitize_twitter_handler( $input ) {
	$output = sanitize_text_field( $input );
	$output = str_replace( '@', '', $output );
	return $output;
}

// Sunset Theme Support Functions
function sunset_theme_options() {
	echo 'Activate and Deactivate specific Theme Support Options';
}

function sunset_post_formats( $args ) {
	$label_for = $args['label_for'];
	$formats = array( 'aside', 'gallery', 'link', 'image', 'quote', 'status', 'video', 'audio', 'chat' );
	$options = get_option( 'post_formats' );
	$output = '';
	foreach ( $formats as $format ) {
		$checked = ( @ $options[$format] ? 'checked' : '' );
		$output .= '<label><div class="ui-toggle"><input type="checkbox" id="post_formats_' . $format . '" name="post_formats[' . $format . ']" value="1" ' . $checked . ' /><label for="' . $label_for . '_' .  $format . '"><div></div></label></div><span class="tabsp"></span>' . ucfirst( $format ) . '</label><br><span class="vsp"></span>';
	}
	echo $output;
}

function sunset_custom_header( $args ) {
	$label_for = $args['label_for'];
	$option = get_option( 'custom_header' );
		$checked = ( @ $option ? 'checked' : '' );
		echo '<div class="ui-toggle"><input type="checkbox" id="custom_header" name="custom_header" value="1" ' . $checked . '><label for="' . $label_for . '"><div></div></label></div>';
}

function sunset_custom_background( $args ) {
	$label_for = $args['label_for'];
	$option = get_option( 'custom_background' );
		$checked = ( @ $option ? 'checked' : '' );
		echo '<div class="ui-toggle"><input type="checkbox" id="custom_background" name="custom_background" value="1" ' . $checked . '/><label for="' . $label_for . '"><div></div></label></div>';
}

// Sunset Theme Contact Form Options
function sunset_contact_section() {
	echo 'Activate and Deactivate the Built-in Contact Form.';
}

function sunset_activate_contact_form( $args ) {
	$label_for = $args['label_for'];
	$option = get_option( 'activate_contact' );
	$checked = ( @ $option ? 'checked' : '' );
	echo '<div class="ui-toggle"><input type="checkbox" id="activate_contact" name="activate_contact" value="1" ' . $checked . '><label for="' . $label_for . '"><div></div></label></div>';
}

// Sunset Theme Custom CSS Options
function sunset_custom_css_section_callback() {
	echo 'Customize Sunset Theme with your own CSS';
}

function sunset_custom_css_callback() {
	$css = get_option( 'custom_css' );
	$css = ( @ $css ? $css : '/* Sunset Theme Custom CSS */' );
	echo '<div id="custom-css">' . $css . '</div><textarea id="custom_css" name="custom_css" style="display: none; visibility: hidden;">' . $css .  '</textarea>';
}

// Custom Css Options Sanitization
function sunset_sanitize_custom_css( $input ) {
	$output = esc_textarea( $input );
	return $output;
}

// Template functions
function sunset_theme_create_page() {
	require_once( get_template_directory() . '/inc/templates/sunset-admin.php');
}

function sunset_theme_support_page() {
	require_once( get_template_directory() . '/inc/templates/sunset-theme-support.php' );
}

function sunset_theme_contact_form_page() {
	require_once( get_template_directory() . '/inc/templates/sunset-contact-form.php' );
}

function sunset_theme_settings_page() {
	require_once( get_template_directory() . '/inc/templates/sunset-custom-css.php' );
}