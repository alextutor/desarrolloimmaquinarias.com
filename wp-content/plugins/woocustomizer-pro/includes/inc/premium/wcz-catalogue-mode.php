<?php
/**
 * Enqueue WCD Catalogue Mode scripts.
 */
function wcz_load_frontend_cm_scripts() {
    if ( get_option( 'wcz-cm-enable-site-notice', woocustomizer_library_get_default( 'wcz-cm-enable-site-notice' ) ) ) :
        wp_enqueue_style( 'dashicons' );
    endif;
    wp_enqueue_style( 'wcz-customizer-catmode-css', WCD_PLUGIN_URL . "/assets/css/premium/catalogue-mode.css", array(), WCD_PLUGIN_VERSION );
}
add_action( 'wp_enqueue_scripts', 'wcz_load_frontend_cm_scripts' );
/**
 * Enqueue WCD Catalogue Mode customizer styling.
 */
function wcz_load_customizer_cm_scripts() {
	wp_enqueue_script( 'wcz-customizer-catmode-js', WCD_PLUGIN_URL . "/includes/customizer/customizer-library/js/premium/customizer-catalogue-mode.js", array('jquery'), WCD_PLUGIN_VERSION, true );
}
add_action( 'customize_controls_enqueue_scripts', 'wcz_load_customizer_cm_scripts' );

/*
 * Turn on Catalogue Mode.
 */
function wcz_enable_catalogue_mode() {
    $wcz_edit = get_option( 'wcz-cm-to-edit', woocustomizer_library_get_default( 'wcz-cm-to-edit' ) );
    $wcz_user_logged = get_option( 'wcz-cm-apply-notlogged', woocustomizer_library_get_default( 'wcz-cm-apply-notlogged' ) );

    // Hide / Show Cart & Checkout Page
    if ( $wcz_user_logged ) {
        if ( !is_user_logged_in() && get_option( 'wcz-cm-hide-cart-checkout', woocustomizer_library_get_default( 'wcz-cm-hide-cart-checkout' ) ) ) {
            wcz_remove_cart_checkout();
        }
    } else {
        if ( get_option( 'wcz-cm-hide-cart-checkout', woocustomizer_library_get_default( 'wcz-cm-hide-cart-checkout' ) ) ) {
            wcz_remove_cart_checkout();
        }
    }
    // Remove Shop & Product Page buttons
    if ( $wcz_user_logged ) {
        if ( !is_user_logged_in() && 'wcz-cm-edit-all' == $wcz_edit && get_option( 'wcz-cm-shop-btn', woocustomizer_library_get_default( 'wcz-cm-shop-btn' ) ) ) {
            remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart', 10 );
        }
        if ( !is_user_logged_in() && 'wcz-cm-edit-all' == $wcz_edit && get_option( 'wcz-cm-product-btn', woocustomizer_library_get_default( 'wcz-cm-product-btn' ) ) ) {
            remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_add_to_cart', 30 );
        }
    } else {
        if ( 'wcz-cm-edit-all' == $wcz_edit && get_option( 'wcz-cm-shop-btn', woocustomizer_library_get_default( 'wcz-cm-shop-btn' ) ) ) {
            remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart', 10 );
        }
        if ( 'wcz-cm-edit-all' == $wcz_edit && get_option( 'wcz-cm-product-btn', woocustomizer_library_get_default( 'wcz-cm-product-btn' ) ) ) {
            remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_add_to_cart', 30 );
        }
    }
    
    // Remove Checkout & Order buttons if Shop & Product buttons are disabled
    if ( 'wcz-cm-edit-all' == $wcz_edit && get_option( 'wcz-cm-shop-btn', woocustomizer_library_get_default( 'wcz-cm-shop-btn' ) ) && get_option( 'wcz-cm-product-btn', woocustomizer_library_get_default( 'wcz-cm-product-btn' ) ) ) {
        remove_action( 'woocommerce_proceed_to_checkout', 'woocommerce_button_proceed_to_checkout', 20 );
        remove_action( 'woocommerce_checkout_order_review', 'woocommerce_checkout_payment', 20 );
    }
    // Add / Show Product ID's for administrators
	if ( 'wcz-cm-edit-selected' == $wcz_edit && get_option( 'wcz-cm-show-productid', woocustomizer_library_get_default( 'wcz-cm-show-productid' ) ) ) {
		add_action( 'woocommerce_before_shop_loop_item_title', 'wcz_show_productid_adminonly' );
    }
    // Add the Catalogue Site Notice
    if ( get_option( 'wcz-cm-enable-site-notice', woocustomizer_library_get_default( 'wcz-cm-enable-site-notice' ) ) ) {
        add_action( 'wp_body_open', 'wcz_shop_catalogue_notice' );
    }
    // Add filter to edit product price text
    if ( get_option( 'wcz-cm-shop-price', woocustomizer_library_get_default( 'wcz-cm-shop-price' ) ) ||
    get_option( 'wcz-cm-product-price', woocustomizer_library_get_default( 'wcz-cm-product-price' ) ) ||
    get_option( 'wcz-cm-selected-shop-price', woocustomizer_library_get_default( 'wcz-cm-selected-shop-price' ) ) ||
    get_option( 'wcz-cm-selected-product-price', woocustomizer_library_get_default( 'wcz-cm-selected-product-price' ) ) ) {
        add_filter( 'woocommerce_get_price_html', 'wcz_get_price_html', 10, 2 );
    }
}
add_filter( 'template_redirect', 'wcz_enable_catalogue_mode' );

// Show Catalogue Notice
function wcz_shop_catalogue_notice() {
    // wc_print_notice( get_option( 'wcz-cm-notice-txt', woocustomizer_library_get_default( 'wcz-cm-notice-txt' ) ), 'error' );
    echo '<div class="wcz-notice ' . sanitize_html_class( get_option( 'wcz-cm-notice-style', woocustomizer_library_get_default( 'wcz-cm-notice-style' ) ) ) . '">' . esc_html( get_option( 'wcz-cm-notice-txt', woocustomizer_library_get_default( 'wcz-cm-notice-txt' ) ) ) . '</div>';
}

// Edit the Price in different sections
function wcz_get_price_html( $price, $instance ) {
    global $product;

    $wcz_edit = get_option( 'wcz-cm-to-edit', woocustomizer_library_get_default( 'wcz-cm-to-edit' ) );

    $wcz_shop_price = get_option( 'wcz-cm-shop-price', woocustomizer_library_get_default( 'wcz-cm-shop-price' ) );
    $wcz_product_price = get_option( 'wcz-cm-product-price', woocustomizer_library_get_default( 'wcz-cm-product-price' ) );

    $wcz_user_logged = get_option( 'wcz-cm-apply-notlogged', woocustomizer_library_get_default( 'wcz-cm-apply-notlogged' ) );
    
    if ( is_shop() || is_product_category() || is_product_tag() ) {
        
        if ( 'wcz-cm-edit-selected' == $wcz_edit ) {

            $wcz_select_setting = 'wcz-cm-applyto-items';
            $wcz_select_mod = get_option( $wcz_select_setting, woocustomizer_library_get_default( $wcz_select_setting ) );
            $wcz_selected_products = array_map( 'trim', explode( ',', $wcz_select_mod ) );

            if ( in_array( $product->get_id(), $wcz_selected_products ) ) {
                $wcz_select_txt = get_option( 'wcz-cm-selected-shop-price', woocustomizer_library_get_default( 'wcz-cm-selected-shop-price' ) );
                
                if ( $wcz_user_logged ) {
                    if ( !is_user_logged_in() && 'wcz-cm-selected-shop-price-edit' == $wcz_select_txt ) {
                        return esc_html( get_option( 'wcz-cm-selected-shop-price-txt', woocustomizer_library_get_default( 'wcz-cm-selected-shop-price-txt' ) ) );
                    } elseif ( !is_user_logged_in() && 'wcz-cm-selected-shop-price-remove' == $wcz_select_txt ) {
                        return '';
                    } else {
                        return $price;
                    }
                } else {
                    if ( 'wcz-cm-selected-shop-price-edit' == $wcz_select_txt ) {
                        return esc_html( get_option( 'wcz-cm-selected-shop-price-txt', woocustomizer_library_get_default( 'wcz-cm-selected-shop-price-txt' ) ) );
                    } elseif ( 'wcz-cm-selected-shop-price-remove' == $wcz_select_txt ) {
                        return '';
                    } else {
                        return $price;
                    }
                }
            } else {
                return $price;
            }

        } else {

            if ( $wcz_user_logged ) {
                if ( !is_user_logged_in() && 'wcz-cm-shop-price-edit' == $wcz_shop_price ) {
                    return esc_html( get_option( 'wcz-cm-shop-price-text', woocustomizer_library_get_default( 'wcz-cm-shop-price-text' ) ) );
                } elseif ( !is_user_logged_in() && 'wcz-cm-shop-price-remove' == $wcz_shop_price ) {
                    return '';
                } else {
                    return $price;
                }
            } else {
                if ( 'wcz-cm-shop-price-edit' == $wcz_shop_price ) {
                    return esc_html( get_option( 'wcz-cm-shop-price-text', woocustomizer_library_get_default( 'wcz-cm-shop-price-text' ) ) );
                } elseif ( 'wcz-cm-shop-price-remove' == $wcz_shop_price ) {
                    return '';
                } else {
                    return $price;
                }
            }

        }
    } elseif ( is_product() ) {
        global $woocommerce_loop;
        
        if ( 'wcz-cm-edit-selected' == $wcz_edit ) {

            $wcz_select_setting = 'wcz-cm-applyto-items';
            $wcz_select_mod = get_option( $wcz_select_setting, woocustomizer_library_get_default( $wcz_select_setting ) );
            $wcz_selected_products = array_map( 'trim', explode( ',', $wcz_select_mod ) );

            if ( in_array( $product->get_id(), $wcz_selected_products ) ) {
                $wcz_select_txt = get_option( 'wcz-cm-selected-product-price', woocustomizer_library_get_default( 'wcz-cm-selected-product-price' ) );

                if ( $wcz_user_logged ) {
                    if ( !is_user_logged_in() && 'wcz-cm-selected-product-price-edit' == $wcz_select_txt ) {
                        return esc_html( get_option( 'wcz-cm-selected-product-price-txt', woocustomizer_library_get_default( 'wcz-cm-selected-product-price-txt' ) ) );
                    } elseif ( !is_user_logged_in() && 'wcz-cm-selected-product-price-remove' == $wcz_select_txt ) {
                        return '';
                    } else {
                        return $price;
                    }
                } else {
                    if ( 'wcz-cm-selected-product-price-edit' == $wcz_select_txt ) {
                        return esc_html( get_option( 'wcz-cm-selected-product-price-txt', woocustomizer_library_get_default( 'wcz-cm-selected-product-price-txt' ) ) );
                    } elseif ( 'wcz-cm-selected-product-price-remove' == $wcz_select_txt ) {
                        return '';
                    } else {
                        return $price;
                    }
                }
            } else {
                return $price;
            }

        } else {

            if ( $woocommerce_loop['name'] == 'related' || $woocommerce_loop['name'] == 'up-sells' ) {
                if ( $wcz_user_logged ) {
                    if ( !is_user_logged_in() && 'wcz-cm-shop-price-edit' == $wcz_shop_price ) {
                        return esc_html( get_option( 'wcz-cm-shop-price-text', woocustomizer_library_get_default( 'wcz-cm-shop-price-text' ) ) );
                    } elseif ( !is_user_logged_in() && 'wcz-cm-shop-price-remove' == $wcz_shop_price ) {
                        return '';
                    } else {
                        return $price;
                    }
                } else {
                    if ( 'wcz-cm-shop-price-edit' == $wcz_shop_price ) {
                        return esc_html( get_option( 'wcz-cm-shop-price-text', woocustomizer_library_get_default( 'wcz-cm-shop-price-text' ) ) );
                    } elseif ( 'wcz-cm-shop-price-remove' == $wcz_shop_price ) {
                        return '';
                    } else {
                        return $price;
                    }
                }
            } else {
                if ( $wcz_user_logged ) {
                    if ( !is_user_logged_in() && 'wcz-cm-product-price-edit' == $wcz_product_price ) {
                        return esc_html( get_option( 'wcz-cm-product-price-text', woocustomizer_library_get_default( 'wcz-cm-product-price-text' ) ) );
                    } elseif ( !is_user_logged_in() && 'wcz-cm-product-price-remove' == $wcz_product_price ) {
                        return '';
                    } else {
                        return $price;
                    }
                } else {
                    if ( 'wcz-cm-product-price-edit' == $wcz_product_price ) {
                        return esc_html( get_option( 'wcz-cm-product-price-text', woocustomizer_library_get_default( 'wcz-cm-product-price-text' ) ) );
                    } elseif ( 'wcz-cm-product-price-remove' == $wcz_product_price ) {
                        return '';
                    } else {
                        return $price;
                    }
                }
            }
        }

    } else {
        return $price;
    }
}

// Add / Show Product ID's for administrators
function wcz_show_productid_adminonly() {
    if ( current_user_can('manage_options') ) {
        echo '<span class="wcz-product-id">' . esc_html__( 'Product ID: ', 'woocustomizer' ) . '<b>' . esc_attr( get_the_ID() ) . '</b></span>';
    }
}

// Hide Cart & Checkout Page
function wcz_remove_cart_checkout() {
    if ( is_cart() || is_checkout() ) {
        wp_redirect( home_url() );
        exit;
    }
}
