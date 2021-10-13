/**
 * Plugin Template Ajax Search js.
 *
 *  @package StoreCustomizer/JS
 */
( function( $ ) {
    jQuery( document ).ready( function () {
        
        jQuery( '.wcz-ajax-search-block' ).each(function () {
            var wczas_id = jQuery( this );
            var wczas_input = wczas_id.find( '.wcz-s' );
            var wcz_minchars = wczas_id.data( 'minchars' );

            // wczas_id.focusin(function() {

                wczas_input.on( 'keyup', this, function (e) {

                    if ( e.which <= 90 && e.which >= 48 || e.which >= 96 && e.which <= 105 || e.which == 8 ) { // Only character keys & numbers
                        
                        var wcz_as_val = wczas_input.val();

                        if ( wcz_as_val.length >= wcz_minchars ) {
                            // Start loading functionality

                            if ( ! jQuery( '.wcz-search-results-block' ).length ) {
                                wczas_id.append( '<div class="wcz-search-results-block wcz-as-loading"></div>' );
                            }

                            jQuery.ajax({
                                type: 'POST',
                                url: wcz_ajaxsearch.ajax_url,
                                dataType: 'html',
                                data: {
                                    'action': 'wcz_ajax_search_get_products',
                                    'search_for': wcz_as_val,
                                },
                                success: function ( result ) {

                                    wczas_id.find( '.wcz-search-results-block' ).removeClass( 'wcz-as-loading' );
                        
                                    wczas_id.find( '.wcz-search-results-block' ).html( result );
                        
                                },
                                error: function () {
                                    // console.log( "No Posts retrieved" );
                                }
                            }); // End of ajax function
                        
                        } else {
                            // Remove loading functionality
                            wczas_id.find( '.wcz-search-results-block' ).remove();
                        }

                    } // Only character keys & numbers - if(
                    
                }); // End .on( 'keyup' )

            // }); // End focusIn()
            
        });

        jQuery( '.wcz-s-submit' ).on( 'click', function () {
            var form = $( this ).closest( 'form' );
            if ( form.find( '.wcz-s' ).val() == '' ) {
                return false;
            }
            return true;
        });

    });


    // Hide Search is user clicks anywhere else
    jQuery( document ).mouseup( function (e) {
        var container = jQuery( '.wcz-ajax-search-block' );

        if ( !container.is( e.target ) && container.has( e.target ).length === 0 ) {
            container.find( '.wcz-search-results-block' ).delay( 400 ).remove();
        }

    });
} )( jQuery );