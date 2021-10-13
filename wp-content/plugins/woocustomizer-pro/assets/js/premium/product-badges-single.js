/**
 *  @package StoreCustomizer/JS
 */
( function( $ ) {
    jQuery( document ).ready( function ( e ) {
        //console.log( 'aaaaaaaaaaa' );

        // var theProduct = jQuery( this );
        // var pBadge = theProduct.find( '.wcz-pbadge' );
        // var bElement = pBadge.data( 'belement' ) ? pBadge.data( 'belement' ) : '.wcz-pbimg';

        
    });

    jQuery( window ).on('load',function () {
        jQuery( '.woocommerce-product-gallery__wrapper' ).before( '<div class="wcz-pbwrap"></div>' );

        jQuery( '.single-product .product .entry-summary' ).find( '.wcz-pbadge' ).each( function( index, value ) {
            console.log( jQuery( this ).html() );
            var pBadge = jQuery( this );
            pBadge.clone().appendTo( jQuery( '.wcz-pbwrap' ) );
            pBadge.remove();
        });

        jQuery( '.wcz-pbwrap .wcz-pbadge' ).each( function( index, value ) {
            var thisBadge = jQuery( this );
            var posValue = thisBadge.data( 'posval' );
            
            if ( 'topcenter' == posValue || 'middlecenter' == posValue || 'bottomcenter' == posValue ) {
                thisBadge.css( 'margin-right', '-' + ( thisBadge.outerWidth() / 2 ) + 'px' );
            } else {
                thisBadge.css( 'margin-right', '0' );
            }
            if ( 'middleleft' == posValue || 'middlecenter' == posValue || 'middleright' == posValue ) {
                thisBadge.css( 'margin-top', '-' + ( thisBadge.outerHeight() / 2 ) + 'px' );
            } else {
                thisBadge.css( 'margin-top', '0' );
            }
        });

        jQuery( 'body' ).removeClass( 'wcz-pbhide' );
    });
} )( jQuery );
