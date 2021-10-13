/**
 *  @package StoreCustomizer/JS
 */
( function( $ ) {
    jQuery( document ).ready( function ( e ) {
        console.log('pb.js');
        jQuery( '.woocommerce li.product' ).each( function( index, value ) {
            var theProduct = jQuery( this );
            var pBadge = theProduct.find( '.wcz-pbadge' );
            var bElement = pBadge.data( 'belement' ) ? pBadge.data( 'belement' ) : '.wcz-pbimg';

            if ( '' === pBadge.data( 'belement' ) ) {
                theProduct.find( '.woocommerce-LoopProduct-link > img' ).wrap( '<div class="wcz-pbimg"></div>' );
            }
            pBadge.each( function( index, value ) {
                var pBadgeEl = jQuery( this );
                pBadgeEl.clone().appendTo( theProduct.find( bElement ) );
                pBadgeEl.remove();
            });
        });
    });

    jQuery( window ).on('load',function () {
        jQuery( '.woocommerce li.product .wcz-pbadge' ).each( function( index, value ) {
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
