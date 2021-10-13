<?php
/*
 * Add Product Quick View Button.
 */
function wcz_pqv_add_quickview_ajax_actions() {
    add_action( 'wp_ajax_wcz_quickview_ajax_product', 'wcz_quickview_ajax_product' );
    add_action( 'wp_ajax_nopriv_wcz_quickview_ajax_product', 'wcz_quickview_ajax_product' );
}
add_filter( 'init', 'wcz_pqv_add_quickview_ajax_actions' );

/**
 * Enqueue WCD Product Quick View scripts.
 */
function wcz_load_frontend_pqv_scripts() {
    wp_enqueue_style( 'wcz-magnific-popup-css', WCD_PLUGIN_URL . "/assets/magnific-popup/css/magnific-popup.css", array(), WCD_PLUGIN_VERSION );
    wp_enqueue_script( 'wcz-magnific-popup-js', WCD_PLUGIN_URL . "/assets/magnific-popup/js/jquery.magnific-popup.min.js", array( 'jquery' ), WCD_PLUGIN_VERSION, true );
    wp_enqueue_style( 'wcz-product-quick-view-css', WCD_PLUGIN_URL . "/assets/css/premium/product-quick-view.css", array( 'wcz-magnific-popup-css' ), WCD_PLUGIN_VERSION );
    
    wp_register_script( 'wcz-product-quick-view-js', WCD_PLUGIN_URL . '/assets/js/premium/product-quick-view.js', array( 'jquery', 'wcz-magnific-popup-js', 'wc-single-product' ), WCD_PLUGIN_VERSION, true );
    wp_localize_script( 'wcz-product-quick-view-js', 'wcz_prodata', array(
        'ajax_url' => admin_url( 'admin-ajax.php' ),
        // 'texts' => $wcz_texts
    ) );
    wp_enqueue_script( 'wcz-product-quick-view-js' );
}
add_action( 'wp_enqueue_scripts', 'wcz_load_frontend_pqv_scripts' );

/**
 * Enqueue WCD Product Quick View customizer scripts.
 */
function wcz_load_customizer_pqv_scripts() {
	wp_enqueue_script( 'wcz-customizer-quickview-js', WCD_PLUGIN_URL . "/includes/customizer/customizer-library/js/premium/customizer-product-quickview.js", array('jquery'), WCD_PLUGIN_VERSION, true );
}
add_action( 'customize_controls_enqueue_scripts', 'wcz_load_customizer_pqv_scripts' );

/*
 * Add Product Quick View Button.
 */
function wcz_pqv_add_quickview_button() {
    // Add Quick View button to products
	if ( get_option( 'wcz-enable-product-quickview', woocustomizer_library_get_default( 'wcz-enable-product-quickview' ) ) ) {
        if ( 'wcz-qv-txt' == get_option( 'wcz-quickview-type', woocustomizer_library_get_default( 'wcz-quickview-type' ) ) ) {
            add_action( 'woocommerce_after_shop_loop_item_title', 'wcz_add_quickview_button' );
        } elseif ( 'wcz-qv-img' == get_option( 'wcz-quickview-type', woocustomizer_library_get_default( 'wcz-quickview-type' ) ) ) {
            add_action( 'woocommerce_before_shop_loop_item_title', 'wcz_add_quickview_button' );
        } else {
            add_action( 'woocommerce_after_shop_loop_item', 'wcz_add_quickview_button' );
        }
        // Footer Modal
        add_action( 'wp_footer', 'wcz_quickview_footer_modal' );
    }
}
add_filter( 'template_redirect', 'wcz_pqv_add_quickview_button' );

// Add Quick View button to products
function wcz_add_quickview_button() {
    $wcz_qv_btntxt = get_option( 'wcz-product-quickview-btntxt', woocustomizer_library_get_default( 'wcz-product-quickview-btntxt' ) );
    $wcz_popup_anim = get_option( 'wcz-quickview-anim', woocustomizer_library_get_default( 'wcz-quickview-anim' ) );
    $wcz_link_btn = get_option( 'wcz-quickview-type', woocustomizer_library_get_default( 'wcz-quickview-type' ) );
    $wcz_link_class = ( 'wcz-qv-btn' == get_option( 'wcz-quickview-type', woocustomizer_library_get_default( 'wcz-quickview-type' ) ) ) ? 'button' : '';
    // global $product;
    // if ( current_user_can('manage_options') ) { ?>
        <div class="<?php echo sanitize_html_class( $wcz_link_btn ); ?>">
            <a href="#wcz-modal" class="<?php echo sanitize_html_class( $wcz_link_class ) ?> wcz-popup-link" data-effect="<?php echo esc_attr( $wcz_popup_anim ); ?> wcz-qv" id="prodid-<?php echo esc_attr( get_the_ID() ); ?>">
                <?php echo esc_html( $wcz_qv_btntxt ); ?>
            </a>
        </div>
    <?php
    // }
}

// Add Footer Modal
function wcz_quickview_footer_modal() {
    $wcz_redirect = get_option( 'wcz-qv-stay-on-shop', woocustomizer_library_get_default( 'wcz-qv-stay-on-shop' ) ) ? 'wcz-to-shop' : 'wcz-to-product';
    echo '<div id="wcz-modal" class="wcz-popup mfp-with-anim mfp-hide"><div class="wcz-popup-inner ' . sanitize_html_class( $wcz_redirect ) . '"></div></div>';
}

// AJAX Get Product Info into WCD Modal
function wcz_quickview_ajax_product() {
    // Get $product ID from ajax
    $product_id = $_POST['product_id'];
    
    ob_start();
        $wcz_args = array(
            'p' => $product_id,
            'post_type' => 'product'
        );
        $wcz_product_query = new WP_Query( $wcz_args ); ?>

        <?php if ( $wcz_product_query->have_posts() ) :  ?>
            <?php while ( $wcz_product_query->have_posts() ) : $wcz_product_query->the_post(); ?>

                <div id="product-<?php the_ID(); ?>" <?php post_class( 'wcz-quickview-product product' ); ?>>

                    <div class="wcz-quickview-product-imgs">

                        <?php 
                        if ( !get_option( 'wcz-qv-remove-sale', woocustomizer_library_get_default( 'wcz-qv-remove-sale' ) ) )
                            woocommerce_show_product_sale_flash(); ?>

                        <?php woocommerce_show_product_images(); ?>
                        
                    </div>

                    <div class="wcz-quickview-product-summary ">

                        <?php
                        if ( !get_option( 'wcz-qv-remove-title', woocustomizer_library_get_default( 'wcz-qv-remove-title' ) ) )
                            woocommerce_template_single_title(); ?>

                        <?php
                        if ( !get_option( 'wcz-qv-remove-rating', woocustomizer_library_get_default( 'wcz-qv-remove-rating' ) ) )
                            woocommerce_template_single_rating(); ?>

                        <?php
                        if ( 'on' == get_option( 'wcz_set_enable_catalogue_mode', woocustomizer_library_get_default( 'wcz_set_enable_catalogue_mode' ) ) && get_option( 'wcz-qv-apply-catmode', woocustomizer_library_get_default( 'wcz-qv-apply-catmode' ) ) ) {
                            
                            if ( 'wcz-cm-edit-selected' == get_option( 'wcz-cm-to-edit', woocustomizer_library_get_default( 'wcz-cm-to-edit' ) ) ) {
                                $wcz_ppcm_applyto = get_option( 'wcz-cm-applyto-items', woocustomizer_library_get_default( 'wcz-cm-applyto-items' ) );
                                $wcz_ppcm_selected = array_map( 'trim', explode( ',', $wcz_ppcm_applyto ) );

                                if ( in_array( $product_id, $wcz_ppcm_selected ) ) {
                                    $wcz_ppcm_user_logged = get_option( 'wcz-cm-apply-notlogged', woocustomizer_library_get_default( 'wcz-cm-apply-notlogged' ) );
                                    $wcz_ppcm_seltxt = get_option( 'wcz-cm-selected-shop-price', woocustomizer_library_get_default( 'wcz-cm-selected-shop-price' ) );
                                    
                                    if ( $wcz_ppcm_user_logged ) {
                                        if ( !is_user_logged_in() && 'wcz-cm-selected-shop-price-edit' == $wcz_ppcm_seltxt ) {
                                            if ( !get_option( 'wcz-qv-remove-price', woocustomizer_library_get_default( 'wcz-qv-remove-price' ) ) )
                                                echo '<p class="price">' . esc_html( get_option( 'wcz-cm-selected-shop-price-txt', woocustomizer_library_get_default( 'wcz-cm-selected-shop-price-txt' ) ) ) . '</p>';
                                        } elseif ( !is_user_logged_in() && 'wcz-cm-selected-shop-price-remove' == $wcz_ppcm_seltxt ) {
                                            // Do Nothing
                                        } else {
                                            if ( !get_option( 'wcz-qv-remove-price', woocustomizer_library_get_default( 'wcz-qv-remove-price' ) ) )
                                                woocommerce_template_single_price();
                                        }
                                    } else {
                                        if ( 'wcz-cm-selected-shop-price-edit' == $wcz_ppcm_seltxt ) {
                                            if ( !get_option( 'wcz-qv-remove-price', woocustomizer_library_get_default( 'wcz-qv-remove-price' ) ) )
                                                echo '<p class="price">' . esc_html( get_option( 'wcz-cm-selected-shop-price-txt', woocustomizer_library_get_default( 'wcz-cm-selected-shop-price-txt' ) ) ) . '</p>';
                                        } elseif ( 'wcz-cm-selected-shop-price-remove' == $wcz_ppcm_seltxt ) {
                                            // Do Nothing
                                        } else {
                                            if ( !get_option( 'wcz-qv-remove-price', woocustomizer_library_get_default( 'wcz-qv-remove-price' ) ) )
                                                woocommerce_template_single_price();
                                        }
                                    }
                                } else {
                                    if ( !get_option( 'wcz-qv-remove-price', woocustomizer_library_get_default( 'wcz-qv-remove-price' ) ) )
                                        woocommerce_template_single_price();
                                }

                            } else {
                                $wcz_ppcm_user_logged = get_option( 'wcz-cm-apply-notlogged', woocustomizer_library_get_default( 'wcz-cm-apply-notlogged' ) );
                                $wcz_ppcm_seltxt = get_option( 'wcz-cm-shop-price', woocustomizer_library_get_default( 'wcz-cm-shop-price' ) );

                                if ( $wcz_ppcm_user_logged ) {
                                    if ( !is_user_logged_in() && 'wcz-cm-shop-price-edit' == $wcz_ppcm_seltxt ) {
                                        if ( !get_option( 'wcz-qv-remove-price', woocustomizer_library_get_default( 'wcz-qv-remove-price' ) ) )
                                            echo '<p class="price">' . esc_html( get_option( 'wcz-cm-shop-price-text', woocustomizer_library_get_default( 'wcz-cm-shop-price-text' ) ) ) . '</p>';
                                    } elseif ( !is_user_logged_in() && 'wcz-cm-shop-price-remove' == $wcz_ppcm_seltxt ) {
                                        // Do Nothing
                                    } else {
                                        if ( !get_option( 'wcz-qv-remove-price', woocustomizer_library_get_default( 'wcz-qv-remove-price' ) ) )
                                            woocommerce_template_single_price();
                                    }
                                } else {
                                    if ( 'wcz-cm-shop-price-edit' == $wcz_ppcm_seltxt ) {
                                        if ( !get_option( 'wcz-qv-remove-price', woocustomizer_library_get_default( 'wcz-qv-remove-price' ) ) )
                                            echo '<p class="price">' . esc_html( get_option( 'wcz-cm-shop-price-text', woocustomizer_library_get_default( 'wcz-cm-shop-price-text' ) ) ) . '</p>';
                                    } elseif ( 'wcz-cm-shop-price-remove' == $wcz_ppcm_seltxt ) {
                                        // Do Nothing
                                    } else {
                                        if ( !get_option( 'wcz-qv-remove-price', woocustomizer_library_get_default( 'wcz-qv-remove-price' ) ) )
                                            woocommerce_template_single_price();
                                    }
                                }
                            }

                        } else {
                            if ( !get_option( 'wcz-qv-remove-price', woocustomizer_library_get_default( 'wcz-qv-remove-price' ) ) )
                                woocommerce_template_single_price();
                        } ?>

                        <?php
                        if ( !get_option( 'wcz-qv-remove-excerpt', woocustomizer_library_get_default( 'wcz-qv-remove-excerpt' ) ) )
                            woocommerce_template_single_excerpt(); ?>
                        
                        <?php if ( get_option( 'wcz-qv-long-desc', woocustomizer_library_get_default( 'wcz-qv-long-desc' ) ) ) : ?>
                            <div class="wcz-quickview-product-cont">
                                <?php
                                // while ( have_posts() ) :
                                    the_content();
                                // endwhile; ?>
                            </div>
                        <?php endif; ?>

                        <?php
                        if ( 'on' == get_option( 'wcz_set_enable_catalogue_mode', woocustomizer_library_get_default( 'wcz_set_enable_catalogue_mode' ) ) && get_option( 'wcz-qv-apply-catmode', woocustomizer_library_get_default( 'wcz-qv-apply-catmode' ) ) ) {

                            if ( get_option( 'wcz-cm-shop-btn', woocustomizer_library_get_default( 'wcz-cm-shop-btn' ) ) ) {
                                // Do Nothing
                            } else {
                                if ( !get_option( 'wcz-qv-remove-addtocart', woocustomizer_library_get_default( 'wcz-qv-remove-addtocart' ) ) )
                                    woocommerce_template_single_add_to_cart();
                            }
                                
                        } else {
                            if ( !get_option( 'wcz-qv-remove-addtocart', woocustomizer_library_get_default( 'wcz-qv-remove-addtocart' ) ) )
                                woocommerce_template_single_add_to_cart();
                        } ?>

                        <?php if ( get_option( 'wcz-qv-add-btn', woocustomizer_library_get_default( 'wcz-qv-add-btn' ) ) ) : ?>
                            <a href="<?php echo esc_url( get_permalink( $product_id ) ); ?>" class="button wcz-qv-btn">
                                <?php echo esc_html( get_option( 'wcz-qv-add-btn-txt', woocustomizer_library_get_default( 'wcz-qv-add-btn-txt' ) ) ); ?>
                            </a>
                        <?php endif; ?>

                        <?php
                        if ( !get_option( 'wcz-qv-remove-meta', woocustomizer_library_get_default( 'wcz-qv-remove-meta' ) ) )
                            woocommerce_template_single_meta(); ?>
                        
                    </div>
                    
                </div>

            <?php endwhile; wp_reset_postdata(); // end of the loop. ?>
        <?php endif;
    echo ob_get_clean();

    die();
}
