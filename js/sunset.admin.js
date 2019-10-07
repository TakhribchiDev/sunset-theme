jQuery(document).ready(function($) {
    var mediaUploader;

    $( '#upload-button' ).on( 'click', function( element ) {

        element.preventDefault();

        if ( mediaUploader ) {
            mediaUploader.open();
            return;
        }
        mediaUploader = wp.media.frames.file_frame = wp.media({
            title: 'Choose Profile Picture',
            button: {
                text: 'Choose Picture'
            },
            multiple: false
        });
        mediaUploader.on( 'select', function() {
            var attachment = mediaUploader.state().get('selection').first().toJSON();
            $( '#profile-picture' ).val(attachment.url);
            $( '#profile-picture-preview' ).css( 'background-image', 'url(' + attachment.url + ')' );
        } );
    } );

    $( '#remove-button' ).on( 'click', function( element ) {
        element.preventDefault();

        var answer = confirm( "Are you sure you want to delete your Profile Picture?" );
        if ( answer === true ) {
            $('#profile-picture').val('');
            $('#profile-picture-preview').css('background-image', 'url(http://sunset.test/wp-content/themes/sunset-theme/img/profile_placeholder.jpg)');
            $( '.sunset-general-form' ).submit();
        }
    } );

});