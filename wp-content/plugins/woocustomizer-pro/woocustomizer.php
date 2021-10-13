<?php

/**
 * Plugin Name: StoreCustomizer Pro
 * Version: 2.2.1
 * Plugin URI: https://kairaweb.com/wordpress-plugins/woocustomizer/
 * Description: Customize WooCommerce without code... StoreCustomizer has all the WooCommerce hooks & lots more store enhancing features built into this WooCommerce customizer plugin, to further edit your WooCommerce Shop and Product pages, Cart, Checkout and User Account store pages.
 * Author: Kaira
 * Author URI: https://kairaweb.com/
 * Requires at least: 5.0
 * Tested up to: 5.5
 * WC requires at least: 3.2
 * WC tested up to: 4.6.1
 * Text Domain: woocustomizer
 * Domain Path: /lang/
 * 
 * @fs_premium_only /includes/inc/premium/, /includes/customizer/customizer-library/js/premium/, /assets/css/premium/, /assets/js/premium/, /assets/font-awesome/, /assets/magnific-popup/
 *
 * @package WordPress
 * @author Kaira
 * @since 1.0.0
 */
define( 'WCD_PLUGIN_VERSION', '2.2.1' );
define( 'WCD_PLUGIN_URL', plugins_url( '', __FILE__ ) );
if ( !defined( 'ABSPATH' ) ) {
    exit;
}

if ( function_exists( 'wcz_fs' ) ) {
    wcz_fs()->set_basename( true, __FILE__ );
} else {
    
    if ( !function_exists( 'wcz_fs' ) ) {
        // Create a helper function for easy SDK access.
        function wcz_fs()
        {
            global  $wcz_fs ;
            
            if ( !isset( $wcz_fs ) ) {
                // Include Freemius SDK.
                require_once dirname( __FILE__ ) . '/freemius/start.php';
                $wcz_fs = fs_dynamic_init( array(
                    'id'              => '4668',
                    'slug'            => 'woocustomizer',
                    'premium_slug'    => 'woocustomizer-pro',
                    'type'            => 'plugin',
                    'public_key'      => 'pk_b12a9cb6205ed1d8256a177af56b4',
                    'is_premium'      => true,
                    'premium_suffix'  => 'Pro',
                    'has_addons'      => false,
                    'has_paid_plans'  => true,
                    'trial'           => array(
                    'days'               => 14,
                    'is_require_payment' => true,
                ),
                    'has_affiliation' => 'selected',
                    'menu'            => array(
                    'slug'        => 'wcz_settings',
                    'contact'     => false,
                    'support'     => false,
                    'affiliation' => true,
                    'parent'      => array(
                    'slug' => 'woocommerce',
                ),
                ),
                    'is_live'         => true,
                ) );
            }
            
            return $wcz_fs;
        }
        
        // Init Freemius.
        wcz_fs();
        // Signal that SDK was initiated.
        do_action( 'wcz_fs_loaded' );
    }
    
    // Load plugin class files.
    require_once 'includes/class-wcz.php';
    require_once 'includes/class-wcz-settings.php';
    // Load plugin libraries.
    require_once 'includes/lib/class-wcz-admin-api.php';
    require_once 'includes/lib/class-wcz-post-type.php';
    require_once 'includes/lib/class-wcz-taxonomy.php';
    // Load Customizer Library files.
    require_once 'includes/customizer/customizer-options.php';
    require_once 'includes/customizer/customizer-library/customizer-library.php';
    require_once 'includes/customizer/styles.php';
    // require_once 'includes/customizer/mods.php';
    if ( WooCustomizer::wcz_is_plugin_active( 'woocommerce.php' ) ) {
        require_once 'includes/inc/woocommerce.php';
    }
    // Excluded from Pro Version
    
    if ( wcz_fs()->can_use_premium_code__premium_only() ) {
        if ( WooCustomizer::wcz_is_plugin_active( 'woocommerce.php' ) && 'on' == get_option( 'wcz_set_enable_handheld_footerbar', woocustomizer_library_get_default( 'wcz_set_enable_handheld_footerbar' ) ) ) {
            require_once 'includes/inc/premium/wcz-handheld-footer.php';
        }
        if ( WooCustomizer::wcz_is_plugin_active( 'woocommerce.php' ) && 'on' == get_option( 'wcz_set_enable_catalogue_mode', woocustomizer_library_get_default( 'wcz_set_enable_catalogue_mode' ) ) ) {
            require_once 'includes/inc/premium/wcz-catalogue-mode.php';
        }
        // if ( WooCustomizer::wcz_is_plugin_active( 'woocommerce.php' ) && 'on' == get_option( 'wcz_set_enable_product_badges', woocustomizer_library_get_default( 'wcz_set_enable_product_badges' ) ) ) {
        //     require_once 'includes/inc/premium/wcz-product-badges.php';
        // }
        if ( WooCustomizer::wcz_is_plugin_active( 'woocommerce.php' ) && 'on' == get_option( 'wcz_set_enable_menu_cart', woocustomizer_library_get_default( 'wcz_set_enable_menu_cart' ) ) ) {
            require_once 'includes/inc/premium/wcz-menu-cart.php';
        }
        if ( WooCustomizer::wcz_is_plugin_active( 'woocommerce.php' ) && 'on' == get_option( 'wcz_set_enable_product_quickview', woocustomizer_library_get_default( 'wcz_set_enable_product_quickview' ) ) ) {
            require_once 'includes/inc/premium/wcz-product-quickview.php';
        }
        if ( WooCustomizer::wcz_is_plugin_active( 'woocommerce.php' ) && 'on' == get_option( 'wcz_set_enable_ajax_search', woocustomizer_library_get_default( 'wcz_set_enable_ajax_search' ) ) ) {
            require_once 'includes/inc/premium/wcz-ajax-search.php';
        }
        if ( WooCustomizer::wcz_is_plugin_active( 'woocommerce.php' ) && 'on' == get_option( 'wcz_set_enable_cthank_you', woocustomizer_library_get_default( 'wcz_set_enable_cthank_you' ) ) ) {
            require_once 'includes/inc/premium/wcz-thank-you-pages.php';
        }
    }
    
    // Excluded from Pro Version
    
    if ( !WooCustomizer::wcz_is_plugin_active( 'woocommerce.php' ) ) {
        // Admin notice for if WooCommerce is not active
        function wcz_no_woocommerce_notice()
        {
            ?>
            <div class="error">
                <p><?php 
            esc_html_e( 'StoreCustomizer requires the WooCommerce plugin to be active to work', 'woocustomizer' );
            ?></p>
            </div>
        <?php 
        }
        
        add_action( 'admin_notices', 'wcz_no_woocommerce_notice' );
        return;
    }
    
    /**
     * Returns the main instance of WooCustomizer to prevent the need to use globals.
     *
     * @since  1.0.0
     * @return object WooCustomizer
     */
    function woocustomizer()
    {
        $instance = WooCustomizer::instance( __FILE__, WCD_PLUGIN_VERSION );
        if ( is_null( $instance->settings ) ) {
            $instance->settings = WooCustomizer_Settings::instance( $instance );
        }
        return $instance;
    }
    
    woocustomizer();
}
