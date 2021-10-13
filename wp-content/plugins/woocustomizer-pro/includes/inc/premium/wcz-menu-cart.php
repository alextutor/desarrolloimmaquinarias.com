<?php
/**
 * Enqueue WCD Menu Cart styling.
 */
function wcz_load_frontend_mc_scripts() {
    wp_enqueue_style( 'wcz-menu-cart-fontawesome', WCD_PLUGIN_URL . "/assets/font-awesome/css/all.css", array(), WCD_PLUGIN_VERSION );
    wp_enqueue_style( 'wcz-menu-cart', WCD_PLUGIN_URL . "/assets/css/premium/menu-cart.css", array(), WCD_PLUGIN_VERSION );
}
add_action( 'wp_enqueue_scripts', 'wcz_load_frontend_mc_scripts' );

/**
 * Enqueue WCD Menu Cart customizer scripts.
 */
function wcz_load_customizer_mc_scripts() {
	wp_enqueue_script( 'wcz-customizer-menu-cart-js', WCD_PLUGIN_URL . "/includes/customizer/customizer-library/js/premium/customizer-menu-cart.js", array( 'jquery' ), WCD_PLUGIN_VERSION, true );
}
add_action( 'customize_controls_enqueue_scripts', 'wcz_load_customizer_mc_scripts' );

/**
 * Menu Cart.
 */
if ( ! function_exists( 'wcz_woocommerce_cart_link_fragment' ) ) {
	/**
	 * Cart Fragments.
	 *
	 * Ensure cart contents update when products are added to the cart via AJAX.
	 *
	 * @param array $fragments Fragments to refresh via AJAX.
	 * @return array Fragments to refresh via AJAX.
	 */
	function wcz_woocommerce_cart_link_fragment( $fragments ) {
		ob_start();
		wcz_woocommerce_cart_link();
		$fragments['a.wcz-menucart'] = ob_get_clean();

		return $fragments;
	}
}
add_filter( 'woocommerce_add_to_cart_fragments', 'wcz_woocommerce_cart_link_fragment' );

if ( ! function_exists( 'wcz_woocommerce_cart_link' ) ) {
	/**
	 * Cart Link.
	 *
	 * Displayed a link to the cart including the number of items present and the cart total.
	 *
	 * @return void
	 */
	function wcz_woocommerce_cart_link() {
        $cart_itemno = WC()->cart->get_cart_contents_count();
        $cart_ifitems = get_option( 'wcz-mc-only-show-ifitems', woocustomizer_library_get_default( 'wcz-mc-only-show-ifitems' ) );
        $cart_showhide = $cart_ifitems && $cart_itemno < 1 ? 'wcz-mc-off' : 'wcz-mc-on'; // Setting to show only if has items ?>
		<a class="wcz-menucart wcz-cart-contents <?php echo $cart_itemno > 0 ? sanitize_html_class( 'wcz-has-items' ) : ''; ?> <?php echo !empty( $cart_ifitems ) ? sanitize_html_class( $cart_showhide ) : ''; ?>" href="<?php echo esc_url( wc_get_cart_url() ); ?>" title="<?php esc_attr_e( 'View your shopping cart', 'woocustomizer' ); ?>">
            <?php
            $wcz_cart_display = get_option( 'wcz-mc-display', woocustomizer_library_get_default( 'wcz-mc-display' ) );
            $wcz_cart_icon = get_option( 'wcz-mc-icon', woocustomizer_library_get_default( 'wcz-mc-icon' ) );

            switch ( $wcz_cart_display ) {
                case 'two': // (1) $30.00 ?>
                    <i class="fas <?php echo sanitize_html_class( $wcz_cart_icon ); ?>"></i>
                    <span class="count"><?php echo esc_html( '(' . $cart_itemno . ') ' ); ?></span>
                    <span class="amount">
                        <?php echo wp_kses_data( WC()->cart->get_cart_subtotal() ); ?>
                    </span>
                    <?php
                    break;
                case 'three': // $30.00 (1) ?>
                    <i class="fas <?php echo sanitize_html_class( $wcz_cart_icon ); ?>"></i>
                    <span class="amount">
                        <?php echo wp_kses_data( WC()->cart->get_cart_subtotal() ); ?>
                    </span>
                    <span class="count"><?php echo esc_html( ' (' . $cart_itemno . ')' ); ?></span>
                    <?php
                    break;
                case 'four': // (1) ?>
                    <i class="fas <?php echo sanitize_html_class( $wcz_cart_icon ); ?>"></i>
                    <span class="count"><?php echo esc_html( '(' . $cart_itemno . ')' ); ?></span>
                    <?php
                    break;
                case 'five': // 1 Item - $30.00
                    $item_count_text = sprintf(
                        /* translators: number of items in the mini cart. */
                        _n( '%d item', '%d items', $cart_itemno, 'woocustomizer' ),
                        $cart_itemno
                    ); ?>
                    <i class="fas <?php echo sanitize_html_class( $wcz_cart_icon ); ?>"></i>
                    <span class="count"><?php echo esc_html( '' . $item_count_text . ' - ' ); ?></span>
                    <span class="amount"><?php echo wp_kses_data( WC()->cart->get_cart_subtotal() ); ?></span>
                    <?php
                    break;
                default: // $30.00 (1 Item)
                    $item_count_text = sprintf(
                        /* translators: number of items in the mini cart. */
                        _n( '%d item', '%d items', $cart_itemno, 'woocustomizer' ),
                        $cart_itemno
                    ); ?>
                    <i class="fas <?php echo sanitize_html_class( $wcz_cart_icon ); ?>"></i>
                    <span class="amount"><?php echo wp_kses_data( WC()->cart->get_cart_subtotal() ); ?></span>
                    <span class="count"><?php echo esc_html( '(' . $item_count_text . ')' ); ?></span>
            <?php
            } ?>
		</a>
	<?php
	}
}

/**
 * Add a WC cart to the end of the main menu.
 */
if ( ! function_exists( 'wcz_add_menu_cart' ) ) {
	
	function wcz_add_menu_cart( $items, $args ) {

        // Setting to show Menu Cart ONLY on WooCommerce pages
        if ( get_option( 'wcz-mc-only-shop-cart', woocustomizer_library_get_default( 'wcz-mc-only-shop-cart' ) ) && !is_woocommerce() )
            return $items;

        if ( $args->theme_location == get_option( 'wcz_set_menu_cart_menu', woocustomizer_library_get_default( 'wcz_set_menu_cart_menu' ) ) ) {
            $items .= '<li class="wcz-menu-cart">';
            ob_start();

            wcz_woocommerce_cart_link();
            if ( !is_cart() && !is_checkout() && get_option( 'wcz-mc-enable-minicart', woocustomizer_library_get_default( 'wcz-mc-enable-minicart' ) ) ) : ?>
                
                <ul class="wcz-menu-cart-widget <?php echo sanitize_html_class( get_option( 'wcz-mc-minicart-align', woocustomizer_library_get_default( 'wcz-mc-minicart-align' ) ) ); ?>">
                    <li>
                        <?php the_widget( 'WC_Widget_Cart', array( 'title' => '' ) ); ?>
                    </li>
                </ul>

            <?php
            endif;
            $items .= ob_get_clean();
            $items .= '</li>';
        }

		return $items;
	}
}
add_filter( 'wp_nav_menu_items', 'wcz_add_menu_cart', 10, 2 );

/*
 * WCZ Shortcode - Menu Cart.
 */
function wcz_menu_cart( $atts ) {
    extract( shortcode_atts( array(
        'minicart' => !empty( $_GET['minicart'] ) ? true : false,
        'align' => !empty( $_GET['align'] ) && 'right' == $_GET['align'] ? 'right' : 'left'
    ), $atts ) );

    ob_start(); ?>
        <div class="wcz-menu-cart-sc">
            <a class="wcz-menucart <?php echo sanitize_html_class( 'wcz-cart-contents' ); ?>" href="<?php echo esc_url( wc_get_cart_url() ); ?>" title="<?php esc_attr_e( 'View your shopping cart', 'woocustomizer' ); ?>"></a>
            <?php
                if ( !is_cart() && !is_checkout() && true == $minicart ) : ?>
                    <ul class="wcz-menu-cart-widget <?php echo sanitize_html_class( 'wcz-cartalign-' . $align ); ?>">
                        <li>
                            <?php the_widget( 'WC_Widget_Cart', array( 'title' => '' ) ); ?>
                        </li>
                    </ul>
            <?php
            endif; ?>
        </div>
    <?php
    return ob_get_clean();
}
add_shortcode( 'wcz_menu_cart', 'wcz_menu_cart' );
