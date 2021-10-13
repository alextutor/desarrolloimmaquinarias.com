<?php
/**
 * Enqueue WCD Custom Thank You Pages styling.
 */
function wcz_load_frontend_ctp_scripts() {
    wp_enqueue_style( 'wcz-thank-you-pages', WCD_PLUGIN_URL . "/assets/css/premium/thank-you-pages.css", array(), WCD_PLUGIN_VERSION );
}
add_action( 'wp_enqueue_scripts', 'wcz_load_frontend_ctp_scripts' );

/**
 * Custom Thank You Pages Per Product.
 */
function wcz_add_thankyou_page_tab( $tabs ) {
    // Only continue IF Product Level Pages option is selected on WCZ Settings Page
    if ( get_option( 'wcz_set_enable_cthank_you', woocustomizer_library_get_default( 'wcz_set_enable_cthank_you' ) ) && 'wcz_ctp_type_product_level' == get_option( 'wcz_set_ctp_type', woocustomizer_library_get_default( 'wcz_set_ctp_type' ) ) ) {
 
        $tabs['wcz_ctp_tab'] = array(
            'label'    => 'Custom Thank You Page',
            'target'   => 'wcz_ctp_product_data',
            // 'class'    => array( 'show_if_simple' ),
            // 'priority' => 21,
        );
    }
    return $tabs;
}
add_filter( 'woocommerce_product_data_tabs', 'wcz_add_thankyou_page_tab' );

/*
 * Custom Thank You Page Product Tab Settings.
 */
function wcz_ctp_product_settings() {

    // Only continue IF Custom Thank You Pages is enabled on WCZ Settings Page
    if ( ! get_option( 'wcz_set_enable_cthank_you', woocustomizer_library_get_default( 'wcz_set_enable_cthank_you' ) ) )
        return;

    // Only continue IF Product Level Pages option is selected on WCZ Settings Page
    if ( 'wcz_ctp_type_product_level' == get_option( 'wcz_set_ctp_type', woocustomizer_library_get_default( 'wcz_set_ctp_type' ) ) ) {
 
        echo '<div id="wcz_ctp_product_data" class="panel woocommerce_options_panel hidden">';
        
        // Get Pages
        $wcz_pages = get_pages(
            array (
                'parent'  => 0, // replaces 'depth' => 1,
                'exclude' => ''
            )
        );
        $wcz_page_ids = wp_list_pluck( $wcz_pages, 'ID' );
        $wcz_pages_list = array( 'pid-default' => 'Please Select' );

        foreach ( $wcz_page_ids as $wcz_page_id => $wcz_page_title ) {
            $wcz_pages_list['pid-' . $wcz_page_title] = get_the_title( $wcz_page_title );
        }
        // Remove Pages to select
        unset( $wcz_pages_list['pid-' . get_option( 'page_on_front' )] ); // Home
        unset( $wcz_pages_list['pid-' . get_option( 'page_for_posts' )] ); // Blog
        // WooCommerce Pages
        unset( $wcz_pages_list['pid-' . wc_get_page_id( 'myaccount' )] );
        unset( $wcz_pages_list['pid-' . wc_get_page_id( 'shop' )] );
        unset( $wcz_pages_list['pid-' . wc_get_page_id( 'cart' )] );
        unset( $wcz_pages_list['pid-' . wc_get_page_id( 'checkout' )] );

        woocommerce_wp_select( array(
            'id'          => 'wcz_ctp_set_page',
            'value'       => get_post_meta( get_the_ID(), 'wcz_ctp_set_page', true ),
            'label'       => __( 'Page', 'woocustomizer' ),
            'options'     => $wcz_pages_list,
            'desc_tip'    => true,
            'description' => __( 'Select the page you would like to redirect the user to after purchasing this product.', 'woocustomizer' ),
        ) );
        
        woocommerce_wp_text_input( array(
            'id'          => 'wcz_ctp_set_priority',
            'value'       => get_post_meta( get_the_ID(), 'wcz_ctp_set_priority', true ) ? get_post_meta( get_the_ID(), 'wcz_ctp_set_priority', true ) : 0,
            'type'        => 'number',
            'label'       => __( 'Priority', 'woocustomizer' ),
            'desc_tip'    => true,
            'description' => __( 'The higher the number, highter the priority.', 'woocustomizer' ),
            'default' => 0
        ) );
    
        echo '</div>';

    }
 
}
add_action( 'woocommerce_product_data_panels', 'wcz_ctp_product_settings' );

/*
 * Save Product Tab Settings.
 */
function wcz_ctp_save_data( $id, $post ){

    // Only continue IF Product Level Pages option is selected on WCZ Settings Page
    if ( get_option( 'wcz_set_enable_cthank_you', woocustomizer_library_get_default( 'wcz_set_enable_cthank_you' ) ) && 'wcz_ctp_type_product_level' == get_option( 'wcz_set_ctp_type', woocustomizer_library_get_default( 'wcz_set_ctp_type' ) ) ) {

        update_post_meta( $id, 'wcz_ctp_set_page', $_POST['wcz_ctp_set_page'] );

        if ( ( 'pid-default' === $_POST['wcz_ctp_set_page'] || 'default' === $_POST['wcz_ctp_set_page'] ) && get_post_meta( $id, 'wcz_ctp_set_priority', true ) >= intval( 1 ) ) {
            update_post_meta( $id, 'wcz_ctp_set_priority', intval( 0 ) );
        } elseif ( ( 'pid-default' !== $_POST['wcz_ctp_set_page'] || 'default' !== $_POST['wcz_ctp_set_page'] ) && get_post_meta( $id, 'wcz_ctp_set_priority', true ) == intval( 0 ) ) {
            if ( get_post_meta( $id, 'wcz_ctp_set_page', true ) != 'pid-default' ) {
                update_post_meta( $id, 'wcz_ctp_set_priority', intval( 1 ) );
            }
        } else {
            update_post_meta( $id, 'wcz_ctp_set_priority', intval( $_POST['wcz_ctp_set_priority'] ) );
        }

    }
 
}
add_action( 'woocommerce_process_product_meta', 'wcz_ctp_save_data', 10, 2 );

/*
 * Add Custom Settings To Payment Tab in WooCommerce Settings.
 */
function wcz_add_payment_gateway_settings_ctp( $settings ) {

    // Only continue IF Custom Thank You Pages is enabled on WCZ Settings Page
    if ( ! get_option( 'wcz_set_enable_cthank_you', woocustomizer_library_get_default( 'wcz_set_enable_cthank_you' ) ) )
        return;

    // Only continue IF Payment Gateways option is selected on WCZ Settings Page
    if ( 'wcz_ctp_type_payment_type' == get_option( 'wcz_set_ctp_type', woocustomizer_library_get_default( 'wcz_set_ctp_type' ) ) ) {

        $updated_settings = array();
    
        foreach ( $settings as $section ) {
    
            // Add to bottom of the Payment section
            if ( isset( $section['type'] ) && 'sectionend' == $section['type'] ) { // Add to Settings Section End
                    

                // Get Pages
                $wcz_pages = get_pages(
                    array (
                        'parent'  => 0, // replaces 'depth' => 1,
                        'exclude' => ''
                    )
                );
                $wcz_page_ids = wp_list_pluck( $wcz_pages, 'ID' );
                $wcz_pages_list = array( 'pid-default' => 'Please Select' );

                foreach ( $wcz_page_ids as $wcz_page_id => $wcz_page_title ) {
                    $wcz_pages_list['pid-' . $wcz_page_title] = get_the_title( $wcz_page_title );
                }
                // Remove Pages to select
                unset( $wcz_pages_list['pid-' . get_option( 'page_on_front' )] ); // Home
                unset( $wcz_pages_list['pid-' . get_option( 'page_for_posts' )] ); // Blog
                // WooCommerce Pages
                unset( $wcz_pages_list['pid-' . wc_get_page_id( 'myaccount' )] );
                unset( $wcz_pages_list['pid-' . wc_get_page_id( 'shop' )] );
                unset( $wcz_pages_list['pid-' . wc_get_page_id( 'cart' )] );
                unset( $wcz_pages_list['pid-' . wc_get_page_id( 'checkout' )] );
                
                $gateways = WC()->payment_gateways->get_available_payment_gateways(); // Get Available WC Gateways
                $enabled_gateways = [];

                // Add a Title For the StoreCustomizer Pages
                $updated_settings[] = array(
                    'name'     => __( 'StoreCustomizer Custom Thank You Pages', 'woocustomizer' ),
                    'id'       => 'wcz_payment_gateway_title',
                    'type'     => 'checkbox',
                    'class'    => 'title'
                );
                if ( $gateways ) {
                    // Add a Select Option for each Enabled Gateway
                    foreach ( $gateways as $gateway ) {
                        if ( $gateway->enabled == 'yes' ) {
                            $updated_settings[] = array(
                                'name'     => $gateway->title,
                                // 'desc_tip' => __( 'ToolTip Text', 'woocustomizer' ),
                                'id'       => 'wcz_payment_gateway_' . $gateway->id,
                                'type'     => 'select',
                                'options'  => $wcz_pages_list,
                                'default'  => 'pid-default',
                            );
                        }
                    }
                }
                
            }
        
            $updated_settings[] = $section;
        }

        // Return Updated WC Settings with Gateway Options
        return $updated_settings;

    } else {

        // Return Normal WC Settings
        return $settings;

    }

}
add_filter( 'woocommerce_payment_gateways_settings', 'wcz_add_payment_gateway_settings_ctp' );

/*
 * Redirect the user after purchase.
 */
function wcz_redirect_user_to_page( $order_id ){
    $wcz_default_id = substr( get_option( 'wcz_set_ctp_default_page', woocustomizer_library_get_default( 'wcz_set_ctp_default_page' ) ), 4 );
    // Get Order & Order Info
    $wcz_order = wc_get_order( $order_id );
    
    // IF Pages Type is set to Product Level Custom Thank You Pages on WCZ Settings Page
    if ( 'wcz_ctp_type_product_level' == get_option( 'wcz_set_ctp_type', woocustomizer_library_get_default( 'wcz_set_ctp_type' ) ) ) {

        // Get products & create a new empty array
        $wcz_items = $wcz_order->get_items();
        $wcz_productids_arr = [];

        // Get product priority & product ids and add to $wcz_productids_arr array
        foreach ( $wcz_items as $wcz_item_id => $wcz_item ) {
            $product_id = $wcz_item->get_product_id();
            $product_priority = get_post_meta( $product_id, 'wcz_ctp_set_priority', true );

            $wcz_productids_arr[$product_id] = $product_priority != 0 ? intval( $product_priority ) : intval( 0 ); // Set priority to 0 if not set
            // var_dump( $wcz_item->get_name() . ' - ' . intval( $product_priority ) ); // Checking the saved values
        }
        
        // Sort array high to low and get first product key
        $wcz_productids_arr = array_filter( $wcz_productids_arr );
        if ( !empty( $wcz_productids_arr ) ) {
            arsort( $wcz_productids_arr );
            $wcz_highpriority_pid = key( $wcz_productids_arr );

            // Page ID
            $wcz_default_id = substr( get_post_meta( $wcz_highpriority_pid, 'wcz_ctp_set_page', true ), 4 );
        }

    } elseif ( 'wcz_ctp_type_payment_type' == get_option( 'wcz_set_ctp_type', woocustomizer_library_get_default( 'wcz_set_ctp_type' ) ) ) {
        // IF Pages Type is set to Payment Options Type Custom Thank You Pages on WCZ Settings Page
        
        $wcz_gateways = WC()->payment_gateways->get_available_payment_gateways(); // Get Available WC Gateways
        $wcz_types = [];

        // Get available Payment Gateways create get_option() value
        if ( $wcz_gateways ) {
            foreach ( $wcz_gateways as $wcz_gateways_name => $wcz_gateway ) {
                $wcz_pgmeta = 'wcz_payment_gateway_' . $wcz_gateway->id;

                $wcz_types[$wcz_gateways_name] = substr( get_option( $wcz_pgmeta, woocustomizer_library_get_default( $wcz_pgmeta ) ), 4 );
            }
        }

        $wcz_checkey = strval( $wcz_order->get_payment_method() ); // Payment Gateway used - id/value

        // Get corresponding value from get_option() value created above
        $wcz_gate_id = isset( $wcz_types[$wcz_checkey] ) ? $wcz_types[$wcz_checkey] : null;

        // Page ID
        $wcz_default_id = $wcz_gate_id;

    } else {
        // Just use the default page set on WCZ Settings Page
        $wcz_default_id = $wcz_default_id;
    }

    if ( 'pid-default' == $wcz_default_id || 'default' == $wcz_default_id )
        return;

    $wcz_redirect = get_page_link( $wcz_default_id );

    if ( ! $wcz_order->has_status( 'failed' ) ) {
        wp_safe_redirect( $wcz_redirect . '?orderid=' . esc_attr( $order_id ) . '&key=' . esc_attr( $wcz_order->get_order_key() ) );
        exit;
    }

}
add_action( 'woocommerce_thankyou', 'wcz_redirect_user_to_page' );

/*
 * Create ORDER SUMMARY Shortcode.
 */
function wcz_ctp_shortcode_order_summary( $atts ) {
    extract( shortcode_atts( array(
        'order_id' => !empty( $_GET['orderid'] ) ? $_GET['orderid'] : 0,
        'order_key' => !empty( $_GET['key'] ) ? $_GET['key'] : 0,
    ), $atts ) );
	
	if ( !$order_id ) {
		$wcz_url = "$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
		$wcz_url_oi = explode( "/", $wcz_url );
		$order_id = $wcz_url_oi[ count( $wcz_url_oi ) - 2 ];
	}

    $order_id_by_key = wc_get_order_id_by_order_key( $order_key );

    if ( $order_id_by_key === $order_id ) :

        $wcz_order = wc_get_order( $order_id );
        
        ob_start(); ?>
            <div class="wcz-order-summary-block">
                <?php if ( $wcz_order->has_status( 'failed' ) ) : ?>

                    <p class="woocommerce-notice woocommerce-notice--error woocommerce-thankyou-order-failed"><?php esc_html_e( 'Unfortunately your order cannot be processed as the originating bank/merchant has declined your transaction. Please attempt your purchase again.', 'woocustomizer' ); ?></p>

                    <p class="woocommerce-notice woocommerce-notice--error woocommerce-thankyou-order-failed-actions">
                        <a href="<?php echo esc_url( $wcz_order->get_checkout_payment_url() ); ?>" class="button pay"><?php esc_html_e( 'Pay', 'woocustomizer' ); ?></a>
                        <?php if ( is_user_logged_in() ) : ?>
                            <a href="<?php echo esc_url( wc_get_page_permalink( 'myaccount' ) ); ?>" class="button pay"><?php esc_html_e( 'My account', 'woocustomizer' ); ?></a>
                        <?php endif; ?>
                    </p>

                <?php else : ?>

                    <p class="woocommerce-notice woocommerce-notice--success woocommerce-thankyou-order-received"><?php echo apply_filters( 'woocommerce_thankyou_order_received_text', esc_html__( 'Thank you. Your order has been received.', 'woocustomizer' ), $wcz_order ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></p>

                    <ul class="woocommerce-order-overview woocommerce-thankyou-order-details order_details">

                        <li class="woocommerce-order-overview__order order">
                            <?php esc_html_e( 'Order number:', 'woocustomizer' ); ?>
                            <strong><?php echo $wcz_order->get_order_number(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></strong>
                        </li>

                        <li class="woocommerce-order-overview__date date">
                            <?php esc_html_e( 'Date:', 'woocustomizer' ); ?>
                            <strong><?php echo wc_format_datetime( $wcz_order->get_date_created() ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></strong>
                        </li>

                        <?php if ( is_user_logged_in() && $wcz_order->get_user_id() === get_current_user_id() && $wcz_order->get_billing_email() ) : ?>
                            <li class="woocommerce-order-overview__email email">
                                <?php esc_html_e( 'Email:', 'woocustomizer' ); ?>
                                <strong><?php echo $wcz_order->get_billing_email(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></strong>
                            </li>
                        <?php endif; ?>

                        <li class="woocommerce-order-overview__total total">
                            <?php esc_html_e( 'Total:', 'woocustomizer' ); ?>
                            <strong><?php echo $wcz_order->get_formatted_order_total(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></strong>
                        </li>

                        <?php if ( $wcz_order->get_payment_method_title() ) : ?>
                            <li class="woocommerce-order-overview__payment-method method">
                                <?php esc_html_e( 'Payment method:', 'woocustomizer' ); ?>
                                <strong><?php echo wp_kses_post( $wcz_order->get_payment_method_title() ); ?></strong>
                            </li>
                        <?php endif; ?>

                    </ul>

                <?php endif; ?>

                <?php
                if ( 'bacs' == $wcz_order->get_payment_method() ) :

                    $bacs_accounts = get_option( 'woocommerce_bacs_accounts');

                    if ( ! empty( $bacs_accounts ) ) {
                        $account_html = '';
                        $has_details  = false;
            
                        foreach ( $bacs_accounts as $bacs_account ) {
                            $bacs_account = (object) $bacs_account;
            
                            if ( $bacs_account->account_name ) {
                                $account_html .= '<h3 class="wc-bacs-bank-details-account-name">' . wp_kses_post( wp_unslash( $bacs_account->account_name ) ) . ':</h3>' . PHP_EOL;
                            }
            
                            $account_html .= '<ul class="wc-bacs-bank-details order_details bacs_details">' . PHP_EOL;
            
                            // BACS account fields shown on the thanks page and in emails.
                            $account_fields = apply_filters(
                                'woocommerce_bacs_account_fields',
                                array(
                                    'bank_name'      => array(
                                        'label' => __( 'Bank', 'woocustomizer' ),
                                        'value' => $bacs_account->bank_name,
                                    ),
                                    'account_number' => array(
                                        'label' => __( 'Account number', 'woocustomizer' ),
                                        'value' => $bacs_account->account_number,
                                    ),
                                    'sort_code'      => array(
                                        'label' => __( 'Branch Code', 'woocommerce' ),
                                        'value' => $bacs_account->sort_code,
                                    ),
                                    'iban'           => array(
                                        'label' => __( 'IBAN', 'woocustomizer' ),
                                        'value' => $bacs_account->iban,
                                    ),
                                    'bic'            => array(
                                        'label' => __( 'BIC', 'woocustomizer' ),
                                        'value' => $bacs_account->bic,
                                    ),
                                ),
                                $order_id
                            );
            
                            foreach ( $account_fields as $field_key => $field ) {
                                if ( ! empty( $field['value'] ) ) {
                                    $account_html .= '<li class="' . esc_attr( $field_key ) . '">' . wp_kses_post( $field['label'] ) . ': <strong>' . wp_kses_post( wptexturize( $field['value'] ) ) . '</strong></li>' . PHP_EOL;
                                    $has_details   = true;
                                }
                            }
            
                            $account_html .= '</ul>';
                        }
            
                        if ( $has_details ) {
                            echo '<section class="woocommerce-bacs-bank-details"><h2 class="wc-bacs-bank-details-heading">' . esc_html__( 'Our bank details', 'woocustomizer' ) . '</h2>' . wp_kses_post( PHP_EOL . $account_html ) . '</section>';
                        }
                    }

                endif; ?>
                
            </div><?php
        return ob_get_clean();

    else :

        ob_start(); ?>
            <div class="wcz-ctp-nomatch">
                <?php
                /* translators: 1: 'go to your account'. */
                printf( esc_html__( 'For some reason your order key does not match your order number. Please %1$s and check again.', 'woocustomizer' ), wp_kses( __( '<a href="' . get_permalink( wc_get_page_id( 'myaccount' ) ) . '/orders/">view your account orders</a>', 'woocustomizer' ), array( 'a' => array( 'href' => array() ) ) ) ); ?>
            </div><?php
        return ob_get_clean();

    endif;
}
add_shortcode( 'wcz_order_summary', 'wcz_ctp_shortcode_order_summary' );

/*
 * Create ORDER DETAILS Shortcode.
 */
function wcz_ctp_shortcode_order_details( $atts ) {
    extract( shortcode_atts( array(
        'order_id' => !empty( $_GET['orderid'] ) ? $_GET['orderid'] : 0,
        'order_key' => !empty( $_GET['key'] ) ? $_GET['key'] : 0,
    ), $atts ) );

    if ( !$order_id ) {
		$wcz_url = "$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
		$wcz_url_oi = explode( "/", $wcz_url );
		$order_id = $wcz_url_oi[ count( $wcz_url_oi ) - 2 ];
	}

    $order_id_by_key = wc_get_order_id_by_order_key( $order_key );

    if ( $order_id_by_key === $order_id ) :

        $wcz_order = wc_get_order( $order_id );

        $order_items           = $wcz_order->get_items( apply_filters( 'woocommerce_purchase_order_item_types', 'line_item' ) );
        $show_purchase_note    = $wcz_order->has_status( apply_filters( 'woocommerce_purchase_note_order_statuses', array( 'completed', 'processing' ) ) );
        $show_customer_details = is_user_logged_in() && $wcz_order->get_user_id() === get_current_user_id();
        $downloads             = $wcz_order->get_downloadable_items();
        $show_downloads        = $wcz_order->has_downloadable_item() && $wcz_order->is_download_permitted();
    
        ob_start(); ?>
            <div class="wcz-order-details-block">
                <?php
                if ( $show_downloads ) {
                    wc_get_template(
                        'order/order-downloads.php',
                        array(
                            'downloads'  => $downloads,
                            'show_title' => true,
                        )
                    );
                } ?>
                <section class="woocommerce-order-details">
                    <?php do_action( 'woocommerce_order_details_before_order_table', $wcz_order ); ?>
                
                    <h2 class="woocommerce-order-details__title"><?php esc_html_e( 'Order details', 'woocustomizer' ); ?></h2>
                
                    <table class="woocommerce-table woocommerce-table--order-details shop_table order_details">
                
                        <thead>
                            <tr>
                                <th class="woocommerce-table__product-name product-name"><?php esc_html_e( 'Product', 'woocustomizer' ); ?></th>
                                <th class="woocommerce-table__product-table product-total"><?php esc_html_e( 'Total', 'woocustomizer' ); ?></th>
                            </tr>
                        </thead>
                
                        <tbody>
                            <?php
                            do_action( 'woocommerce_order_details_before_order_table_items', $wcz_order );
                
                            foreach ( $order_items as $item_id => $item ) {
                                $product = $item->get_product();
                
                                wc_get_template(
                                    'order/order-details-item.php',
                                    array(
                                        'order'              => $wcz_order,
                                        'item_id'            => $item_id,
                                        'item'               => $item,
                                        'show_purchase_note' => $show_purchase_note,
                                        'purchase_note'      => $product ? $product->get_purchase_note() : '',
                                        'product'            => $product,
                                    )
                                );
                            }
                
                            do_action( 'woocommerce_order_details_after_order_table_items', $wcz_order );
                            ?>
                        </tbody>
                
                        <tfoot>
                            <?php
                            foreach ( $wcz_order->get_order_item_totals() as $key => $total ) {
                                ?>
                                    <tr>
                                        <th scope="row"><?php echo esc_html( $total['label'] ); ?></th>
                                        <td><?php echo ( 'payment_method' === $key ) ? esc_html( $total['value'] ) : wp_kses_post( $total['value'] ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></td>
                                    </tr>
                                    <?php
                            }
                            ?>
                            <?php if ( $wcz_order->get_customer_note() ) : ?>
                                <tr>
                                    <th><?php esc_html_e( 'Note:', 'woocustomizer' ); ?></th>
                                    <td><?php echo wp_kses_post( nl2br( wptexturize( $wcz_order->get_customer_note() ) ) ); ?></td>
                                </tr>
                            <?php endif; ?>
                        </tfoot>
                    </table>
                
                    <?php do_action( 'woocommerce_order_details_after_order_table', $wcz_order ); ?>
                </section>
            </div><?php
        return ob_get_clean();

    else :

        ob_start(); ?>
            <div class="wcz-ctp-nomatch">
                <?php
                /* translators: 1: 'go to your account'. */
                printf( esc_html__( 'For some reason your order key does not match your order number. Please %1$s and check again.', 'woocustomizer' ), wp_kses( __( '<a href="' . get_permalink( wc_get_page_id( 'myaccount' ) ) . '/orders/">view your account orders</a>', 'woocustomizer' ), array( 'a' => array( 'href' => array() ) ) ) ); ?>
            </div><?php
        return ob_get_clean();

    endif;
}
add_shortcode( 'wcz_order_details', 'wcz_ctp_shortcode_order_details' );

/*
 * Create CUSTOMER DETAILS Shortcode.
 */
function wcz_ctp_shortcode_customer_details( $atts ) {
    extract( shortcode_atts( array(
        'order_id' => !empty( $_GET['orderid'] ) ? $_GET['orderid'] : 0,
        'order_key' => !empty( $_GET['key'] ) ? $_GET['key'] : 0,
    ), $atts ) );

    if ( !$order_id ) {
		$wcz_url = "$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
		$wcz_url_oi = explode( "/", $wcz_url );
		$order_id = $wcz_url_oi[ count( $wcz_url_oi ) - 2 ];
	}

    $order_id_by_key = wc_get_order_id_by_order_key( $order_key );

    if ( $order_id_by_key === $order_id ) :

        $wcz_order = wc_get_order( $order_id );
        
        ob_start(); ?>
            <div class="wcz-customer-details-block">
                <?php wc_get_template( 'order/order-details-customer.php', array( 'order' => $wcz_order ) ); ?>
            </div><?php
        return ob_get_clean();

    else :

        ob_start(); ?>
            <div class="wcz-ctp-nomatch">
                <?php
                /* translators: 1: 'go to your account'. */
                printf( esc_html__( 'For some reason your order key does not match your order number. Please %1$s and check again.', 'woocustomizer' ), wp_kses( __( '<a href="' . get_permalink( wc_get_page_id( 'myaccount' ) ) . '/orders/">view your account orders</a>', 'woocustomizer' ), array( 'a' => array( 'href' => array() ) ) ) ); ?>
            </div><?php
        return ob_get_clean();

    endif;
}
add_shortcode( 'wcz_customer_details', 'wcz_ctp_shortcode_customer_details' );

/*
 * WCZ Shortcode - First Name.
 */
function wcz_firstname( $atts ) {
    extract( shortcode_atts( array(
        'order_id' => !empty( $_GET['orderid'] ) ? $_GET['orderid'] : 0,
        'order_key' => !empty( $_GET['key'] ) ? $_GET['key'] : 0,
    ), $atts ) );

    if ( !$order_id ) {
		$wcz_url = "$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
		$wcz_url_oi = explode( "/", $wcz_url );
		$order_id = $wcz_url_oi[ count( $wcz_url_oi ) - 2 ];
	}

    $order_id_by_key = wc_get_order_id_by_order_key( $order_key );

    if ( $order_id_by_key === $order_id ) :

        $wcz_order = wc_get_order( $order_id );
        
        ob_start(); ?><span class="wcz-shortcode wcz-firstname"><?php echo $wcz_order->get_billing_first_name(); ?></span><?php
        return ob_get_clean();

    endif;
}
add_shortcode( 'wcz_firstname', 'wcz_firstname' );

/*
 * WCZ Shortcode - Last Name.
 */
function wcz_lastname( $atts ) {
    extract( shortcode_atts( array(
        'order_id' => !empty( $_GET['orderid'] ) ? $_GET['orderid'] : 0,
        'order_key' => !empty( $_GET['key'] ) ? $_GET['key'] : 0,
    ), $atts ) );

    if ( !$order_id ) {
		$wcz_url = "$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
		$wcz_url_oi = explode( "/", $wcz_url );
		$order_id = $wcz_url_oi[ count( $wcz_url_oi ) - 2 ];
    }
    
    $order_id_by_key = wc_get_order_id_by_order_key( $order_key );

    if ( $order_id_by_key === $order_id ) :

        $wcz_order = wc_get_order( $order_id );
        
        ob_start(); ?><span class="wcz-shortcode wcz-lastname"><?php echo $wcz_order->get_billing_last_name(); ?></span><?php
        return ob_get_clean();

    endif;
}
add_shortcode( 'wcz_lastname', 'wcz_lastname' );

/*
 * WCZ Shortcode - Full Name.
 */
function wcz_fullname( $atts ) {
    extract( shortcode_atts( array(
        'order_id' => !empty( $_GET['orderid'] ) ? $_GET['orderid'] : 0,
        'order_key' => !empty( $_GET['key'] ) ? $_GET['key'] : 0,
    ), $atts ) );

    if ( !$order_id ) {
		$wcz_url = "$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
		$wcz_url_oi = explode( "/", $wcz_url );
		$order_id = $wcz_url_oi[ count( $wcz_url_oi ) - 2 ];
    }
    
    $order_id_by_key = wc_get_order_id_by_order_key( $order_key );

    if ( $order_id_by_key === $order_id ) :

        $wcz_order = wc_get_order( $order_id );
        
        ob_start(); ?><span class="wcz-shortcode wcz-fullname"><?php echo $wcz_order->get_billing_first_name(); ?> <?php echo $wcz_order->get_billing_last_name(); ?></span><?php
        return ob_get_clean();

    endif;
}
add_shortcode( 'wcz_fullname', 'wcz_fullname' );

/*
 * WCZ Shortcode - Email Address.
 */
function wcz_email( $atts ) {
    extract( shortcode_atts( array(
        'order_id' => !empty( $_GET['orderid'] ) ? $_GET['orderid'] : 0,
        'order_key' => !empty( $_GET['key'] ) ? $_GET['key'] : 0,
    ), $atts ) );

    if ( !$order_id ) {
		$wcz_url = "$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
		$wcz_url_oi = explode( "/", $wcz_url );
		$order_id = $wcz_url_oi[ count( $wcz_url_oi ) - 2 ];
    }
    
    $order_id_by_key = wc_get_order_id_by_order_key( $order_key );

    if ( $order_id_by_key === $order_id ) :

        $wcz_order = wc_get_order( $order_id );
        
        ob_start(); ?><span class="wcz-shortcode wcz-email"><?php echo $wcz_order->get_billing_email(); ?></span><?php
        return ob_get_clean();

    endif;
}
add_shortcode( 'wcz_email', 'wcz_email' );

/*
 * WCZ Shortcode - Order Number.
 */
function wcz_order_number( $atts ) {
    extract( shortcode_atts( array(
        'order_id' => !empty( $_GET['orderid'] ) ? $_GET['orderid'] : 0,
        'order_key' => !empty( $_GET['key'] ) ? $_GET['key'] : 0,
    ), $atts ) );

    if ( !$order_id ) {
		$wcz_url = "$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
		$wcz_url_oi = explode( "/", $wcz_url );
		$order_id = $wcz_url_oi[ count( $wcz_url_oi ) - 2 ];
    }
    
    $order_id_by_key = wc_get_order_id_by_order_key( $order_key );

    if ( $order_id_by_key === $order_id ) :

        $wcz_order = wc_get_order( $order_id );
        
        ob_start(); ?><span class="wcz-shortcode wcz-order_number"><?php echo $wcz_order->get_order_number(); ?></span><?php
        return ob_get_clean();

    endif;
}
add_shortcode( 'wcz_order_number', 'wcz_order_number' );

/*
 * WCZ Shortcode - Order Total.
 */
function wcz_order_total( $atts ) {
    extract( shortcode_atts( array(
        'order_id' => !empty( $_GET['orderid'] ) ? $_GET['orderid'] : 0,
        'order_key' => !empty( $_GET['key'] ) ? $_GET['key'] : 0,
    ), $atts ) );

    if ( !$order_id ) {
		$wcz_url = "$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
		$wcz_url_oi = explode( "/", $wcz_url );
		$order_id = $wcz_url_oi[ count( $wcz_url_oi ) - 2 ];
    }
    
    $order_id_by_key = wc_get_order_id_by_order_key( $order_key );

    if ( $order_id_by_key === $order_id ) :

        $wcz_order = wc_get_order( $order_id );
        
        ob_start(); ?><span class="wcz-shortcode wcz-order_total"><?php echo $wcz_order->get_formatted_order_total(); ?></span><?php
        return ob_get_clean();

    endif;
}
add_shortcode( 'wcz_order_total', 'wcz_order_total' );

/*
 * WCZ Shortcode - Order Date.
 */
function wcz_order_date( $atts ) {
    extract( shortcode_atts( array(
        'order_id' => !empty( $_GET['orderid'] ) ? $_GET['orderid'] : 0,
        'order_key' => !empty( $_GET['key'] ) ? $_GET['key'] : 0,
    ), $atts ) );

    if ( !$order_id ) {
		$wcz_url = "$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
		$wcz_url_oi = explode( "/", $wcz_url );
		$order_id = $wcz_url_oi[ count( $wcz_url_oi ) - 2 ];
    }
    
    $order_id_by_key = wc_get_order_id_by_order_key( $order_key );

    if ( $order_id_by_key === $order_id ) :

        $wcz_order = wc_get_order( $order_id );
        
        ob_start(); ?><span class="wcz-shortcode wcz-order_date"><?php echo wc_format_datetime( $wcz_order->get_date_created() ); ?></span><?php
        return ob_get_clean();

    endif;
}
add_shortcode( 'wcz_order_date', 'wcz_order_date' );
