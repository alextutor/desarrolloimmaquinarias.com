/**
 * StoreCustomizer Quick View Custom JS
 */
( function( $ ) {
    $( document ).ready( function () {

        // Menu Cart Alignment
        wcz_mc_add_mini_cart();
        $( '#customize-control-wcz-mc-enable-minicart input[type=checkbox]' ).on( 'change', function() {
            wcz_mc_add_mini_cart();
        });
        
        function wcz_mc_add_mini_cart() {
            if ( $( '#customize-control-wcz-mc-enable-minicart input[type=checkbox]' ).is( ':checked' ) ) {
                $( '#sub-accordion-section-wcz-panel-wcz-menu-cart #customize-control-wcz-mc-minicart-align' ).show();
            } else {
                $( '#sub-accordion-section-wcz-panel-wcz-menu-cart #customize-control-wcz-mc-minicart-align' ).hide();
            }
        }

        // Menu Cart Design
        wcz_mc_menu_cart_design();
        $( '#customize-control-wcz-mc-edit-design input[type=checkbox]' ).on( 'change', function() {
            wcz_mc_menu_cart_design();
        });
        
        function wcz_mc_menu_cart_design() {
            if ( $( '#customize-control-wcz-mc-edit-design input[type=checkbox]' ).is( ':checked' ) ) {
                $( '#sub-accordion-section-wcz-panel-wcz-menu-cart #customize-control-wcz-mc-font-color' ).show();
                $( '#sub-accordion-section-wcz-panel-wcz-menu-cart #customize-control-wcz-mc-icon-color' ).show();
                $( '#sub-accordion-section-wcz-panel-wcz-menu-cart #customize-control-wcz-mc-icon-size' ).show();
                $( '#sub-accordion-section-wcz-panel-wcz-menu-cart #customize-control-wcz-mc-drop-bg-color' ).show();
                $( '#sub-accordion-section-wcz-panel-wcz-menu-cart #customize-control-wcz-mc-drop-font-color' ).show();
                $( '#sub-accordion-section-wcz-panel-wcz-menu-cart #customize-control-wcz-mc-drop-btn-color' ).show();
                $( '#sub-accordion-section-wcz-panel-wcz-menu-cart #customize-control-wcz-mc-drop-btnhover-color' ).show();
            } else {
                $( '#sub-accordion-section-wcz-panel-wcz-menu-cart #customize-control-wcz-mc-font-color' ).hide();
                $( '#sub-accordion-section-wcz-panel-wcz-menu-cart #customize-control-wcz-mc-icon-color' ).hide();
                $( '#sub-accordion-section-wcz-panel-wcz-menu-cart #customize-control-wcz-mc-icon-size' ).hide();
                $( '#sub-accordion-section-wcz-panel-wcz-menu-cart #customize-control-wcz-mc-drop-bg-color' ).hide();
                $( '#sub-accordion-section-wcz-panel-wcz-menu-cart #customize-control-wcz-mc-drop-font-color' ).hide();
                $( '#sub-accordion-section-wcz-panel-wcz-menu-cart #customize-control-wcz-mc-drop-btn-color' ).hide();
                $( '#sub-accordion-section-wcz-panel-wcz-menu-cart #customize-control-wcz-mc-drop-btnhover-color' ).hide();
            }
        }

    });
} )( jQuery );
