<?php
/**
 * Defines customizer options
 *
 * @package Customizer Library Overlay
 */

function woocustomizer_customizer_library_options() {

	$primary_color = '#4e87d8';
    $secondary_color = '#0b53b9';
    
	// Stores all the controls that will be added
	$options = array();

	// Stores all the sections to be added
	$sections = array();

	// Stores all the panels to be added
    $panels = array();
    
    // Font Selections
    // $font_websafe_choices = array( 'Arial' => 'Arial', 'Arial Black' => 'Arial Black', 'Helvetica' => 'Helvetica', 'Verdana' => 'Verdana', 'Georgia' => 'Georgia', 'Palatino' => 'Palatino', 'Garamond' => 'Garamond', 'Bookman' => 'Bookman', 'Courier' => 'Courier', 'Courier New' => 'Courier New', 'Times New Roman' => 'Times New Roman', 'Times' => 'Times' );
    // $font_google_choices = woocustomizer_library_get_font_choices();

	// Adds the sections to the $options array
    $options['sections'] = $sections;
    
    if ( WooCustomizer::wcz_is_plugin_active( 'woocommerce.php' ) ) : // is WooCommerce Activated

        // ---------------- PANEL - Theme Settings
        $panel = 'wcz-panel-settings';
        $panels[] = array(
            'id' => $panel,
            'title' => __( 'StoreCustomizer', 'woocustomizer' ),
            'priority' => '10'
        );
        
        // --------------------------------------------------------------------------------------------------------------------------------- WC Panel

        // ----------------------------------------------------------------------------------------------- StoreCustomizer Main Panel
        $section = 'wcz-panel-woocustomizer';
        $sections[] = array(
            'id' => $section,
            'title' => __( 'StoreCustomizer', 'woocustomizer' ),
            'priority' => '10',
            'panel' => $panel,
            // 'description' => '<a href="#wcz-panel-product" rel="wcz-section">link</a> here'
        );
        $options['wcz-wc-remove-breadcrumbs'] = array(
            'id' => 'wcz-wc-remove-breadcrumbs',
            'label'   => __( 'Remove All WooCommerce Breadcrumbs', 'woocustomizer' ),
            'section' => $section,
            'type'    => 'checkbox',
            'default' => 0,
        );

        // Admin Only Settings
        $options['wcz-heading-wcc-admin'] = array(
            'id' => 'wcz-heading-wcc-admin',
            'label'   => __( 'Admin Only Settings', 'woocustomizer' ),
            'section' => $section,
            'type'    => 'url',
        );
        $options['wcz-admin-product-stats'] = array(
            'id' => 'wcz-admin-product-stats',
            'label'   => __( 'Turn on Front-End Product Statistics', 'woocustomizer' ),
            'section' => $section,
            'type'    => 'checkbox',
            'description' => __( 'Only admin users are able to view these statistics on the website front-end.<br />Site visitors will not see this.', 'woocustomizer' ),
            'default' => 0,
        );

        // Login or Logout Menu Item Settings
        $options['wcz-heading-login-logout'] = array(
            'id' => 'wcz-heading-login-logout',
            'label'   => __( 'Login / Logout Menu Item', 'woocustomizer' ),
            'section' => $section,
            'type'    => 'url',
        );

        // Get Theme Menu Locations for Menu Cart
        $wcz_menus = get_registered_nav_menus();
        $nav_choices = array( 'none' => 'None' );

        foreach ( $wcz_menus as $location => $description ) {
            $nav_choices[$location] = $description;
        }
        $options['wcz-login-logout-menu'] = array(
            'id' => 'wcz-login-logout-menu',
            'label'   => __( 'Add Login / Logout to Navigation', 'woocustomizer' ),
            'section' => $section,
            'type'    => 'select',
            'choices' => $nav_choices,
            'description' => __( 'This will add a Login navigation item, and will change to Logout if the user is logged in.', 'woocustomizer' ),
            'default' => 'none'
        );
        $options['wcz-login-redirect-page'] = array(
            'id' => 'wcz-login-redirect-page',
            'label'   => __( 'Login Redirect Page', 'woocustomizer' ),
            'section' => $section,
            'type'    => 'dropdown-pages',
            'description' => __( 'Select which page to redirect the user to after LOGGING IN. Defaults to Home.', 'woocustomizer' ),
            'default' => ''
        );
        $options['wcz-logout-redirect-page'] = array(
            'id' => 'wcz-logout-redirect-page',
            'label'   => __( 'Logout Redirect Page', 'woocustomizer' ),
            'section' => $section,
            'type'    => 'dropdown-pages',
            'description' => __( 'Select which page to redirect the user to adter LOGGING OUT. Defaults to Home.', 'woocustomizer' ),
            'default' => ''
        );
        $options['wcz-login-text'] = array(
            'id' => 'wcz-login-text',
            'label'   => __( 'Login Text', 'woocustomizer' ),
            'section' => $section,
            'type'    => 'text',
            'default' => __( 'Login', 'woocustomizer' )
        );
        $options['wcz-logout-text'] = array(
            'id' => 'wcz-logout-text',
            'label'   => __( 'Logout Text', 'woocustomizer' ),
            'section' => $section,
            'type'    => 'text',
            'default' => __( 'Logout', 'woocustomizer' )
        );

        // Banner to WooCommerce Pages
        $options['wcz-heading-wcc-page-banner'] = array(
            'id' => 'wcz-heading-wcc-page-banner',
            'label'   => __( 'WooCommerce Page/s Notice', 'woocustomizer' ),
            'section' => $section,
            'type'    => 'url',
        );
        $options['wcz-wc-notice-banner'] = array(
            'id' => 'wcz-wc-notice-banner',
            'label'   => __( 'Add a notice to WooCommerce pages', 'woocustomizer' ),
            'section' => $section,
            'type'    => 'checkbox',
            'description' => __( 'Depending on your theme, the position of these hooks might change slightly', 'woocustomizer' ),
            'default' => 0,
        );

        $options['wcz-wc-notice-title'] = array(
            'id' => 'wcz-wc-notice-title',
            'label'   => __( 'Title', 'woocustomizer' ),
            'section' => $section,
            'type'    => 'text',
            'default' => __( 'Please Note!', 'woocustomizer' ),
        );
        $options['wcz-wc-notice-text'] = array(
            'id' => 'wcz-wc-notice-text',
            'label'   => __( 'Text', 'woocustomizer' ),
            'section' => $section,
            'type'    => 'textarea',
            'default' => __( 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nunc tincidunt nec diam eu convallis. Nullam quis ipsum volutpat, porta ex sit amet, posuere lorem.', 'woocustomizer' ),
        );

        $choices = array(
            'none' => 'Off',
            'woocommerce_before_main_content' => 'Top of Page',
            'woocommerce_before_shop_loop' => 'Before Products',
            'woocommerce_after_shop_loop' => 'After Products'
        );
        $options['wcz-wc-notice-banner-shop'] = array(
            'id' => 'wcz-wc-notice-banner-shop',
            'label'   => __( 'Add to Shop & Archive pages', 'woocustomizer' ),
            'section' => $section,
            'type'    => 'select',
            'choices' => $choices,
            'default' => 'none'
        );
        $options['wcz-wc-notice-banner-archives'] = array(
            'id' => 'wcz-wc-notice-banner-archives',
            'label'   => __( 'Include Category & Archive pages', 'woocustomizer' ),
            'section' => $section,
            'type'    => 'checkbox',
            'default' => 0,
        );
        $choices = array(
            'none' => 'Off',
            'woocommerce_before_single_product' => 'Top of Page',
            'woocommerce_single_product_summary' => 'Above Product Summary',
            'woocommerce_before_add_to_cart_form' => 'Before \'Add to Cart\'',
            'woocommerce_after_add_to_cart_form' => 'After \'Add to Cart\'',
            'woocommerce_product_meta_end' => 'After Product Meta',
            'woocommerce_after_single_product_summary' => 'After Single Product Summary',
            'woocommerce_after_single_product' => 'Bottom of Page',
        );
        $options['wcz-wc-notice-banner-product'] = array(
            'id' => 'wcz-wc-notice-banner-product',
            'label'   => __( 'Add to Product pages', 'woocustomizer' ),
            'section' => $section,
            'type'    => 'select',
            'choices' => $choices,
            'default' => 'none'
        );
        $choices = array(
            'none' => 'Off',
            'woocommerce_before_cart' => 'Above Cart',
            'woocommerce_after_cart_table' => 'Below Cart',
            'woocommerce_proceed_to_checkout' => 'Before \'Proceed to Checkout\' button',
            'woocommerce_after_cart_totals' => 'After \'Proceed to Checkout\' button',
            'woocommerce_after_cart' => 'After Cart',
        );
        $options['wcz-wc-notice-banner-cart'] = array(
            'id' => 'wcz-wc-notice-banner-cart',
            'label'   => __( 'Add to Cart page', 'woocustomizer' ),
            'section' => $section,
            'type'    => 'select',
            'choices' => $choices,
            'default' => 'none'
        );
        $choices = array(
            'none' => 'Off',
            'woocommerce_before_checkout_form' => 'Top of Page',
            'woocommerce_checkout_before_customer_details' => 'Before Customer Details',
            'woocommerce_after_order_notes' => 'After \'Order Notes\'',
            'woocommerce_checkout_after_customer_details' => 'After Customer Details',
            'woocommerce_review_order_before_payment' => 'Before Payment Options',
            'woocommerce_after_checkout_form' => 'Bottom of Page',
        );
        $options['wcz-wc-notice-banner-checkout'] = array(
            'id' => 'wcz-wc-notice-banner-checkout',
            'label'   => __( 'Add to Checkout page', 'woocustomizer' ),
            'section' => $section,
            'type'    => 'select',
            'choices' => $choices,
            'default' => 'none'
        );

        $options['wcz-wc-notice-design'] = array(
            'id' => 'wcz-wc-notice-design',
            'label'   => __( 'Edit Design', 'woocustomizer' ),
            'section' => $section,
            'type'    => 'checkbox',
            'default' => 0,
        );
        $choices = array(
            'wcz-notice-one' => 'Plain',
            'wcz-notice-two' => 'Bordered',
            'wcz-notice-three' => 'Side Border',
            'wcz-notice-four' => 'Solid Color',
        );
        $options['wcz-wc-notice-style'] = array(
            'id' => 'wcz-wc-notice-style',
            'label'   => __( 'Design', 'woocustomizer' ),
            'section' => $section,
            'type'    => 'select',
            'choices' => $choices,
            'default' => 'wcz-notice-one'
        );
        $wcz_rangeval = get_option( 'wcz-wc-notice-titlesize', 18 );
        $options['wcz-wc-notice-titlesize'] = array(
            'id' => 'wcz-wc-notice-titlesize',
            'label'   => __( 'Title Size', 'woocustomizer' ),
            'section' => $section,
            'type'    => 'range',
            'input_attrs' => array(
                'min'   => 12,
                'max'   => 34,
                'step'  => 1,
            ),
            'description' => '<i>12</i> <span><b class="wcz-rangeval">' . esc_html( $wcz_rangeval ) . '</b>px</span> <i>34</i>', // Non translatale Numbers
            'default' => 18
        );
        $wcz_rangeval = get_option( 'wcz-wc-notice-textsize', 14 );
        $options['wcz-wc-notice-textsize'] = array(
            'id' => 'wcz-wc-notice-textsize',
            'label'   => __( 'Text Size', 'woocustomizer' ),
            'section' => $section,
            'type'    => 'range',
            'input_attrs' => array(
                'min'   => 11,
                'max'   => 26,
                'step'  => 1,
            ),
            'description' => '<i>11</i> <span><b class="wcz-rangeval">' . esc_html( $wcz_rangeval ) . '</b>px</span> <i>26</i>', // Non translatale Numbers
            'default' => 14
        );
        $options['wcz-wc-notice-center'] = array(
            'id' => 'wcz-wc-notice-center',
            'label'   => __( 'Center Align', 'woocustomizer' ),
            'section' => $section,
            'type'    => 'checkbox',
            'default' => 0,
        );
        $options['wcz-wc-notice-color'] = array(
            'id' => 'wcz-wc-notice-color',
            'label'   => __( 'Notice Color', 'woocustomizer' ),
            'section' => $section,
            'type'    => 'color',
            'default' => '#2f79ff',
        );
        $wcz_rangeval = get_option( 'wcz-wc-notice-width', 100 );
        $options['wcz-wc-notice-width'] = array(
            'id' => 'wcz-wc-notice-width',
            'label'   => __( 'Max Width', 'woocustomizer' ),
            'section' => $section,
            'type'    => 'range',
            'input_attrs' => array(
                'min'   => 40,
                'max'   => 100,
                'step'  => 1,
            ),
            'description' => '<i>30</i> <span><b class="wcz-rangeval">' . esc_html( $wcz_rangeval ) . '</b>%</span> <i>100</i>', // Non translatale Numbers
            'default' => 100
        );
        $wcz_rangeval = get_option( 'wcz-wc-notice-margin', 20 );
        $options['wcz-wc-notice-margin'] = array(
            'id' => 'wcz-wc-notice-margin',
            'label'   => __( 'Bottom Margin', 'woocustomizer' ),
            'section' => $section,
            'type'    => 'range',
            'input_attrs' => array(
                'min'   => 0,
                'max'   => 80,
                'step'  => 1,
            ),
            'description' => '<i>0</i> <span><b class="wcz-rangeval">' . esc_html( $wcz_rangeval ) . '</b>px</span> <i>80</i>', // Non translatale Numbers
            'default' => 20
        );

        // ----------------------------------------------------------------------------------------------- StoreCustomizer Main Panel

        // ----------------------------------------------------------------------------------------------- WooCommerce Shop Page
        $section = 'wcz-panel-shop';
        $sections[] = array(
            'id' => $section,
            'title' => __( 'WooCommerce Shop Page', 'woocustomizer' ),
            'priority' => '10',
            'panel' => $panel,
            // 'description' => '<a href="#wcz-panel-product" rel="wcz-section">link</a> here'
        );
        
        $options['wcz-shop-remove-breadcrumbs'] = array(
            'id' => 'wcz-shop-remove-breadcrumbs',
            'label'   => __( 'Remove Shop Page Breadcrumbs', 'woocustomizer' ),
            'section' => $section,
            'type'    => 'checkbox',
            'default' => 0,
        );
        $options['wcz-shop-remove-title'] = array(
            'id' => 'wcz-shop-remove-title',
            'label'   => __( 'Remove Shop Title', 'woocustomizer' ),
            'section' => $section,
            'type'    => 'checkbox',
            'default' => 0,
        );
        $options['wcz-shop-remove-sorting'] = array(
            'id' => 'wcz-shop-remove-sorting',
            'label'   => __( 'Remove Shop Sorting Dropdown', 'woocustomizer' ),
            'section' => $section,
            'type'    => 'checkbox',
            'default' => 0,
        );
        $options['wcz-shop-remove-result'] = array(
            'id' => 'wcz-shop-remove-result',
            'label'   => __( 'Remove Shop Sorting Results', 'woocustomizer' ),
            'section' => $section,
            'type'    => 'checkbox',
            'default' => 0,
        );

        $wcz_rangeval = get_option( 'wcz-shop-pppage', 12 );
        $options['wcz-shop-pppage'] = array(
            'id' => 'wcz-shop-pppage',
            'label'   => __( 'Products Per Page', 'woocustomizer' ),
            'section' => $section,
            'type'    => 'range',
            'input_attrs' => array(
                'min'   => 2,
                'max'   => 100,
                'step'  => 1,
            ),
            'description' => '<i>2</i> <span><b class="wcz-rangeval">' . esc_html( $wcz_rangeval ) . '</b></span> <i>100</i>', // Non translatale Numbers
            'default' => 12
        );
        $options['wcz-shop-pprow'] = array(
            'id' => 'wcz-shop-pprow',
            'label'   => __( 'Products Per Row', 'woocustomizer' ),
            'section' => $section,
            'type'    => 'range',
            'input_attrs' => array(
                'min'   => 1,
                'max'   => 5,
                'step'  => 1,
            ),
            'description' => __( '<i>1</i> <b>|</b> 2 <b>|</b> 3 <b>|</b> 4 <b>|</b> <i>5</i>', 'woocustomizer' ),
            'default' => 4
        );

        $options['wcz-shop-sale-txt'] = array(
            'id' => 'wcz-shop-sale-txt',
            'label'   => __( 'Sale Banner Text', 'woocustomizer' ),
            'section' => $section,
            'type'    => 'text',
            'default' => __( 'Sale!', 'woocustomizer' ),
        );

        $options['wcz-shop-add-soldout'] = array(
            'id' => 'wcz-shop-add-soldout',
            'label'   => __( 'Add a banner to Sold Out products', 'woocustomizer' ),
            'section' => $section,
            'type'    => 'checkbox',
            'default' => 0,
        );
        $choices = array(
            'wcz-soldout-style-plain' => 'Plain Text',
            'wcz-soldout-style-angle' => 'Angle Over Image'
        );
        $options['wcz-soldout-style'] = array(
            'id' => 'wcz-soldout-style',
            'label'   => __( 'Sold Out Banner Style', 'woocustomizer' ),
            'section' => $section,
            'type'    => 'select',
            'choices' => $choices,
            'default' => 'wcz-soldout-style-plain'
        );
        $options['wcz-shop-soldout-txt'] = array(
            'id' => 'wcz-shop-soldout-txt',
            'label'   => __( 'Sold Out Banner Text', 'woocustomizer' ),
            'section' => $section,
            'type'    => 'text',
            'default' => __( 'SOLD OUT', 'woocustomizer' ),
        );

        $options['wcz-shop-show-stock'] = array(
            'id' => 'wcz-shop-show-stock',
            'label'   => __( 'Show stock amount for Users', 'woocustomizer' ),
            'section' => $section,
            'type'    => 'checkbox',
            'description' => __( 'This uses the stock set at product level.<br /><br />Use "[no]" in the text to display the stock amount.', 'woocustomizer' ),
            'default' => 0,
        );
        $options['wcz-shop-stock-lowamnt-txt'] = array(
            'id' => 'wcz-shop-stock-lowamnt-txt',
            'label'   => __( 'Low Stock Amount Text', 'woocustomizer' ),
            'section' => $section,
            'type'    => 'text',
            'description' => __( 'If the product stock is 3 or less', 'woocustomizer' ),
            'default' => __( 'Only [no] left in stock!', 'woocustomizer' ),
        );
        $options['wcz-shop-stock-amnt-txt'] = array(
            'id' => 'wcz-shop-stock-amnt-txt',
            'label'   => __( 'Stock Amount Text', 'woocustomizer' ),
            'section' => $section,
            'type'    => 'text',
            'default' => __( '[no] left in stock!', 'woocustomizer' ),
        );

        $options['wcz-shop-edit-btns'] = array(
            'id' => 'wcz-shop-edit-btns',
            'label'   => __( 'Edit Shop Button Texts', 'woocustomizer' ),
            'section' => $section,
            'type'    => 'checkbox',
            'default' => 0,
        );
        $options['wcz-shoplist-button-txt-simple'] = array(
            'id' => 'wcz-shoplist-button-txt-simple',
            'label'   => __( 'Simple Product Button Text', 'woocustomizer' ),
            'section' => $section,
            'type'    => 'text',
            'default' => __( 'Add to cart', 'woocustomizer' ),
        );
        $options['wcz-shop-button-txt-variable'] = array(
            'id' => 'wcz-shop-button-txt-variable',
            'label'   => __( 'Variable Product Button Text', 'woocustomizer' ),
            'section' => $section,
            'type'    => 'text',
            'default' => __( 'Select Options', 'woocustomizer' ),
        );
        $options['wcz-shop-button-txt-grouped'] = array(
            'id' => 'wcz-shop-button-txt-grouped',
            'label'   => __( 'Grouped Product Button Text', 'woocustomizer' ),
            'section' => $section,
            'type'    => 'text',
            'default' => __( 'View products', 'woocustomizer' ),
        );

        // New badge for recent products
        $options['wcz-shop-new-badge'] = array(
            'id' => 'wcz-shop-new-badge',
            'label'   => __( 'Add a "New" badge for recently added products', 'woocustomizer' ),
            'section' => $section,
            'type'    => 'checkbox',
            'default' => 0,
        );
        $options['wcz-shop-new-product-days'] = array(
            'id' => 'wcz-shop-new-product-days',
            'label'   => __( 'Days to determine if product is "New"', 'woocustomizer' ),
            'section' => $section,
            'type'    => 'number',
            'description' => __( 'The "New" badge will only display on products where the "Published On" date is less that the number of days specified here.', 'woocustomizer' ),
            'default' => 7,
        );
        $options['wcz-shop-new-product-badge-text'] = array(
            'id' => 'wcz-shop-new-product-badge-text',
            'label'   => __( 'New Product Badge Text', 'woocustomizer' ),
            'section' => $section,
            'type'    => 'text',
            'default' => __( 'New Product', 'woocustomizer' ),
        );
        $choices = array(
            'topleft' => 'Top Left',
            'topright' => 'Top Right',
            'abovetitle' => 'Above Product Title',
            'belowtitle' => 'Below Product Title'
        );
        $options['wcz-shop-new-badge-pos'] = array(
            'id' => 'wcz-shop-new-badge-pos',
            'label'   => __( 'Badge Position', 'woocustomizer' ),
            'section' => $section,
            'type'    => 'select',
            'choices' => $choices,
            'default' => 'topleft'
        );
        $options['wcz-shop-new-badge-color'] = array(
            'id' => 'wcz-shop-new-badge-color',
            'label'   => __( 'Badge Color', 'woocustomizer' ),
            'section' => $section,
            'type'    => 'color',
            'default' => '#2f79ff',
        );

        // Archives Settings
        $options['wcz-heading-archives'] = array(
            'id' => 'wcz-heading-archives',
            'label'   => __( 'Shop Archive / Categories Pages', 'woocustomizer' ),
            'section' => $section,
            'type'    => 'url',
        );

        $options['wcz-shop-remove-catcount'] = array(
            'id' => 'wcz-shop-remove-catcount',
            'label'   => __( 'Remove Category Count', 'woocustomizer' ),
            'section' => $section,
            'type'    => 'checkbox',
            'default' => 0,
        );

        $options['wcz-shop-archives-remove-breadcrumbs'] = array(
            'id' => 'wcz-shop-archives-remove-breadcrumbs',
            'label'   => __( 'Remove Shop Archive Breadcrumbs', 'woocustomizer' ),
            'section' => $section,
            'type'    => 'checkbox',
            'default' => 0,
        );
        $options['wcz-shop-archives-remove-title'] = array(
            'id' => 'wcz-shop-archives-remove-title',
            'label'   => __( 'Remove Archives Title', 'woocustomizer' ),
            'section' => $section,
            'type'    => 'checkbox',
            'default' => 0,
        );

        // -------------------------------- Shop Design Settings
        $options['wcz-heading-wcc-btn'] = array(
            'id' => 'wcz-heading-wcc-btn',
            'label'   => __( 'Design Elements', 'woocustomizer' ),
            'section' => $section,
            'type'    => 'url',
            'description' => __( 'Depending on your theme, these design settings might not always work. If not, please contact us to help get these working with your theme.', 'woocustomizer' ),
        );

        // Customize - Button
        $options['wcz-wc-edit-btns'] = array(
            'id' => 'wcz-wc-edit-btns',
            'label'   => __( 'Customize Button Design', 'woocustomizer' ),
            'section' => $section,
            'type'    => 'checkbox',
            'default' => 0,
        );
        $choices = array(
            'wcz-btn-style-default' => 'Theme Style / Default',
            'wcz-btn-style-plain' => 'Plain',
            'wcz-btn-style-detailed' => 'Detailed'
        );
        $options['wcz-btn-style'] = array(
            'id' => 'wcz-btn-style',
            'label'   => __( 'Button Style', 'woocustomizer' ),
            'section' => $section,
            'type'    => 'select',
            'choices' => $choices,
            'default' => 'wcz-btn-style-default'
        );
        $wcz_bfsval = get_option( 'wcz-btn-fsize', 16 );
        $options['wcz-btn-fsize'] = array(
            'id' => 'wcz-btn-fsize',
            'label'   => __( 'Font Size', 'woocustomizer' ),
            'section' => $section,
            'type'    => 'range',
            'input_attrs' => array(
                'min'   => 10,
                'max'   => 34,
                'step'  => 1,
            ),
            'description' => '<i>10</i> <span><b class="wcz-rangeval">' . esc_html( $wcz_bfsval ) . '</b></span> <i>34</i>', // Non translatale Numbers
            'default' => 16
        );
        $options['wcz-btn-fweight'] = array(
            'id' => 'wcz-btn-fweight',
            'label'   => __( 'Bold', 'woocustomizer' ),
            'section' => $section,
            'type'    => 'checkbox',
            'default' => 0,
        );
        $options['wcz-btn-bgcolor'] = array(
            'id' => 'wcz-btn-bgcolor',
            'label'   => __( 'Button Color', 'woocustomizer' ),
            'section' => $section,
            'type'    => 'color',
            'default' => '#e8e8e8',
        );
        $options['wcz-btn-hovercolor'] = array(
            'id' => 'wcz-btn-hovercolor',
            'label'   => __( 'Button Hover Color', 'woocustomizer' ),
            'section' => $section,
            'type'    => 'color',
            'default' => '#757575',
        );
        $wcz_bbrval = get_option( 'wcz-btn-br', 3 );
        $options['wcz-btn-br'] = array(
            'id' => 'wcz-btn-br',
            'label'   => __( 'Border Radius', 'woocustomizer' ),
            'section' => $section,
            'type'    => 'range',
            'input_attrs' => array(
                'min'   => 0,
                'max'   => 50,
                'step'  => 1,
            ),
            'description' => '<i>0</i> <span><b class="wcz-rangeval">' . esc_html( $wcz_bbrval ) . '</b></span> <i>50</i>', // Non translatale Numbers
            'default' => 3
        );
        $wcz_bpval = get_option( 'wcz-btn-padding', 10 );
        $options['wcz-btn-padding'] = array(
            'id' => 'wcz-btn-padding',
            'label'   => __( 'Padding', 'woocustomizer' ),
            'section' => $section,
            'type'    => 'range',
            'input_attrs' => array(
                'min'   => 5,
                'max'   => 40,
                'step'  => 1,
            ),
            'description' => '<i>5</i> <span><b class="wcz-rangeval">' . esc_html( $wcz_bpval ) . '</b></span> <i>40</i>', // Non translatale Numbers
            'default' => 10
        );

        // Customize - Sale Banner
        $options['wcz-wc-edit-sale'] = array(
            'id' => 'wcz-wc-edit-sale',
            'label'   => __( 'Customize Sale Banner', 'woocustomizer' ),
            'section' => $section,
            'type'    => 'checkbox',
            'default' => 0,
        );
        $wcz_sfsval = get_option( 'wcz-sale-fsize', 15 );
        $options['wcz-sale-fsize'] = array(
            'id' => 'wcz-sale-fsize',
            'label'   => __( 'Font Size', 'woocustomizer' ),
            'section' => $section,
            'type'    => 'range',
            'input_attrs' => array(
                'min'   => 10,
                'max'   => 32,
                'step'  => 1,
            ),
            'description' => '<i>10</i> <span><b class="wcz-rangeval">' . esc_html( $wcz_sfsval ) . '</b></span> <i>32</i>', // Non translatale Numbers
            'default' => 15
        );
        $options['wcz-sale-fweight'] = array(
            'id' => 'wcz-sale-fweight',
            'label'   => __( 'Bold', 'woocustomizer' ),
            'section' => $section,
            'type'    => 'checkbox',
            'default' => 0,
        );

        $options['wcz-sale-bgcolor'] = array(
            'id' => 'wcz-sale-bgcolor',
            'label'   => __( 'Sale Banner Color', 'woocustomizer' ),
            'section' => $section,
            'type'    => 'color',
            'default' => '#e8e8e8',
        );
        $wcz_sbbrval = get_option( 'wcz-sale-br', 3 );
        $options['wcz-sale-br'] = array(
            'id' => 'wcz-sale-br',
            'label'   => __( 'Border Radius', 'woocustomizer' ),
            'section' => $section,
            'type'    => 'range',
            'input_attrs' => array(
                'min'   => 0,
                'max'   => 20,
                'step'  => 1,
            ),
            'description' => '<i>0</i> <span><b class="wcz-rangeval">' . esc_html( $wcz_sbbrval ) . '</b></span> <i>20</i>', // Non translatale Numbers
            'default' => 3
        );
        $wcz_sbpval = get_option( 'wcz-sale-padding', 5 );
        $options['wcz-sale-padding'] = array(
            'id' => 'wcz-sale-padding',
            'label'   => __( 'Padding', 'woocustomizer' ),
            'section' => $section,
            'type'    => 'range',
            'input_attrs' => array(
                'min'   => 2,
                'max'   => 20,
                'step'  => 1,
            ),
            'description' => '<i>2</i> <span><b class="wcz-rangeval">' . esc_html( $wcz_sbpval ) . '</b></span> <i>20</i>', // Non translatale Numbers
            'default' => 5
        );
        // Customize - Product Title
        $options['wcz-wc-edit-shop-title'] = array(
            'id' => 'wcz-wc-edit-shop-title',
            'label'   => __( 'Customize Product Title', 'woocustomizer' ),
            'section' => $section,
            'type'    => 'checkbox',
            'default' => 0,
        );
        $wcz_sfsval = get_option( 'wcz-shop-title-fsize', 16 );
        $options['wcz-shop-title-fsize'] = array(
            'id' => 'wcz-shop-title-fsize',
            'label'   => __( 'Font Size', 'woocustomizer' ),
            'section' => $section,
            'type'    => 'range',
            'input_attrs' => array(
                'min'   => 10,
                'max'   => 38,
                'step'  => 1,
            ),
            'description' => '<i>10</i> <span><b class="wcz-rangeval">' . esc_html( $wcz_sfsval ) . '</b></span> <i>38</i>', // Non translatale Numbers
            'default' => 16
        );
        $options['wcz-shop-title-fcolor'] = array(
            'id' => 'wcz-shop-title-fcolor',
            'label'   => __( 'Font Color', 'woocustomizer' ),
            'section' => $section,
            'type'    => 'color',
            'default' => '#444',
        );
        // Customize - Product Price
        $options['wcz-wc-edit-shop-price'] = array(
            'id' => 'wcz-wc-edit-shop-price',
            'label'   => __( 'Customize Product Price', 'woocustomizer' ),
            'section' => $section,
            'type'    => 'checkbox',
            'default' => 0,
        );
        $wcz_sfsval = get_option( 'wcz-shop-price-fsize', 14 );
        $options['wcz-shop-price-fsize'] = array(
            'id' => 'wcz-shop-price-fsize',
            'label'   => __( 'Font Size', 'woocustomizer' ),
            'section' => $section,
            'type'    => 'range',
            'input_attrs' => array(
                'min'   => 10,
                'max'   => 34,
                'step'  => 1,
            ),
            'description' => '<i>10</i> <span><b class="wcz-rangeval">' . esc_html( $wcz_sfsval ) . '</b></span> <i>34</i>', // Non translatale Numbers
            'default' => 14
        );
        $options['wcz-shop-price-fcolor'] = array(
            'id' => 'wcz-shop-price-fcolor',
            'label'   => __( 'Font Color', 'woocustomizer' ),
            'section' => $section,
            'type'    => 'color',
            'default' => '#222',
        );
        // -------------------------------- Shop Design Settings
        // Customize - Apply to Gutenberg Blocks
        $options['wcz-wc-edit-applyto-blocks'] = array(
            'id' => 'wcz-wc-edit-applyto-blocks',
            'label'   => __( 'Apply these design settings to WooCommerce Blocks for Gutenberg', 'woocustomizer' ),
            'section' => $section,
            'type'    => 'checkbox',
            'default' => 0,
        );
        // ----------------------------------------------------------------------------------------------- WooCommerce Shop Page

        // ----------------------------------------------------------------------------------------------- WooCommerce Product Page
        $section = 'wcz-panel-product';
        $sections[] = array(
            'id' => $section,
            'title' => __( 'WooCommerce Product Page', 'woocustomizer' ),
            'priority' => '10',
            'panel' => $panel,
        );

        $options['wcz-remove-product-breadcrumbs'] = array(
            'id' => 'wcz-remove-product-breadcrumbs',
            'label'   => __( 'Remove Product Breadcrumbs', 'woocustomizer' ),
            'section' => $section,
            'type'    => 'checkbox',
            'default' => 0,
        );

        $options['wcz-remove-product-zoom'] = array(
            'id' => 'wcz-remove-product-zoom',
            'label'   => __( 'Remove Image Zoom', 'woocustomizer' ),
            'section' => $section,
            'type'    => 'checkbox',
            'default' => 0,
        );
        $options['wcz-remove-product-lightbox'] = array(
            'id' => 'wcz-remove-product-lightbox',
            'label'   => __( 'Remove Image Lightbox', 'woocustomizer' ),
            'section' => $section,
            'type'    => 'checkbox',
            'default' => 0,
        );
        $options['wcz-remove-product-slider'] = array(
            'id' => 'wcz-remove-product-slider',
            'label'   => __( 'Remove Image Slider', 'woocustomizer' ),
            'section' => $section,
            'type'    => 'checkbox',
            'default' => 0,
        );
        $options['wcz-product-imggal-ppr'] = array(
            'id' => 'wcz-product-imggal-ppr',
            'label'   => __( 'Product Image Thumbnails Per Row', 'woocustomizer' ),
            'section' => $section,
            'type'    => 'range',
            'input_attrs' => array(
                'min'   => 2,
                'max'   => 5,
                'step'  => 1,
            ),
            'description' => __( '<i>2</i> <b>|</b> 3 <b>|</b> 4 <b>|</b> <i>5</i>', 'woocustomizer' ),
            'default' => 4
        );

        $options['wcz-product-sale-txt'] = array(
            'id' => 'wcz-product-sale-txt',
            'label'   => __( 'Sale Banner Text', 'woocustomizer' ),
            'section' => $section,
            'type'    => 'text',
            'default' => __( 'Sale!', 'woocustomizer'),
        );
        $options['wcz-remove-product-title'] = array(
            'id' => 'wcz-remove-product-title',
            'label'   => __( 'Remove Product Title', 'woocustomizer' ),
            'section' => $section,
            'type'    => 'checkbox',
            'default' => 0,
        );
        $options['wcz-add-price-prefix'] = array(
            'id' => 'wcz-add-price-prefix',
            'label'   => __( 'Add a default Price Prefix', 'woocustomizer' ),
            'section' => $section,
            'type'    => 'checkbox',
            'description' => __( 'Edit the prefix per product under Product Data -> StoreCustomizer on each product.<br /><br />To add a prefix to only certain products, simply add nothing here (and save), then edit the prefix setting on each product.', 'woocustomizer' ),
            'default' => 0,
        );
        $options['wcz-add-price-prefix-txt'] = array(
            'id' => 'wcz-add-price-prefix-txt',
            'label'   => __( 'Product Price Prefix Text', 'woocustomizer' ),
            'section' => $section,
            'type'    => 'text',
            'default' => __( 'From:', 'woocustomizer' ),
        );
        $options['wcz-add-price-prefix-shop'] = array(
            'id' => 'wcz-add-price-prefix-shop',
            'label'   => __( 'Add the prefix to Product Shop page', 'woocustomizer' ),
            'section' => $section,
            'type'    => 'checkbox',
            'description' => __( 'Add the prefix to the product list and category pages too.', 'woocustomizer' ),
            'default' => 0,
        );

        $options['wcz-add-price-suffix'] = array(
            'id' => 'wcz-add-price-suffix',
            'label'   => __( 'Add a default Price Suffix', 'woocustomizer' ),
            'section' => $section,
            'type'    => 'checkbox',
            'description' => __( 'Edit the suffix per product under Product Data -> StoreCustomizer on each product.<br /><br />To add a suffix to only certain products, simply add nothing here (and save), then edit the suffix setting on each product.', 'woocustomizer' ),
            'default' => 0,
        );
        $options['wcz-add-price-suffix-txt'] = array(
            'id' => 'wcz-add-price-suffix-txt',
            'label'   => __( 'Product Price Suffix Text', 'woocustomizer' ),
            'section' => $section,
            'type'    => 'text',
            'default' => __( 'Incl. VAT', 'woocustomizer' ),
        );
        $options['wcz-add-price-suffix-shop'] = array(
            'id' => 'wcz-add-price-suffix-shop',
            'label'   => __( 'Add the suffix to Product Shop page', 'woocustomizer' ),
            'section' => $section,
            'type'    => 'checkbox',
            'description' => __( 'Add the suffix to the product list and category pages too.', 'woocustomizer' ),
            'default' => 0,
        );

        $options['wcz-product-edit-btn'] = array(
            'id' => 'wcz-product-edit-btn',
            'label'   => __( 'Edit Product Button Text', 'woocustomizer' ),
            'section' => $section,
            'type'    => 'checkbox',
            'default' => 0,
        );
        $options['wcz-product-button-txt-simple'] = array(
            'id' => 'wcz-product-button-txt-simple',
            'label'   => __( 'Product Button Text', 'woocustomizer' ),
            'section' => $section,
            'type'    => 'text',
            'default' => __( 'Add to cart', 'woocustomizer'),
        );
        $options['wcz-remove-product-sku'] = array(
            'id' => 'wcz-remove-product-sku',
            'label'   => __( 'Remove SKU', 'woocustomizer' ),
            'section' => $section,
            'type'    => 'checkbox',
            'default' => 0,
        );
        $options['wcz-remove-product-cats'] = array(
            'id' => 'wcz-remove-product-cats',
            'label'   => __( 'Remove Product Categories', 'woocustomizer' ),
            'section' => $section,
            'type'    => 'checkbox',
            'default' => 0,
        );
        $options['wcz-remove-product-tags'] = array(
            'id' => 'wcz-remove-product-tags',
            'label'   => __( 'Remove Product Tags', 'woocustomizer' ),
            'section' => $section,
            'type'    => 'checkbox',
            'default' => 0,
        );

        $options['wcz-product-show-unitsold'] = array(
            'id' => 'wcz-product-show-unitsold',
            'label'   => __( 'Show Amount Sold', 'woocustomizer' ),
            'section' => $section,
            'type'    => 'checkbox',
            'default' => 0,
        );
        $options['wcz-product-unitsold-txt'] = array(
            'id' => 'wcz-product-unitsold-txt',
            'label'   => __( 'Amount Sold Text', 'woocustomizer' ),
            'section' => $section,
            'type'    => 'text',
            'description' => __( 'Use "[no]" in the text to display the amount sold.', 'woocustomizer' ),
            'default' => __( 'Items Sold: [no]', 'woocustomizer' ),
        );
        $options['wcz-add-shop-button'] = array(
            'id' => 'wcz-add-shop-button',
            'label'   => __( 'Add button to \'Continue Shopping\'', 'woocustomizer' ),
            'section' => $section,
            'type'    => 'checkbox',
            'default' => 0,
        );
        $options['wcz-add-shop-button-txt'] = array(
            'id' => 'wcz-add-shop-button-txt',
            'label'   => __( 'Continue Shopping Text', 'woocustomizer' ),
            'section' => $section,
            'type'    => 'text',
            'default' => __( 'Continue Shopping', 'woocustomizer'),
        );
        $options['wcz-add-shop-button-url'] = array(
            'id' => 'wcz-add-shop-button-url',
            'label'   => __( 'Continue Shopping URL', 'woocustomizer' ),
            'section' => $section,
            'type'    => 'url',
            'description' => __( 'If not set, this will default to the shop page.<br />Enter the full url, including \'https://\'', 'woocustomizer' ),
            'default' => '',
        );

        $options['wcz-product-variable-ddo'] = array(
            'id' => 'wcz-product-variable-ddo',
            'label'   => __( 'Edit Variable Product dropdown label', 'woocustomizer' ),
            'section' => $section,
            'type'    => 'checkbox',
            'default' => 0,
        );
        $options['wcz-product-variable-ddo-txt'] = array(
            'id' => 'wcz-product-variable-ddo-txt',
            'label'   => __( 'Default Label', 'woocustomizer' ),
            'section' => $section,
            'type'    => 'text',
            'default' => __( 'Choose an option', 'woocustomizer'),
        );

        // EXCLUDED FROM FREE VERSION -- This "if" block will be auto removed from the Free version.
        if ( wcz_fs()->can_use_premium_code__premium_only() ) {

            $options['wcz-add-plus-minus-btns'] = array(
                'id' => 'wcz-add-plus-minus-btns',
                'label'   => __( 'Add Plus & Minus buttons to \'Add To Cart\'', 'woocustomizer' ),
                'section' => $section,
                'type'    => 'checkbox',
                'default' => 0,
            );

        } // EXCLUDED FROM FREE VERSION -- This "if" block will be auto removed from the Free version.

        $options['wcz-set-cart-increment-vals'] = array(
            'id' => 'wcz-set-cart-increment-vals',
            'label'   => __( 'Set \'Add To Cart\' Increment values', 'woocustomizer' ),
            'section' => $section,
            'type'    => 'checkbox',
            'default' => 0,
        );
        $options['wcz-set-cart-inc-min'] = array(
            'id' => 'wcz-set-cart-inc-min',
            'label'   => __( 'Minimum Value Allowed', 'woocustomizer' ),
            'section' => $section,
            'type'    => 'number',
            'default' => 3,
        );
        $options['wcz-set-cart-inc-max'] = array(
            'id' => 'wcz-set-cart-inc-max',
            'label'   => __( 'Maximum Value Allowed', 'woocustomizer' ),
            'section' => $section,
            'type'    => 'number',
            'default' => 10,
        );
        $options['wcz-set-cart-inc-by'] = array(
            'id' => 'wcz-set-cart-inc-by',
            'label'   => __( 'Increment / Decrement By', 'woocustomizer' ),
            'section' => $section,
            'type'    => 'number',
            'default' => 1,
        );

        // Adjust Simple Product Stock Status Text - Get Working with Variable Products !
        $options['wcz-edit-stockstatus'] = array(
            'id' => 'wcz-edit-stockstatus',
            'label'   => __( 'Edit Stock Status Texts', 'woocustomizer' ),
            'section' => $section,
            'type'    => 'checkbox',
            'description' => __( 'Currently only available for Simple Products.', 'woocustomizer' ),
            'default' => 0,
        );
        $options['wcz-product-outofstock-txt'] = array(
            'id' => 'wcz-product-outofstock-txt',
            'label'   => __( 'Out Of Stock Text', 'woocustomizer' ),
            'section' => $section,
            'type'    => 'text',
            'default' => __( 'Out Of Stock', 'woocustomizer'),
        );
        $options['wcz-product-instock-txt'] = array(
            'id' => 'wcz-product-instock-txt',
            'label'   => __( 'In Stock Text', 'woocustomizer' ),
            'section' => $section,
            'type'    => 'text',
            'description' => __( 'Managing stock at a product level, you can display the stock amount here by using "[no]" in the text to display the amount, or simply add your own text.', 'woocustomizer' ),
            'default' => __( 'Stock Available', 'woocustomizer'),
        );
        $options['wcz-product-onbackorder-txt'] = array(
            'id' => 'wcz-product-onbackorder-txt',
            'label'   => __( 'On Back Order Text', 'woocustomizer' ),
            'section' => $section,
            'type'    => 'text',
            'default' => __( 'On Back Order', 'woocustomizer'),
        );
        $options['wcz-always-show-stockstatus'] = array(
            'id' => 'wcz-always-show-stockstatus',
            'label'   => __( 'Always Show Stock Status Types', 'woocustomizer' ),
            'section' => $section,
            'type'    => 'checkbox',
            'default' => 0,
        );
        $options['wcz-product-instock-deaf-txt'] = array(
            'id' => 'wcz-product-instock-deaf-txt',
            'label'   => __( 'Stock Text', 'woocustomizer' ),
            'section' => $section,
            'type'    => 'text',
            'description' => __( 'If not managing stock at a product level, by default nothing shows. Add default \'In Stock\' text if you want to show the product is in stock.', 'woocustomizer' ),
            'default' => __( 'In Stock', 'woocustomizer'),
        );

        // Product Settings - Tabs
        $options['wcz-heading-product-tabs'] = array(
            'id' => 'wcz-heading-product-tabs',
            'label'   => __( 'Product Page Tabs', 'woocustomizer' ),
            'section' => $section,
            'type'    => 'url',
        );
        $choices = array( // Edit/Remove Description Tab
            'reset' => '',
            'wcz-wcproduct-desc-tab-edit' => 'Edit Tab Text',
            'wcz-wcproduct-desc-tab-remove' => 'Remove Tab',
        );
        $options['wcz-wcproduct-desc-tab'] = array(
            'id' => 'wcz-wcproduct-desc-tab',
            'label'   => __( 'Description Tab', 'woocustomizer' ),
            'section' => $section,
            'type'    => 'radio',
            'choices' => $choices,
            'default' => ''
        );
        $options['wcz-wcproduct-desc-tab-title'] = array(
            'id' => 'wcz-wcproduct-desc-tab-title',
            'label'   => __( 'Tab Title', 'woocustomizer' ),
            'section' => $section,
            'type'    => 'text',
            'default' => __( 'Description', 'woocustomizer'),
        );
        $options['wcz-wcproduct-desc-head'] = array(
            'id' => 'wcz-wcproduct-desc-head',
            'label'   => __( 'Tab Heading', 'woocustomizer' ),
            'section' => $section,
            'type'    => 'text',
            'default' => __( 'Description', 'woocustomizer'),
        ); // Edit/Remove Description Tab

        $choices = array( // Edit/Remove Additional Info Tab
            'reset' => '',
            'wcz-wcproduct-addinfo-tab-edit' => 'Edit Tab Text',
            'wcz-wcproduct-addinfo-tab-remove' => 'Remove Tab',
        );
        $options['wcz-wcproduct-addinfo-tab'] = array(
            'id' => 'wcz-wcproduct-addinfo-tab',
            'label'   => __( 'Additional Info Tab', 'woocustomizer' ),
            'section' => $section,
            'type'    => 'radio',
            'choices' => $choices,
            'default' => ''
        );
        $options['wcz-wcproduct-addinfo-tab-title'] = array(
            'id' => 'wcz-wcproduct-addinfo-tab-title',
            'label'   => __( 'Tab Title', 'woocustomizer' ),
            'section' => $section,
            'type'    => 'text',
            'default' => __( 'Additional Information', 'woocustomizer'),
        );
        $options['wcz-wcproduct-addinfo-head'] = array(
            'id' => 'wcz-wcproduct-addinfo-head',
            'label'   => __( 'Tab Heading', 'woocustomizer' ),
            'section' => $section,
            'type'    => 'text',
            'default' => __( 'Additional Information', 'woocustomizer'),
        ); // Edit/Remove Additional Info Tab

        $choices = array( // Edit/Remove Reviews Tab
            'reset' => '',
            'wcz-wcproduct-reviews-tab-edit' => 'Edit Tab Text',
            'wcz-wcproduct-reviews-tab-remove' => 'Remove Tab',
        );
        $options['wcz-wcproduct-reviews-tab'] = array(
            'id' => 'wcz-wcproduct-reviews-tab',
            'label'   => __( 'Reviews Tab', 'woocustomizer' ),
            'section' => $section,
            'type'    => 'radio',
            'choices' => $choices,
            'default' => ''
        );
        $options['wcz-wcproduct-reviews-tab-title'] = array(
            'id' => 'wcz-wcproduct-reviews-tab-title',
            'label'   => __( 'Tab Title', 'woocustomizer' ),
            'section' => $section,
            'type'    => 'text',
            'default' => __( 'Reviews', 'woocustomizer'),
        ); // Edit/Remove Reviews Tab

        $options['wcz-add-product-long-desc'] = array(
            'id' => 'wcz-add-product-long-desc',
            'label'   => __( 'Add Product Long Description after Tabs', 'woocustomizer' ),
            'section' => $section,
            'type'    => 'checkbox',
            'default' => 0,
        );

        // Product Settings - Related & Recommended
        $options['wcz-heading-product-relrec'] = array(
            'id' => 'wcz-heading-product-relrec',
            'label'   => __( 'Related & Recommended Products', 'woocustomizer' ),
            'section' => $section,
            'type'    => 'url',
        );
        $choices = array( // Edit/Remove Product Recommedations
            'reset' => '',
            'wcz-wcproduct-recomm-edit' => 'Edit Title',
            'wcz-wcproduct-recomm-remove' => 'Remove Section',
        );
        $options['wcz-wcproduct-recomm'] = array(
            'id' => 'wcz-wcproduct-recomm',
            'label'   => __( 'Product Recommendations', 'woocustomizer' ),
            'section' => $section,
            'type'    => 'radio',
            'choices' => $choices,
            'default' => ''
        );
        $options['wcz-wcproduct-recomm-title'] = array(
            'id' => 'wcz-wcproduct-recomm-title',
            'label'   => __( 'Recommendations Title', 'woocustomizer' ),
            'section' => $section,
            'type'    => 'text',
            'default' => __( 'You may also like&hellip;', 'woocustomizer'),
        ); // Edit/Remove Product Recommedations
        $options['wcz-product-recomm-ppr'] = array(
            'id' => 'wcz-product-recomm-ppr',
            'label'   => __( 'Products Per Row', 'woocustomizer' ),
            'section' => $section,
            'type'    => 'range',
            'input_attrs' => array(
                'min'   => 2,
                'max'   => 5,
                'step'  => 1,
            ),
            'description' => __( '<i>2</i> <b>|</b> 3 <b>|</b> 4 <b>|</b> <i>5</i>', 'woocustomizer' ),
            'default' => 3
        );

        $choices = array( // Edit/Remove Related Products
            'reset' => '',
            'wcz-wcproduct-related-edit' => 'Edit Title',
            'wcz-wcproduct-related-remove' => 'Remove Section',
        );
        $options['wcz-wcproduct-related'] = array(
            'id' => 'wcz-wcproduct-related',
            'label'   => __( 'Related Products', 'woocustomizer' ),
            'section' => $section,
            'type'    => 'radio',
            'choices' => $choices,
            'default' => ''
        );
        $options['wcz-wcproduct-related-title'] = array(
            'id' => 'wcz-wcproduct-related-title',
            'label'   => __( 'Related Products Title', 'woocustomizer' ),
            'section' => $section,
            'type'    => 'text',
            'default' => __( 'Related products', 'woocustomizer'),
        ); // Edit/Remove Related Products
        $options['wcz-product-related-ppr'] = array(
            'id' => 'wcz-product-related-ppr',
            'label'   => __( 'Products Per Row', 'woocustomizer' ),
            'section' => $section,
            'type'    => 'range',
            'input_attrs' => array(
                'min'   => 2,
                'max'   => 5,
                'step'  => 1,
            ),
            'description' => __( '<i>2</i> <b>|</b> 3 <b>|</b> 4 <b>|</b> <i>5</i>', 'woocustomizer' ),
            'default' => 3
        );
        
        // -------------------------------- Product Page Design Settings
        $options['wcz-heading-wcc-prod'] = array(
            'id' => 'wcz-heading-wcc-prod',
            'label'   => __( 'Design Elements', 'woocustomizer' ),
            'section' => $section,
            'type'    => 'url',
            'description' => __( 'Depending on your theme, these design settings might not always work. If not, please contact us to help get these working with your theme.', 'woocustomizer' ),
        );
        // Customize - Product Title
        $options['wcz-wc-edit-product-title'] = array(
            'id' => 'wcz-wc-edit-product-title',
            'label'   => __( 'Customize Product Title', 'woocustomizer' ),
            'section' => $section,
            'type'    => 'checkbox',
            'default' => 0,
        );
        $wcz_sfsval = get_option( 'wcz-product-title-fsize', 34 );
        $options['wcz-product-title-fsize'] = array(
            'id' => 'wcz-product-title-fsize',
            'label'   => __( 'Font Size', 'woocustomizer' ),
            'section' => $section,
            'type'    => 'range',
            'input_attrs' => array(
                'min'   => 12,
                'max'   => 48,
                'step'  => 1,
            ),
            'description' => '<i>10</i> <span><b class="wcz-rangeval">' . esc_html( $wcz_sfsval ) . '</b></span> <i>48</i>', // Non translatale Numbers
            'default' => 34
        );
        $options['wcz-product-title-fcolor'] = array(
            'id' => 'wcz-product-title-fcolor',
            'label'   => __( 'Font Color', 'woocustomizer' ),
            'section' => $section,
            'type'    => 'color',
            'default' => '#444',
        );
        // Customize - Product Price
        $options['wcz-wc-edit-product-price'] = array(
            'id' => 'wcz-wc-edit-product-price',
            'label'   => __( 'Customize Product Price', 'woocustomizer' ),
            'section' => $section,
            'type'    => 'checkbox',
            'default' => 0,
        );
        $wcz_sfsval = get_option( 'wcz-product-price-fsize', 18 );
        $options['wcz-product-price-fsize'] = array(
            'id' => 'wcz-product-price-fsize',
            'label'   => __( 'Font Size', 'woocustomizer' ),
            'section' => $section,
            'type'    => 'range',
            'input_attrs' => array(
                'min'   => 11,
                'max'   => 44,
                'step'  => 1,
            ),
            'description' => '<i>11</i> <span><b class="wcz-rangeval">' . esc_html( $wcz_sfsval ) . '</b></span> <i>44</i>', // Non translatale Numbers
            'default' => 18
        );
        $options['wcz-product-price-fcolor'] = array(
            'id' => 'wcz-product-price-fcolor',
            'label'   => __( 'Font Color', 'woocustomizer' ),
            'section' => $section,
            'type'    => 'color',
            'default' => '#222',
        );
        // Customize - Continue Shopping Button
        $options['wcz-wc-edit-contshop-btn'] = array(
            'id' => 'wcz-wc-edit-contshop-btn',
            'label'   => __( 'Customize \'Continue Shopping\' Button', 'woocustomizer' ),
            'section' => $section,
            'type'    => 'checkbox',
            'default' => 0,
        );
        $options['wcz-contshop-bgcolor'] = array(
            'id' => 'wcz-contshop-bgcolor',
            'label'   => __( 'Button Color', 'woocustomizer' ),
            'section' => $section,
            'type'    => 'color',
            'default' => '#ebe9eb',
        );
        $options['wcz-contshop-hovercolor'] = array(
            'id' => 'wcz-contshop-hovercolor',
            'label'   => __( 'Button Hover Color', 'woocustomizer' ),
            'section' => $section,
            'type'    => 'color',
            'default' => '#cccacc',
        );
        $wcz_cs_btn_fs = get_option( 'wcz-contshop-fsize', 18 );
        $options['wcz-contshop-fsize'] = array(
            'id' => 'wcz-contshop-fsize',
            'label'   => __( 'Font Size', 'woocustomizer' ),
            'section' => $section,
            'type'    => 'range',
            'input_attrs' => array(
                'min'   => 11,
                'max'   => 34,
                'step'  => 1,
            ),
            'description' => '<i>11</i> <span><b class="wcz-rangeval">' . esc_html( $wcz_cs_btn_fs ) . '</b></span> <i>34</i>', // Non translatale Numbers
            'default' => 18
        );
        $wcz_cs_btn_pad = get_option( 'wcz-contshop-pad', 18 );
        $options['wcz-contshop-pad'] = array(
            'id' => 'wcz-contshop-pad',
            'label'   => __( 'Button Padding', 'woocustomizer' ),
            'section' => $section,
            'type'    => 'range',
            'input_attrs' => array(
                'min'   => 10,
                'max'   => 40,
                'step'  => 1,
            ),
            'description' => '<i>10</i> <span><b class="wcz-rangeval">' . esc_html( $wcz_cs_btn_pad ) . '</b></span> <i>40</i>', // Non translatale Numbers
            'default' => 18
        );
        // -------------------------------- Product Page Design Settings
        // ----------------------------------------------------------------------------------------------- WooCommerce Product Page

        // ----------------------------------------------------------------------------------------------- WooCommerce Account Page
        $section = 'wcz-panel-account';
        $sections[] = array(
            'id' => $section,
            'title' => __( 'Account Page', 'woocustomizer' ),
            'priority' => '10',
            'panel' => $panel,
            // 'description' => '<a href="#wcz-panel-settings-hahaha" rel="wcz-section">link</a> here'
        );

        $choices = array( // Account Page Tab Styling
            'wcz-tabstyle-none' => 'None',
            'wcz-tabstyle-side' => 'Side Tab Styling',
            'wcz-tabstyle-horizontal' => 'Horizontal Styling',
        );
        $options['wcz-tab-style'] = array(
            'id' => 'wcz-tab-style',
            'label'   => __( 'Account Tab Design', 'woocustomizer' ),
            'section' => $section,
            'type'    => 'select',
            'choices' => $choices,
            'description' => __( 'Account Tab Design is only for if your theme has not added custom styling to your WooCommerce Account Page.', 'woocustomizer'),
            'default' => 'wcz-tabstyle-none'
        );

        // Account Tabs
        $options['wcz-heading-account-tabs'] = array(
            'id' => 'wcz-heading-account-tabs',
            'label'   => __( 'Account Tabs', 'woocustomizer' ),
            'section' => $section,
            'type'    => 'url',
        );
        $choices = array( // Edit/Remove Dashboard Tab
            'reset' => '',
            'wcz-account-dashboard-edit' => 'Edit Tab Text',
            'wcz-account-dashboard-remove' => 'Remove Tab',
        );
        $options['wcz-account-dashboard-tab'] = array(
            'id' => 'wcz-account-dashboard-tab',
            'label'   => __( 'Account Dashboard Tab', 'woocustomizer' ),
            'section' => $section,
            'type'    => 'radio',
            'choices' => $choices,
            'default' => ''
        );
        $options['wcz-account-tab-dash-tab'] = array(
            'id' => 'wcz-account-tab-dash-tab',
            'label'   => __( 'Dashboard Tab Title', 'woocustomizer' ),
            'section' => $section,
            'type'    => 'text',
            'default' => __( 'Dashboard', 'woocustomizer'),
        ); // Edit/Remove Dashboard Tab

        $choices = array( // Edit/Remove Orders Tab
            'reset' => '',
            'wcz-account-orders-edit' => 'Edit Tab Text',
            'wcz-account-orders-remove' => 'Remove Tab',
        );
        $options['wcz-account-orders-tab'] = array(
            'id' => 'wcz-account-orders-tab',
            'label'   => __( 'Orders Tab', 'woocustomizer' ),
            'section' => $section,
            'type'    => 'radio',
            'choices' => $choices,
            'default' => ''
        );
        $options['wcz-account-tab-orders-tab'] = array(
            'id' => 'wcz-account-tab-orders-tab',
            'label'   => __( 'Tab Title', 'woocustomizer' ),
            'section' => $section,
            'type'    => 'text',
            'default' => __( 'Orders', 'woocustomizer'),
        );
        $options['wcz-account-tab-orders-title'] = array(
            'id' => 'wcz-account-tab-orders-title',
            'label'   => __( 'Page Title', 'woocustomizer' ),
            'section' => $section,
            'type'    => 'text',
            'default' => __( 'Orders', 'woocustomizer'),
        ); // Edit/Remove Orders Tab


        $choices = array( // Edit/Remove Downloads Tab
            'reset' => '',
            'wcz-account-downloads-edit' => 'Edit Tab Text',
            'wcz-account-downloads-remove' => 'Remove Tab',
        );
        $options['wcz-account-downloads-tab'] = array(
            'id' => 'wcz-account-downloads-tab',
            'label'   => __( 'Downloads Tab', 'woocustomizer' ),
            'section' => $section,
            'type'    => 'radio',
            'choices' => $choices,
            'default' => ''
        );
        $options['wcz-account-tab-downloads-tab'] = array(
            'id' => 'wcz-account-tab-downloads-tab',
            'label'   => __( 'Tab Title', 'woocustomizer' ),
            'section' => $section,
            'type'    => 'text',
            'default' => __( 'Downloads', 'woocustomizer'),
        );
        $options['wcz-account-tab-downloads-title'] = array(
            'id' => 'wcz-account-tab-downloads-title',
            'label'   => __( 'Page Title', 'woocustomizer' ),
            'section' => $section,
            'type'    => 'text',
            'default' => __( 'Downloads', 'woocustomizer'),
        ); // Edit/Remove Downloads Tab


        $choices = array( // Edit/Remove Addresses Tab
            'reset' => '',
            'wcz-account-address-edit' => 'Edit Tab Text',
            'wcz-account-address-remove' => 'Remove Tab',
        );
        $options['wcz-account-address-tab'] = array(
            'id' => 'wcz-account-address-tab',
            'label'   => __( 'Address Tab', 'woocustomizer' ),
            'section' => $section,
            'type'    => 'radio',
            'choices' => $choices,
            'default' => ''
        );
        $options['wcz-account-tab-address-tab'] = array(
            'id' => 'wcz-account-tab-address-tab',
            'label'   => __( 'Tab Title', 'woocustomizer' ),
            'section' => $section,
            'type'    => 'text',
            'default' => __( 'Addresses', 'woocustomizer'),
        );
        $options['wcz-account-tab-address-title'] = array(
            'id' => 'wcz-account-tab-address-title',
            'label'   => __( 'Page Title', 'woocustomizer' ),
            'section' => $section,
            'type'    => 'text',
            'default' => __( 'Addresses', 'woocustomizer'),
        ); // Edit/Remove Addresses Tab


        $choices = array( // Edit/Remove Account Details Tab
            'reset' => '',
            'wcz-account-details-edit' => 'Edit Tab Text',
            'wcz-account-details-remove' => 'Remove Tab',
        );
        $options['wcz-account-details-tab'] = array(
            'id' => 'wcz-account-details-tab',
            'label'   => __( 'Account Details Tab', 'woocustomizer' ),
            'section' => $section,
            'type'    => 'radio',
            'choices' => $choices,
            'default' => ''
        );
        $options['wcz-account-tab-details-tab'] = array(
            'id' => 'wcz-account-tab-details-tab',
            'label'   => __( 'Tab Title', 'woocustomizer' ),
            'section' => $section,
            'type'    => 'text',
            'default' => __( 'Account Details', 'woocustomizer'),
        );
        $options['wcz-account-tab-details-title'] = array(
            'id' => 'wcz-account-tab-details-title',
            'label'   => __( 'Page Title', 'woocustomizer' ),
            'section' => $section,
            'type'    => 'text',
            'default' => __( 'Account Details', 'woocustomizer'),
        ); // Edit/Remove Account Details Tab

        
        $choices = array( // Edit/Remove Logout Tab
            'reset' => '',
            'wcz-account-logout-edit' => 'Edit Tab Text',
            'wcz-account-logout-remove' => 'Remove Tab',
        );
        $options['wcz-account-logout-tab'] = array(
            'id' => 'wcz-account-logout-tab',
            'label'   => __( 'Logout Tab', 'woocustomizer' ),
            'section' => $section,
            'type'    => 'radio',
            'choices' => $choices,
            'default' => ''
        );
        $options['wcz-account-tab-logout-tab'] = array(
            'id' => 'wcz-account-tab-logout-tab',
            'label'   => __( 'Tab Title', 'woocustomizer' ),
            'section' => $section,
            'type'    => 'text',
            'default' => __( 'Logout', 'woocustomizer'),
        ); // Edit/Remove Logout Tab


        // EXCLUDED FROM FREE VERSION -- This "if" block will be auto removed from the Free version.
        if ( wcz_fs()->can_use_premium_code__premium_only() ) {
            
            // ---------------- New Tabs

            // Account New Tabs
            $options['wcz-heading-account-newtabs'] = array(
                'id' => 'wcz-heading-account-newtabs',
                'label'   => __( 'Add New Account Tabs', 'woocustomizer' ),
                'section' => $section,
                'type'    => 'url',
            );
            $options['wcz-accendpoint-one'] = array(
                'id' => 'wcz-accendpoint-one',
                'label'   => __( 'Add a new Account Tab to the Top', 'woocustomizer' ),
                'section' => $section,
                'type'    => 'checkbox',
                'description' => __( 'Before you can view this new tab, click Publish at the top.<br /><br />Then you\'ll need to <a href="' . esc_url( admin_url( 'options-permalink.php' ) ) . '" target="_blank">Go to the Permalinks page</a>, scroll to the bottom and click \'Save Changes\'<br /><br />Then <a href="javascript:window.location.reload(true)">Refresh this page</a> to view the new tab.', 'woocustomizer'),
                'default' => 0,
            );

            $options['wcz-account-tab-one-tab'] = array(
                'id' => 'wcz-account-tab-one-tab',
                'label'   => __( 'Tab Title', 'woocustomizer' ),
                'section' => $section,
                'type'    => 'text',
                'default' => __( 'New Tab', 'woocustomizer'),
            );
            $options['wcz-account-tab-one-title'] = array(
                'id' => 'wcz-account-tab-one-title',
                'label'   => __( 'Page Title', 'woocustomizer' ),
                'section' => $section,
                'type'    => 'text',
                'default' => __( 'My New Tab', 'woocustomizer' ),
            );
            $options['wcz-account-tab-one-pageid'] = array(
                'id' => 'wcz-account-tab-one-pageid',
                'label'   => __( 'Example Drop Down Pages', 'woocustomizer' ),
                'section' => $section,
                'type'    => 'dropdown-pages',
                'description' => __( 'Select the page you\'d like to display in this new tab.', 'woocustomizer'),
                'default' => ''
            );

            $options['wcz-accendpoint-two'] = array(
                'id' => 'wcz-accendpoint-two',
                'label'   => __( 'Add a new Account Tab to the Top', 'woocustomizer' ),
                'section' => $section,
                'type'    => 'checkbox',
                'description' => __( 'Before you can view this new tab, click Publish at the top.<br /><br />Then you\'ll need to <a href="' . esc_url( admin_url( 'options-permalink.php' ) ) . '" target="_blank">Go to the Permalinks page</a>, scroll to the bottom and click \'Save Changes\'<br /><br />Then <a href="javascript:window.location.reload(true)">Refresh this page</a> to view the new tab.', 'woocustomizer'),
                'default' => 0,
            );

            $options['wcz-account-tab-two-tab'] = array(
                'id' => 'wcz-account-tab-two-tab',
                'label'   => __( 'Tab Title', 'woocustomizer' ),
                'section' => $section,
                'type'    => 'text',
                'default' => __( 'New Tab', 'woocustomizer'),
            );
            $options['wcz-account-tab-two-title'] = array(
                'id' => 'wcz-account-tab-two-title',
                'label'   => __( 'Page Title', 'woocustomizer' ),
                'section' => $section,
                'type'    => 'text',
                'default' => __( 'My New Tab', 'woocustomizer' ),
            );
            $options['wcz-account-tab-two-pageid'] = array(
                'id' => 'wcz-account-tab-two-pageid',
                'label'   => __( 'Example Drop Down Pages', 'woocustomizer' ),
                'section' => $section,
                'type'    => 'dropdown-pages',
                'description' => __( 'Select the page you\'d like to display in this new tab.', 'woocustomizer'),
                'default' => ''
            );

            $options['wcz-accendpoint-three'] = array(
                'id' => 'wcz-accendpoint-three',
                'label'   => __( 'Add a new Account Tab to the Bottom', 'woocustomizer' ),
                'section' => $section,
                'type'    => 'checkbox',
                'description' => __( 'Before you can view this new tab, click Publish at the top.<br /><br />Then you\'ll need to <a href="' . esc_url( admin_url( 'options-permalink.php' ) ) . '" target="_blank">Go to the Permalinks page</a>, scroll to the bottom and click \'Save Changes\'<br /><br />Then <a href="javascript:window.location.reload(true)">Refresh this page</a> to view the new tab.', 'woocustomizer'),
                'default' => 0,
            );

            $options['wcz-account-tab-three-tab'] = array(
                'id' => 'wcz-account-tab-three-tab',
                'label'   => __( 'Tab Title', 'woocustomizer' ),
                'section' => $section,
                'type'    => 'text',
                'default' => __( 'New Tab', 'woocustomizer'),
            );
            $options['wcz-account-tab-three-title'] = array(
                'id' => 'wcz-account-tab-three-title',
                'label'   => __( 'Page Title', 'woocustomizer' ),
                'section' => $section,
                'type'    => 'text',
                'default' => __( 'My New Tab', 'woocustomizer' ),
            );
            $options['wcz-account-tab-three-pageid'] = array(
                'id' => 'wcz-account-tab-three-pageid',
                'label'   => __( 'Example Drop Down Pages', 'woocustomizer' ),
                'section' => $section,
                'type'    => 'dropdown-pages',
                'description' => __( 'Select the page you\'d like to display in this new tab.', 'woocustomizer'),
                'default' => ''
            );

            $options['wcz-accendpoint-four'] = array(
                'id' => 'wcz-accendpoint-four',
                'label'   => __( 'Add a new Account Tab to the bottom', 'woocustomizer' ),
                'section' => $section,
                'type'    => 'checkbox',
                'description' => __( 'Before you can view this new tab, click Publish at the top.<br /><br />Then you\'ll need to <a href="' . esc_url( admin_url( 'options-permalink.php' ) ) . '" target="_blank">Go to the Permalinks page</a>, scroll to the bottom and click \'Save Changes\'<br /><br />Then <a href="javascript:window.location.reload(true)">Refresh this page</a> to view the new tab.', 'woocustomizer'),
                'default' => 0,
            );

            $options['wcz-account-tab-four-tab'] = array(
                'id' => 'wcz-account-tab-four-tab',
                'label'   => __( 'Tab Title', 'woocustomizer' ),
                'section' => $section,
                'type'    => 'text',
                'default' => __( 'New Tab', 'woocustomizer'),
            );
            $options['wcz-account-tab-four-title'] = array(
                'id' => 'wcz-account-tab-four-title',
                'label'   => __( 'Page Title', 'woocustomizer' ),
                'section' => $section,
                'type'    => 'text',
                'default' => __( 'My New Tab', 'woocustomizer' ),
            );
            $options['wcz-account-tab-four-pageid'] = array(
                'id' => 'wcz-account-tab-four-pageid',
                'label'   => __( 'Example Drop Down Pages', 'woocustomizer' ),
                'section' => $section,
                'type'    => 'dropdown-pages',
                'description' => __( 'Select the page you\'d like to display in this new tab.', 'woocustomizer'),
                'default' => ''
            );

        } // EXCLUDED FROM FREE VERSION -- This "if" block will be auto removed from the Free version.

        // ----------------------------------------------------------------------------------------------- WooCommerce Account Page
        
        // ----------------------------------------------------------------------------------------------- WooCommerce Cart Page
        $section = 'wcz-panel-cart';
        $sections[] = array(
            'id' => $section,
            'title' => __( 'Cart Page', 'woocustomizer' ),
            'priority' => '10',
            'panel' => $panel,
        );
        $options['wcz-cart-remove-coupons'] = array(
            'id' => 'wcz-cart-remove-coupons',
            'label'   => __( 'Remove Coupons form', 'woocustomizer' ),
            'section' => $section,
            'type'    => 'checkbox',
            'default' => 0,
        );

        $options['wcz-cart-disable-cart-quantity'] = array(
            'id' => 'wcz-cart-disable-cart-quantity',
            'label'   => __( 'Disable users adjusting the quantity ', 'woocustomizer' ),
            'section' => $section,
            'type'    => 'checkbox',
            'description' => __( 'This will stop users being able to adjust the product amounts in the cart', 'woocustomizer'),
            'default' => 0,
        );
        $options['wcz-cart-ajax-update'] = array(
            'id' => 'wcz-cart-ajax-update',
            'label'   => __( 'Auto Update Cart Amount', 'woocustomizer' ),
            'section' => $section,
            'type'    => 'checkbox',
            'description' => __( 'Users will not need to click \'Update Cart\' anymore, this will remove the update button and will auto update the cart as users change the product amounts.', 'woocustomizer'),
            'default' => 0,
        );
        $options['wcz-cart-remove-links'] = array(
            'id' => 'wcz-cart-remove-links',
            'label'   => __( 'Remove Product Links ', 'woocustomizer' ),
            'section' => $section,
            'type'    => 'checkbox',
            'description' => __( 'This will remove the Product Links in the cart, depending on your theme, this might break the design.', 'woocustomizer'),
            'default' => 0,
        );

        $options['wcz-cart-bts-btn'] = array(
            'id' => 'wcz-cart-bts-btn',
            'label'   => __( 'Add a \'Back To Shop\' button', 'woocustomizer' ),
            'section' => $section,
            'type'    => 'checkbox',
            'description' => __( 'Add a button to the cart page for customers to return to the Shop instead of proceeding to checkout.', 'woocustomizer'),
            'default' => 0,
        );
        $choices = array(
            'woocommerce_before_cart_table' => 'Before Cart Table',
            'woocommerce_cart_coupon' => 'Next to Cart Table Coupon',
            'woocommerce_after_cart_totals' => 'After Proceed to Checkout button',
        );
        $options['wcz-cart-bts-pos'] = array(
            'id' => 'wcz-cart-bts-pos',
            'label'   => __( 'Button Position', 'woocustomizer' ),
            'section' => $section,
            'type'    => 'select',
            'choices' => $choices,
            'default' => 'woocommerce_after_cart_totals'
        );
        $options['wcz-cart-bts-txt'] = array(
            'id' => 'wcz-cart-bts-txt',
            'label'   => __( 'Button Text', 'woocustomizer' ),
            'section' => $section,
            'type'    => 'text',
            'default' => __( 'Back to Shop', 'woocustomizer' ),
        );
        $options['wcz-cart-bts-url'] = array(
            'id' => 'wcz-cart-bts-url',
            'label'   => __( 'Button Custom URL', 'woocustomizer' ),
            'section' => $section,
            'type'    => 'text',
        );
        $options['wcz-cart-bts-color'] = array(
            'id' => 'wcz-cart-bts-color',
            'label'   => __( 'Button Color', 'woocustomizer' ),
            'section' => $section,
            'type'    => 'color',
            'default' => '#ebe9eb',
        );
        $options['wcz-cart-bts-hcolor'] = array(
            'id' => 'wcz-cart-bts-hcolor',
            'label'   => __( 'Button Hover Color', 'woocustomizer' ),
            'section' => $section,
            'type'    => 'color',
            'default' => '#d0d0d0',
        );
        $choices = array(
            'left' => 'Left Align',
            'center' => 'Center Align',
            'right' => 'Right Align',
        );
        $options['wcz-cart-bts-align'] = array(
            'id' => 'wcz-cart-bts-align',
            'label'   => __( 'Button Alignment', 'woocustomizer' ),
            'section' => $section,
            'type'    => 'select',
            'choices' => $choices,
            'default' => 'left'
        );
        
        $options['wcz-heading-final'] = array(
            'id' => 'wcz-heading-final',
            'label'   => __( 'Cross Sells & Cart Totals', 'woocustomizer' ),
            'section' => $section,
            'type'    => 'url',
        );
        $options['wcz-cart-move-crollsells-below'] = array(
            'id' => 'wcz-cart-move-crollsells-below',
            'label'   => __( 'Move Cross Sells to below Cart Totals', 'woocustomizer' ),
            'section' => $section,
            'type'    => 'checkbox',
            'default' => 0,
        );
        $options['wcz-cart-remove-cross-sells'] = array(
            'id' => 'wcz-cart-remove-cross-sells',
            'label'   => __( 'Remove Cross Sell Section', 'woocustomizer' ),
            'section' => $section,
            'type'    => 'checkbox',
            'default' => 0,
        );

        $choices = array( // Edit/Remove Cart Cross Sells Title
            'reset' => '',
            'wcz-wccart-recomm-edit' => 'Edit Title',
            'wcz-wccart-recomm-remove' => 'Remove Title',
        );
        $options['wcz-wccart-recomm'] = array(
            'id' => 'wcz-wccart-recomm',
            'label'   => __( 'Cross Sells Title', 'woocustomizer' ),
            'section' => $section,
            'type'    => 'radio',
            'choices' => $choices,
            'default' => ''
        );
        $options['wcz-wccart-recomm-title'] = array(
            'id' => 'wcz-wccart-recomm-title',
            'label'   => __( 'Cross Sells Title', 'woocustomizer' ),
            'section' => $section,
            'type'    => 'text',
            'default' => __( 'You may be interested in&hellip;', 'woocustomizer'),
        ); // Edit/Remove Cart Cross Sells Title

        $options['wcz-cart-crosssells-ppr'] = array(
            'id' => 'wcz-cart-crosssells-ppr',
            'label'   => __( 'Products Per Row', 'woocustomizer' ),
            'section' => $section,
            'type'    => 'range',
            'input_attrs' => array(
                'min'   => 2,
                'max'   => 5,
                'step'  => 1,
            ),
            'description' => __( '<i>2</i> <b>|</b> 3 <b>|</b> 4 <b>|</b> <i>5</i>', 'woocustomizer' ),
            'default' => 2
        );

        $choices = array( // Edit/Remove Cart Totals Title
            'reset' => '',
            'wcz-wccart-totals-edit' => 'Edit Title',
            'wcz-wccart-totals-remove' => 'Remove Title',
        );
        $options['wcz-wccart-totals'] = array(
            'id' => 'wcz-wccart-totals',
            'label'   => __( 'Cart Totals Title', 'woocustomizer' ),
            'section' => $section,
            'type'    => 'radio',
            'choices' => $choices,
            'default' => ''
        );
        $options['wcz-wccart-totals-title'] = array(
            'id' => 'wcz-wccart-totals-title',
            'label'   => __( 'Cart Totals Title', 'woocustomizer' ),
            'section' => $section,
            'type'    => 'text',
            'default' => __( 'Cart totals', 'woocustomizer'),
        ); // Edit/Remove Cart Totals Title

        // Empty Cart Page Settings
        $options['wcz-heading-emptycart'] = array(
            'id' => 'wcz-heading-emptycart',
            'label'   => __( 'Empty Cart Page', 'woocustomizer' ),
            'section' => $section,
            'type'    => 'url',
        );
        $options['wcz-cart-add-custom-text'] = array(
            'id' => 'wcz-cart-add-custom-text',
            'label'   => __( 'Add Custom Text to Empty Cart Page', 'woocustomizer' ),
            'section' => $section,
            'type'    => 'checkbox',
            'default' => 0,
        );
        $options['wcz-cart-empty-txt'] = array(
            'id' => 'wcz-cart-empty-txt',
            'label'   => __( 'Page Text', 'woocustomizer' ),
            'section' => $section,
            'type'    => 'textarea',
            'description' => __( 'This will only show on the Empty Cart Page', 'woocustomizer'),
            'default' => __( 'Some Extra Text', 'woocustomizer' ),
        );

        $options['wcz-cart-edit-rts'] = array(
            'id' => 'wcz-cart-edit-rts',
            'label'   => __( 'Edit \'Return to Shop\' button', 'woocustomizer' ),
            'section' => $section,
            'type'    => 'checkbox',
            'default' => 0,
        );
        $options['wcz-cart-edit-rts-text'] = array(
            'id' => 'wcz-cart-edit-rts-text',
            'label'   => __( 'Text', 'woocustomizer' ),
            'section' => $section,
            'type'    => 'text',
            'default' => __( 'Return to shop', 'woocustomizer'),
        );
        $options['wcz-cart-edit-rts-page'] = array(
            'id' => 'wcz-cart-edit-rts-page',
            'label'   => __( 'Select the page this button links to', 'woocustomizer' ),
            'section' => $section,
            'type'    => 'dropdown-pages',
            'default' => ''
        );

        $options['wcz-heading-cart-design'] = array(
            'id' => 'wcz-heading-cart-design',
            'label'   => __( 'Design Elements', 'woocustomizer' ),
            'section' => $section,
            'type'    => 'url',
            'description' => __( 'These buttons should be designed by the theme. We try offer extra customization for these elements. If these don\'t work, please get in contact for help.', 'woocustomizer'),
        );
        // Customize - Return To Cart button
        $options['wcz-cart-return-btn'] = array(
            'id' => 'wcz-cart-return-btn',
            'label'   => __( 'Customize "Return To Shop" button', 'woocustomizer' ),
            'section' => $section,
            'type'    => 'checkbox',
            'description' => __( 'Your cart needs to be empty to view this button', 'woocustomizer'),
            'default' => 0,
        );
        $options['wcz-cart-return-btn-align'] = array(
            'id' => 'wcz-cart-return-btn-align',
            'label'   => __( 'Center Align', 'woocustomizer' ),
            'section' => $section,
            'type'    => 'checkbox',
            'default' => 0,
        );
        $wcz_sfsval = get_option( 'wcz-cart-return-btn-fsize', 16 );
        $options['wcz-cart-return-btn-fsize'] = array(
            'id' => 'wcz-cart-return-btn-fsize',
            'label'   => __( 'Font Size', 'woocustomizer' ),
            'section' => $section,
            'type'    => 'range',
            'input_attrs' => array(
                'min'   => 11,
                'max'   => 38,
                'step'  => 1,
            ),
            'description' => '<i>10</i> <span><b class="wcz-rangeval">' . esc_html( $wcz_sfsval ) . '</b></span> <i>44</i>', // Non translatale Numbers
            'default' => 16
        );
        $options['wcz-cart-return-btn-color'] = array(
            'id' => 'wcz-cart-return-btn-color',
            'label'   => __( 'Background Color', 'woocustomizer' ),
            'section' => $section,
            'type'    => 'color',
            'default' => '#222',
        );
        $wcz_sfsval = get_option( 'wcz-cart-return-btn-pad', 10 );
        $options['wcz-cart-return-btn-pad'] = array(
            'id' => 'wcz-cart-return-btn-pad',
            'label'   => __( 'Padding', 'woocustomizer' ),
            'section' => $section,
            'type'    => 'range',
            'input_attrs' => array(
                'min'   => 10,
                'max'   => 60,
                'step'  => 1,
            ),
            'description' => '<i>10</i> <span><b class="wcz-rangeval">' . esc_html( $wcz_sfsval ) . '</b></span> <i>60</i>', // Non translatale Numbers
            'default' => 10
        );
        // Customize - Proceed to Checkout button
        $options['wcz-cart-proceed-btn'] = array(
            'id' => 'wcz-cart-proceed-btn',
            'label'   => __( 'Customize "Proceed To Checkout" button', 'woocustomizer' ),
            'section' => $section,
            'type'    => 'checkbox',
            'default' => 0,
        );
        $wcz_sfsval = get_option( 'wcz-cart-proceed-btn-fsize', 18 );
        $options['wcz-cart-proceed-btn-fsize'] = array(
            'id' => 'wcz-cart-proceed-btn-fsize',
            'label'   => __( 'Font Size', 'woocustomizer' ),
            'section' => $section,
            'type'    => 'range',
            'input_attrs' => array(
                'min'   => 11,
                'max'   => 44,
                'step'  => 1,
            ),
            'description' => '<i>10</i> <span><b class="wcz-rangeval">' . esc_html( $wcz_sfsval ) . '</b></span> <i>44</i>', // Non translatale Numbers
            'default' => 18
        );
        $options['wcz-cart-proceed-btn-color'] = array(
            'id' => 'wcz-cart-proceed-btn-color',
            'label'   => __( 'Font Color', 'woocustomizer' ),
            'section' => $section,
            'type'    => 'color',
            'default' => '#222',
        );
        $wcz_sfsval = get_option( 'wcz-cart-proceed-btn-pad', 20 );
        $options['wcz-cart-proceed-btn-pad'] = array(
            'id' => 'wcz-cart-proceed-btn-pad',
            'label'   => __( 'Padding', 'woocustomizer' ),
            'section' => $section,
            'type'    => 'range',
            'input_attrs' => array(
                'min'   => 10,
                'max'   => 80,
                'step'  => 1,
            ),
            'description' => '<i>10</i> <span><b class="wcz-rangeval">' . esc_html( $wcz_sfsval ) . '</b></span> <i>80</i>', // Non translatale Numbers
            'default' => 20
        );
        // ----------------------------------------------------------------------------------------------- WooCommerce Cart Page

        // ----------------------------------------------------------------------------------------------- WooCommerce Checkout Page
        $section = 'wcz-panel-checkout';
        $sections[] = array(
            'id' => $section,
            'title' => __( 'Checkout Page', 'woocustomizer' ),
            'priority' => '10',
            'panel' => $panel
        );
        $options['wcz-checkout-edit-coupon-txt'] = array(
            'id' => 'wcz-checkout-edit-coupon-txt',
            'label'   => __( 'Edit Coupon Section Text', 'woocustomizer' ),
            'section' => $section,
            'type'    => 'checkbox',
            'default' => 0,
        );
        $options['wcz-checkout-coupon-text'] = array(
            'id' => 'wcz-checkout-coupon-text',
            'label'   => __( 'Coupon Code Text', 'woocustomizer' ),
            'section' => $section,
            'type'    => 'text',
            'default' => __( 'Have a coupon?', 'woocustomizer' ),
        );
        $options['wcz-checkout-coupon-link-text'] = array(
            'id' => 'wcz-checkout-coupon-link-text',
            'label'   => __( 'Coupon Code Link Text', 'woocustomizer' ),
            'section' => $section,
            'type'    => 'text',
            'default' => __( 'Click here to enter your code', 'woocustomizer' ),
        );
        $options['wcz-checkout-coupon-instruction-text'] = array(
            'id' => 'wcz-checkout-coupon-instruction-text',
            'label'   => __( 'Coupon Text', 'woocustomizer' ),
            'section' => $section,
            'type'    => 'text',
            'default' => __( 'If you have a coupon code, please apply it below.', 'woocustomizer' ),
        );

        $options['wcz-checkout-edit-ordernotes-txt'] = array(
            'id' => 'wcz-checkout-edit-ordernotes-txt',
            'label'   => __( 'Edit Order Notes Text', 'woocustomizer' ),
            'section' => $section,
            'type'    => 'checkbox',
            'default' => 0,
        );
        $options['wcz-checkout-ordernotes-label'] = array(
            'id' => 'wcz-checkout-ordernotes-label',
            'label'   => __( 'Label Text', 'woocustomizer' ),
            'section' => $section,
            'type'    => 'text',
            'default' => __( 'Order notes', 'woocustomizer' ),
        );
        $options['wcz-checkout-ordernotes-placeholder'] = array(
            'id' => 'wcz-checkout-ordernotes-placeholder',
            'label'   => __( 'Placeholder Text', 'woocustomizer' ),
            'section' => $section,
            'type'    => 'text',
            'default' => __( 'Notes about your order, e.g. special notes for delivery.', 'woocustomizer' ),
        );

        $options['wcz-checkout-add-img'] = array(
            'id' => 'wcz-checkout-add-img',
            'label'   => __( 'Add Custom Image', 'woocustomizer' ),
            'section' => $section,
            'type'    => 'checkbox',
            'description' => __( 'This can be used to ensure that the site is secure for your users.', 'woocustomizer'),
            'default' => 0,
        );
        $options['wcz-checkout-img'] = array(
            'id' => 'wcz-checkout-img',
            'label'   => __( 'Upload Image', 'woocustomizer' ),
            'section' => $section,
            'type'    => 'upload',
            'description' => __( 'Upload this image at the correct size.', 'woocustomizer'),
	        'default' => '',
        );
        $options['wcz-checkout-img-center'] = array(
            'id' => 'wcz-checkout-img-center',
            'label'   => __( 'Center Image', 'woocustomizer' ),
            'section' => $section,
            'type'    => 'checkbox',
            'default' => 0,
        );

        $options['wcz-checkout-add-po-txt'] = array(
            'id' => 'wcz-checkout-add-po-txt',
            'label'   => __( 'Add Text under Place Order button', 'woocustomizer' ),
            'section' => $section,
            'type'    => 'checkbox',
            'default' => 0,
        );
        $options['wcz-checkout-po-txt'] = array(
            'id' => 'wcz-checkout-po-txt',
            'label'   => __( 'Custom Text', 'woocustomizer' ),
            'section' => $section,
            'type'    => 'textarea',
            'description' => __( 'This will only show up once you refresh and/or go to the Checkout page.', 'woocustomizer'),
            'default' => __( 'Your personal data will help us create your account and to support your user experience throughout this website. Please have a look at our Privacy Policy for more information on how we use your personal data', 'woocustomizer' ),
        );

        $options['wcz-heading-remove-checkout-fields'] = array(
            'id' => 'wcz-heading-remove-checkout-fields',
            'label'   => __( 'Remove Checkout Fields', 'woocustomizer' ),
            'section' => $section,
            'type'    => 'url',
            'description' => __( 'Depending on your theme, the removal of these settings might not work. Edit these settings and then check the site front-end to see if they work.', 'woocustomizer'),
        );
        $options['wcz-checkout-remove-lastname'] = array(
            'id' => 'wcz-checkout-remove-lastname',
            'label'   => __( 'Remove Last Name', 'woocustomizer' ),
            'section' => $section,
            'type'    => 'checkbox',
            'default' => 0,
        );
        $options['wcz-checkout-remove-company'] = array(
            'id' => 'wcz-checkout-remove-company',
            'label'   => __( 'Remove Company Name', 'woocustomizer' ),
            'section' => $section,
            'type'    => 'checkbox',
            'default' => 0,
        );
        $options['wcz-checkout-remove-address'] = array(
            'id' => 'wcz-checkout-remove-address',
            'label'   => __( 'Remove Address', 'woocustomizer' ),
            'section' => $section,
            'type'    => 'checkbox',
            'default' => 0,
        );
        $options['wcz-checkout-remove-towncity'] = array(
            'id' => 'wcz-checkout-remove-towncity',
            'label'   => __( 'Remove Town / City', 'woocustomizer' ),
            'section' => $section,
            'type'    => 'checkbox',
            'default' => 0,
        );
        $options['wcz-checkout-remove-provstate'] = array(
            'id' => 'wcz-checkout-remove-provstate',
            'label'   => __( 'Remove State / Province & Zip Code', 'woocustomizer' ),
            'section' => $section,
            'type'    => 'checkbox',
            'default' => 0,
        );
        $options['wcz-checkout-remove-phone'] = array(
            'id' => 'wcz-checkout-remove-phone',
            'label'   => __( 'Remove Phone Number', 'woocustomizer' ),
            'section' => $section,
            'type'    => 'checkbox',
            'default' => 0,
        );
        $options['wcz-checkout-remove-order-notes'] = array(
            'id' => 'wcz-checkout-remove-order-notes',
            'label'   => __( 'Remove Order Notes', 'woocustomizer' ),
            'section' => $section,
            'type'    => 'checkbox',
            'description' => __( 'Edit <a href="' . esc_url( admin_url( 'admin.php?page=wc-settings&tab=shipping&section=options' ) ) . '" target="_blank">Shipping destination</a> to remove the Shipping Address details.', 'woocustomizer'),
            'default' => 0,
        );

        $options['wcz-heading-checkout-design'] = array(
            'id' => 'wcz-heading-checkout-design',
            'label'   => __( 'Design Elements', 'woocustomizer' ),
            'section' => $section,
            'type'    => 'url',
            'description' => __( 'This button should be designed by the theme. We try offer extra customization for this button. If this doesn\'t work, please get in contact for help.', 'woocustomizer'),
        );
        // Customize - Place Order button
        $options['wcz-checkout-placeorder-btn'] = array(
            'id' => 'wcz-checkout-placeorder-btn',
            'label'   => __( 'Customize the "Place Order" button', 'woocustomizer' ),
            'section' => $section,
            'type'    => 'checkbox',
            'default' => 0,
        );
        $wcz_sfsval = get_option( 'wcz-checkout-placeorder-btn-fsize', 18 );
        $options['wcz-checkout-placeorder-btn-fsize'] = array(
            'id' => 'wcz-checkout-placeorder-btn-fsize',
            'label'   => __( 'Font Size', 'woocustomizer' ),
            'section' => $section,
            'type'    => 'range',
            'input_attrs' => array(
                'min'   => 11,
                'max'   => 44,
                'step'  => 1,
            ),
            'description' => '<i>10</i> <span><b class="wcz-rangeval">' . esc_html( $wcz_sfsval ) . '</b></span> <i>44</i>', // Non translatale Numbers
            'default' => 18
        );
        $options['wcz-checkout-placeorder-btn-color'] = array(
            'id' => 'wcz-checkout-placeorder-btn-color',
            'label'   => __( 'Button Color', 'woocustomizer' ),
            'section' => $section,
            'type'    => 'color',
            'default' => '#222',
        );
        $wcz_sfsval = get_option( 'wcz-checkout-placeorder-btn-pad', 20 );
        $options['wcz-checkout-placeorder-btn-pad'] = array(
            'id' => 'wcz-checkout-placeorder-btn-pad',
            'label'   => __( 'Padding', 'woocustomizer' ),
            'section' => $section,
            'type'    => 'range',
            'input_attrs' => array(
                'min'   => 10,
                'max'   => 80,
                'step'  => 1,
            ),
            'description' => '<i>10</i> <span><b class="wcz-rangeval">' . esc_html( $wcz_sfsval ) . '</b></span> <i>80</i>', // Non translatale Numbers
            'default' => 20
        );
        // ----------------------------------------------------------------------------------------------- WooCommerce Checkout Page



        // EXCLUDED FROM FREE VERSION -- This "if" block will be auto removed from the Free version.
        if ( wcz_fs()->can_use_premium_code__premium_only() ) {
            // ----------------------------------------------------------------------------------------------- WC Catalogue Mode
            if ( 'on' == get_option( 'wcz_set_enable_catalogue_mode', woocustomizer_library_get_default( 'wcz_set_enable_catalogue_mode' ) ) ) :

                $section = 'wcz-panel-wcz-catalogue-mode';
                $sections[] = array(
                    'id' => $section,
                    'title' => __( 'WC Catalogue Mode', 'woocustomizer' ),
                    'priority' => '10',
                    'panel' => $panel,
                    // 'description' => __( '<a href="#wcz-panel-shop" rel="wcz-section">link</a> here', 'woocustomizer' ),
                );
                
                $choices = array( // Edit/Remove Product Price
                    'wcz-cm-edit-all' => 'All Products',
                    'wcz-cm-edit-selected' => 'Selected Products',
                );
                $options['wcz-cm-to-edit'] = array(
                    'id' => 'wcz-cm-to-edit',
                    'label'   => __( 'Catalogue Mode For:', 'woocustomizer' ),
                    'section' => $section,
                    'type'    => 'select',
                    'choices' => $choices,
                    'default' => 'wcz-cm-edit-all'
                );

                $options['wcz-cm-apply-notlogged'] = array(
                    'id' => 'wcz-cm-apply-notlogged',
                    'label'   => __( 'Apply all to ONLY Logged Out users', 'woocustomizer' ),
                    'section' => $section,
                    'type'    => 'checkbox',
                    'description' => __( 'All Changes for Catalogue Mode are now only happening for users NOT LOGGED IN.<br /><br />Please logout to see the changes.', 'woocustomizer'),
                    'default' => 0,
                );

                $options['wcz-heading-cm-editall'] = array(
                    'id' => 'wcz-heading-cm-editall',
                    'label'   => __( 'Edit All Products', 'woocustomizer' ),
                    'section' => $section,
                    'type'    => 'url',
                );
                $options['wcz-heading-cm-editselected'] = array(
                    'id' => 'wcz-heading-cm-editselected',
                    'label'   => __( 'Edit Selected Products', 'woocustomizer' ),
                    'section' => $section,
                    'type'    => 'url',
                );
                $options['wcz-cm-shop-btn'] = array(
                    'id' => 'wcz-cm-shop-btn',
                    'label'   => __( 'Remove Shop Page Buttons', 'woocustomizer' ),
                    'section' => $section,
                    'type'    => 'checkbox',
                    'default' => 0,
                );

                $choices = array( // Edit/Remove Product Price
                    'reset' => '',
                    'wcz-cm-shop-price-edit' => 'Replace With Text',
                    'wcz-cm-shop-price-remove' => 'Remove',
                );
                $options['wcz-cm-shop-price'] = array(
                    'id' => 'wcz-cm-shop-price',
                    'label'   => __( 'Shop Page Price', 'woocustomizer' ),
                    'section' => $section,
                    'type'    => 'radio',
                    'choices' => $choices,
                    'default' => ''
                );
                $options['wcz-cm-shop-price-text'] = array(
                    'id' => 'wcz-cm-shop-price-text',
                    'label'   => __( 'Price Text', 'woocustomizer' ),
                    'section' => $section,
                    'type'    => 'text',
                    'default' => __( 'View Product', 'woocustomizer'),
                ); // Edit/Remove Product Price

                $options['wcz-cm-product-btn'] = array(
                    'id' => 'wcz-cm-product-btn',
                    'label'   => __( 'Remove Product Page Buttons', 'woocustomizer' ),
                    'section' => $section,
                    'type'    => 'checkbox',
                    'default' => 0,
                );

                $choices = array( // Edit/Remove Product Price
                    'reset' => '',
                    'wcz-cm-product-price-edit' => 'Replace With Text',
                    'wcz-cm-product-price-remove' => 'Remove',
                );
                $options['wcz-cm-product-price'] = array(
                    'id' => 'wcz-cm-product-price',
                    'label'   => __( 'Product Page Price', 'woocustomizer' ),
                    'section' => $section,
                    'type'    => 'radio',
                    'choices' => $choices,
                    'default' => ''
                );
                $options['wcz-cm-product-price-text'] = array(
                    'id' => 'wcz-cm-product-price-text',
                    'label'   => __( 'Price Text', 'woocustomizer' ),
                    'section' => $section,
                    'type'    => 'text',
                    'default' => __( 'Product Currently Unavailable', 'woocustomizer'),
                ); // Edit/Remove Product Price

                $options['wcz-cm-show-productid'] = array(
                    'id' => 'wcz-cm-show-productid',
                    'label'   => __( 'Show Product ID\'s for Administrators', 'woocustomizer' ),
                    'section' => $section,
                    'type'    => 'checkbox',
                    'default' => 0,
                );
                $options['wcz-cm-applyto-items'] = array(
                    'id' => 'wcz-cm-applyto-items',
                    'label'   => __( 'Selected Product ID\'s', 'woocustomizer' ),
                    'section' => $section,
                    'type'    => 'text',
                    'description' => __( 'Enter the ID\'s of the selected products, separated by a comma(,).<br />Eg: 38, 40, 41', 'woocustomizer' ),
                    'default' => '',
                );
                $options['wcz-cm-selected-shop-btn'] = array(
                    'id' => 'wcz-cm-selected-shop-btn',
                    'label'   => __( 'Remove Shop Page Buttons', 'woocustomizer' ),
                    'section' => $section,
                    'type'    => 'checkbox',
                    'default' => 0,
                );
                $choices = array( // Edit/Remove Product Price
                    'reset' => '',
                    'wcz-cm-selected-shop-price-edit' => 'Replace With Text',
                    'wcz-cm-selected-shop-price-remove' => 'Remove',
                );
                $options['wcz-cm-selected-shop-price'] = array(
                    'id' => 'wcz-cm-selected-shop-price',
                    'label'   => __( 'Selected Shop Page Price', 'woocustomizer' ),
                    'section' => $section,
                    'type'    => 'radio',
                    'choices' => $choices,
                    'default' => ''
                );
                $options['wcz-cm-selected-shop-price-txt'] = array(
                    'id' => 'wcz-cm-selected-shop-price-txt',
                    'label'   => __( 'Price Text', 'woocustomizer' ),
                    'section' => $section,
                    'type'    => 'text',
                    'default' => __( 'View Product', 'woocustomizer'),
                ); // Edit/Remove Product Price

                $options['wcz-cm-selected-product-btn'] = array(
                    'id' => 'wcz-cm-selected-product-btn',
                    'label'   => __( 'Remove Product Page Buttons', 'woocustomizer' ),
                    'section' => $section,
                    'type'    => 'checkbox',
                    'default' => 0,
                );
                $choices = array( // Edit/Remove Product Price
                    'reset' => '',
                    'wcz-cm-selected-product-price-edit' => 'Replace With Text',
                    'wcz-cm-selected-product-price-remove' => 'Remove',
                );
                $options['wcz-cm-selected-product-price'] = array(
                    'id' => 'wcz-cm-selected-product-price',
                    'label'   => __( 'Selected Product Price', 'woocustomizer' ),
                    'section' => $section,
                    'type'    => 'radio',
                    'choices' => $choices,
                    'default' => ''
                );
                $options['wcz-cm-selected-product-price-txt'] = array(
                    'id' => 'wcz-cm-selected-product-price-txt',
                    'label'   => __( 'Price Text', 'woocustomizer' ),
                    'section' => $section,
                    'type'    => 'text',
                    'default' => __( 'Product Coming Soon', 'woocustomizer'),
                ); // Edit/Remove Product Price

                $options['wcz-heading-cm-cartcheckout'] = array(
                    'id' => 'wcz-heading-cm-cartcheckout',
                    'label'   => __( 'Cart & Checkout Pages', 'woocustomizer' ),
                    'section' => $section,
                    'type'    => 'url',
                );
                $options['wcz-cm-hide-cart-checkout'] = array(
                    'id' => 'wcz-cm-hide-cart-checkout',
                    'label'   => __( 'Hide Cart & Checkout Pages', 'woocustomizer' ),
                    'section' => $section,
                    'type'    => 'checkbox',
                    'default' => 0,
                );

                // Site Notice
                $options['wcz-heading-cm-notice'] = array(
                    'id' => 'wcz-heading-cm-notice',
                    'label'   => __( 'Catalogue Mode Notice', 'woocustomizer' ),
                    'section' => $section,
                    'type'    => 'url',
                );
                $options['wcz-cm-enable-site-notice'] = array(
                    'id' => 'wcz-cm-enable-site-notice',
                    'label'   => __( 'Turn on Catalogue Mode Notice', 'woocustomizer' ),
                    'section' => $section,
                    'type'    => 'checkbox',
                    'default' => 0,
                );
                $options['wcz-cm-notice-txt'] = array(
                    'id' => 'wcz-cm-notice-txt',
                    'label'   => __( 'Notice Text', 'woocustomizer' ),
                    'section' => $section,
                    'type'    => 'textarea',
                    'default' => __( 'Our store is temporarily closed for maintenance... Come back soon!', 'woocustomizer' ),
                );
                $choices = array(
                    'wcz-notice-default' => 'WC default Notice',
                    'wcz-notice-solid' => 'Plain Solid Website',
                );
                $options['wcz-cm-notice-style'] = array(
                    'id' => 'wcz-cm-notice-style',
                    'label'   => __( 'Notice Style', 'woocustomizer' ),
                    'section' => $section,
                    'type'    => 'select',
                    'choices' => $choices,
                    'default' => 'wcz-notice-default'
                );
                $options['wcz-cm-notice-color'] = array(
                    'id' => 'wcz-cm-notice-color',
                    'label'   => __( 'Notice Color', 'woocustomizer' ),
                    'section' => $section,
                    'type'    => 'color',
                    'default' => '#a46497',
                );
                $options['wcz-cm-notice-font-color'] = array(
                    'id' => 'wcz-cm-notice-font-color',
                    'label'   => __( 'Notice Font Color', 'woocustomizer' ),
                    'section' => $section,
                    'type'    => 'color',
                    'default' => '#515151',
                );
                $wcz_cmnfval = get_option( 'wcz-cm-notice-fsize', 16 );
                $options['wcz-cm-notice-fsize'] = array(
                    'id' => 'wcz-cm-notice-fsize',
                    'label'   => __( 'Font Size', 'woocustomizer' ),
                    'section' => $section,
                    'type'    => 'range',
                    'input_attrs' => array(
                        'min'   => 10,
                        'max'   => 28,
                        'step'  => 1,
                    ),
                    'description' => '<i>10</i> <span><b class="wcz-rangeval">' . esc_html( $wcz_cmnfval ) . '</b></span> <i>28</i>', // Non translatale Numbers
                    'default' => 16
                );

            endif;
            // ----------------------------------------------------------------------------------------------- WC Catalogue Mode

            // ----------------------------------------------------------------------------------------------- WC Menu Cart
            if ( 'on' == get_option( 'wcz_set_enable_menu_cart', woocustomizer_library_get_default( 'wcz_set_enable_menu_cart' ) ) ) :
                
                $section = 'wcz-panel-wcz-menu-cart';
                $sections[] = array(
                    'id' => $section,
                    'title' => __( 'WC Menu Cart', 'woocustomizer' ),
                    'priority' => '10',
                    'panel' => $panel,
                    // 'description' => __( '<a href="#wcz-panel-shop" rel="wcz-section">link</a> here', 'woocustomizer' ),
                );
                
                $options['wcz-mc-remove-theme-cart'] = array(
                    'id' => 'wcz-mc-remove-theme-cart',
                    'label'   => __( 'Remove the Theme Cart', 'woocustomizer' ),
                    'section' => $section,
                    'type'    => 'checkbox',
                    'default' => 0,
                );
                $options['wcz-mc-only-shop-cart'] = array(
                    'id' => 'wcz-mc-only-shop-cart',
                    'label'   => __( 'Show ONLY on WooCommerce pages', 'woocustomizer' ),
                    'section' => $section,
                    'type'    => 'checkbox',
                    'default' => 0,
                );
                $options['wcz-mc-only-show-ifitems'] = array(
                    'id' => 'wcz-mc-only-show-ifitems',
                    'label'   => __( 'Show ONLY if cart has items', 'woocustomizer' ),
                    'section' => $section,
                    'type'    => 'checkbox',
                    'description' => __( 'Please open the site is a new tab to see this work', 'woocustomizer' ),
                    'default' => 0,
                );
                $options['wcz-mc-enable-minicart'] = array(
                    'id' => 'wcz-mc-enable-minicart',
                    'label'   => __( 'Add Menu Cart - Mini Cart', 'woocustomizer' ),
                    'section' => $section,
                    'type'    => 'checkbox',
                    'default' => 0,
                );
                $choices = array(
                    'wcz-minicart-left' => 'Align to the Left',
                    'wcz-minicart-right' => 'Align to the Right',
                    'wcz-minicart-center' => 'Center Align',
                );
                $options['wcz-mc-minicart-align'] = array(
                    'id' => 'wcz-mc-minicart-align',
                    'label'   => __( 'Mini Cart Alignment', 'woocustomizer' ),
                    'section' => $section,
                    'type'    => 'select',
                    'choices' => $choices,
                    'default' => 'wcz-minicart-left'
                );

                $choices = array( // Edit/Remove Product Price
                    'fa-shopping-cart' => 'Shopping Cart',
                    'fa-shopping-basket' => 'Shopping Basket',
                    'fa-shopping-bag' => 'Shopping Bag',
                    'fa-tag' => 'Tag',
                    'fa-gift' => 'Gift',
                    'none' => 'None',
                );
                $options['wcz-mc-icon'] = array(
                    'id' => 'wcz-mc-icon',
                    'label'   => __( 'Cart Icon', 'woocustomizer' ),
                    'section' => $section,
                    'type'    => 'select',
                    'choices' => $choices,
                    'description' => __( 'These 2 options will only show when you save and open the site again in a new tab.', 'woocustomizer' ),
                    'default' => 'fa-shopping-cart'
                );

                $choices = array( // Edit/Remove Product Price
                    'one'   => '$30.00 (1 Item)',
                    'two'   => '(1) $30.00',
                    'three' => '$30.00 (1)',
                    'four' => '(1)',
                    'five'  => '1 Item - $30.00',
                );
                $options['wcz-mc-display'] = array(
                    'id' => 'wcz-mc-display',
                    'label'   => __( 'Menu Cart Display', 'woocustomizer' ),
                    'section' => $section,
                    'type'    => 'select',
                    'choices' => $choices,
                    'default' => 'one'
                );

                $options['wcz-mc-align'] = array(
                    'id' => 'wcz-mc-align',
                    'label'   => __( 'Align Menu Cart - Right', 'woocustomizer' ),
                    'section' => $section,
                    'type'    => 'checkbox',
                    'default' => 0,
                );

                // Menu Cart Design
                $options['wcz-heading-mc-design'] = array(
                    'id' => 'wcz-heading-mc-design',
                    'label'   => __( 'Menu Cart Design', 'woocustomizer' ),
                    'section' => $section,
                    'type'    => 'url',
                );
                $options['wcz-mc-edit-design'] = array(
                    'id' => 'wcz-mc-edit-design',
                    'label'   => __( 'Edit Menu Cart Design', 'woocustomizer' ),
                    'section' => $section,
                    'type'    => 'checkbox',
                    'default' => 0,
                );

                $options['wcz-mc-icon-color'] = array(
                    'id' => 'wcz-mc-icon-color',
                    'label'   => __( 'Cart \'Has Items\' Icon Color', 'woocustomizer' ),
                    'section' => $section,
                    'type'    => 'color',
                    'default' => '#444',
                );
                $wcz_mc_iconsize = get_option( 'wcz-mc-icon-size', 12 );
                $options['wcz-mc-icon-size'] = array(
                    'id' => 'wcz-mc-icon-size',
                    'label'   => __( 'Cart Icon Size', 'woocustomizer' ),
                    'section' => $section,
                    'type'    => 'range',
                    'input_attrs' => array(
                        'min'   => 9,
                        'max'   => 22,
                        'step'  => 1,
                    ),
                    'description' => '<i>9</i> <span><b class="wcz-rangeval">' . esc_html( $wcz_mc_iconsize ) . '</b>px</span> <i>22</i>', // Non translatale Numbers
                    'default' => 13
                );

                $options['wcz-mc-drop-bg-color'] = array(
                    'id' => 'wcz-mc-drop-bg-color',
                    'label'   => __( 'Cart Widget Background Color', 'woocustomizer' ),
                    'section' => $section,
                    'type'    => 'color',
                    'default' => '#FFFFFF',
                );
                $options['wcz-mc-drop-btn-color'] = array(
                    'id' => 'wcz-mc-drop-btn-color',
                    'label'   => __( 'Cart Widget Button Color', 'woocustomizer' ),
                    'section' => $section,
                    'type'    => 'color',
                    'default' => '#e8e8e8',
                );
                $options['wcz-mc-drop-btnhover-color'] = array(
                    'id' => 'wcz-mc-drop-btnhover-color',
                    'label'   => __( 'Cart Widget Button:hover Color', 'woocustomizer' ),
                    'section' => $section,
                    'type'    => 'color',
                    'default' => '#9c9c9c',
                );

            endif;
            // ----------------------------------------------------------------------------------------------- WC Menu Cart

            // ----------------------------------------------------------------------------------------------- WC Product Quick View
            if ( 'on' == get_option( 'wcz_set_enable_product_quickview', woocustomizer_library_get_default( 'wcz_set_enable_product_quickview' ) ) ) :

                $section = 'wcz-panel-wcz-product-quickview';
                $sections[] = array(
                    'id' => $section,
                    'title' => __( 'WC Product Quick View', 'woocustomizer' ),
                    'priority' => '10',
                    'panel' => $panel,
                    // 'description' => '<a href="#wcz-panel-shop" rel="wcz-section">link</a> here'
                );
                $options['wcz-enable-product-quickview'] = array(
                    'id' => 'wcz-enable-product-quickview',
                    'label'   => __( 'Enable Product Quick View', 'woocustomizer' ),
                    'section' => $section,
                    'type'    => 'checkbox',
                    'default' => 0,
                );
                $choices = array( // Edit/Remove Product Price
                    'wcz-qv-btn' => 'Default Button',
                    'wcz-qv-img' => 'Over Image Button',
                    'wcz-qv-txt' => 'Plain Text'
                );
                $options['wcz-quickview-type'] = array(
                    'id' => 'wcz-quickview-type',
                    'label'   => __( 'Button Type', 'woocustomizer' ),
                    'section' => $section,
                    'type'    => 'select',
                    'choices' => $choices,
                    'default' => 'wcz-qv-btn'
                );
                $options['wcz-product-quickview-btntxt'] = array(
                    'id' => 'wcz-product-quickview-btntxt',
                    'label'   => __( 'Quick View Button Text', 'woocustomizer' ),
                    'section' => $section,
                    'type'    => 'text',
                    'default' => __( 'Quick View', 'woocustomizer'),
                );

                if ( 'on' == get_option( 'wcz_set_enable_catalogue_mode', woocustomizer_library_get_default( 'wcz_set_enable_catalogue_mode' ) ) ) :
                    $options['wcz-qv-apply-catmode'] = array(
                        'id' => 'wcz-qv-apply-catmode',
                        'label'   => __( 'Apply Catalogue Mode settings to popup', 'woocustomizer' ),
                        'section' => $section,
                        'type'    => 'checkbox',
                        'default' => 0,
                    );
                endif;

                $choices = array( // Edit/Remove Product Price
                    'mfp-zoom-in' => 'Zoom In',
                    'mfp-zoom-out' => 'Zoom Out',
                    'mfp-move-horizontal' => 'Move Horizontal',
                    'mfp-move-from-top' => 'Move From Top',
                    'mfp-fade' => 'Fade',
                    'mfp-3d-unfold' => '3D Unfold',
                );
                $options['wcz-quickview-anim'] = array(
                    'id' => 'wcz-quickview-anim',
                    'label'   => __( 'Popup Animation', 'woocustomizer' ),
                    'section' => $section,
                    'type'    => 'select',
                    'choices' => $choices,
                    'default' => 'mfp-zoom-in'
                );

                $options['wcz-qv-stay-on-shop'] = array(
                    'id' => 'wcz-qv-stay-on-shop',
                    'label'   => __( 'Stay on Shop after item added to cart', 'woocustomizer' ),
                    'section' => $section,
                    'type'    => 'checkbox',
                    'default' => 0,
                );

                $options['wcz-qv-remove-sale'] = array(
                    'id' => 'wcz-qv-remove-sale',
                    'label'   => __( 'Remove Sale Banner', 'woocustomizer' ),
                    'section' => $section,
                    'type'    => 'checkbox',
                    'default' => 0,
                );
                $options['wcz-qv-remove-title'] = array(
                    'id' => 'wcz-qv-remove-title',
                    'label'   => __( 'Remove Title', 'woocustomizer' ),
                    'section' => $section,
                    'type'    => 'checkbox',
                    'default' => 0,
                );
                $options['wcz-qv-remove-rating'] = array(
                    'id' => 'wcz-qv-remove-rating',
                    'label'   => __( 'Remove Rating', 'woocustomizer' ),
                    'section' => $section,
                    'type'    => 'checkbox',
                    'default' => 0,
                );
                $options['wcz-qv-remove-price'] = array(
                    'id' => 'wcz-qv-remove-price',
                    'label'   => __( 'Remove Price', 'woocustomizer' ),
                    'section' => $section,
                    'type'    => 'checkbox',
                    'default' => 0,
                );
                $options['wcz-qv-remove-excerpt'] = array(
                    'id' => 'wcz-qv-remove-excerpt',
                    'label'   => __( 'Remove Short Description', 'woocustomizer' ),
                    'section' => $section,
                    'type'    => 'checkbox',
                    'default' => 0,
                );
                $options['wcz-qv-long-desc'] = array(
                    'id' => 'wcz-qv-long-desc',
                    'label'   => __( 'Add Product Long Description', 'woocustomizer' ),
                    'section' => $section,
                    'type'    => 'checkbox',
                    'default' => 0,
                );
                $options['wcz-qv-remove-addtocart'] = array(
                    'id' => 'wcz-qv-remove-addtocart',
                    'label'   => __( 'Remove \'Add To Cart\' Section', 'woocustomizer' ),
                    'section' => $section,
                    'type'    => 'checkbox',
                    'default' => 0,
                );
                $options['wcz-qv-remove-meta-sku'] = array(
                    'id' => 'wcz-qv-remove-meta-sku',
                    'label'   => __( 'Remove Product Sku', 'woocustomizer' ),
                    'section' => $section,
                    'type'    => 'checkbox',
                    'default' => 0,
                );
                $options['wcz-qv-remove-meta-cats'] = array(
                    'id' => 'wcz-qv-remove-meta-cats',
                    'label'   => __( 'Remove Product Categories', 'woocustomizer' ),
                    'section' => $section,
                    'type'    => 'checkbox',
                    'default' => 0,
                );
                $options['wcz-qv-remove-meta-tags'] = array(
                    'id' => 'wcz-qv-remove-meta-tags',
                    'label'   => __( 'Remove Product Tags', 'woocustomizer' ),
                    'section' => $section,
                    'type'    => 'checkbox',
                    'default' => 0,
                );

                $options['wcz-qv-add-btn'] = array(
                    'id' => 'wcz-qv-add-btn',
                    'label'   => __( 'Add Button Link To Product Page', 'woocustomizer' ),
                    'section' => $section,
                    'type'    => 'checkbox',
                    'default' => 0,
                );
                $options['wcz-qv-add-btn-txt'] = array(
                    'id' => 'wcz-qv-add-btn-txt',
                    'label'   => __( 'Button Text', 'woocustomizer' ),
                    'section' => $section,
                    'type'    => 'text',
                    'default' => __( 'View Product Page', 'woocustomizer'),
                );

                // Product Quick View Design
                $options['wcz-heading-qv-design'] = array(
                    'id' => 'wcz-heading-qv-design',
                    'label'   => __( 'Quick View Popup Design', 'woocustomizer' ),
                    'section' => $section,
                    'type'    => 'url',
                );
                $wcz_qv_btn_margin = get_option( 'wcz-qv-btn-topmargin', 0 );
                $options['wcz-qv-btn-topmargin'] = array(
                    'id' => 'wcz-qv-btn-topmargin',
                    'label'   => __( 'Button Top Spacing', 'woocustomizer' ),
                    'section' => $section,
                    'type'    => 'range',
                    'input_attrs' => array(
                        'min'   => 0,
                        'max'   => 60,
                        'step'  => 1,
                    ),
                    'description' => '<i>0</i> <span><b class="wcz-rangeval">' . esc_html( $wcz_qv_btn_margin ) . '</b></span> <i>60</i>', // Non translatale Numbers
                    'default' => 0
                );
                $options['wcz-qv-edit-design'] = array(
                    'id' => 'wcz-qv-edit-design',
                    'label'   => __( 'Edit the Popup Design', 'woocustomizer' ),
                    'section' => $section,
                    'type'    => 'checkbox',
                    'default' => 0,
                );
                $wcz_popupwidth = get_option( 'wcz-qv-popup-width', 860 );
                $options['wcz-qv-popup-width'] = array(
                    'id' => 'wcz-qv-popup-width',
                    'label'   => __( 'Popup Max-Width', 'woocustomizer' ),
                    'section' => $section,
                    'type'    => 'range',
                    'input_attrs' => array(
                        'min'   => 600,
                        'max'   => 1000,
                        'step'  => 1,
                    ),
                    'description' => '<i>600</i> <span><b class="wcz-rangeval">' . esc_html( $wcz_popupwidth ) . '</b></span> <i>1000</i>', // Non translatale Numbers
                    'default' => 860
                );
                $wcz_popupimg = get_option( 'wcz-qv-popup-img-size', 0.8 );
                $options['wcz-qv-popup-img-size'] = array(
                    'id' => 'wcz-qv-popup-img-size',
                    'label'   => __( 'Popup Image Size/Width', 'woocustomizer' ),
                    'section' => $section,
                    'type'    => 'range',
                    'input_attrs' => array(
                        'min'   => 0.4,
                        'max'   => 1,
                        'step'  => .1,
                    ),
                    'description' => '<i>0.4</i> <span><b class="wcz-rangeval">' . esc_html( $wcz_popupimg ) . '</b></span> <i>1</i>', // Non translatale Numbers
                    'default' => 0.8
                );
                $options['wcz-qv-center-align'] = array(
                    'id' => 'wcz-qv-center-align',
                    'label'   => __( 'Vertically Center Align Image & Summary', 'woocustomizer' ),
                    'section' => $section,
                    'type'    => 'checkbox',
                    'default' => 0,
                );
                $options['wcz-qv-edit-overlaycolor'] = array(
                    'id' => 'wcz-qv-edit-overlaycolor',
                    'label'   => __( 'Background Overlay Color', 'woocustomizer' ),
                    'section' => $section,
                    'type'    => 'color',
                    'default' => '#000000',
                );
                $wcz_bg_overlay = get_option( 'wcz-qv-edit-overlayop', 0.9 );
                $options['wcz-qv-edit-overlayop'] = array(
                    'id' => 'wcz-qv-edit-overlayop',
                    'label'   => __( 'Background Overlay Opacity', 'woocustomizer' ),
                    'section' => $section,
                    'type'    => 'range',
                    'input_attrs' => array(
                        'min'   => 0,
                        'max'   => 0.9,
                        'step'  => .1,
                    ),
                    'description' => '<i>0</i> <span><b class="wcz-rangeval">' . esc_html( $wcz_bg_overlay ) . '</b></span> <i>0.9</i>', // Non translatale Numbers
                    'default' => 0.9
                );
                $options['wcz-qv-edit-bgcolor'] = array(
                    'id' => 'wcz-qv-edit-bgcolor',
                    'label'   => __( 'Popup Background Color', 'woocustomizer' ),
                    'section' => $section,
                    'type'    => 'color',
                    'default' => '#FFFFFF',
                );
                $options['wcz-qv-remove-border'] = array(
                    'id' => 'wcz-qv-remove-border',
                    'label'   => __( 'Remove Popup Border', 'woocustomizer' ),
                    'section' => $section,
                    'type'    => 'checkbox',
                    'default' => 0,
                );

            endif;
            // ----------------------------------------------------------------------------------------------- WC Product Quick View

            // ----------------------------------------------------------------------------------------------- WC Ajax Search
            if ( 'on' == get_option( 'wcz_set_enable_ajax_search', woocustomizer_library_get_default( 'wcz_set_enable_ajax_search' ) ) ) :

                $section = 'wcz-panel-wcz-ajax-search';
                $sections[] = array(
                    'id' => $section,
                    'title' => __( 'WC Ajax Search', 'woocustomizer' ),
                    'priority' => '10',
                    'panel' => $panel,
                    // 'description' => '<a href="#wcz-panel-shop" rel="wcz-section">link</a> here'
                );
                $options['wcz-enable-ajax-search'] = array(
                    'id' => 'wcz-enable-ajax-search',
                    'label'   => __( 'Add Ajax Search to Shop Page', 'woocustomizer' ),
                    'section' => $section,
                    'type'    => 'checkbox',
                    'description' => __( 'Add an <a href="https://storecustomizer.com/documentation/ajax-search-by-shortcode/" target="_blank">ajax search via shortcode</a>', 'woocustomizer'),
                    'default' => 0,
                );
                $choices = array(
                    'wcz-ajaxs-all' => 'Title, Short & Long Description & SKU',
                    'wcz-ajaxs-title' => 'Only Product Titles',
                    'wcz-ajaxs-title-cont' => 'Product Title & Short Description',
                    'wcz-ajaxs-title-longcont' => 'Product Title & Long Description',
                );
                $options['wcz-search-thro'] = array(
                    'id' => 'wcz-search-thro',
                    'label'   => __( 'Search Through:', 'woocustomizer' ),
                    'section' => $section,
                    'type'    => 'select',
                    'choices' => $choices,
                    'default' => 'wcz-ajaxs-all'
                );

                $options['wcz-as-and-cats'] = array(
                    'id' => 'wcz-as-and-cats',
                    'label'   => __( 'Add Product Category Titles to Search', 'woocustomizer' ),
                    'section' => $section,
                    'type'    => 'checkbox',
                    'default' => 0,
                );
                $options['wcz-as-and-tags'] = array(
                    'id' => 'wcz-as-and-tags',
                    'label'   => __( 'Add Product Tag Titles to Search', 'woocustomizer' ),
                    'section' => $section,
                    'type'    => 'checkbox',
                    'default' => 0,
                );

                $options['wcz-as-min-chars'] = array(
                    'id' => 'wcz-as-min-chars',
                    'label'   => __( 'Character Count to start Ajax Search', 'woocustomizer' ),
                    'section' => $section,
                    'type'    => 'number',
                    'default' => 3,
                );

                $options['wcz-ajaxsearch-ph'] = array(
                    'id' => 'wcz-ajaxsearch-ph',
                    'label'   => __( 'Search Placeholder Text', 'woocustomizer' ),
                    'section' => $section,
                    'type'    => 'text',
                    'default' => __( 'Search For Products', 'woocustomizer'),
                );

                $choices = array(
                    'wcz-as-btn-text' => 'Text',
                    'wcz-as-btn-icon' => 'Icon',
                    'wcz-as-btn-none' => 'None',
                );
                $options['wcz-search-btn'] = array(
                    'id' => 'wcz-search-btn',
                    'label'   => __( 'Search Button', 'woocustomizer' ),
                    'section' => $section,
                    'type'    => 'select',
                    'choices' => $choices,
                    'default' => 'wcz-as-btn-text'
                );
                $options['wcz-ajaxsearch-btn-txt'] = array(
                    'id' => 'wcz-ajaxsearch-btn-txt',
                    'label'   => __( 'Search Button Text', 'woocustomizer' ),
                    'section' => $section,
                    'type'    => 'text',
                    'default' => __( 'Search', 'woocustomizer'),
                );
                $options['wcz-ajaxsearch-remove-btn'] = array(
                    'id' => 'wcz-ajaxsearch-remove-btn',
                    'label'   => __( 'Remove Search Button', 'woocustomizer' ),
                    'section' => $section,
                    'type'    => 'checkbox',
                    'default' => 0,
                );
                $choices = array(
                    'fa-arrow-right' => 'Arrow',
                    'fa-caret-right' => 'Caret',
                    'fa-angle-right' => 'Angle',
                    'fa-chevron-circle-right' => 'Chevron Circle',
                    'fa-caret-square-right' => 'Caret Square',
                    'fa-arrow-circle-right' => 'Arrow Circle',
                    'fa-arrow-alt-circle-right' => 'Circle Alternate',
                );
                $options['wcz-search-btn-icon'] = array(
                    'id' => 'wcz-search-btn-icon',
                    'label'   => __( 'Icon', 'woocustomizer' ),
                    'section' => $section,
                    'type'    => 'select',
                    'choices' => $choices,
                    'default' => 'fa-arrow-right'
                );

                // Ajax Search Results
                $options['wcz-heading-as-results'] = array(
                    'id' => 'wcz-heading-as-results',
                    'label'   => __( 'Search Results', 'woocustomizer' ),
                    'section' => $section,
                    'type'    => 'url',
                );
                $options['wcz-as-results-amount'] = array(
                    'id' => 'wcz-as-results-amount',
                    'label'   => __( 'Maximum Results to Show', 'woocustomizer' ),
                    'section' => $section,
                    'type'    => 'number',
                    'default' => 5,
                );

                $options['wcz-ajaxsearch-remove-img'] = array(
                    'id' => 'wcz-ajaxsearch-remove-img',
                    'label'   => __( 'Remove Image', 'woocustomizer' ),
                    'section' => $section,
                    'type'    => 'checkbox',
                    'default' => 0,
                );
                $options['wcz-ajaxsearch-remove-desc'] = array(
                    'id' => 'wcz-ajaxsearch-remove-desc',
                    'label'   => __( 'Remove Short Description', 'woocustomizer' ),
                    'section' => $section,
                    'type'    => 'checkbox',
                    'default' => 0,
                );
                $options['wcz-ajaxsearch-remove-sale'] = array(
                    'id' => 'wcz-ajaxsearch-remove-sale',
                    'label'   => __( 'Remove Sale Banner', 'woocustomizer' ),
                    'section' => $section,
                    'type'    => 'checkbox',
                    'default' => 0,
                );
                $options['wcz-ajaxsearch-remove-cats'] = array(
                    'id' => 'wcz-ajaxsearch-remove-cats',
                    'label'   => __( 'Remove Categories', 'woocustomizer' ),
                    'section' => $section,
                    'type'    => 'checkbox',
                    'default' => 0,
                );
                $choices = array(
                    'name' => 'Name',
                    'date' => 'Date Created',
                    'rand' => 'Random',
                );
                $options['wcz-search-orderby'] = array(
                    'id' => 'wcz-search-orderby',
                    'label'   => __( 'Order Results by', 'woocustomizer' ),
                    'section' => $section,
                    'type'    => 'select',
                    'choices' => $choices,
                    'default' => 'name'
                );
                $choices = array(
                    'ASC' => 'ASC',
                    'DESC' => 'DESC',
                );
                $options['wcz-search-order'] = array(
                    'id' => 'wcz-search-order',
                    'label'   => __( 'Order', 'woocustomizer' ),
                    'section' => $section,
                    'type'    => 'select',
                    'choices' => $choices,
                    'default' => 'ASC'
                );

                // Ajax Search Design
                $options['wcz-heading-as-design'] = array(
                    'id' => 'wcz-heading-as-design',
                    'label'   => __( 'Ajax Search Design', 'woocustomizer' ),
                    'section' => $section,
                    'type'    => 'url',
                );
                $options['wcz-ajaxsearch-edit-design'] = array(
                    'id' => 'wcz-ajaxsearch-edit-design',
                    'label'   => __( 'Edit Ajax Search Design', 'woocustomizer' ),
                    'section' => $section,
                    'type'    => 'checkbox',
                    'default' => 0,
                );

                
                $wcz_as_fsize = get_option( 'wcz-ajaxsearch-fsize', 16 );
                $options['wcz-ajaxsearch-fsize'] = array(
                    'id' => 'wcz-ajaxsearch-fsize',
                    'label'   => __( 'Font Size', 'woocustomizer' ),
                    'section' => $section,
                    'type'    => 'range',
                    'input_attrs' => array(
                        'min'   => 10,
                        'max'   => 24,
                        'step'  => 1,
                    ),
                    'description' => '<i>10</i> <span><b class="wcz-rangeval">' . esc_html( $wcz_as_fsize ) . '</b></span> <i>24</i>', // Non translatale Numbers
                    'default' => 16
                );
                $options['wcz-ajaxsearch-color'] = array(
                    'id' => 'wcz-ajaxsearch-color',
                    'label'   => __( 'Search Background Color', 'woocustomizer' ),
                    'section' => $section,
                    'type'    => 'color',
                    'default' => '#fafafa',
                );
                $options['wcz-ajaxsearch-btn-color'] = array(
                    'id' => 'wcz-ajaxsearch-btn-color',
                    'label'   => __( 'Search Button Color', 'woocustomizer' ),
                    'section' => $section,
                    'type'    => 'color',
                    'default' => '#666666',
                );
                $options['wcz-ajaxsearch-bg-color'] = array(
                    'id' => 'wcz-ajaxsearch-bg-color',
                    'label'   => __( 'Search Results Background Color', 'woocustomizer' ),
                    'section' => $section,
                    'type'    => 'color',
                    'default' => '#f7f7f7',
                );
                $options['wcz-ajaxsearch-sale-color'] = array(
                    'id' => 'wcz-ajaxsearch-sale-color',
                    'label'   => __( 'Sale Banner Color', 'woocustomizer' ),
                    'section' => $section,
                    'type'    => 'color',
                    'default' => '#f3f5f6',
                );

                $wcz_as_pad = get_option( 'wcz-ajaxsearch-padding', 10 );
                $options['wcz-ajaxsearch-padding'] = array(
                    'id' => 'wcz-ajaxsearch-padding',
                    'label'   => __( 'Search Box Padding', 'woocustomizer' ),
                    'section' => $section,
                    'type'    => 'range',
                    'input_attrs' => array(
                        'min'   => 2,
                        'max'   => 30,
                        'step'  => 1,
                    ),
                    'description' => '<i>2</i> <span><b class="wcz-rangeval">' . esc_html( $wcz_as_pad ) . '</b>px</span> <i>30</i>', // Non translatale Numbers
                    'default' => 10
                );

                $wcz_as_width = get_option( 'wcz-ajaxsearch-width', 100 );
                $options['wcz-ajaxsearch-width'] = array(
                    'id' => 'wcz-ajaxsearch-width',
                    'label'   => __( 'Search Box Max-Width', 'woocustomizer' ),
                    'section' => $section,
                    'type'    => 'range',
                    'input_attrs' => array(
                        'min'   => 30,
                        'max'   => 100,
                        'step'  => 1,
                    ),
                    'description' => '<i>0</i> <span><b class="wcz-rangeval">' . esc_html( $wcz_as_width ) . '</b>%</span> <i>100</i>', // Non translatale Numbers
                    'default' => 100
                );

                $wcz_as_toppad = get_option( 'wcz-ajaxsearch-toppad', 0 );
                $options['wcz-ajaxsearch-toppad'] = array(
                    'id' => 'wcz-ajaxsearch-toppad',
                    'label'   => __( 'Search Box Top Spacing', 'woocustomizer' ),
                    'section' => $section,
                    'type'    => 'range',
                    'input_attrs' => array(
                        'min'   => 0,
                        'max'   => 180,
                        'step'  => 1,
                    ),
                    'description' => '<i>0</i> <span><b class="wcz-rangeval">' . esc_html( $wcz_as_toppad ) . '</b>px</span> <i>180</i>', // Non translatale Numbers
                    'default' => 0
                );
                $wcz_as_botpad = get_option( 'wcz-ajaxsearch-botpad', 25 );
                $options['wcz-ajaxsearch-botpad'] = array(
                    'id' => 'wcz-ajaxsearch-botpad',
                    'label'   => __( 'Search Box Bottom Spacing', 'woocustomizer' ),
                    'section' => $section,
                    'type'    => 'range',
                    'input_attrs' => array(
                        'min'   => 0,
                        'max'   => 180,
                        'step'  => 1,
                    ),
                    'description' => '<i>0</i> <span><b class="wcz-rangeval">' . esc_html( $wcz_as_botpad ) . '</b>px</span> <i>180</i>', // Non translatale Numbers
                    'default' => 25
                );

            endif;
            // ----------------------------------------------------------------------------------------------- WC Ajax Search

            // ----------------------------------------------------------------------------------------------- WC Handheld Footer Bar
            if ( 'on' == get_option( 'wcz_set_enable_handheld_footerbar', woocustomizer_library_get_default( 'wcz_set_enable_handheld_footerbar' ) ) ) :

                $section = 'wcz-panel-wcz-handheld-fb';
                $sections[] = array(
                    'id' => $section,
                    'title' => __( 'WC Handheld Footer Bar', 'woocustomizer' ),
                    'priority' => '10',
                    'panel' => $panel,
                    // 'description' => '<a href="#wcz-panel-shop" rel="wcz-section">link</a> here'
                );
                $choices = array( // Edit/Remove Product Price
                    'wcz-mobile' => __( 'Mobile', 'woocustomizer' ),
                    'wcz-tablet' => __( 'Tablet', 'woocustomizer' ),
                    'wcz-always' => __( 'Always On', 'woocustomizer' ),
                );
                $options['wcz-handheld-footerbar-on'] = array(
                    'id' => 'wcz-handheld-footerbar-on',
                    'label'   => __( 'When to show the Handheld Footer Bar', 'woocustomizer' ),
                    'section' => $section,
                    'type'    => 'select',
                    'choices' => $choices,
                    'description' => __( 'Hint: Change this to "Always On" for easy editing', 'woocustomizer'),
                    'default' => 'wcz-mobile'
                );

                $options['wcz-handheld-add-titles'] = array(
                    'id' => 'wcz-handheld-add-titles',
                    'label'   => __( 'Add Page Titles', 'woocustomizer' ),
                    'section' => $section,
                    'type'    => 'checkbox',
                    'default' => 0,
                );

                $options['wcz-handheld-remove-account'] = array(
                    'id' => 'wcz-handheld-remove-account',
                    'label'   => __( 'Remove Account Link', 'woocustomizer' ),
                    'section' => $section,
                    'type'    => 'checkbox',
                    'default' => 0,
                );
                $options['wcz-handheld-remove-search'] = array(
                    'id' => 'wcz-handheld-remove-search',
                    'label'   => __( 'Remove Search', 'woocustomizer' ),
                    'section' => $section,
                    'type'    => 'checkbox',
                    'default' => 0,
                );
                $options['wcz-handheld-remove-cart'] = array(
                    'id' => 'wcz-handheld-remove-cart',
                    'label'   => __( 'Remove Cart Link', 'woocustomizer' ),
                    'section' => $section,
                    'type'    => 'checkbox',
                    'default' => 0,
                );
                $options['wcz-handheld-add-cart-count'] = array(
                    'id' => 'wcz-handheld-add-cart-count',
                    'label'   => __( 'Add Number of Items to Cart', 'woocustomizer' ),
                    'section' => $section,
                    'type'    => 'checkbox',
                    'default' => 0,
                );

                // Add Custom Link 1
                $options['wcz-add-handheld-link-one'] = array(
                    'id' => 'wcz-add-handheld-link-one',
                    'label'   => __( 'Add a new Handheld Bar Link', 'woocustomizer' ),
                    'section' => $section,
                    'type'    => 'checkbox',
                    'default' => 0,
                );
                $options['wcz-handheld-link-icon-one'] = array(
                    'id' => 'wcz-handheld-link-icon-one',
                    'label'   => __( 'Icon', 'woocustomizer' ),
                    'section' => $section,
                    'type'    => 'text',
                    'description' => __( 'Enter only the name of the <a href="' . esc_url( 'https://developer.wordpress.org/resource/dashicons/#admin-links' ) . '" target="_blank">Dashicon</a> you\'d like to use, excluding "dashicons-"', 'woocustomizer'),
                    'default' => __( 'admin-links', 'woocustomizer'),
                );
                $options['wcz-handheld-link-title-one'] = array(
                    'id' => 'wcz-handheld-link-title-one',
                    'label'   => __( 'Title', 'woocustomizer' ),
                    'section' => $section,
                    'type'    => 'text',
                    'default' => __( 'Title', 'woocustomizer'),
                );
                $options['wcz-handheld-link-page-one'] = array(
                    'id' => 'wcz-handheld-link-page-one',
                    'label'   => __( 'Page to link to', 'woocustomizer' ),
                    'section' => $section,
                    'type'    => 'dropdown-pages',
                    'description' => __( 'Select the page you\'d like to link to.', 'woocustomizer'),
                    'default' => ''
                );
                // Add Custom Link 2
                $options['wcz-add-handheld-link-two'] = array(
                    'id' => 'wcz-add-handheld-link-two',
                    'label'   => __( 'Add a new Handheld Bar Link', 'woocustomizer' ),
                    'section' => $section,
                    'type'    => 'checkbox',
                    'default' => 0,
                );
                $options['wcz-handheld-link-icon-two'] = array(
                    'id' => 'wcz-handheld-link-icon-two',
                    'label'   => __( 'Icon', 'woocustomizer' ),
                    'section' => $section,
                    'type'    => 'text',
                    'description' => __( 'Enter only the name of the <a href="' . esc_url( 'https://developer.wordpress.org/resource/dashicons/#admin-links' ) . '" target="_blank">Dashicon</a> you\'d like to use, excluding "dashicons-"', 'woocustomizer'),
                    'default' => __( 'admin-links', 'woocustomizer'),
                );
                $options['wcz-handheld-link-title-two'] = array(
                    'id' => 'wcz-handheld-link-title-two',
                    'label'   => __( 'Title', 'woocustomizer' ),
                    'section' => $section,
                    'type'    => 'text',
                    'default' => __( 'Title', 'woocustomizer'),
                );
                $options['wcz-handheld-link-page-two'] = array(
                    'id' => 'wcz-handheld-link-page-two',
                    'label'   => __( 'Page to link to', 'woocustomizer' ),
                    'section' => $section,
                    'type'    => 'dropdown-pages',
                    'description' => __( 'Select the page you\'d like to link to.', 'woocustomizer'),
                    'default' => ''
                );
                // Add Custom Link 3
                $options['wcz-add-handheld-link-three'] = array(
                    'id' => 'wcz-add-handheld-link-three',
                    'label'   => __( 'Add a new Handheld Bar Link', 'woocustomizer' ),
                    'section' => $section,
                    'type'    => 'checkbox',
                    'default' => 0,
                );
                $options['wcz-handheld-link-icon-three'] = array(
                    'id' => 'wcz-handheld-link-icon-three',
                    'label'   => __( 'Icon', 'woocustomizer' ),
                    'section' => $section,
                    'type'    => 'text',
                    'description' => __( 'Enter only the name of the <a href="' . esc_url( 'https://developer.wordpress.org/resource/dashicons/#admin-links' ) . '" target="_blank">Dashicon</a> you\'d like to use, excluding "dashicons-"', 'woocustomizer'),
                    'default' => __( 'admin-links', 'woocustomizer'),
                );
                $options['wcz-handheld-link-title-three'] = array(
                    'id' => 'wcz-handheld-link-title-three',
                    'label'   => __( 'Title', 'woocustomizer' ),
                    'section' => $section,
                    'type'    => 'text',
                    'default' => __( 'Title', 'woocustomizer'),
                );
                $options['wcz-handheld-link-page-three'] = array(
                    'id' => 'wcz-handheld-link-page-three',
                    'label'   => __( 'Page to link to', 'woocustomizer' ),
                    'section' => $section,
                    'type'    => 'dropdown-pages',
                    'description' => __( 'Select the page you\'d like to link to.', 'woocustomizer'),
                    'default' => ''
                );
                // Add Custom Link 4
                $options['wcz-add-handheld-link-four'] = array(
                    'id' => 'wcz-add-handheld-link-four',
                    'label'   => __( 'Add a new Handheld Bar Link', 'woocustomizer' ),
                    'section' => $section,
                    'type'    => 'checkbox',
                    'default' => 0,
                );
                $options['wcz-handheld-link-icon-four'] = array(
                    'id' => 'wcz-handheld-link-icon-four',
                    'label'   => __( 'Icon', 'woocustomizer' ),
                    'section' => $section,
                    'type'    => 'text',
                    'description' => __( 'Enter only the name of the <a href="' . esc_url( 'https://developer.wordpress.org/resource/dashicons/#admin-links' ) . '" target="_blank">Dashicon</a> you\'d like to use, excluding "dashicons-"', 'woocustomizer'),
                    'default' => __( 'admin-links', 'woocustomizer'),
                );
                $options['wcz-handheld-link-title-four'] = array(
                    'id' => 'wcz-handheld-link-title-four',
                    'label'   => __( 'Title', 'woocustomizer' ),
                    'section' => $section,
                    'type'    => 'text',
                    'default' => __( 'Title', 'woocustomizer'),
                );
                $options['wcz-handheld-link-page-four'] = array(
                    'id' => 'wcz-handheld-link-page-four',
                    'label'   => __( 'Page to link to', 'woocustomizer' ),
                    'section' => $section,
                    'type'    => 'dropdown-pages',
                    'description' => __( 'Select the page you\'d like to link to.', 'woocustomizer'),
                    'default' => ''
                );
                
                if ( 'on' == get_option( 'wcz_set_enable_ajax_search', woocustomizer_library_get_default( 'wcz_set_enable_ajax_search' ) ) ) :
                    // Handheld Bar Design
                    $options['wcz-heading-hhfb-search'] = array(
                        'id' => 'wcz-heading-hhfb-search',
                        'label'   => __( 'Search Options', 'woocustomizer' ),
                        'section' => $section,
                        'type'    => 'url',
                    );
                    $options['wcz-handheld-use-wcz-search'] = array(
                        'id' => 'wcz-handheld-use-wcz-search',
                        'label'   => __( 'Use StoreCustomizer Ajax Search', 'woocustomizer' ),
                        'section' => $section,
                        'type'    => 'checkbox',
                        'default' => 0,
                    );
                    $options['wcz-handheld-search-placeholder'] = array(
                        'id' => 'wcz-handheld-search-placeholder',
                        'label'   => __( 'Search Placehoder Text', 'woocustomizer' ),
                        'section' => $section,
                        'type'    => 'text',
                        'default' => __( 'Search', 'woocustomizer'),
                    );
                    $options['wcz-handheld-remove-btn'] = array(
                        'id' => 'wcz-handheld-remove-btn',
                        'label'   => __( 'Remove Search Button', 'woocustomizer' ),
                        'section' => $section,
                        'type'    => 'checkbox',
                        'default' => 0,
                    );
                endif;

                // Handheld Bar Design
                $options['wcz-heading-hhfb-design'] = array(
                    'id' => 'wcz-heading-hhfb-design',
                    'label'   => __( 'Handheld Footer Design', 'woocustomizer' ),
                    'section' => $section,
                    'type'    => 'url',
                );
                $options['wcz-handheld-edit-design'] = array(
                    'id' => 'wcz-handheld-edit-design',
                    'label'   => __( 'Edit Handheld Bar Design', 'woocustomizer' ),
                    'section' => $section,
                    'type'    => 'checkbox',
                    'default' => 0,
                );

                $wcz_hh_ts = get_option( 'wcz-handheld-title-size', 11 );
                $options['wcz-handheld-title-size'] = array(
                    'id' => 'wcz-handheld-title-size',
                    'label'   => __( 'Title Size', 'woocustomizer' ),
                    'section' => $section,
                    'type'    => 'range',
                    'input_attrs' => array(
                        'min'   => 10,
                        'max'   => 18,
                        'step'  => 1,
                    ),
                    'description' => '<i>10</i> <span><b class="wcz-rangeval">' . esc_html( $wcz_hh_ts ) . '</b>px</span> <i>18</i>', // Non translatale Numbers
                    'default' => 11
                );
                $options['wcz-handheld-titles-uppercase'] = array(
                    'id' => 'wcz-handheld-titles-uppercase',
                    'label'   => __( 'Titles Text Uppercase', 'woocustomizer' ),
                    'section' => $section,
                    'type'    => 'checkbox',
                    'default' => 0,
                );
                $options['wcz-handheld-bar-bgcolor'] = array(
                    'id' => 'wcz-handheld-bar-bgcolor',
                    'label'   => __( 'Background Color', 'woocustomizer' ),
                    'section' => $section,
                    'type'    => 'color',
                    'default' => '#FFF',
                );
                $options['wcz-handheld-bar-fontcolor'] = array(
                    'id' => 'wcz-handheld-bar-fontcolor',
                    'label'   => __( 'Font Color', 'woocustomizer' ),
                    'section' => $section,
                    'type'    => 'color',
                    'default' => '#999',
                );
                $options['wcz-handheld-bar-hovercolor'] = array(
                    'id' => 'wcz-handheld-bar-hovercolor',
                    'label'   => __( 'Font Selected Color', 'woocustomizer' ),
                    'section' => $section,
                    'type'    => 'color',
                    'default' => '#4373b0',
                );
                $wcz_as_botpad = get_option( 'wcz-handheld-icon-size', 28 );
                $options['wcz-handheld-icon-size'] = array(
                    'id' => 'wcz-handheld-icon-size',
                    'label'   => __( 'Icon Size', 'woocustomizer' ),
                    'section' => $section,
                    'type'    => 'range',
                    'input_attrs' => array(
                        'min'   => 16,
                        'max'   => 48,
                        'step'  => 1,
                    ),
                    'description' => '<i>16</i> <span><b class="wcz-rangeval">' . esc_html( $wcz_as_botpad ) . '</b>px</span> <i>48</i>', // Non translatale Numbers
                    'default' => 28
                );


            endif;
            // ----------------------------------------------------------------------------------------------- WC Handheld Footer Bar

        } // EXCLUDED FROM FREE VERSION -- This "if" block will be auto removed from the Free version.

        // --------------------------------------------------------------------------------------------------------------------------------- WC Panel

    endif;  // is WooCommerce Activated - end

	// Adds the sections to the $options array
	$options['sections'] = $sections;

	// Adds the panels to the $options array
	$options['panels'] = $panels;

	$customizer_library = WooCustomizer_Library::Instance();
	$customizer_library->add_options( $options );

	// To delete custom mods use: woocustomizer_library_remove_theme_mods();

}
add_action( 'init', 'woocustomizer_customizer_library_options' );
