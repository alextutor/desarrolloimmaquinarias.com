<?php
/**
 * Implements styles set in the theme customizer
 *
 * @package Customizer Library WooCommerce Designer
 */

if ( ! function_exists( 'woocustomizer_customizer_library_build_styles' ) && class_exists( 'WooCustomizer_Library_Styles' ) ) :
/**
 * Process user options to generate CSS needed to implement the choices.
 *
 * @since  1.0.0.
 *
 * @return void
 */
function woocustomizer_customizer_library_build_styles() {
	
	// ----------------------------------------------------------------------------------------------- WCD Panel Settings
	// Remove All WooCommerce Breadcrumbs
	$setting = 'wcz-wc-remove-breadcrumbs';
	$mod = get_option( $setting, woocustomizer_library_get_default( $setting ) );

	if ( $mod !== woocustomizer_library_get_default( $setting ) ) {

		$wcz_shop_title = esc_attr( $mod );

		WooCustomizer_Library_Styles()->add( array(
			'selectors' => array(
				'body.woocommerce .woocommerce-breadcrumb'
			),
			'declarations' => array(
				'display' => 'none !important'
			)
		) );
    }
    if ( get_option( 'wcz-wc-notice-banner', woocustomizer_library_get_default( 'wcz-wc-notice-banner' ) ) && get_option( 'wcz-wc-notice-design', woocustomizer_library_get_default( 'wcz-wc-notice-design' ) ) ) :
        // Notice Color
		$setting = 'wcz-wc-notice-color';
		$mod = get_option( $setting, woocustomizer_library_get_default( $setting ) );

		if ( $mod !== woocustomizer_library_get_default( $setting ) ) {

			$wcz_notice_clr = wcz_sanitize_hex_color( $mod );

            if ( 'wcz-notice-four' == get_option( 'wcz-wc-notice-style', woocustomizer_library_get_default( 'wcz-wc-notice-style' ) ) ) {
                WooCustomizer_Library_Styles()->add( array(
                    'selectors' => array(
                        '.wcz-banner-notice.wcz-notice-four'
                    ),
                    'declarations' => array(
                        'background-color' => $wcz_notice_clr,
                        'color' => wcz_getContrastColor( $wcz_notice_clr )
                    )
                ) );
            } else if ( 'wcz-notice-three' == get_option( 'wcz-wc-notice-style', woocustomizer_library_get_default( 'wcz-wc-notice-style' ) ) ) {
                WooCustomizer_Library_Styles()->add( array(
                    'selectors' => array(
                        '.wcz-banner-notice.wcz-notice-three'
                    ),
                    'declarations' => array(
                        'box-shadow' => '4px 0 0 ' . $wcz_notice_clr . ' inset',
                    )
                ) );
            } else if ( 'wcz-notice-two' == get_option( 'wcz-wc-notice-style', woocustomizer_library_get_default( 'wcz-wc-notice-style' ) ) ) {
                $wcz_notice_clr_rgb = woocustomizer_library_hex_to_rgb( $mod );

                WooCustomizer_Library_Styles()->add( array(
                    'selectors' => array(
                        '.wcz-banner-notice.wcz-notice-two'
                    ),
                    'declarations' => array(
                        'background-color' => 'rgba(' . $wcz_notice_clr_rgb['r'] . ', ' . $wcz_notice_clr_rgb['g'] . ', ' . $wcz_notice_clr_rgb['b'] . ', 0.06)'
                    )
                ) );
                WooCustomizer_Library_Styles()->add( array(
                    'selectors' => array(
                        '.wcz-banner-notice.wcz-notice-two'
                    ),
                    'declarations' => array(
                        'border' => '1px solid ' . $wcz_notice_clr,
                    )
                ) );
            } else {
                WooCustomizer_Library_Styles()->add( array(
                    'selectors' => array(
                        '.wcz-banner-notice.wcz-notice-one h4'
                    ),
                    'declarations' => array(
                        'color' => $wcz_notice_clr,
                    )
                ) );
            }
		}
        // Notice Title Size
		$setting = 'wcz-wc-notice-titlesize';
		$mod = get_option( $setting, woocustomizer_library_get_default( $setting ) );
		if ( $mod !== woocustomizer_library_get_default( $setting ) ) {
			$wcz_note_tsize = esc_attr( $mod );

			WooCustomizer_Library_Styles()->add( array(
				'selectors' => array(
					'.wcz-banner-notice h4'
				),
				'declarations' => array(
					'font-size' => $wcz_note_tsize . 'px'
				)
			) );
        }
        // Notice Title Size
		$setting = 'wcz-wc-notice-textsize';
		$mod = get_option( $setting, woocustomizer_library_get_default( $setting ) );
		if ( $mod !== woocustomizer_library_get_default( $setting ) ) {
			$wcz_note_fsize = esc_attr( $mod );

			WooCustomizer_Library_Styles()->add( array(
				'selectors' => array(
					'.wcz-banner-notice p'
				),
				'declarations' => array(
					'font-size' => $wcz_note_fsize . 'px'
				)
			) );
        }
        // Notice Center
		$setting = 'wcz-wc-notice-center';
		$mod = get_option( $setting, woocustomizer_library_get_default( $setting ) );
		if ( $mod !== woocustomizer_library_get_default( $setting ) ) {
			$wcz_note_tsize = esc_attr( $mod );

			WooCustomizer_Library_Styles()->add( array(
				'selectors' => array(
					'.wcz-banner-notice'
				),
				'declarations' => array(
					'text-align' => 'center'
				)
			) );
        }
        // Notice Width
		$setting = 'wcz-wc-notice-width';
		$mod = get_option( $setting, woocustomizer_library_get_default( $setting ) );
		if ( $mod !== woocustomizer_library_get_default( $setting ) ) {
			$wcz_note_width = esc_attr( $mod );

			WooCustomizer_Library_Styles()->add( array(
				'selectors' => array(
					'.wcz-banner-notice'
				),
				'declarations' => array(
					'max-width' => $wcz_note_width . '%'
				)
			) );
		}
        // Notice Margin
		$setting = 'wcz-wc-notice-margin';
		$mod = get_option( $setting, woocustomizer_library_get_default( $setting ) );
		if ( $mod !== woocustomizer_library_get_default( $setting ) ) {
			$wcz_note_margin = esc_attr( $mod );

			WooCustomizer_Library_Styles()->add( array(
				'selectors' => array(
					'.wcz-banner-notice'
				),
				'declarations' => array(
					'margin-bottom' => $wcz_note_margin . 'px'
				)
			) );
		}
    endif;
	// ----------------------------------------------------------------------------------------------- WCD Panel Settings
	
	// ----------------------------------------------------------------------------------------------- WCD Shop Page Settings
	// Remove Shop Page Breadcrumbs
	$setting = 'wcz-shop-remove-breadcrumbs';
	$mod = get_option( $setting, woocustomizer_library_get_default( $setting ) );

	if ( $mod !== woocustomizer_library_get_default( $setting ) ) {

		$wcz_shop_bc = esc_attr( $mod );

		WooCustomizer_Library_Styles()->add( array(
			'selectors' => array(
				'body.post-type-archive-product .woocommerce-breadcrumb'
			),
			'declarations' => array(
				'display' => 'none !important'
			)
		) );
	}
	// Remove Shop Page Title
	$setting = 'wcz-shop-remove-title';
	$mod = get_option( $setting, woocustomizer_library_get_default( $setting ) );

	if ( $mod !== woocustomizer_library_get_default( $setting ) ) {

		$wcz_shop_title = esc_attr( $mod );

		WooCustomizer_Library_Styles()->add( array(
			'selectors' => array(
				'body.post-type-archive-product header.woocommerce-products-header .woocommerce-products-header__title'
			),
			'declarations' => array(
				'display' => 'none !important'
			)
		) );
	}
	// Remove Shop Page Sorting
	$setting = 'wcz-shop-remove-sorting';
	$mod = get_option( $setting, woocustomizer_library_get_default( $setting ) );

	if ( $mod !== woocustomizer_library_get_default( $setting ) ) {

		$wcz_shop_sort = esc_attr( $mod );

		WooCustomizer_Library_Styles()->add( array(
			'selectors' => array(
				'body.woocommerce form.woocommerce-ordering'
			),
			'declarations' => array(
				'display' => 'none !important'
			)
		) );
	}
	// Remove Shop Page Results
	$setting = 'wcz-shop-remove-result';
	$mod = get_option( $setting, woocustomizer_library_get_default( $setting ) );

	if ( $mod !== woocustomizer_library_get_default( $setting ) ) {

		$wcz_shop_result = esc_attr( $mod );

		WooCustomizer_Library_Styles()->add( array(
			'selectors' => array(
				'body.woocommerce p.woocommerce-result-count'
			),
			'declarations' => array(
				'display' => 'none !important'
			)
		) );
	}

	// Remove Shop Archive Breadcrumbs
	$setting = 'wcz-shop-archives-remove-breadcrumbs';
	$mod = get_option( $setting, woocustomizer_library_get_default( $setting ) );

	if ( $mod !== woocustomizer_library_get_default( $setting ) ) {

		$wcz_arch_bc = esc_attr( $mod );

		WooCustomizer_Library_Styles()->add( array(
			'selectors' => array(
				'body.tax-product_cat .woocommerce-breadcrumb,
				body.tax-product_tag .woocommerce-breadcrumb'
			),
			'declarations' => array(
				'display' => 'none !important'
			)
		) );
	}
	// Remove Shop Page Title
	$setting = 'wcz-shop-archives-remove-title';
	$mod = get_option( $setting, woocustomizer_library_get_default( $setting ) );

	if ( $mod !== woocustomizer_library_get_default( $setting ) ) {

		$wcz_arch_title = esc_attr( $mod );

		WooCustomizer_Library_Styles()->add( array(
			'selectors' => array(
				'body.tax-product_cat header.woocommerce-products-header,
				body.tax-product_tag header.woocommerce-products-header'
			),
			'declarations' => array(
				'display' => 'none !important'
			)
		) );
	}
	if ( get_option( 'wcz-shop-new-badge', woocustomizer_library_get_default( 'wcz-shop-new-badge' ) ) ) :
		// "New" Badge Color
		$setting = 'wcz-shop-new-badge-color';
		$mod = get_option( $setting, woocustomizer_library_get_default( $setting ) );

		if ( $mod !== woocustomizer_library_get_default( $setting ) ) {

			$wcz_badge_bgcolor = wcz_sanitize_hex_color( $mod );
			$wcz_badge_bgrgb = woocustomizer_library_hex_to_rgb( $wcz_badge_bgcolor );

			WooCustomizer_Library_Styles()->add( array(
				'selectors' => array(
					'div.wcz-new-product-badge span'
				),
				'declarations' => array(
					'background-color' => $wcz_badge_bgcolor,
					'color' => wcz_getContrastColor( $wcz_badge_bgcolor ) . ' !important'
				)
			) );
		}
    endif;
    
    if ( get_option( 'wcz-wc-edit-btns', woocustomizer_library_get_default( 'wcz-wc-edit-btns' ) ) ) :

		// Button - Font Size
		$setting = 'wcz-btn-fsize';
		$mod = get_option( $setting, woocustomizer_library_get_default( $setting ) );

		if ( $mod !== woocustomizer_library_get_default( $setting ) ) {

			$wcz_btn_fsize = esc_attr( $mod );

			WooCustomizer_Library_Styles()->add( array(
				'selectors' => array(
					'body.wcz-btns.wcz-woocommerce ul.products li.product a.button,
					body.wcz-btns.wcz-woocommerce .related.products ul.products li.product a.button,
                    body.wcz-btns.wcz-woocommerce.single-product div.product form.cart .button,
                    body.wcz-btns.wcz-woocommerce.wcz-wooblocks ul.wc-block-grid__products li.wc-block-grid__product .add_to_cart_button' // Woo Blocks
				),
				'declarations' => array(
					'font-size' => $wcz_btn_fsize . 'px'
				)
			) );
		}
		// Button - Font Weight
		$setting = 'wcz-btn-fweight';
		$mod = get_option( $setting, woocustomizer_library_get_default( $setting ) );

		if ( $mod !== woocustomizer_library_get_default( $setting ) ) {

			$wcz_btn_fweight = esc_attr( $mod );

			WooCustomizer_Library_Styles()->add( array(
				'selectors' => array(
					'body.wcz-btns.wcz-woocommerce ul.products li.product a.button,
					body.wcz-btns.wcz-woocommerce .related.products ul.products li.product a.button,
                    body.wcz-btns.wcz-woocommerce.single-product div.product form.cart .button,
                    body.wcz-btns.wcz-woocommerce.wcz-wooblocks ul.wc-block-grid__products li.wc-block-grid__product .add_to_cart_button' // Woo Blocks
				),
				'declarations' => array(
					'font-weight' => '700'
				)
			) );
		}
		// Button - Color
		$setting = 'wcz-btn-bgcolor';
		$mod = get_option( $setting, woocustomizer_library_get_default( $setting ) );

		if ( $mod !== woocustomizer_library_get_default( $setting ) ) {

			$wcz_btn_bgcolor = wcz_sanitize_hex_color( $mod );
			$wcz_btn_bgrgb = woocustomizer_library_hex_to_rgb( $wcz_btn_bgcolor );

			WooCustomizer_Library_Styles()->add( array(
				'selectors' => array(
					'body.wcz-btns.wcz-woocommerce ul.products li.product a.button,
					body.wcz-btns.wcz-woocommerce .related.products ul.products li.product a.button,
                    body.wcz-btns.wcz-woocommerce.single-product div.product form.cart .button,
                    body.wcz-btns.wcz-woocommerce.wcz-wooblocks ul.wc-block-grid__products li.wc-block-grid__product .add_to_cart_button' // Woo Blocks
				),
				'declarations' => array(
					'background-color' => $wcz_btn_bgcolor,
					'color' => wcz_getContrastColor( $wcz_btn_bgcolor ) . ' !important',
					'text-shadow' => 'none'
				)
			) );
		}
		// Button - Hover Color
		$setting = 'wcz-btn-hovercolor';
		$mod = get_option( $setting, woocustomizer_library_get_default( $setting ) );

		if ( $mod !== woocustomizer_library_get_default( $setting ) ) {

			$wcz_btn_hovercolor = wcz_sanitize_hex_color( $mod );

			WooCustomizer_Library_Styles()->add( array(
				'selectors' => array(
					'body.wcz-btns.wcz-woocommerce ul.products li.product a.button:hover,
					body.wcz-btns.wcz-woocommerce .related.products ul.products li.product a.button:hover,
                    body.wcz-btns.wcz-woocommerce.single-product div.product form.cart .button:hover,
                    body.wcz-btns.wcz-woocommerce.wcz-wooblocks ul.wc-block-grid__products li.wc-block-grid__product .add_to_cart_button:hover' // Woo Blocks
				),
				'declarations' => array(
					'background-color' => $wcz_btn_hovercolor,
					'color' => wcz_getContrastColor( $wcz_btn_hovercolor ) . ' !important'
				)
			) );
		}
		// Button - Border Radius
		$setting = 'wcz-btn-br';
		$mod = get_option( $setting, woocustomizer_library_get_default( $setting ) );

		if ( $mod !== woocustomizer_library_get_default( $setting ) ) {

			$wcz_btn_br = esc_attr( $mod );

			WooCustomizer_Library_Styles()->add( array(
				'selectors' => array(
					'body.wcz-btns.wcz-woocommerce ul.products li.product a.button,
					body.wcz-btns.wcz-woocommerce .related.products ul.products li.product a.button,
                    body.wcz-btns.wcz-woocommerce.single-product div.product form.cart .button,
                    body.wcz-btns.wcz-woocommerce.wcz-wooblocks ul.wc-block-grid__products li.wc-block-grid__product .add_to_cart_button' // Woo Blocks
				),
				'declarations' => array(
					'border-radius' => $wcz_btn_br . 'px'
				)
			) );
		}
		// Button - Padding
		$setting = 'wcz-btn-padding';
		$mod = get_option( $setting, woocustomizer_library_get_default( $setting ) );

		if ( $mod !== woocustomizer_library_get_default( $setting ) ) {

			$wcz_btn_pad = esc_attr( $mod );

			WooCustomizer_Library_Styles()->add( array(
				'selectors' => array(
					'body.wcz-btns.wcz-woocommerce ul.products li.product a.button,
					body.wcz-btns.wcz-woocommerce .related.products ul.products li.product a.button,
                    body.wcz-btns.wcz-woocommerce.single-product div.product form.cart .button,
                    body.wcz-btns.wcz-woocommerce.wcz-wooblocks ul.wc-block-grid__products li.wc-block-grid__product .add_to_cart_button' // Woo Blocks
				),
				'declarations' => array(
					'padding' => $wcz_btn_pad . 'px ' . ( $wcz_btn_pad * 2 ) . 'px ' . ( $wcz_btn_pad + 1 ) . 'px'
				)
			) );
		}

	endif;

	if ( get_option( 'wcz-wc-edit-sale', woocustomizer_library_get_default( 'wcz-wc-edit-sale' ) ) ) :

		// Sale Banner - Font Size
		$setting = 'wcz-sale-fsize';
		$mod = get_option( $setting, woocustomizer_library_get_default( $setting ) );

		if ( $mod !== woocustomizer_library_get_default( $setting ) ) {

			$wcz_sale_fsize = esc_attr( $mod );

			WooCustomizer_Library_Styles()->add( array(
				'selectors' => array(
					'body.wcz-edit-sale.woocommerce ul.products li.product span.onsale,
					body.wcz-edit-sale.single-product span.onsale,
                    body.wcz-edit-sale .wcz-popup span.onsale,
                    body.wcz-edit-sale.wcz-wooblocks ul.wc-block-grid__products li.wc-block-grid__product .wc-block-grid__product-onsale' // Woo Blocks
				),
				'declarations' => array(
					'font-size' => $wcz_sale_fsize . 'px'
				)
			) );
		}
		// Sale Banner - Font Weight
		$setting = 'wcz-sale-fweight';
		$mod = get_option( $setting, woocustomizer_library_get_default( $setting ) );

		if ( $mod !== woocustomizer_library_get_default( $setting ) ) {

			$wcz_sale_fweight = esc_attr( $mod );

			WooCustomizer_Library_Styles()->add( array(
				'selectors' => array(
					'body.wcz-edit-sale.woocommerce ul.products li.product span.onsale,
					body.wcz-edit-sale.single-product span.onsale,
                    body.wcz-edit-sale .wcz-popup span.onsale,
                    body.wcz-edit-sale.wcz-wooblocks ul.wc-block-grid__products li.wc-block-grid__product .wc-block-grid__product-onsale' // Woo Blocks
				),
				'declarations' => array(
					'font-weight' => '700'
				)
			) );
		}
		// Sale Banner - Color
		$setting = 'wcz-sale-bgcolor';
		$mod = get_option( $setting, woocustomizer_library_get_default( $setting ) );

		if ( $mod !== woocustomizer_library_get_default( $setting ) ) {

			$wcz_sale_bgcolor = wcz_sanitize_hex_color( $mod );
			$wcz_sale_bgrgb = woocustomizer_library_hex_to_rgb( $wcz_sale_bgcolor );

			WooCustomizer_Library_Styles()->add( array(
				'selectors' => array(
					'body.wcz-edit-sale.woocommerce ul.products li.product span.onsale,
					body.wcz-edit-sale.single-product span.onsale,
					.woocommerce span.wcz-ajaxsearch-result-sale,
                    body.wcz-edit-sale .wcz-popup span.onsale,
                    body.wcz-edit-sale.wcz-wooblocks ul.wc-block-grid__products li.wc-block-grid__product .wc-block-grid__product-onsale' // Woo Blocks
				),
				'declarations' => array(
					'background-color' => $wcz_sale_bgcolor,
					'color' => wcz_getContrastColor( $wcz_sale_bgcolor ),
					'text-shadow' => 'none'
				)
			) );
		}
		// Sale Banner - Border Radius
		$setting = 'wcz-sale-br';
		$mod = get_option( $setting, woocustomizer_library_get_default( $setting ) );

		if ( $mod !== woocustomizer_library_get_default( $setting ) ) {

			$wcz_sale_br = esc_attr( $mod );

			WooCustomizer_Library_Styles()->add( array(
				'selectors' => array(
					'body.wcz-edit-sale.woocommerce ul.products li.product span.onsale,
					body.wcz-edit-sale.single-product span.onsale,
                    body.wcz-edit-sale .wcz-popup span.onsale,
                    body.wcz-edit-sale.wcz-wooblocks ul.wc-block-grid__products li.wc-block-grid__product .wc-block-grid__product-onsale' // Woo Blocks
				),
				'declarations' => array(
					'border-radius' => $wcz_sale_br . 'px'
				)
			) );
		}
		// Sale Banner - Padding
		$setting = 'wcz-sale-padding';
		$mod = get_option( $setting, woocustomizer_library_get_default( $setting ) );

		if ( $mod !== woocustomizer_library_get_default( $setting ) ) {

			$wcz_sale_pad = esc_attr( $mod );

			WooCustomizer_Library_Styles()->add( array(
				'selectors' => array(
					'body.wcz-edit-sale.woocommerce ul.products li.product span.onsale,
					body.wcz-edit-sale.single-product span.onsale,
                    body.wcz-edit-sale .wcz-popup span.onsale,
                    body.wcz-edit-sale.wcz-wooblocks ul.wc-block-grid__products li.wc-block-grid__product .wc-block-grid__product-onsale' // Woo Blocks
				),
				'declarations' => array(
					'padding' => $wcz_sale_pad . 'px ' . ( $wcz_sale_pad * 2 ) . 'px ' . ( $wcz_sale_pad + 1 ) . 'px'
				)
			) );
		}

    endif;
    if ( get_option( 'wcz-wc-edit-shop-title', woocustomizer_library_get_default( 'wcz-wc-edit-shop-title' ) ) ) :
		// Product Title - Font Size
		$setting = 'wcz-shop-title-fsize';
		$mod = get_option( $setting, woocustomizer_library_get_default( $setting ) );

		if ( $mod !== woocustomizer_library_get_default( $setting ) ) {

			$wcz_shop_prodtitlefs = esc_attr( $mod );

			WooCustomizer_Library_Styles()->add( array(
				'selectors' => array(
                    'body.woocommerce.wcz-woocommerce ul.products li.product .woocommerce-loop-product__title,
                    body.wcz-wooblocks ul.wc-block-grid__products li.wc-block-grid__product .wc-block-grid__product-title' // Woo Blocks
				),
				'declarations' => array(
					'font-size' => $wcz_shop_prodtitlefs . 'px'
				)
			) );
		}
		// Product Title - Color
		$setting = 'wcz-shop-title-fcolor';
		$mod = get_option( $setting, woocustomizer_library_get_default( $setting ) );

		if ( $mod !== woocustomizer_library_get_default( $setting ) ) {

			$wcz_shop_prodtitlefc = wcz_sanitize_hex_color( $mod );

			WooCustomizer_Library_Styles()->add( array(
				'selectors' => array(
                    'body.woocommerce.wcz-woocommerce ul.products li.product .woocommerce-loop-product__title,
                    body.wcz-wooblocks ul.wc-block-grid__products li.wc-block-grid__product .wc-block-grid__product-title a' // Woo Blocks
				),
				'declarations' => array(
					'color' => $wcz_shop_prodtitlefc
				)
			) );
		}
    endif;
    if ( get_option( 'wcz-wc-edit-shop-price', woocustomizer_library_get_default( 'wcz-wc-edit-shop-price' ) ) ) :
		// Product Price - Font Size
		$setting = 'wcz-shop-price-fsize';
		$mod = get_option( $setting, woocustomizer_library_get_default( $setting ) );

		if ( $mod !== woocustomizer_library_get_default( $setting ) ) {

			$wcz_shop_prodpricefs = esc_attr( $mod );

			WooCustomizer_Library_Styles()->add( array(
				'selectors' => array(
                    'body.woocommerce.wcz-woocommerce ul.products li.product .price,
                    body.wcz-wooblocks ul.wc-block-grid__products li.wc-block-grid__product .wc-block-grid__product-price' // Woo Blocks
				),
				'declarations' => array(
					'font-size' => $wcz_shop_prodpricefs . 'px'
				)
			) );
		}
		// Product Price - Color
		$setting = 'wcz-shop-price-fcolor';
		$mod = get_option( $setting, woocustomizer_library_get_default( $setting ) );

		if ( $mod !== woocustomizer_library_get_default( $setting ) ) {

            $wcz_shop_prodpricefc = wcz_sanitize_hex_color( $mod );
            $wcz_shop_prodpricefc_rgb = woocustomizer_library_hex_to_rgb( $mod );

			WooCustomizer_Library_Styles()->add( array(
				'selectors' => array(
                    'body.woocommerce.wcz-woocommerce ul.products li.product .price,
                    body.wcz-wooblocks ul.wc-block-grid__products li.wc-block-grid__product .wc-block-grid__product-price__value,
                    body.wcz-wooblocks ul.wc-block-grid__products li.wc-block-grid__product .wc-block-grid__product-price ins' // Woo Blocks
				),
				'declarations' => array(
					'color' => $wcz_shop_prodpricefc
				)
            ) );
            WooCustomizer_Library_Styles()->add( array(
                'selectors' => array(
                    'body.wcz-wooblocks ul.wc-block-grid__products li.wc-block-grid__product .wc-block-grid__product-price del'
                ),
                'declarations' => array(
                    'color' => 'rgba(' . $wcz_shop_prodpricefc_rgb['r'] . ', ' . $wcz_shop_prodpricefc_rgb['g'] . ', ' . $wcz_shop_prodpricefc_rgb['b'] . ', 0.45)'
                )
            ) );
		}
	endif;
	// ----------------------------------------------------------------------------------------------- WCD Shop Page Settings

	// ----------------------------------------------------------------------------------------------- WooCommerce Product Page Settings
	// Remove Product Breadcrumbs
	$setting = 'wcz-remove-product-breadcrumbs';
	$mod = get_option( $setting, woocustomizer_library_get_default( $setting ) );

	if ( $mod !== woocustomizer_library_get_default( $setting ) ) {

		$wcz_prod_bc = esc_attr( $mod );

		WooCustomizer_Library_Styles()->add( array(
			'selectors' => array(
				'body.single-product .woocommerce-breadcrumb'
			),
			'declarations' => array(
				'display' => 'none !important'
			)
		) );
	}
	// Remove Product SKU, Cats & Tags
	$setting = 'wcz-remove-product-sku';
	$mod = get_option( $setting, woocustomizer_library_get_default( $setting ) );

	if ( $mod !== woocustomizer_library_get_default( $setting ) ) {

		$wcz_prod_sku = esc_attr( $mod );

		WooCustomizer_Library_Styles()->add( array(
			'selectors' => array(
				'body.single-product .product_meta .sku_wrapper'
			),
			'declarations' => array(
				'display' => 'none !important'
			)
		) );
	}
	$setting = 'wcz-remove-product-cats';
	$mod = get_option( $setting, woocustomizer_library_get_default( $setting ) );

	if ( $mod !== woocustomizer_library_get_default( $setting ) ) {

		$wcz_prod_cats = esc_attr( $mod );

		WooCustomizer_Library_Styles()->add( array(
			'selectors' => array(
				'body.single-product .product_meta .posted_in'
			),
			'declarations' => array(
				'display' => 'none !important'
			)
		) );
	}
	$setting = 'wcz-remove-product-tags';
	$mod = get_option( $setting, woocustomizer_library_get_default( $setting ) );

	if ( $mod !== woocustomizer_library_get_default( $setting ) ) {

		$wcz_prod_tags = esc_attr( $mod );

		WooCustomizer_Library_Styles()->add( array(
			'selectors' => array(
				'body.single-product .product_meta .tagged_as'
			),
			'declarations' => array(
				'display' => 'none !important'
			)
		) );
	}
	// Remove Product Recommendations
	$setting = 'wcz-wcproduct-recomm';
	$mod = get_option( $setting, woocustomizer_library_get_default( $setting ) );

	if ( $mod == 'wcz-wcproduct-recomm-remove' ) {

		$wcz_prod_recom = esc_attr( $mod );

		WooCustomizer_Library_Styles()->add( array(
			'selectors' => array(
				'body.single-product section.upsells'
			),
			'declarations' => array(
				'display' => 'none !important'
			)
		) );
	}
	// Remove Product Related Products
	$setting = 'wcz-wcproduct-related';
	$mod = get_option( $setting, woocustomizer_library_get_default( $setting ) );

	if ( $mod == 'wcz-wcproduct-related-remove' ) {

		$wcz_prod_rel = esc_attr( $mod );

		WooCustomizer_Library_Styles()->add( array(
			'selectors' => array(
				'.single-product section.related.products'
			),
			'declarations' => array(
				'display' => 'none !important'
			)
		) );
	}
	$setting = 'wcz-add-shop-button';
	$mod = get_option( $setting, woocustomizer_library_get_default( $setting ) );

	if ( $mod !== woocustomizer_library_get_default( $setting ) ) {

		$wcz_prod_shop_btn = esc_attr( $mod );

		WooCustomizer_Library_Styles()->add( array(
			'selectors' => array(
				'body.single-product a.wcz-continue'
			),
			'declarations' => array(
				'margin-bottom' => '20px'
			)
		) );
    }
    if ( get_option( 'wcz-wc-edit-product-title', woocustomizer_library_get_default( 'wcz-wc-edit-product-title' ) ) ) :
		// Product Page Title - Font Size
		$setting = 'wcz-product-title-fsize';
		$mod = get_option( $setting, woocustomizer_library_get_default( $setting ) );

		if ( $mod !== woocustomizer_library_get_default( $setting ) ) {

			$wcz_product_prodtitlefs = esc_attr( $mod );

			WooCustomizer_Library_Styles()->add( array(
				'selectors' => array(
					'body.single-product.wcz-woocommerce div.product .product_title'
				),
				'declarations' => array(
					'font-size' => $wcz_product_prodtitlefs . 'px'
				)
			) );
		}
		// Product Page Title - Color
		$setting = 'wcz-product-title-fcolor';
		$mod = get_option( $setting, woocustomizer_library_get_default( $setting ) );

		if ( $mod !== woocustomizer_library_get_default( $setting ) ) {

			$wcz_product_prodtitlefc = wcz_sanitize_hex_color( $mod );

			WooCustomizer_Library_Styles()->add( array(
				'selectors' => array(
					'body.single-product.wcz-woocommerce div.product .product_title'
				),
				'declarations' => array(
					'color' => $wcz_product_prodtitlefc
				)
			) );
		}
    endif;
    if ( get_option( 'wcz-wc-edit-product-price', woocustomizer_library_get_default( 'wcz-wc-edit-product-price' ) ) ) :
		// Product Page Price - Font Size
		$setting = 'wcz-product-price-fsize';
		$mod = get_option( $setting, woocustomizer_library_get_default( $setting ) );

		if ( $mod !== woocustomizer_library_get_default( $setting ) ) {

			$wcz_product_prodpricefs = esc_attr( $mod );

			WooCustomizer_Library_Styles()->add( array(
				'selectors' => array(
					'body.single-product.wcz-woocommerce div.product p.price'
				),
				'declarations' => array(
					'font-size' => $wcz_product_prodpricefs . 'px'
				)
			) );
		}
		// Product Page Price - Color
		$setting = 'wcz-product-price-fcolor';
		$mod = get_option( $setting, woocustomizer_library_get_default( $setting ) );

		if ( $mod !== woocustomizer_library_get_default( $setting ) ) {

			$wcz_product_prodpricefc = wcz_sanitize_hex_color( $mod );

			WooCustomizer_Library_Styles()->add( array(
				'selectors' => array(
					'body.single-product.wcz-woocommerce div.product p.price'
				),
				'declarations' => array(
					'color' => $wcz_product_prodpricefc
				)
			) );
		}
    endif;
    
    if ( get_option( 'wcz-wc-edit-contshop-btn', woocustomizer_library_get_default( 'wcz-wc-edit-contshop-btn' ) ) ) :
        // Continue Shopping
        $setting = 'wcz-contshop-bgcolor';
		$mod = get_option( $setting, woocustomizer_library_get_default( $setting ) );

		if ( $mod !== woocustomizer_library_get_default( $setting ) ) {

			$wcz_contshop_bgcolor = wcz_sanitize_hex_color( $mod );

			WooCustomizer_Library_Styles()->add( array(
				'selectors' => array(
					'a.button.wcz-continue'
				),
				'declarations' => array(
                    'background-color' => $wcz_contshop_bgcolor,
                    'color' => wcz_getContrastColor( $wcz_contshop_bgcolor )
				)
			) );
        }
        $setting = 'wcz-contshop-hovercolor';
		$mod = get_option( $setting, woocustomizer_library_get_default( $setting ) );

		if ( $mod !== woocustomizer_library_get_default( $setting ) ) {

			$wcz_contshop_bgcolor = wcz_sanitize_hex_color( $mod );

			WooCustomizer_Library_Styles()->add( array(
				'selectors' => array(
					'a.button.wcz-continue:hover'
				),
				'declarations' => array(
                    'background-color' => $wcz_contshop_bgcolor,
                    'color' => wcz_getContrastColor( $wcz_contshop_bgcolor )
				)
			) );
		}
		$setting = 'wcz-contshop-fsize';
		$mod = get_option( $setting, woocustomizer_library_get_default( $setting ) );

		if ( $mod !== woocustomizer_library_get_default( $setting ) ) {

			$wcz_product_prodpricefs = esc_attr( $mod );

			WooCustomizer_Library_Styles()->add( array(
				'selectors' => array(
					'a.button.wcz-continue'
				),
				'declarations' => array(
					'font-size' => $wcz_product_prodpricefs . 'px'
				)
			) );
        }
        $setting = 'wcz-contshop-pad';
		$mod = get_option( $setting, woocustomizer_library_get_default( $setting ) );

		if ( $mod !== woocustomizer_library_get_default( $setting ) ) {

			$wcz_product_prodpricefs = esc_attr( $mod );

			WooCustomizer_Library_Styles()->add( array(
				'selectors' => array(
					'a.button.wcz-continue'
				),
				'declarations' => array(
					'padding' => $wcz_product_prodpricefs . 'px ' . $wcz_product_prodpricefs * 2 . 'px'
				)
			) );
		}
	endif;

	// EXCLUDED FROM FREE VERSION -- This "if" block will be auto removed from the Free version.
	if ( wcz_fs()->can_use_premium_code__premium_only() ) {

		// Add styling for IF Plus & Minus button are turned on
		if ( get_option( 'wcz-add-plus-minus-btns', woocustomizer_library_get_default( 'wcz-add-plus-minus-btns' ) ) ) :

			$setting = 'wcz-add-plus-minus-btns';
			$mod = get_option( $setting, woocustomizer_library_get_default( $setting ) );

			if ( $mod !== woocustomizer_library_get_default( $setting ) ) {

				WooCustomizer_Library_Styles()->add( array(
					'selectors' => array(
						'body.woocommerce.single-product div.product form.cart .quantity'
					),
					'declarations' => array(
						'float' => 'none',
						'margin' => '0',
						'display' => 'inline-block'
					)
				) );
				WooCustomizer_Library_Styles()->add( array(
					'selectors' => array(
						'body.woocommerce.single-product div.product form.cart .button'
					),
					'declarations' => array(
						'float' => 'none',
						'margin' => '0 0 0 10px',
						'display' => 'inline-block'
					)
				) );
			}

		endif;

	} // EXCLUDED FROM FREE VERSION -- This "if" above block will be auto removed from the Free version.
	// ----------------------------------------------------------------------------------------------- WooCommerce Product Page Settings

	// ----------------------------------------------------------------------------------------------- WooCommerce Account Settings



	// ----------------------------------------------------------------------------------------------- WooCommerce Account Settings

	// ----------------------------------------------------------------------------------------------- WooCommerce Cart Settings

	// Remove Update Button from Cart Page
	$setting = 'wcz-cart-ajax-update';
	$mod = get_option( $setting, woocustomizer_library_get_default( $setting ) );

	if ( $mod !== woocustomizer_library_get_default( $setting ) ) {

		WooCustomizer_Library_Styles()->add( array(
			'selectors' => array(
				'.woocommerce button[name="update_cart"],
				.woocommerce input[name="update_cart"]'
			),
			'declarations' => array(
				'display' => 'none !important'
			)
		) );
	}
	// Remove Cross Sells heading
	$setting = 'wcz-wccart-recomm';
	$mod = get_option( $setting, woocustomizer_library_get_default( $setting ) );

	if ( $mod == 'wcz-wccart-recomm-remove' ) {

		$wcz_cart_recom = esc_attr( $mod );

		WooCustomizer_Library_Styles()->add( array(
			'selectors' => array(
				'body.woocommerce-cart .cross-sells h2'
			),
			'declarations' => array(
				'display' => 'none !important'
			)
		) );
	}
	// Remove Cart Totals heading
	$setting = 'wcz-wccart-totals';
	$mod = get_option( $setting, woocustomizer_library_get_default( $setting ) );

	if ( $mod == 'wcz-wccart-totals-remove' ) {

		$wcz_cart_recom = esc_attr( $mod );

		WooCustomizer_Library_Styles()->add( array(
			'selectors' => array(
				'body.woocommerce-cart .cart_totals h2'
			),
			'declarations' => array(
				'display' => 'none !important'
			)
		) );
    }
	// Cart - Back To Shop Button
    $setting = 'wcz-cart-bts-color';
    $mod = get_option( $setting, woocustomizer_library_get_default( $setting ) );

    if ( $mod !== woocustomizer_library_get_default( $setting ) ) {

        $wcz_cartbts_color = wcz_sanitize_hex_color( $mod );

        WooCustomizer_Library_Styles()->add( array(
            'selectors' => array(
                'body.woocommerce-cart a.button.wcz-bts-btn'
            ),
            'declarations' => array(
                'background-color' => $wcz_cartbts_color,
                'color' => wcz_getContrastColor( $wcz_cartbts_color )
            )
        ) );
    }
    $setting = 'wcz-cart-bts-hcolor';
    $mod = get_option( $setting, woocustomizer_library_get_default( $setting ) );

    if ( $mod !== woocustomizer_library_get_default( $setting ) ) {

        $wcz_cartbts_hcolor = wcz_sanitize_hex_color( $mod );

        WooCustomizer_Library_Styles()->add( array(
            'selectors' => array(
                'body.woocommerce-cart a.button.wcz-bts-btn:hover'
            ),
            'declarations' => array(
                'background-color' => $wcz_cartbts_hcolor,
                'color' => wcz_getContrastColor( $wcz_cartbts_hcolor )
            )
        ) );
    }
    if ( get_option( 'wcz-cart-return-btn', woocustomizer_library_get_default( 'wcz-cart-return-btn' ) ) ) :
		$setting = 'wcz-cart-return-btn-align';
		$mod = get_option( $setting, woocustomizer_library_get_default( $setting ) );

		if ( $mod !== woocustomizer_library_get_default( $setting ) ) {

			$wcz_cart_rts_btn = esc_attr( $mod );

			WooCustomizer_Library_Styles()->add( array(
				'selectors' => array(
					'body.woocommerce-cart p.return-to-shop'
				),
				'declarations' => array(
					'text-align' => 'center'
				)
			) );
        }
        $setting = 'wcz-cart-return-btn-fsize';
		$mod = get_option( $setting, woocustomizer_library_get_default( $setting ) );

		if ( $mod !== woocustomizer_library_get_default( $setting ) ) {

			$wcz_cart_rts_btn_fsize = esc_attr( $mod );

			WooCustomizer_Library_Styles()->add( array(
				'selectors' => array(
					'body.woocommerce-cart p.return-to-shop a.button'
				),
				'declarations' => array(
					'font-size' => $wcz_cart_rts_btn_fsize . 'px'
				)
			) );
		}
		$setting = 'wcz-cart-return-btn-color';
		$mod = get_option( $setting, woocustomizer_library_get_default( $setting ) );

		if ( $mod !== woocustomizer_library_get_default( $setting ) ) {

			$wcz_cart_rts_btn_color = wcz_sanitize_hex_color( $mod );

			WooCustomizer_Library_Styles()->add( array(
				'selectors' => array(
					'body.woocommerce-cart p.return-to-shop a.button'
				),
				'declarations' => array(
                    'background-color' => $wcz_cart_rts_btn_color,
                    'color' => wcz_getContrastColor( $wcz_cart_rts_btn_color )
				)
			) );
        }
        $setting = 'wcz-cart-return-btn-pad';
		$mod = get_option( $setting, woocustomizer_library_get_default( $setting ) );

		if ( $mod !== woocustomizer_library_get_default( $setting ) ) {

			$wcz_cart_rts_btn_pad = esc_attr( $mod );

			WooCustomizer_Library_Styles()->add( array(
				'selectors' => array(
					'body.woocommerce-cart p.return-to-shop a.button'
				),
				'declarations' => array(
					'padding' => $wcz_cart_rts_btn_pad . 'px ' . ( $wcz_cart_rts_btn_pad * 2 ) . 'px'
				)
			) );
		}
    endif;
    if ( get_option( 'wcz-cart-proceed-btn', woocustomizer_library_get_default( 'wcz-cart-proceed-btn' ) ) ) :
        $setting = 'wcz-cart-proceed-btn-fsize';
		$mod = get_option( $setting, woocustomizer_library_get_default( $setting ) );

		if ( $mod !== woocustomizer_library_get_default( $setting ) ) {

			$wcz_cart_rts_btn_fsize = esc_attr( $mod );

			WooCustomizer_Library_Styles()->add( array(
				'selectors' => array(
					'body.woocommerce-cart .wc-proceed-to-checkout a.button.checkout-button'
				),
				'declarations' => array(
					'font-size' => $wcz_cart_rts_btn_fsize . 'px'
				)
			) );
		}
		$setting = 'wcz-cart-proceed-btn-color';
		$mod = get_option( $setting, woocustomizer_library_get_default( $setting ) );

		if ( $mod !== woocustomizer_library_get_default( $setting ) ) {

			$wcz_cart_rts_btn_color = wcz_sanitize_hex_color( $mod );

			WooCustomizer_Library_Styles()->add( array(
				'selectors' => array(
					'body.woocommerce-cart .wc-proceed-to-checkout a.button.checkout-button'
				),
				'declarations' => array(
                    'background-color' => $wcz_cart_rts_btn_color,
                    'color' => wcz_getContrastColor( $wcz_cart_rts_btn_color )
				)
			) );
        }
        $setting = 'wcz-cart-proceed-btn-pad';
		$mod = get_option( $setting, woocustomizer_library_get_default( $setting ) );

		if ( $mod !== woocustomizer_library_get_default( $setting ) ) {

			$wcz_cart_rts_btn_pad = esc_attr( $mod );

			WooCustomizer_Library_Styles()->add( array(
				'selectors' => array(
					'body.woocommerce-cart .wc-proceed-to-checkout a.button.checkout-button'
				),
				'declarations' => array(
					'padding' => $wcz_cart_rts_btn_pad . 'px ' . ( $wcz_cart_rts_btn_pad * 2 ) . 'px'
				)
			) );
		}
	endif;
	// ----------------------------------------------------------------------------------------------- WooCommerce Cart Settings

	// ----------------------------------------------------------------------------------------------- WooCommerce Checkout Settings
    if ( get_option( 'wcz-checkout-placeorder-btn', woocustomizer_library_get_default( 'wcz-checkout-placeorder-btn' ) ) ) :
        $setting = 'wcz-checkout-placeorder-btn-fsize';
		$mod = get_option( $setting, woocustomizer_library_get_default( $setting ) );

		if ( $mod !== woocustomizer_library_get_default( $setting ) ) {

			$wcz_cart_rts_btn_fsize = esc_attr( $mod );

			WooCustomizer_Library_Styles()->add( array(
				'selectors' => array(
					'body.woocommerce-checkout #payment button#place_order'
				),
				'declarations' => array(
					'font-size' => $wcz_cart_rts_btn_fsize . 'px'
				)
			) );
		}
		$setting = 'wcz-checkout-placeorder-btn-color';
		$mod = get_option( $setting, woocustomizer_library_get_default( $setting ) );

		if ( $mod !== woocustomizer_library_get_default( $setting ) ) {

			$wcz_cart_rts_btn_color = wcz_sanitize_hex_color( $mod );

			WooCustomizer_Library_Styles()->add( array(
				'selectors' => array(
					'body.woocommerce-checkout #payment button#place_order'
				),
				'declarations' => array(
                    'background-color' => $wcz_cart_rts_btn_color,
                    'color' => wcz_getContrastColor( $wcz_cart_rts_btn_color )
				)
			) );
        }
        $setting = 'wcz-checkout-placeorder-btn-pad';
		$mod = get_option( $setting, woocustomizer_library_get_default( $setting ) );

		if ( $mod !== woocustomizer_library_get_default( $setting ) ) {

			$wcz_cart_rts_btn_pad = esc_attr( $mod );

			WooCustomizer_Library_Styles()->add( array(
				'selectors' => array(
					'body.woocommerce-checkout #payment button#place_order'
				),
				'declarations' => array(
					'padding' => $wcz_cart_rts_btn_pad . 'px ' . ( $wcz_cart_rts_btn_pad * 2 ) . 'px'
				)
			) );
		}
	endif;
	// ----------------------------------------------------------------------------------------------- WooCommerce Checkout Settings

	// EXCLUDED FROM FREE VERSION -- This "if" block will be auto removed from the Free version.
	if ( wcz_fs()->can_use_premium_code__premium_only() ) {

		// ----------------------------------------------------------------------------------------------- WCD CATALOGUE MODE
		$wcz_edit = get_option( 'wcz-cm-to-edit', woocustomizer_library_get_default( 'wcz-cm-to-edit' ) );
		$wcz_user_logged = get_option( 'wcz-cm-apply-notlogged', woocustomizer_library_get_default( 'wcz-cm-apply-notlogged' ) );

		// Remove if set for only Logged Out Users
		if ( $wcz_user_logged ) :
			// Shop Page
			if ( !is_user_logged_in() && 'wcz-cm-edit-all' == $wcz_edit && get_option( 'wcz-cm-shop-btn', woocustomizer_library_get_default( 'wcz-cm-shop-btn' ) ) ) :

				// Remove ALL Product page buttons
				$setting = 'wcz-cm-shop-btn';
				$mod = get_option( $setting, woocustomizer_library_get_default( $setting ) );

				if ( $mod !== woocustomizer_library_get_default( $setting ) ) {

					$wcz_mc_remove_cart = esc_attr( $mod );

					WooCustomizer_Library_Styles()->add( array(
						'selectors' => array(
							'body.post-type-archive-product li.product a.button.add_to_cart_button,
							body.tax-product_cat li.product a.button.add_to_cart_button,
							body.tax-product_tag li.product a.button.add_to_cart_button,
							body.post-type-archive-product li.product a.button.product_type_external,
							body.tax-product_cat li.product a.button.product_type_external,
							body.tax-product_tag li.product a.button.product_type_external,
							body.post-type-archive-product li.product a.button.product_type_variable,
							body.tax-product_cat li.product a.button.product_type_variable,
							body.tax-product_tag li.product a.button.product_type_variable,
							body.post-type-archive-product li.product a.button.product_type_grouped,
							body.tax-product_cat li.product a.button.product_type_grouped,
							body.tax-product_tag li.product a.button.product_type_grouped'
						),
						'declarations' => array(
							'display' => 'none !important'
						)
					) );
				}

			endif;
		else :
			// ELSE Remove if set for all Users
			// Shop Page
			if ( 'wcz-cm-edit-all' == $wcz_edit && get_option( 'wcz-cm-shop-btn', woocustomizer_library_get_default( 'wcz-cm-shop-btn' ) ) ) :

				// Remove ALL Product page buttons
				$setting = 'wcz-cm-shop-btn';
				$mod = get_option( $setting, woocustomizer_library_get_default( $setting ) );

				if ( $mod !== woocustomizer_library_get_default( $setting ) ) {

					$wcz_mc_remove_cart = esc_attr( $mod );

					WooCustomizer_Library_Styles()->add( array(
						'selectors' => array(
							'body.post-type-archive-product li.product a.button.add_to_cart_button,
							body.tax-product_cat li.product a.button.add_to_cart_button,
							body.tax-product_tag li.product a.button.add_to_cart_button,
							body.post-type-archive-product li.product a.button.product_type_external,
							body.tax-product_cat li.product a.button.product_type_external,
							body.tax-product_tag li.product a.button.product_type_external,
							body.post-type-archive-product li.product a.button.product_type_variable,
							body.tax-product_cat li.product a.button.product_type_variable,
							body.tax-product_tag li.product a.button.product_type_variable,
							body.post-type-archive-product li.product a.button.product_type_grouped,
							body.tax-product_cat li.product a.button.product_type_grouped,
							body.tax-product_tag li.product a.button.product_type_grouped'
						),
						'declarations' => array(
							'display' => 'none !important'
						)
					) );
				}

			endif;
		endif;

		// Remove if set for only Logged Out Users
		if ( $wcz_user_logged ) :
			// Selected Shop Page
			if ( !is_user_logged_in() && 'wcz-cm-edit-selected' == get_option( 'wcz-cm-to-edit', woocustomizer_library_get_default( 'wcz-cm-to-edit' ) ) && get_option( 'wcz-cm-selected-shop-btn', woocustomizer_library_get_default( 'wcz-cm-selected-shop-btn' ) ) ) :
				
				// CSS Remove Product Page Buttons
				$setting = 'wcz-cm-applyto-items';
				$mod = get_option( $setting, woocustomizer_library_get_default( $setting ) );

				$mod_array = array_map( 'trim', explode( ',', $mod ) );

				if ( $mod !== woocustomizer_library_get_default( $setting ) ) {

					foreach( $mod_array as $mod_item ) {

						WooCustomizer_Library_Styles()->add( array(
							'selectors' => array(
								'body.post-type-archive-product li.product.post-' . $mod_item . ' > a.button.product_type_simple,
								body.tax-product_cat li.product.post-' . $mod_item . ' > a.button.product_type_simple,
								body.tax-product_tag li.product.post-' . $mod_item . ' > a.button.product_type_simple,
								body.post-type-archive-product li.product.post-' . $mod_item . ' > a.button.product_type_external,
								body.tax-product_cat li.product.post-' . $mod_item . ' > a.button.product_type_external,
								body.tax-product_tag li.product.post-' . $mod_item . ' > a.button.product_type_external,
								body.post-type-archive-product li.product.post-' . $mod_item . ' > a.button.product_type_variable,
								body.tax-product_cat li.product.post-' . $mod_item . ' > a.button.product_type_variable,
								body.tax-product_tag li.product.post-' . $mod_item . ' > a.button.product_type_variable,
								body.post-type-archive-product li.product.post-' . $mod_item . ' > a.button.product_type_grouped,
								body.tax-product_cat li.product.post-' . $mod_item . ' > a.button.product_type_grouped,
								body.tax-product_tag li.product.post-' . $mod_item . ' > a.button.product_type_grouped'
							),
							'declarations' => array(
								'display' => 'none !important'
							)
						) );
					}


				}

			endif;
			// Selected Product Page
			if ( !is_user_logged_in() && 'wcz-cm-edit-selected' == get_option( 'wcz-cm-to-edit', woocustomizer_library_get_default( 'wcz-cm-to-edit' ) ) && get_option( 'wcz-cm-selected-product-btn', woocustomizer_library_get_default( 'wcz-cm-selected-product-btn' ) ) ) :
				
				// CSS Remove Product Page Buttons
				$setting = 'wcz-cm-applyto-items';
				$mod = get_option( $setting, woocustomizer_library_get_default( $setting ) );

				$mod_array = array_map( 'trim', explode( ',', $mod ) );

				if ( $mod !== woocustomizer_library_get_default( $setting ) ) {

					foreach( $mod_array as $mod_item ) {

						WooCustomizer_Library_Styles()->add( array(
							'selectors' => array(
								'body.single-product #product-' . $mod_item . ' form.cart'
							),
							'declarations' => array(
								'display' => 'none !important'
							)
						) );
					}


				}

			endif;
		else :
			// ELSE Remove if set for all Users
			// Shop Page
			if ( 'wcz-cm-edit-selected' == get_option( 'wcz-cm-to-edit', woocustomizer_library_get_default( 'wcz-cm-to-edit' ) ) && get_option( 'wcz-cm-selected-shop-btn', woocustomizer_library_get_default( 'wcz-cm-selected-shop-btn' ) ) ) :
				
				// CSS Remove Product Page Buttons
				$setting = 'wcz-cm-applyto-items';
				$mod = get_option( $setting, woocustomizer_library_get_default( $setting ) );

				$mod_array = array_map( 'trim', explode( ',', $mod ) );

				if ( $mod !== woocustomizer_library_get_default( $setting ) ) {

					foreach( $mod_array as $mod_item ) {

						WooCustomizer_Library_Styles()->add( array(
							'selectors' => array(
								'body.post-type-archive-product li.product.post-' . $mod_item . ' > a.button.product_type_simple,
								body.tax-product_cat li.product.post-' . $mod_item . ' > a.button.product_type_simple,
								body.tax-product_tag li.product.post-' . $mod_item . ' > a.button.product_type_simple,
								body.post-type-archive-product li.product.post-' . $mod_item . ' > a.button.product_type_external,
								body.tax-product_cat li.product.post-' . $mod_item . ' > a.button.product_type_external,
								body.tax-product_tag li.product.post-' . $mod_item . ' > a.button.product_type_external,
								body.post-type-archive-product li.product.post-' . $mod_item . ' > a.button.product_type_variable,
								body.tax-product_cat li.product.post-' . $mod_item . ' > a.button.product_type_variable,
								body.tax-product_tag li.product.post-' . $mod_item . ' > a.button.product_type_variable,
								body.post-type-archive-product li.product.post-' . $mod_item . ' > a.button.product_type_grouped,
								body.tax-product_cat li.product.post-' . $mod_item . ' > a.button.product_type_grouped,
								body.tax-product_tag li.product.post-' . $mod_item . ' > a.button.product_type_grouped'
							),
							'declarations' => array(
								'display' => 'none !important'
							)
						) );
					}


				}

			endif;
			// Product Page
			if ( 'wcz-cm-edit-selected' == get_option( 'wcz-cm-to-edit', woocustomizer_library_get_default( 'wcz-cm-to-edit' ) ) && get_option( 'wcz-cm-selected-product-btn', woocustomizer_library_get_default( 'wcz-cm-selected-product-btn' ) ) ) :
				
				// CSS Remove Product Page Buttons
				$setting = 'wcz-cm-applyto-items';
				$mod = get_option( $setting, woocustomizer_library_get_default( $setting ) );

				$mod_array = array_map( 'trim', explode( ',', $mod ) );

				if ( $mod !== woocustomizer_library_get_default( $setting ) ) {

					foreach( $mod_array as $mod_item ) {

						WooCustomizer_Library_Styles()->add( array(
							'selectors' => array(
								'body.single-product #product-' . $mod_item . ' form.cart'
							),
							'declarations' => array(
								'display' => 'none !important'
							)
						) );
					}


				}

			endif;
		endif;

		// Notice Design
		if ( get_option( 'wcz-cm-enable-site-notice', woocustomizer_library_get_default( 'wcz-cm-enable-site-notice' ) ) ) :

			$setting = 'wcz-cm-notice-color';
			$mod = get_option( $setting, woocustomizer_library_get_default( $setting ) );

			if ( $mod !== woocustomizer_library_get_default( $setting ) ) {

				$wcz_cmnotice_bg = wcz_sanitize_hex_color( $mod );
				
				WooCustomizer_Library_Styles()->add( array(
					'selectors' => array(
						'.wcz-notice.wcz-notice-default,
						.wcz-notice.wcz-notice-solid'
					),
					'declarations' => array(
						'border-top-color' => $wcz_cmnotice_bg
					)
				) );
				WooCustomizer_Library_Styles()->add( array(
					'selectors' => array(
						'.wcz-notice.wcz-notice-default::before'
					),
					'declarations' => array(
						'color' => $wcz_cmnotice_bg
					)
				) );
				WooCustomizer_Library_Styles()->add( array(
					'selectors' => array(
						'.wcz-notice.wcz-notice-solid'
					),
					'declarations' => array(
						'background-color' => $wcz_cmnotice_bg
					)
				) );
			}
			$setting = 'wcz-cm-notice-font-color';
			$mod = get_option( $setting, woocustomizer_library_get_default( $setting ) );

			if ( $mod !== woocustomizer_library_get_default( $setting ) ) {

				$wcz_cmnotice_font = wcz_sanitize_hex_color( $mod );

				WooCustomizer_Library_Styles()->add( array(
					'selectors' => array(
						'.wcz-notice.wcz-notice-default,
						.wcz-notice.wcz-notice-solid,
						.wcz-notice.wcz-notice-solid::before'
					),
					'declarations' => array(
						'color' => $wcz_cmnotice_font
					)
				) );
			}
			$setting = 'wcz-cm-notice-fsize';
			$mod = get_option( $setting, woocustomizer_library_get_default( $setting ) );

			if ( $mod !== woocustomizer_library_get_default( $setting ) ) {

				$wcz_notice_fsize = esc_attr( $mod );

				WooCustomizer_Library_Styles()->add( array(
					'selectors' => array(
						'.wcz-notice'
					),
					'declarations' => array(
						'font-size' => $wcz_notice_fsize . 'px'
					)
				) );
			}

		endif;
		// ----------------------------------------------------------------------------------------------- WCD CATALOGUE MODE

		// ----------------------------------------------------------------------------------------------- WCD MENU CART

		if ( get_option( 'wcz_set_enable_menu_cart', woocustomizer_library_get_default( 'wcz_set_enable_menu_cart' ) ) ) :
		
			$setting = 'wcz-mc-remove-theme-cart';
			$mod = get_option( $setting, woocustomizer_library_get_default( $setting ) );

			if ( $mod !== woocustomizer_library_get_default( $setting ) ) {

				$wcz_mc_remove_cart = esc_attr( $mod );

				WooCustomizer_Library_Styles()->add( array(
					'selectors' => array(
						'.site-header-cart,
						.theme-oceanwp li.toggle-cart-widget'
					),
					'declarations' => array(
						'display' => 'none !important'
					)
				) );
			}
			$setting = 'wcz-mc-align';
			$mod = get_option( $setting, woocustomizer_library_get_default( $setting ) );

			if ( $mod !== woocustomizer_library_get_default( $setting ) ) {

				$wcz_mc_align = esc_attr( $mod );

				WooCustomizer_Library_Styles()->add( array(
					'selectors' => array(
						'.wcz-menu-cart'
					),
					'declarations' => array(
						'float' => 'right !important'
					)
				) );
			}

			// Menu Cart Design
			if ( get_option( 'wcz-mc-edit-design', woocustomizer_library_get_default( 'wcz-mc-edit-design' ) ) ) :

				$setting = 'wcz-mc-icon-color';
				$mod = get_option( $setting, woocustomizer_library_get_default( $setting ) );

				if ( $mod !== woocustomizer_library_get_default( $setting ) ) {

					$wcz_mc_fcolor = wcz_sanitize_hex_color( $mod );

					WooCustomizer_Library_Styles()->add( array(
						'selectors' => array(
							'body.wcz-woocommerce li.wcz-menu-cart .wcz-has-items i.fas,
							.wcz-menu-cart-sc .wcz-has-items i.fas'
						),
						'declarations' => array(
							'color' => $wcz_mc_fcolor . ' !important'
						)
					) );
				}
				$setting = 'wcz-mc-icon-size';
				$mod = get_option( $setting, woocustomizer_library_get_default( $setting ) );

				if ( $mod !== woocustomizer_library_get_default( $setting ) ) {

					$wcz_mc_isize = esc_attr( $mod );

					WooCustomizer_Library_Styles()->add( array(
						'selectors' => array(
							'body.wcz-woocommerce li.wcz-menu-cart a.wcz-menucart.wcz-cart-contents i.fas,
							.wcz-menu-cart-sc .wcz-menucart i.fas'
						),
						'declarations' => array(
							'font-size' => $wcz_mc_isize . 'px'
						)
					) );
				}
				$setting = 'wcz-mc-drop-bg-color';
				$mod = get_option( $setting, woocustomizer_library_get_default( $setting ) );

				if ( $mod !== woocustomizer_library_get_default( $setting ) ) {

					$wcz_mc_dbgscolor = wcz_sanitize_hex_color( $mod );

					WooCustomizer_Library_Styles()->add( array(
						'selectors' => array(
							'body.wcz-woocommerce li.wcz-menu-cart ul.wcz-menu-cart-widget,
							body.wcz-woocommerce li.wcz-menu-cart ul.wcz-menu-cart-widget li ul.woocommerce-mini-cart .woocommerce-mini-cart-item .remove_from_cart_button:hover,
							.wcz-menu-cart-sc ul.wcz-menu-cart-widget,
							.wcz-menu-cart-sc ul.wcz-menu-cart-widget .woocommerce-mini-cart-item .remove_from_cart_button:hover'
						),
						'declarations' => array(
							'background-color' => $wcz_mc_dbgscolor . ' !important'
						)
					) );
					WooCustomizer_Library_Styles()->add( array(
						'selectors' => array(
							'body.wcz-woocommerce li.wcz-menu-cart ul.wcz-menu-cart-widget li,
							body.wcz-woocommerce li.wcz-menu-cart ul.wcz-menu-cart-widget li span,
							body.wcz-woocommerce li.wcz-menu-cart ul.wcz-menu-cart-widget .woocommerce-mini-cart__total.total strong,
							body.wcz-woocommerce li.wcz-menu-cart ul.wcz-menu-cart-widget li ul.woocommerce-mini-cart .woocommerce-mini-cart-item .remove_from_cart_button,
							.wcz-menu-cart-sc ul.wcz-menu-cart-widget li,
							.wcz-menu-cart-sc ul.wcz-menu-cart-widget li span,
							.wcz-menu-cart-sc ul.wcz-menu-cart-widget .woocommerce-mini-cart__total.total strong,
							.wcz-menu-cart-sc ul.wcz-menu-cart-widget li ul.woocommerce-mini-cart .woocommerce-mini-cart-item .remove_from_cart_button'
						),
						'declarations' => array(
							'color' => wcz_getContrastColor( $wcz_mc_dbgscolor ) . ' !important'
						)
					) );
				}

				$setting = 'wcz-mc-drop-btn-color';
				$mod = get_option( $setting, woocustomizer_library_get_default( $setting ) );

				if ( $mod !== woocustomizer_library_get_default( $setting ) ) {

					$wcz_mc_bcolor = wcz_sanitize_hex_color( $mod );

					WooCustomizer_Library_Styles()->add( array(
						'selectors' => array(
							'body.wcz-woocommerce li.wcz-menu-cart ul.wcz-menu-cart-widget .woocommerce-mini-cart__buttons.buttons > a.button,
							.wcz-menu-cart-sc ul.wcz-menu-cart-widget .woocommerce-mini-cart__buttons.buttons > a.button'
						),
						'declarations' => array(
							'background-color' => $wcz_mc_bcolor . ' !important',
							'color' => wcz_getContrastColor( $wcz_mc_bcolor ) . ' !important'
						)
					) );
				}
				$setting = 'wcz-mc-drop-btnhover-color';
				$mod = get_option( $setting, woocustomizer_library_get_default( $setting ) );

				if ( $mod !== woocustomizer_library_get_default( $setting ) ) {

					$wcz_mc_bhcolor = wcz_sanitize_hex_color( $mod );

					WooCustomizer_Library_Styles()->add( array(
						'selectors' => array(
							'body.wcz-woocommerce li.wcz-menu-cart ul.wcz-menu-cart-widget .woocommerce-mini-cart__buttons.buttons > a.button:hover,
							.wcz-menu-cart-sc ul.wcz-menu-cart-widget .woocommerce-mini-cart__buttons.buttons > a.button:hover'
						),
						'declarations' => array(
							'background-color' => $wcz_mc_bhcolor . ' !important',
							'color' => wcz_getContrastColor( $wcz_mc_bhcolor ) . ' !important'
						)
					) );
				}

			endif;

		endif;

		// ----------------------------------------------------------------------------------------------- WCD MENU CART

		// ----------------------------------------------------------------------------------------------- WCD QUICK VIEW

		// Popup Width
		$setting = 'wcz-qv-popup-width';
		$mod = get_option( $setting, woocustomizer_library_get_default( $setting ) );

		if ( $mod !== woocustomizer_library_get_default( $setting ) ) {

			$wczqv_popup_width = esc_attr( $mod );

			WooCustomizer_Library_Styles()->add( array(
				'selectors' => array(
					'.wcz-popup'
				),
				'declarations' => array(
					'max-width' => $wczqv_popup_width . 'px'
				)
			) );
		}
		// Popup Image Sizing
		$setting = 'wcz-qv-popup-img-size';
		$mod = get_option( $setting, woocustomizer_library_get_default( $setting ) );

		if ( $mod !== woocustomizer_library_get_default( $setting ) ) {

			$wczqv_popup_imgsize = esc_attr( $mod );

			WooCustomizer_Library_Styles()->add( array(
				'selectors' => array(
					'.wcz-quickview-product-imgs'
				),
				'declarations' => array(
					'flex' => $wczqv_popup_imgsize
				)
			) );
		}
		// Popup Image & Summary Center Align
		$setting = 'wcz-qv-center-align';
		$mod = get_option( $setting, woocustomizer_library_get_default( $setting ) );

		if ( $mod !== woocustomizer_library_get_default( $setting ) ) {

			$wczqv_popup_align = esc_attr( $mod );

			WooCustomizer_Library_Styles()->add( array(
				'selectors' => array(
					'.wcz-quickview-product'
				),
				'declarations' => array(
					'align-items' => 'center'
				)
			) );
		}
		// Remove Popup SKU
		$setting = 'wcz-qv-remove-meta-sku';
		$mod = get_option( $setting, woocustomizer_library_get_default( $setting ) );

		if ( $mod !== woocustomizer_library_get_default( $setting ) ) {

			$wczqv_popup_align = esc_attr( $mod );

			WooCustomizer_Library_Styles()->add( array(
				'selectors' => array(
					'.wcz-quickview-product-summary span.sku_wrapper'
				),
				'declarations' => array(
					'display' => 'none !important'
				)
			) );
		}
		// Remove Popup Categories
		$setting = 'wcz-qv-remove-meta-cats';
		$mod = get_option( $setting, woocustomizer_library_get_default( $setting ) );

		if ( $mod !== woocustomizer_library_get_default( $setting ) ) {

			$wczqv_popup_align = esc_attr( $mod );

			WooCustomizer_Library_Styles()->add( array(
				'selectors' => array(
					'.wcz-quickview-product-summary span.posted_in'
				),
				'declarations' => array(
					'display' => 'none !important'
				)
			) );
		}
		// Remove Popup Tags
		$setting = 'wcz-qv-remove-meta-tags';
		$mod = get_option( $setting, woocustomizer_library_get_default( $setting ) );

		if ( $mod !== woocustomizer_library_get_default( $setting ) ) {

			$wczqv_popup_align = esc_attr( $mod );

			WooCustomizer_Library_Styles()->add( array(
				'selectors' => array(
					'.wcz-quickview-product-summary span.tagged_as'
				),
				'declarations' => array(
					'display' => 'none !important'
				)
			) );
        }
        
        // Vutton Top Margin
		$setting = 'wcz-qv-btn-topmargin';
		$mod = get_option( $setting, woocustomizer_library_get_default( $setting ) );

		if ( $mod !== woocustomizer_library_get_default( $setting ) ) {

			$wczqv_btn_topmargin = esc_attr( $mod );

			WooCustomizer_Library_Styles()->add( array(
				'selectors' => array(
					'.woocommerce ul.products li.product .wcz-qv-btn a.wcz-popup-link'
				),
				'declarations' => array(
					'margin-top' => $wczqv_btn_topmargin . 'px'
				)
			) );
		}

		if ( get_option( 'wcz-qv-edit-design', woocustomizer_library_get_default( 'wcz-qv-edit-design' ) ) ) :

			// Popup Background Overlay Color
			$setting = 'wcz-qv-edit-overlaycolor';
			$setting_opacity = 'wcz-qv-edit-overlayop';
			$mod = get_option( $setting, woocustomizer_library_get_default( $setting ) );
			$mod_opacity = get_option( $setting_opacity, woocustomizer_library_get_default( $setting_opacity ) );

			if ( $mod !== woocustomizer_library_get_default( $setting ) || $mod_opacity !== woocustomizer_library_get_default( $setting_opacity ) ) {

				$color = wcz_sanitize_hex_color( $mod );
				$rgba_color = woocustomizer_library_hex_to_rgb( $color );
				$opacity = esc_attr( $mod_opacity );
				
				WooCustomizer_Library_Styles()->add( array(
					'selectors' => array(
						'.mfp-bg.wcz-qv'
					),
					'declarations' => array(
						'background-color' => 'rgba(' . $rgba_color['r'] . ', ' . $rgba_color['g'] . ', ' . $rgba_color['b'] . ', ' . $opacity . ') !important'
					)
				) );
				
			}
			// Popup Background Color
			$setting = 'wcz-qv-edit-bgcolor';
			$mod = get_option( $setting, woocustomizer_library_get_default( $setting ) );

			if ( $mod !== woocustomizer_library_get_default( $setting ) ) {

				$wczqv_popup_bg = wcz_sanitize_hex_color( $mod );

				WooCustomizer_Library_Styles()->add( array(
					'selectors' => array(
						'.wcz-qv .wcz-popup'
					),
					'declarations' => array(
						'background-color' => $wczqv_popup_bg . '!important',
						'color' => wcz_getContrastColor( $wczqv_popup_bg ) . '!important'
					)
				) );
			}
			// Remove Popup Border
			$setting = 'wcz-qv-remove-border';
			$mod = get_option( $setting, woocustomizer_library_get_default( $setting ) );

			if ( $mod !== woocustomizer_library_get_default( $setting ) ) {

				$wczqv_popup_align = esc_attr( $mod );

				WooCustomizer_Library_Styles()->add( array(
					'selectors' => array(
						'.wcz-popup'
					),
					'declarations' => array(
						'box-shadow' => 'none'
					)
				) );
			}

		endif;

		// ----------------------------------------------------------------------------------------------- WCD QUICK VIEW

		// ----------------------------------------------------------------------------------------------- WCD AJAX SEARCH

		if ( get_option( 'wcz-ajaxsearch-edit-design', woocustomizer_library_get_default( 'wcz-ajaxsearch-edit-design' ) ) ) :

			// Ajax Search Font Size
			$setting = 'wcz-ajaxsearch-fsize';
			$mod = get_option( $setting, woocustomizer_library_get_default( $setting ) );

			if ( $mod !== woocustomizer_library_get_default( $setting ) ) {

				$wczas_fsize = esc_attr( $mod );

				WooCustomizer_Library_Styles()->add( array(
					'selectors' => array(
						'.wcz-ajax-search-block .wcz-s,
						.wcz-ajax-search-block .wcz-s-submit'
					),
					'declarations' => array(
						'font-size' => $wczas_fsize . 'px'
					)
				) );
			}
			// Search Color
			$setting = 'wcz-ajaxsearch-color';
			$mod = get_option( $setting, woocustomizer_library_get_default( $setting ) );

			if ( $mod !== woocustomizer_library_get_default( $setting ) ) {

				$wczas_color = wcz_sanitize_hex_color( $mod );

				WooCustomizer_Library_Styles()->add( array(
					'selectors' => array(
						'.wcz-ajax-search-block .wcz-s'
					),
					'declarations' => array(
						'background-color' => $wczas_color . '!important',
						'color' => wcz_getContrastColor( $wczas_color ) . '!important'
					)
				) );
				WooCustomizer_Library_Styles()->add( array(
					'selectors' => array(
						'.wcz-ajax-search-block .wcz-s::placeholder'
					),
					'declarations' => array(
						'color' => wcz_getContrastColor( $wczas_color ) . '!important',
						'opacity' => 0.35
					)
				) );
			}
			// Search Button Color
			$setting = 'wcz-ajaxsearch-btn-color';
			$mod = get_option( $setting, woocustomizer_library_get_default( $setting ) );

			if ( $mod !== woocustomizer_library_get_default( $setting ) ) {

				$wczas_btn_color = wcz_sanitize_hex_color( $mod );

				WooCustomizer_Library_Styles()->add( array(
					'selectors' => array(
						'.wcz-ajax-search-block .wcz-s-submit'
					),
					'declarations' => array(
						'background-color' => $wczas_btn_color . '!important',
						'color' => wcz_getContrastColor( $wczas_btn_color ) . '!important'
					)
				) );
			}
			// Search Results Color
			$setting = 'wcz-ajaxsearch-bg-color';
			$mod = get_option( $setting, woocustomizer_library_get_default( $setting ) );

			if ( $mod !== woocustomizer_library_get_default( $setting ) ) {

				$wczas_color = wcz_sanitize_hex_color( $mod );

				WooCustomizer_Library_Styles()->add( array(
					'selectors' => array(
						'.wcz-search-results-block'
					),
					'declarations' => array(
						'background-color' => $wczas_color . '!important',
						'color' => wcz_getContrastColor( $wczas_color ) . '!important'
					)
				) );
            }
            // Search Results Color
			$setting = 'wcz-ajaxsearch-sale-color';
			$mod = get_option( $setting, woocustomizer_library_get_default( $setting ) );

			if ( $mod !== woocustomizer_library_get_default( $setting ) ) {

				$wczas_sale_color = wcz_sanitize_hex_color( $mod );

				WooCustomizer_Library_Styles()->add( array(
					'selectors' => array(
						'.wcz-search-results-block .wcz-ajaxsearch-result .wcz-ajaxsearch-result-sale.onsale'
					),
					'declarations' => array(
						'background-color' => $wczas_sale_color,
						'color' => wcz_getContrastColor( $wczas_sale_color )
					)
				) );
			}
			// Ajax Search Padding
			$setting = 'wcz-ajaxsearch-padding';
			$mod = get_option( $setting, woocustomizer_library_get_default( $setting ) );

			if ( $mod !== woocustomizer_library_get_default( $setting ) ) {

				$wczas_pad = esc_attr( $mod );

				WooCustomizer_Library_Styles()->add( array(
					'selectors' => array(
						'.wcz-ajax-search-block .wcz-s,
						.wcz-ajax-search-block .wcz-s-submit'
					),
					'declarations' => array(
						'padding' => $wczas_pad . 'px ' . ( $wczas_pad + 5 ) . 'px'
					)
				) );
			}
			// Ajax Search Max-Width
			$setting = 'wcz-ajaxsearch-width';
			$mod = get_option( $setting, woocustomizer_library_get_default( $setting ) );

			if ( $mod !== woocustomizer_library_get_default( $setting ) ) {

				$wczas_width = esc_attr( $mod );

				WooCustomizer_Library_Styles()->add( array(
					'selectors' => array(
						'.wcz-ajax-search-block'
					),
					'declarations' => array(
						'width' => $wczas_width . '%'
					)
				) );
			}
			// Ajax Search Top Spacing
			$setting = 'wcz-ajaxsearch-toppad';
			$mod = get_option( $setting, woocustomizer_library_get_default( $setting ) );

			if ( $mod !== woocustomizer_library_get_default( $setting ) ) {

				$wczas_toppad = esc_attr( $mod );

				WooCustomizer_Library_Styles()->add( array(
					'selectors' => array(
						'.wcz-ajax-search-block-shop'
					),
					'declarations' => array(
						'margin-top' => $wczas_toppad . 'px'
					)
				) );
			}
			// Ajax Search Bottom Spacing
			$setting = 'wcz-ajaxsearch-botpad';
			$mod = get_option( $setting, woocustomizer_library_get_default( $setting ) );

			if ( $mod !== woocustomizer_library_get_default( $setting ) ) {

				$wczas_botpad = esc_attr( $mod );

				WooCustomizer_Library_Styles()->add( array(
					'selectors' => array(
						'.wcz-ajax-search-block-shop'
					),
					'declarations' => array(
						'margin-bottom' => $wczas_botpad . 'px'
					)
				) );
			}

		endif;

        // ----------------------------------------------------------------------------------------------- WCD AJAX SEARCH
        
        // ----------------------------------------------------------------------------------------------- WCD HANDHELD FOOTER BAR

        // Remove Handheld Search Button
        $setting = 'wcz-handheld-remove-btn';
        $mod = get_option( $setting, woocustomizer_library_get_default( $setting ) );

        if ( $mod !== woocustomizer_library_get_default( $setting ) ) {

            $wczas_fsize = esc_attr( $mod );

            WooCustomizer_Library_Styles()->add( array(
                'selectors' => array(
                    '.wcz-handheld-footerbar .wcz-handheld-searchbar .search-submit,
                    .wcz-handheld-searchbar .wcz-ajax-search-block .wcz-s-submit'
                ),
                'declarations' => array(
                    'display' => 'none !important'
                )
            ) );
        }

		if ( get_option( 'wcz-handheld-edit-design', woocustomizer_library_get_default( 'wcz-handheld-edit-design' ) ) ) :

            // Handheld Background Color
			$setting = 'wcz-handheld-bar-bgcolor';
			$mod = get_option( $setting, woocustomizer_library_get_default( $setting ) );

			if ( $mod !== woocustomizer_library_get_default( $setting ) ) {

				$wczhhfb_bgcolor = wcz_sanitize_hex_color( $mod );

				WooCustomizer_Library_Styles()->add( array(
					'selectors' => array(
						'.wcz-handheld-footerbar-inner'
					),
					'declarations' => array(
						'background-color' => $wczhhfb_bgcolor,
					)
                ) );
                WooCustomizer_Library_Styles()->add( array(
					'selectors' => array(
						'.wcz-handheld-footerbar-inner .wcz-handheld-link'
					),
					'declarations' => array(
						'color' => wcz_getContrastColor( $wczhhfb_bgcolor )
					)
				) );
            }
            // Handheld Icon Color
			$setting = 'wcz-handheld-bar-fontcolor';
			$mod = get_option( $setting, woocustomizer_library_get_default( $setting ) );

			if ( $mod !== woocustomizer_library_get_default( $setting ) ) {

				$wczhhfb_fontcolor = wcz_sanitize_hex_color( $mod );

                WooCustomizer_Library_Styles()->add( array(
					'selectors' => array(
                        '.wcz-handheld-footerbar-inner .wcz-handheld-link,
                        .wcz-handheld-footerbar-inner .wcz-handheld-title'
					),
					'declarations' => array(
						'color' => $wczhhfb_fontcolor
					)
				) );
            }
            // Handheld Icon Selected Color
			$setting = 'wcz-handheld-bar-hovercolor';
			$mod = get_option( $setting, woocustomizer_library_get_default( $setting ) );

			if ( $mod !== woocustomizer_library_get_default( $setting ) ) {

				$wczhhfb_hovercolor = wcz_sanitize_hex_color( $mod );

                WooCustomizer_Library_Styles()->add( array(
					'selectors' => array(
                        '.wcz-handheld-footerbar-inner .wcz-handheld-link:hover,
                        .wcz-handheld-footerbar-inner .wcz-handheld-link:hover .wcz-handheld-title'
					),
					'declarations' => array(
						'color' => $wczhhfb_hovercolor
					)
				) );
            }
            // Handheld Icon Size
			$setting = 'wcz-handheld-icon-size';
			$mod = get_option( $setting, woocustomizer_library_get_default( $setting ) );

			if ( $mod !== woocustomizer_library_get_default( $setting ) ) {

				$wczhhfb_iconsize = esc_attr( $mod );

				WooCustomizer_Library_Styles()->add( array(
					'selectors' => array(
						'.wcz-handheld-footerbar-inner .wcz-handheld-link span.dashicons'
					),
					'declarations' => array(
						'font-size' => $wczhhfb_iconsize . 'px'
					)
                ) );
                WooCustomizer_Library_Styles()->add( array(
					'selectors' => array(
						'.wcz-handheld-footerbar-inner .wcz-handheld-link .wcz-handheld-no'
					),
					'declarations' => array(
						'font-size' => $wczhhfb_iconsize < 24 ? 14 . 'px' : ( $wczhhfb_iconsize - 10 ) . 'px'
					)
				) );
            }
            
            // Handheld Title Size & Case
			$setting = 'wcz-handheld-title-size';
			$mod = get_option( $setting, woocustomizer_library_get_default( $setting ) );

			if ( $mod !== woocustomizer_library_get_default( $setting ) ) {

				$wczhhfb_titlesize = esc_attr( $mod );

				WooCustomizer_Library_Styles()->add( array(
					'selectors' => array(
						'.wcz-handheld-footerbar-inner .wcz-handheld-title'
					),
					'declarations' => array(
						'font-size' => $wczhhfb_titlesize . 'px'
					)
				) );
            }
            $setting = 'wcz-handheld-titles-uppercase';
			$mod = get_option( $setting, woocustomizer_library_get_default( $setting ) );

			if ( $mod !== woocustomizer_library_get_default( $setting ) ) {

				$wczhhfb_title_uc = esc_attr( $mod );

				WooCustomizer_Library_Styles()->add( array(
					'selectors' => array(
						'.wcz-handheld-footerbar-inner .wcz-handheld-title'
					),
					'declarations' => array(
						'text-transform' => 'uppercase'
					)
				) );
            }

		endif;

		// ----------------------------------------------------------------------------------------------- WCD HANDHELD FOOTER BAR

	} // EXCLUDED FROM FREE VERSION -- This "if" above block will be auto removed from the Free version.

}
endif;

add_action( 'customizer_library_styles', 'woocustomizer_customizer_library_build_styles' );

if ( ! function_exists( 'woocustomizer_customizer_library_styles' ) ) :
/**
 * Generates the style tag and CSS needed for the theme options.
 *
 * By using the "WooCustomizer_Library_Styles" filter, different components can print CSS in the header.
 * It is organized this way to ensure there is only one "style" tag.
 *
 * @since  1.0.0.
 *
 * @return void
 */
function woocustomizer_customizer_library_styles() {

	do_action( 'customizer_library_styles' );

	// Echo the rules
	$css = WooCustomizer_Library_Styles()->build();

	if ( ! empty( $css ) ) {
		wp_register_style( 'wcz-customizer-custom-css', false );
		wp_enqueue_style( 'wcz-customizer-custom-css' );
 		wp_add_inline_style( 'wcz-customizer-custom-css', $css );
	}
}
endif;

add_action( 'wp_enqueue_scripts', 'woocustomizer_customizer_library_styles', 11 );

function wcz_getContrastColor( $hexColor ) {

	// hexColor RGB
	$R1 = hexdec(substr($hexColor, 1, 2));
	$G1 = hexdec(substr($hexColor, 3, 2));
	$B1 = hexdec(substr($hexColor, 5, 2));

	// Black RGB
	$blackColor = "#000000";
	$R2BlackColor = hexdec(substr($blackColor, 1, 2));
	$G2BlackColor = hexdec(substr($blackColor, 3, 2));
	$B2BlackColor = hexdec(substr($blackColor, 5, 2));

	 // Calc contrast ratio
	 $L1 = 0.2126 * pow($R1 / 255, 2.2) +
		   0.7152 * pow($G1 / 255, 2.2) +
		   0.0722 * pow($B1 / 255, 2.2);

	$L2 = 0.2126 * pow($R2BlackColor / 255, 2.2) +
		  0.7152 * pow($G2BlackColor / 255, 2.2) +
		  0.0722 * pow($B2BlackColor / 255, 2.2);

	$contrastRatio = 0;
	if ($L1 > $L2) {
		$contrastRatio = (int)(($L1 + 0.05) / ($L2 + 0.05));
	} else {
		$contrastRatio = (int)(($L2 + 0.05) / ($L1 + 0.05));
	}

	// If contrast is more than 5, return black color
	if ( $contrastRatio > 5 ) {
		return '#000000';
	} else { 
		// if not, return white color.
		return '#FFFFFF';
	}
}
