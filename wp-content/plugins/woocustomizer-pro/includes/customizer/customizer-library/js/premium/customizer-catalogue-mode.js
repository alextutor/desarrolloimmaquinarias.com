/**
 * StoreCustomizer Custom JS
 */
( function( $ ) {
    $( document ).ready( function () {

        var wcz_cm_edit = $( '#customize-control-wcz-cm-to-edit select' ).val();
        wcz_cm_edit_value_check( wcz_cm_edit );
        $( '#customize-control-wcz-cm-to-edit select' ).on( 'change', function() {
            var wcz_cm_edit_value = $( this ).val();
            wcz_cm_edit_value_check( wcz_cm_edit_value );
        } );
        function wcz_cm_edit_value_check( wcz_cm_edit_value ) {
            if ( wcz_cm_edit_value == 'wcz-cm-edit-all' ) {
                $( '#sub-accordion-section-wcz-panel-wcz-catalogue-mode #customize-control-wcz-heading-cm-editall' ).show();
                $( '#sub-accordion-section-wcz-panel-wcz-catalogue-mode #customize-control-wcz-heading-cm-editselected' ).hide();
                $( '#sub-accordion-section-wcz-panel-wcz-catalogue-mode #customize-control-wcz-cm-shop-btn' ).show();
                $( '#sub-accordion-section-wcz-panel-wcz-catalogue-mode #customize-control-wcz-cm-shop-price' ).show();
                $( '#sub-accordion-section-wcz-panel-wcz-catalogue-mode #customize-control-wcz-cm-product-btn' ).show();
                $( '#sub-accordion-section-wcz-panel-wcz-catalogue-mode #customize-control-wcz-cm-product-price' ).show();
                wcz_catmode_shop_price();
                wcz_catmode_product_price();
                $( '#sub-accordion-section-wcz-panel-wcz-catalogue-mode #customize-control-wcz-cm-show-productid' ).hide();
                $( '#sub-accordion-section-wcz-panel-wcz-catalogue-mode #customize-control-wcz-cm-applyto-items' ).hide();
                $( '#sub-accordion-section-wcz-panel-wcz-catalogue-mode #customize-control-wcz-cm-selected-shop-btn' ).hide();
                $( '#sub-accordion-section-wcz-panel-wcz-catalogue-mode #customize-control-wcz-cm-selected-shop-price' ).hide();
                $( '#sub-accordion-section-wcz-panel-wcz-catalogue-mode #customize-control-wcz-cm-selected-product-btn' ).hide();
                $( '#sub-accordion-section-wcz-panel-wcz-catalogue-mode #customize-control-wcz-cm-selected-product-price' ).hide();
                wcz_selected_shop_text_change();
                wcz_selected_products_text_change();
            } else {
                $( '#sub-accordion-section-wcz-panel-wcz-catalogue-mode #customize-control-wcz-heading-cm-editall' ).hide();
                $( '#sub-accordion-section-wcz-panel-wcz-catalogue-mode #customize-control-wcz-heading-cm-editselected' ).show();
                $( '#sub-accordion-section-wcz-panel-wcz-catalogue-mode #customize-control-wcz-cm-shop-btn' ).hide();
                $( '#sub-accordion-section-wcz-panel-wcz-catalogue-mode #customize-control-wcz-cm-shop-price' ).hide();
                $( '#sub-accordion-section-wcz-panel-wcz-catalogue-mode #customize-control-wcz-cm-product-btn' ).hide();
                $( '#sub-accordion-section-wcz-panel-wcz-catalogue-mode #customize-control-wcz-cm-product-price' ).hide();
                wcz_catmode_shop_price();
                wcz_catmode_product_price();
                $( '#sub-accordion-section-wcz-panel-wcz-catalogue-mode #customize-control-wcz-cm-show-productid' ).show();
                $( '#sub-accordion-section-wcz-panel-wcz-catalogue-mode #customize-control-wcz-cm-applyto-items' ).show();
                $( '#sub-accordion-section-wcz-panel-wcz-catalogue-mode #customize-control-wcz-cm-selected-shop-btn' ).show();
                $( '#sub-accordion-section-wcz-panel-wcz-catalogue-mode #customize-control-wcz-cm-selected-shop-price' ).show();
                $( '#sub-accordion-section-wcz-panel-wcz-catalogue-mode #customize-control-wcz-cm-selected-product-btn' ).show();
                $( '#sub-accordion-section-wcz-panel-wcz-catalogue-mode #customize-control-wcz-cm-selected-product-price' ).show();
                wcz_selected_shop_text_change();
                wcz_selected_products_text_change();
            }
        }

        // Catalogue Mode Shop Price
        wcz_catmode_shop_price();
        $( '#customize-control-wcz-cm-shop-price input[type=radio]' ).on( 'change', function() {
            wcz_catmode_shop_price();
        });
        function wcz_catmode_shop_price() {
            if ( $( '#customize-control-wcz-cm-to-edit select' ).val() == 'wcz-cm-edit-all' && $( '#customize-control-wcz-cm-shop-price input[type=radio]:checked' ).val() == 'wcz-cm-shop-price-edit' ) {
                $( '#sub-accordion-section-wcz-panel-wcz-catalogue-mode #customize-control-wcz-cm-shop-price-text' ).show();
            } else {
                $( '#sub-accordion-section-wcz-panel-wcz-catalogue-mode #customize-control-wcz-cm-shop-price-text' ).hide();
            }
        }
        // Catalogue Mode Product Price
        wcz_catmode_product_price();
        $( '#customize-control-wcz-cm-product-price input[type=radio]' ).on( 'change', function() {
            wcz_catmode_product_price();
        });
        function wcz_catmode_product_price() {
            if ( $( '#customize-control-wcz-cm-to-edit select' ).val() == 'wcz-cm-edit-all' && $( '#customize-control-wcz-cm-product-price input[type=radio]:checked' ).val() == 'wcz-cm-product-price-edit' ) {
                $( '#sub-accordion-section-wcz-panel-wcz-catalogue-mode #customize-control-wcz-cm-product-price-text' ).show();
            } else {
                $( '#sub-accordion-section-wcz-panel-wcz-catalogue-mode #customize-control-wcz-cm-product-price-text' ).hide();
            }
        } // ALL Products

        // Show / Hide Selected Shop Price Text
        wcz_selected_shop_text_change();
        $( '#customize-control-wcz-cm-selected-shop-price input[type=radio]' ).on( 'change', function() {
            wcz_selected_shop_text_change();
        });
        function wcz_selected_shop_text_change() {
            if ( $( '#customize-control-wcz-cm-to-edit select' ).val() == 'wcz-cm-edit-selected' && $( '#customize-control-wcz-cm-selected-shop-price input[type=radio]:checked' ).val() == 'wcz-cm-selected-shop-price-edit' ) {
                $( '#sub-accordion-section-wcz-panel-wcz-catalogue-mode #customize-control-wcz-cm-selected-shop-price-txt' ).show();
            } else {
                $( '#sub-accordion-section-wcz-panel-wcz-catalogue-mode #customize-control-wcz-cm-selected-shop-price-txt' ).hide();
            }
        }
        // Show / Hide Selected Product Price Text
        wcz_selected_products_text_change();
        $( '#customize-control-wcz-cm-selected-product-price input[type=radio]' ).on( 'change', function() {
            wcz_selected_products_text_change();
        });
        function wcz_selected_products_text_change() {
            if ( $( '#customize-control-wcz-cm-to-edit select' ).val() == 'wcz-cm-edit-selected' && $( '#customize-control-wcz-cm-selected-product-price input[type=radio]:checked' ).val() == 'wcz-cm-selected-product-price-edit' ) {
                $( '#sub-accordion-section-wcz-panel-wcz-catalogue-mode #customize-control-wcz-cm-selected-product-price-txt' ).show();
            } else {
                $( '#sub-accordion-section-wcz-panel-wcz-catalogue-mode #customize-control-wcz-cm-selected-product-price-txt' ).hide();
            }
        }

        // Apply to Logged Out users notice
        wcz_logged_users_notice();
        $( '#customize-control-wcz-cm-apply-notlogged input[type=checkbox]' ).on( 'change', function() {
            wcz_logged_users_notice();
        });
        function wcz_logged_users_notice() {
            if ( $( '#customize-control-wcz-cm-apply-notlogged input[type=checkbox]' ).is( ':checked' ) ) {
                $( '#sub-accordion-section-wcz-panel-wcz-catalogue-mode #customize-control-wcz-cm-apply-notlogged .customize-control-description' ).show();
            } else {
                $( '#sub-accordion-section-wcz-panel-wcz-catalogue-mode #customize-control-wcz-cm-apply-notlogged .customize-control-description' ).hide();
            }
        }

        // Catalogue Notice
        wcz_cat_notice();
        $( '#customize-control-wcz-cm-enable-site-notice input[type=checkbox]' ).on( 'change', function() {
            wcz_cat_notice();
        });
        function wcz_cat_notice() {
            if ( $( '#customize-control-wcz-cm-enable-site-notice input[type=checkbox]' ).is( ':checked' ) ) {
                $( '#sub-accordion-section-wcz-panel-wcz-catalogue-mode #customize-control-wcz-cm-notice-txt' ).show();
                $( '#sub-accordion-section-wcz-panel-wcz-catalogue-mode #customize-control-wcz-cm-notice-style' ).show();
                $( '#sub-accordion-section-wcz-panel-wcz-catalogue-mode #customize-control-wcz-cm-notice-color' ).show();
                $( '#sub-accordion-section-wcz-panel-wcz-catalogue-mode #customize-control-wcz-cm-notice-font-color' ).show();
                $( '#sub-accordion-section-wcz-panel-wcz-catalogue-mode #customize-control-wcz-cm-notice-fsize' ).show();
            } else {
                $( '#sub-accordion-section-wcz-panel-wcz-catalogue-mode #customize-control-wcz-cm-notice-txt' ).hide();
                $( '#sub-accordion-section-wcz-panel-wcz-catalogue-mode #customize-control-wcz-cm-notice-style' ).hide();
                $( '#sub-accordion-section-wcz-panel-wcz-catalogue-mode #customize-control-wcz-cm-notice-color' ).hide();
                $( '#sub-accordion-section-wcz-panel-wcz-catalogue-mode #customize-control-wcz-cm-notice-font-color' ).hide();
                $( '#sub-accordion-section-wcz-panel-wcz-catalogue-mode #customize-control-wcz-cm-notice-fsize' ).hide();
            }
        }

    });
} )( jQuery );
