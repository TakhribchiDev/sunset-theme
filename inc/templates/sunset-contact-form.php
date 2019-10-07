<h1>Sunset Contact Form Options</h1>
<?php settings_errors(); ?>
<form method="post" action="options.php" class="sunset-general-form">
	<?php
	settings_fields( 'sunset-contact-options' );
	do_settings_sections( 'sunset_theme_contact' );
	submit_button();
	?>
</form>
