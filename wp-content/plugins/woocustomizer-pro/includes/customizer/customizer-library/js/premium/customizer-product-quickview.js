/**
 * StoreCustomizer Quick View Custom JS
 */
( function( $ ) {
    $( document ).ready( function () {

        // Quick View Add Button
        wcz_qv_enable_btn();
        $( '#customize-control-wcz-enable-product-quickview input[type=checkbox]' ).on( 'change', function() {
            wcz_qv_enable_btn();
        });
        
        function wcz_qv_enable_btn() {
            if ( $( '#customize-control-wcz-enable-product-quickview input[type=checkbox]' ).is( ':checked' ) ) {
                $( '#sub-accordion-section-wcz-panel-wcz-product-quickview #customize-control-wcz-quickview-type' ).show();
                $( '#sub-accordion-section-wcz-panel-wcz-product-quickview #customize-control-wcz-product-quickview-btntxt' ).show();
            } else {
                $( '#sub-accordion-section-wcz-panel-wcz-product-quickview #customize-control-wcz-quickview-type' ).hide();
                $( '#sub-accordion-section-wcz-panel-wcz-product-quickview #customize-control-wcz-product-quickview-btntxt' ).hide();
            }
        }

        // Quick View Add Product Button
        wcz_qv_add_product_btn();
        $( '#customize-control-wcz-qv-add-btn input[type=checkbox]' ).on( 'change', function() {
            wcz_qv_add_product_btn();
        });
        
        function wcz_qv_add_product_btn() {
            if ( $( '#customize-control-wcz-qv-add-btn input[type=checkbox]' ).is( ':checked' ) ) {
                $( '#sub-accordion-section-wcz-panel-wcz-product-quickview #customize-control-wcz-qv-add-btn-txt' ).show();
            } else {
                $( '#sub-accordion-section-wcz-panel-wcz-product-quickview #customize-control-wcz-qv-add-btn-txt' ).hide();
            }
        }

        // Quick View Design
        wcz_qv_popup_design();
        $( '#customize-control-wcz-qv-edit-design input[type=checkbox]' ).on( 'change', function() {
            wcz_qv_popup_design();
        });
        
        function wcz_qv_popup_design() {
            if ( $( '#customize-control-wcz-qv-edit-design input[type=checkbox]' ).is( ':checked' ) ) {
                $( '#sub-accordion-section-wcz-panel-wcz-product-quickview #customize-control-wcz-qv-popup-width' ).show();
                $( '#sub-accordion-section-wcz-panel-wcz-product-quickview #customize-control-wcz-qv-popup-img-size' ).show();
                $( '#sub-accordion-section-wcz-panel-wcz-product-quickview #customize-control-wcz-qv-center-align' ).show();
                $( '#sub-accordion-section-wcz-panel-wcz-product-quickview #customize-control-wcz-qv-edit-overlaycolor' ).show();
                $( '#sub-accordion-section-wcz-panel-wcz-product-quickview #customize-control-wcz-qv-edit-overlayop' ).show();
                $( '#sub-accordion-section-wcz-panel-wcz-product-quickview #customize-control-wcz-qv-edit-bgcolor' ).show();
                $( '#sub-accordion-section-wcz-panel-wcz-product-quickview #customize-control-wcz-qv-edit-fontcolor' ).show();
                $( '#sub-accordion-section-wcz-panel-wcz-product-quickview #customize-control-wcz-qv-remove-border' ).show();
            } else {
                $( '#sub-accordion-section-wcz-panel-wcz-product-quickview #customize-control-wcz-qv-popup-width' ).hide();
                $( '#sub-accordion-section-wcz-panel-wcz-product-quickview #customize-control-wcz-qv-popup-img-size' ).hide();
                $( '#sub-accordion-section-wcz-panel-wcz-product-quickview #customize-control-wcz-qv-center-align' ).hide();
                $( '#sub-accordion-section-wcz-panel-wcz-product-quickview #customize-control-wcz-qv-edit-overlaycolor' ).hide();
                $( '#sub-accordion-section-wcz-panel-wcz-product-quickview #customize-control-wcz-qv-edit-overlayop' ).hide();
                $( '#sub-accordion-section-wcz-panel-wcz-product-quickview #customize-control-wcz-qv-edit-bgcolor' ).hide();
                $( '#sub-accordion-section-wcz-panel-wcz-product-quickview #customize-control-wcz-qv-edit-fontcolor' ).hide();
                $( '#sub-accordion-section-wcz-panel-wcz-product-quickview #customize-control-wcz-qv-remove-border' ).hide();
            }
        }

    });
} )( jQuery );
