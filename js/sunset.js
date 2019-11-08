jQuery(document).ready(function($) {
    // Custom Sunset Scripts

    /* Variable Declarations */
    let last_scroll = 0;

    /* Init Functions */
    revealPosts();

    /* Carousel Control */
    $(document).on( 'click', '.sunset-carousel-thumb', function() {

        let id = $( "#" + $(this).attr("id") );

        $(id).on('slid.bs.carousel', function() {

            sunset_get_bs_thumbs(id);

        } );

    } );

    $(document).on( 'mouseenter', '.sunset-carousel-thumb', function() {

        let id = $( "#" + $(this).attr("id") );
        sunset_get_bs_thumbs(id);

    } );

    function sunset_get_bs_thumbs( id ) {

        let nextThumb = $(id).find('.item.active').find( '.next-image-preview').data('image');
        let prevThumb = $(id).find('.item.active').find( '.prev-image-preview').data('image');
        $(id).find('.right.carousel-control').find('.thumbnail-container').css({ 'background-image' : 'url('+nextThumb+')' });
        $(id).find('.left.carousel-control').find('.thumbnail-container').css({ 'background-image' : 'url('+prevThumb+')' });

    }

    /* Ajax Functions */
    $(document).on( 'click', '.sunset-load-more:not(.loading)', function() {

        let that = $(this);
        let page = that.data('page');
        let newPage = page + 1;
        let ajaxurl = that.data('url');
        let prev = that.data( 'prev' );
        let archive = that.data( 'archive' );

        if ( typeof( prev ) === 'undefined' ) {
            prev = 0;
        }

        if ( typeof( archive ) === 'undefined' ) {
            archive = 0;
        }

        that.addClass( 'loading' ).find( '.text' ).slideUp(320);
        that.find( '.sunset-icon' ).addClass( 'spin' );

        $.ajax({
            url : ajaxurl,
            type : 'post',
            data : {
                page : page,
                prev : prev,
                archive: archive,
                action: 'sunset_load_more'
            },
            error : function( response ) {
                console.log( response );
            },
            success : function( response ) {

                if ( response == 0 ) {
                    $('.sunset-posts-container').append( '<div class="text-center"><h3>You reached end of the line!</h3><p>No more posts to load.</p></div>' );
                    that.slideUp(320);
                } else {
                    setTimeout( function()
                    {
                        if ( prev == 1 ) {
                            $('.sunset-posts-container').prepend( response );
                            newPage = page - 1;
                        } else {
                            $('.sunset-posts-container').append( response );
                        }

                        if ( newPage == 1 ) {
                            that.slideUp(320);
                        } else {
                            that.data('page', newPage);

                            that.removeClass( 'loading' ).find( '.text' ).slideDown(320);
                            that.find( '.sunset-icon' ).removeClass( 'spin' );
                        }

                        revealPosts();

                    }, 1000 );
                }
            }
        });
    } );

    /* Scroll Functions */
    $( window ).scroll( function() {

        let scroll = $( window ).scrollTop();

        if ( Math.abs( scroll- last_scroll ) > $( window ).height() * 0.1 ) {
            last_scroll = scroll;

            $('.page-limit').each( function( index ) {
                if ( isVisible( $( this ) ) ) {
                   history.replaceState( null, null, $( this ).data( 'page' ) );
                   return (false);
                }
            } );

        }

    } );

    /* Helper Functions */
    function revealPosts() {

        // Enable tooltips and popovers in posts content
        $('[data-toggle="tooltip"]').tooltip();
        $('[data-toggle="popover"]').popover();

        let posts = $('article:not(.reveal)');
        let i = 0;

        setInterval( function() {

            if ( i >= posts.length ) return false;

            let el = posts[i];
            $(el).addClass('reveal').find('.sunset-carousel-thumb').carousel();

            i++;
        }, 200 );
    }

    function isVisible( element ) {
        let scroll_pos = $( window ).scrollTop();
        let window_height = $( window ).height();
        let el_top = $( element ).offset().top;
        let el_height = $( element ).height();
        let el_bottom = el_top + el_height;

        return ( el_bottom - el_height * 0.25 > scroll_pos ) && ( el_top < ( scroll_pos + 0.5 * window_height ) );
    }

    /* Sidebar Functions */
    $(document).on( 'click', '.js-toggleSidebar', function() {

        $( '.sunset-sidebar' ).toggleClass( 'sidebar-closed' );
        $( '.sidebar-overlay' ).fadeToggle( 320 );
        $( 'body' ).toggleClass( 'no-scroll' );

    } );

    /* Contact form submission */
    $( '#sunsetContactForm' ).on( 'submit', function( e ) {
        e.preventDefault();
        $( '.has-error' ).removeClass( 'has-error' );
        $( '.js-show-feedback' ).removeClass( 'js-show-feedback' );

        let form = $( '#sunsetContactForm' ),
            name = form.find( '#name' ).val(),
            email = form.find( '#email' ).val(),
            message = form.find( '#message' ).val(),
            ajaxurl = form.data( 'url' );

        if ( name == '' ) {
            $( '#name' ).parent( '.form-group' ).addClass( 'has-error' );
            return;
        }
        if ( email == '' ) {
            $( '#email' ).parent( '.form-group' ).addClass( 'has-error' );
            return;
        }
        if ( message == '' ) {
            $( '#message' ).parent( '.form-group' ).addClass( 'has-error' );
            return;
        }

        form.find( 'input, button, textarea' ).attr( 'disabled', 'disabled' );
        $( '.js-form-submission' ).addClass( 'js-show-feedback' );

        $.ajax({
            url : ajaxurl,
            type : 'post',
            data : {
               name: name,
                email: email,
                message: message,
                action: 'sunset_save_user_contact_form'
            },
            error : function( response ) {
                setTimeout( function() {
                    $( '.js-form-submission' ).removeClass( 'js-show-feedback' );
                    $( '.js-form-error' ).addClass( 'js-show-feedback' );
                    form.find( 'input, button, textarea' ).removeAttr( 'disabled' );
                }, 1500 );
            },
            success : function( response ) {
                if ( response == 0 ) {
                    setTimeout( function() {
                        $( '.js-form-submission' ).removeClass( 'js-show-feedback' );
                        $( '.js-form-error' ).addClass( 'js-show-feedback' );
                        form.find( 'input, button, textarea' ).removeAttr( 'disabled' );
                    }, 1500 );
                } else {
                    setTimeout( function() {
                        $( '.js-form-submission' ).removeClass( 'js-show-feedback' );
                        $( '.js-form-success' ).addClass( 'js-show-feedback' );
                        form.find( 'input, button, textarea' ).removeAttr( 'disabled' );
                        form.find( 'input, textarea' ).val('');
                    }, 1500 );
                }
            }
        });
    } );
});