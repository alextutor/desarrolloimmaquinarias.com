/**
 * Plugin Template Magnific Popup js.
 *
 *  @package StoreCustomizer/JS
 */
( function( $ ) {
    jQuery( document ).ready( function ( e ) {

        jQuery( '.wcz-popup-link' ).magnificPopup({
            items: {
                src: '#wcz-modal',
                type: 'inline'
            },
            removalDelay: 500, //delay removal by X to allow out-animation
            callbacks: {
                beforeOpen: function() {
                    jQuery( '.wcz-popup-inner' ).addClass( 'wcz-loading' );

                    this.st.mainClass = this.st.el.attr('data-effect');

                    $wcz_productid = this.st.el.attr( 'id' ).substring( 7 );

                    jQuery.ajax({
                        type: 'POST',
                        url: wcz_prodata.ajax_url,
                        dataType: 'html',
                        data: {
                            'action': 'wcz_quickview_ajax_product',
                            'product_id': $wcz_productid,
                        },
                        success: function ( result ) {

                            jQuery( '#wcz-modal .wcz-popup-inner' ).html( result );

                            jQuery( '.wcz-popup-inner' ).removeClass( 'wcz-loading' );

                            jQuery( '#wcz-modal .wcz-popup-inner' ).find( '.woocommerce-product-gallery' ).each(function () {
                                jQuery( this ).wc_product_gallery();
                                jQuery( '.wcz-quickview-product-imgs div.woocommerce-product-gallery .woocommerce-product-gallery__image a' ).removeAttr( 'href' );
                            });

                            jQuery( '.wcz-quickview-product-imgs div.woocommerce-product-gallery .woocommerce-product-gallery__image' ).each(function () {
                                jQuery( this ).addClass( 'wcz-img ' );
                            });
                            jQuery( '.wcz-quickview-product-imgs div.woocommerce-product-gallery .woocommerce-product-gallery__image:first-child' ).removeClass( 'wcz-img' ).attr( 'id', 'wcz-img-first' );

                            jQuery('div.wcz-img').click(function() {
                                var bigHtml = jQuery( '#wcz-img-first' ).html();
                                var smallHtml = jQuery( this ).html();
                        
                                jQuery( 'div#wcz-img-first' ).html( smallHtml );
                                jQuery( this ).html( bigHtml );
                            });
                            
                            // Disables the redirect to product page after Add to Cart
                            if ( jQuery( '.wcz-popup-inner' ).hasClass( 'wcz-to-shop' ) ) {
                                if ( jQuery( '.wcz-popup-inner > .product' ).hasClass( 'product-type-external' ) )
                                    return;

                                jQuery( '#wcz-modal form.cart' ).attr( 'action', '' );
                            }
                
                        },
                        error: function () {
                            // console.log( "No Posts retrieved" );
                        }
                    }); // End of ajax function

                },
                afterClose: function() {
                    jQuery( '#wcz-modal .wcz-popup-inner' ).html( '' );
                }
            },
            midClick: true // allow opening popup on middle mouse click.
        });

    });
} )( jQuery );
