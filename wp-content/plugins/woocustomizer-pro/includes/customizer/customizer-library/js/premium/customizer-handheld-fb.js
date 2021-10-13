/**
 * StoreCustomizer Ajax Search Custom JS
 */
( function( $ ) {
    $( document ).ready( function () {

        // Custom Link - One
        wcz_handheld_fb_link_one();
        $( '#customize-control-wcz-add-handheld-link-one input[type=checkbox]' ).on( 'change', function() {
            wcz_handheld_fb_link_one();
        });
        function wcz_handheld_fb_link_one() {
            if ( $( '#customize-control-wcz-add-handheld-link-one input[type=checkbox]' ).is( ':checked' ) ) {
                $( '#sub-accordion-section-wcz-panel-wcz-handheld-fb #customize-control-wcz-handheld-link-icon-one' ).show();
                $( '#sub-accordion-section-wcz-panel-wcz-handheld-fb #customize-control-wcz-handheld-link-title-one' ).show();
                $( '#sub-accordion-section-wcz-panel-wcz-handheld-fb #customize-control-wcz-handheld-link-page-one' ).show();
            } else {
                $( '#sub-accordion-section-wcz-panel-wcz-handheld-fb #customize-control-wcz-handheld-link-icon-one' ).hide();
                $( '#sub-accordion-section-wcz-panel-wcz-handheld-fb #customize-control-wcz-handheld-link-title-one' ).hide();
                $( '#sub-accordion-section-wcz-panel-wcz-handheld-fb #customize-control-wcz-handheld-link-page-one' ).hide();
            }
        }

        // Custom Link - Two
        wcz_handheld_fb_link_two();
        $( '#customize-control-wcz-add-handheld-link-two input[type=checkbox]' ).on( 'change', function() {
            wcz_handheld_fb_link_two();
        });
        function wcz_handheld_fb_link_two() {
            if ( $( '#customize-control-wcz-add-handheld-link-two input[type=checkbox]' ).is( ':checked' ) ) {
                $( '#sub-accordion-section-wcz-panel-wcz-handheld-fb #customize-control-wcz-handheld-link-icon-two' ).show();
                $( '#sub-accordion-section-wcz-panel-wcz-handheld-fb #customize-control-wcz-handheld-link-title-two' ).show();
                $( '#sub-accordion-section-wcz-panel-wcz-handheld-fb #customize-control-wcz-handheld-link-page-two' ).show();
            } else {
                $( '#sub-accordion-section-wcz-panel-wcz-handheld-fb #customize-control-wcz-handheld-link-icon-two' ).hide();
                $( '#sub-accordion-section-wcz-panel-wcz-handheld-fb #customize-control-wcz-handheld-link-title-two' ).hide();
                $( '#sub-accordion-section-wcz-panel-wcz-handheld-fb #customize-control-wcz-handheld-link-page-two' ).hide();
            }
        }
        // Custom Link - Three
        wcz_handheld_fb_link_three();
        $( '#customize-control-wcz-add-handheld-link-three input[type=checkbox]' ).on( 'change', function() {
            wcz_handheld_fb_link_three();
        });
        function wcz_handheld_fb_link_three() {
            if ( $( '#customize-control-wcz-add-handheld-link-three input[type=checkbox]' ).is( ':checked' ) ) {
                $( '#sub-accordion-section-wcz-panel-wcz-handheld-fb #customize-control-wcz-handheld-link-icon-three' ).show();
                $( '#sub-accordion-section-wcz-panel-wcz-handheld-fb #customize-control-wcz-handheld-link-title-three' ).show();
                $( '#sub-accordion-section-wcz-panel-wcz-handheld-fb #customize-control-wcz-handheld-link-page-three' ).show();
            } else {
                $( '#sub-accordion-section-wcz-panel-wcz-handheld-fb #customize-control-wcz-handheld-link-icon-three' ).hide();
                $( '#sub-accordion-section-wcz-panel-wcz-handheld-fb #customize-control-wcz-handheld-link-title-three' ).hide();
                $( '#sub-accordion-section-wcz-panel-wcz-handheld-fb #customize-control-wcz-handheld-link-page-three' ).hide();
            }
        }
        // Custom Link - Four
        wcz_handheld_fb_link_four();
        $( '#customize-control-wcz-add-handheld-link-four input[type=checkbox]' ).on( 'change', function() {
            wcz_handheld_fb_link_four();
        });
        function wcz_handheld_fb_link_four() {
            if ( $( '#customize-control-wcz-add-handheld-link-four input[type=checkbox]' ).is( ':checked' ) ) {
                $( '#sub-accordion-section-wcz-panel-wcz-handheld-fb #customize-control-wcz-handheld-link-icon-four' ).show();
                $( '#sub-accordion-section-wcz-panel-wcz-handheld-fb #customize-control-wcz-handheld-link-title-four' ).show();
                $( '#sub-accordion-section-wcz-panel-wcz-handheld-fb #customize-control-wcz-handheld-link-page-four' ).show();
            } else {
                $( '#sub-accordion-section-wcz-panel-wcz-handheld-fb #customize-control-wcz-handheld-link-icon-four' ).hide();
                $( '#sub-accordion-section-wcz-panel-wcz-handheld-fb #customize-control-wcz-handheld-link-title-four' ).hide();
                $( '#sub-accordion-section-wcz-panel-wcz-handheld-fb #customize-control-wcz-handheld-link-page-four' ).hide();
            }
        }

        // Cart Link Option
        wcz_handheld_cart_no();
        $( '#customize-control-wcz-handheld-remove-cart input[type=checkbox]' ).on( 'change', function() {
            wcz_handheld_cart_no();
        });
        function wcz_handheld_cart_no() {
            if ( $( '#customize-control-wcz-handheld-remove-cart input[type=checkbox]' ).is( ':checked' ) ) {
                $( '#sub-accordion-section-wcz-panel-wcz-handheld-fb #customize-control-wcz-handheld-add-cart-count' ).hide();
            } else {
                $( '#sub-accordion-section-wcz-panel-wcz-handheld-fb #customize-control-wcz-handheld-add-cart-count' ).show();
            }
        }

        // Search Options
        wcz_handheld_search_use();
        $( '#customize-control-wcz-handheld-use-wcz-search input[type=checkbox]' ).on( 'change', function() {
            wcz_handheld_search_use();
        });
        function wcz_handheld_search_use() {
            if ( $( '#customize-control-wcz-handheld-use-wcz-search input[type=checkbox]' ).is( ':checked' ) ) {
                $( '#sub-accordion-section-wcz-panel-wcz-handheld-fb #customize-control-wcz-handheld-search-placeholder' ).show();
            } else {
                $( '#sub-accordion-section-wcz-panel-wcz-handheld-fb #customize-control-wcz-handheld-search-placeholder' ).hide();
            }
        }

        // Edit Design
        wcz_handheld_colors();
        $( '#customize-control-wcz-handheld-edit-design input[type=checkbox]' ).on( 'change', function() {
            wcz_handheld_colors();
        });
        function wcz_handheld_colors() {
            if ( $( '#customize-control-wcz-handheld-edit-design input[type=checkbox]' ).is( ':checked' ) ) {
                $( '#sub-accordion-section-wcz-panel-wcz-handheld-fb #customize-control-wcz-handheld-title-size' ).show();
                $( '#sub-accordion-section-wcz-panel-wcz-handheld-fb #customize-control-wcz-handheld-titles-uppercase' ).show();
                $( '#sub-accordion-section-wcz-panel-wcz-handheld-fb #customize-control-wcz-handheld-bar-bgcolor' ).show();
                $( '#sub-accordion-section-wcz-panel-wcz-handheld-fb #customize-control-wcz-handheld-bar-fontcolor' ).show();
                $( '#sub-accordion-section-wcz-panel-wcz-handheld-fb #customize-control-wcz-handheld-bar-hovercolor' ).show();
                $( '#sub-accordion-section-wcz-panel-wcz-handheld-fb #customize-control-wcz-handheld-icon-size' ).show();
            } else {
                $( '#sub-accordion-section-wcz-panel-wcz-handheld-fb #customize-control-wcz-handheld-title-size' ).hide();
                $( '#sub-accordion-section-wcz-panel-wcz-handheld-fb #customize-control-wcz-handheld-titles-uppercase' ).hide();
                $( '#sub-accordion-section-wcz-panel-wcz-handheld-fb #customize-control-wcz-handheld-bar-bgcolor' ).hide();
                $( '#sub-accordion-section-wcz-panel-wcz-handheld-fb #customize-control-wcz-handheld-bar-fontcolor' ).hide();
                $( '#sub-accordion-section-wcz-panel-wcz-handheld-fb #customize-control-wcz-handheld-bar-hovercolor' ).hide();
                $( '#sub-accordion-section-wcz-panel-wcz-handheld-fb #customize-control-wcz-handheld-icon-size' ).hide();
            }
        }

    });
} )( jQuery );
