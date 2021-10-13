/**
 *  @package StoreCustomizer/JS
 */
( function( $ ) {
    jQuery( document ).ready( function ( e ) {
        jQuery( '.wcz-handheld-search' ).on( 'click', function (e) {
            e.preventDefault();
            jQuery( this ).closest( '.wcz-handheld-footerbar' ).toggleClass( 'wcz-show-search' );
        });
    });
    // Hide Search if user clicks outside
    jQuery( document ).mouseup( function (e) {
        var container = jQuery( '.wcz-handheld-footerbar' );
        if ( !container.is( e.target ) && container.has( e.target ).length === 0 ) {
            container.removeClass( 'wcz-show-search' );
        }
    });
} )( jQuery );
