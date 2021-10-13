/**
 * StoreCustomizer Ajax Search Custom JS
 */
( function( $ ) {
    $( document ).ready( function () {

        var wcz_as_txt = $( '#customize-control-wcz-search-btn select' ).val();
        wcz_as_txt_value_check( wcz_as_txt );
        $( '#customize-control-wcz-search-btn select' ).on( 'change', function() {
            var wcz_as_txt_value = $( this ).val();
            wcz_as_txt_value_check( wcz_as_txt_value );
        } );
        function wcz_as_txt_value_check( wcz_as_txt_value ) {
            if ( wcz_as_txt_value == 'wcz-as-btn-none' ) {
                $( '#sub-accordion-section-wcz-panel-wcz-ajax-search #customize-control-wcz-ajaxsearch-btn-txt' ).hide();
                $( '#sub-accordion-section-wcz-panel-wcz-ajax-search #customize-control-wcz-ajaxsearch-remove-btn' ).hide();
                $( '#sub-accordion-section-wcz-panel-wcz-ajax-search #customize-control-wcz-search-btn-icon' ).hide();
            } else if ( wcz_as_txt_value == 'wcz-as-btn-icon' ) {
                $( '#sub-accordion-section-wcz-panel-wcz-ajax-search #customize-control-wcz-ajaxsearch-btn-txt' ).hide();
                $( '#sub-accordion-section-wcz-panel-wcz-ajax-search #customize-control-wcz-ajaxsearch-remove-btn' ).hide();
                $( '#sub-accordion-section-wcz-panel-wcz-ajax-search #customize-control-wcz-search-btn-icon' ).show();
            } else {
                $( '#sub-accordion-section-wcz-panel-wcz-ajax-search #customize-control-wcz-ajaxsearch-btn-txt' ).show();
                $( '#sub-accordion-section-wcz-panel-wcz-ajax-search #customize-control-wcz-ajaxsearch-remove-btn' ).show();
                $( '#sub-accordion-section-wcz-panel-wcz-ajax-search #customize-control-wcz-search-btn-icon' ).hide();
            }
        }

        // Ajax Search Design
        wcz_as_design();
        $( '#customize-control-wcz-ajaxsearch-edit-design input[type=checkbox]' ).on( 'change', function() {
            wcz_as_design();
        });
        
        function wcz_as_design() {
            if ( $( '#customize-control-wcz-ajaxsearch-edit-design input[type=checkbox]' ).is( ':checked' ) ) {
                $( '#sub-accordion-section-wcz-panel-wcz-ajax-search #customize-control-wcz-ajaxsearch-fsize' ).show();
                $( '#sub-accordion-section-wcz-panel-wcz-ajax-search #customize-control-wcz-ajaxsearch-color' ).show();
                $( '#sub-accordion-section-wcz-panel-wcz-ajax-search #customize-control-wcz-ajaxsearch-btn-color' ).show();
                $( '#sub-accordion-section-wcz-panel-wcz-ajax-search #customize-control-wcz-ajaxsearch-bg-color' ).show();
                $( '#sub-accordion-section-wcz-panel-wcz-ajax-search #customize-control-wcz-ajaxsearch-sale-color' ).show();
                $( '#sub-accordion-section-wcz-panel-wcz-ajax-search #customize-control-wcz-ajaxsearch-padding' ).show();
                $( '#sub-accordion-section-wcz-panel-wcz-ajax-search #customize-control-wcz-ajaxsearch-width' ).show();
                wcz_as_design_pad();
            } else {
                $( '#sub-accordion-section-wcz-panel-wcz-ajax-search #customize-control-wcz-ajaxsearch-fsize' ).hide();
                $( '#sub-accordion-section-wcz-panel-wcz-ajax-search #customize-control-wcz-ajaxsearch-color' ).hide();
                $( '#sub-accordion-section-wcz-panel-wcz-ajax-search #customize-control-wcz-ajaxsearch-btn-color' ).hide();
                $( '#sub-accordion-section-wcz-panel-wcz-ajax-search #customize-control-wcz-ajaxsearch-bg-color' ).hide();
                $( '#sub-accordion-section-wcz-panel-wcz-ajax-search #customize-control-wcz-ajaxsearch-sale-color' ).hide();
                $( '#sub-accordion-section-wcz-panel-wcz-ajax-search #customize-control-wcz-ajaxsearch-padding' ).hide();
                $( '#sub-accordion-section-wcz-panel-wcz-ajax-search #customize-control-wcz-ajaxsearch-width' ).hide();
                wcz_as_design_pad();
            }
        }
        // Show / Hide Search Box spacing Top & Bottom
        $( '#customize-control-wcz-ajaxsearch-edit-design input[type=checkbox], #customize-control-wcz-enable-ajax-search input[type=checkbox]' ).on( 'change', function() {
            wcz_as_design_pad();
        });
        function wcz_as_design_pad() {
            if ( $( '#customize-control-wcz-enable-ajax-search input[type=checkbox]' ).is( ':checked' ) && $( '#customize-control-wcz-ajaxsearch-edit-design input[type=checkbox]' ).is( ':checked' ) ) {
                $( '#sub-accordion-section-wcz-panel-wcz-ajax-search #customize-control-wcz-ajaxsearch-toppad' ).show();
                $( '#sub-accordion-section-wcz-panel-wcz-ajax-search #customize-control-wcz-ajaxsearch-botpad' ).show();
            } else {
                $( '#sub-accordion-section-wcz-panel-wcz-ajax-search #customize-control-wcz-ajaxsearch-toppad' ).hide();
                $( '#sub-accordion-section-wcz-panel-wcz-ajax-search #customize-control-wcz-ajaxsearch-botpad' ).hide();
            }
        }

    });
} )( jQuery );
