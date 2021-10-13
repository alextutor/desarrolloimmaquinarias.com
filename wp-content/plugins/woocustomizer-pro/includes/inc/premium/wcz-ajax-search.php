<?php
/*
 * Add Product Quick View Button.
 */
function wcz_ajax_search_actions() {
    add_action( 'wp_ajax_wcz_ajax_search_get_products', 'wcz_ajax_search_get_products' );
    add_action( 'wp_ajax_nopriv_wcz_ajax_search_get_products', 'wcz_ajax_search_get_products' );
}
add_filter( 'init', 'wcz_ajax_search_actions' );

/**
 * Enqueue WCD Product Quick View scripts.
 */
function wcz_load_frontend_ajax_search_scripts() {
    wp_enqueue_style( 'wcz-ajaxsearch-custom-css', WCD_PLUGIN_URL . "/assets/css/premium/ajax-search.css", array(), WCD_PLUGIN_VERSION );
    
    wp_register_script( 'wcz-ajaxsearch-custom-js', WCD_PLUGIN_URL . '/assets/js/premium/ajax-search.js', array( 'jquery' ), WCD_PLUGIN_VERSION, true );
    wp_localize_script( 'wcz-ajaxsearch-custom-js', 'wcz_ajaxsearch', array(
        'ajax_url' => admin_url( 'admin-ajax.php' ),
        // 'texts' => $wcz_texts
    ) );
    wp_enqueue_script( 'wcz-ajaxsearch-custom-js' );
}
add_action( 'wp_enqueue_scripts', 'wcz_load_frontend_ajax_search_scripts' );

/**
 * Enqueue WCD Ajax Search customizer scripts.
 */
function wcz_load_customizer_ajax_search_scripts() {
	wp_enqueue_script( 'wcz-customizer-ajaxsearch-js', WCD_PLUGIN_URL . "/includes/customizer/customizer-library/js/premium/customizer-ajax-search.js", array('jquery'), WCD_PLUGIN_VERSION, true );
}
add_action( 'customize_controls_enqueue_scripts', 'wcz_load_customizer_ajax_search_scripts' );

/*
 * Add Product Quick View Button.
 */
function wcz_add_ajax_search_() {
    if ( get_option( 'wcz-enable-ajax-search', woocustomizer_library_get_default( 'wcz-enable-ajax-search' ) ) ) {
        add_action( 'woocommerce_before_shop_loop', 'wcz_ajax_search_addto_header' );
    }
}
add_filter( 'template_redirect', 'wcz_add_ajax_search_' );

// Add Ajax Search
function wcz_ajax_search_addto_header() {
    $wcz_min_chars = get_option( 'wcz-as-min-chars', woocustomizer_library_get_default( 'wcz-as-min-chars' ) );
    $wcz_placeholder = get_option( 'wcz-ajaxsearch-ph', woocustomizer_library_get_default( 'wcz-ajaxsearch-ph' ) );
    $wcz_btn = get_option( 'wcz-search-btn', woocustomizer_library_get_default( 'wcz-search-btn' ) );
    $wcz_btn_txt = get_option( 'wcz-ajaxsearch-btn-txt', woocustomizer_library_get_default( 'wcz-ajaxsearch-btn-txt' ) );

    ob_start(); ?>
        <div class="wcz-ajax-search-block wcz-ajax-search-block-shop" data-minchars="<?php echo esc_attr( $wcz_min_chars ); ?>">
            <form role="search" method="get" class="wcz-search-form" action="<?php echo esc_url( home_url( '/'  ) ) ?>">
                <input type="search" value="<?php echo get_search_query() ?>" name="s" class="wcz-s" placeholder="<?php echo esc_attr( $wcz_placeholder ); ?>" autocomplete="off" />
                <?php if ( 'wcz-as-btn-none' == $wcz_btn ) : ?>
                    <!-- No Button -->
                <?php elseif ( 'wcz-as-btn-icon' == $wcz_btn ) : ?>
                    <button class="wcz-s-submit fas <?php echo sanitize_html_class( get_option( 'wcz-search-btn-icon', woocustomizer_library_get_default( 'wcz-search-btn-icon' ) ) ); ?>"></button>
                <?php else : ?>
                    <?php if ( !get_option( 'wcz-ajaxsearch-remove-btn', woocustomizer_library_get_default( 'wcz-ajaxsearch-remove-btn' ) ) ) : ?>
                        <input type="submit" class="wcz-s-submit" value="<?php echo esc_attr( $wcz_btn_txt ); ?>">
                    <?php endif; ?>
                <?php endif; ?>
            </form>
        </div>
    <?php
    echo ob_get_clean();
}

// AJAX Get Products for Search Results
function wcz_ajax_search_get_products() {
    // Get $product ID from ajax
    $search_for = $_POST['search_for'];
    $wcz_results_amt = get_option( 'wcz-as-results-amount', woocustomizer_library_get_default( 'wcz-as-results-amount' ) );
    $search_thro = get_option( 'wcz-search-thro', woocustomizer_library_get_default( 'wcz-search-thro' ) );
    $search_cats = get_option( 'wcz-as-and-cats', woocustomizer_library_get_default( 'wcz-as-and-cats' ) );
    $search_tags = get_option( 'wcz-as-and-tags', woocustomizer_library_get_default( 'wcz-as-and-tags' ) );

    $search_orderby = get_option( 'wcz-search-orderby', woocustomizer_library_get_default( 'wcz-search-orderby' ) );
    $search_order = get_option( 'wcz-search-order', woocustomizer_library_get_default( 'wcz-search-order' ) );

    $args = array(
        'status' => 'publish',
        'limit' => -1,
        'orderby' => $search_orderby, // 'none' | 'ID' | 'name' | 'type' | 'rand' | 'date' | 'modified'
        'order' => $search_order, // 'DESC' | 'ASC'
        'return' => 'ids', // 'ids' | 'objects'
    );
    $products = wc_get_products( $args );

    $product_results = array();

    foreach ( $products as $product ) {
        $product = wc_get_product( $product );

        switch ( $search_thro ) {
            case "wcz-ajaxs-title":
                $search_in = $product->get_name();
                break;
            case "wcz-ajaxs-title-cont":
                $search_in = $product->get_name() . ' ' . $product->get_short_description();
                break;
            case "wcz-ajaxs-title-longcont":
                $search_in = $product->get_name() . ' ' . $product->get_description();
                break;
            default:
                $search_in = $product->get_name() . ' ' . $product->get_short_description() . ' ' . $product->get_description() . ' ' . $product->get_sku();
        }

        // Include Product Categories in Search
        if ( $search_cats ) {
            $cats = get_the_terms( $product->get_id(), 'product_cat' );
            $all_cats = '';
            foreach ( $cats  as $cat ) {                            
                $all_cats .= ' ' . $cat->name;
            }
            $search_in .= $all_cats;
        }
        // Include Product Tags in Search
        if ( $search_tags ) {
            $tags = get_the_terms( $product->get_id(), 'product_tag' );
            $all_tags = '';
            foreach ( $tags  as $tag ) {                            
                $all_tags .= ' ' . $tag->name;
            }
            $search_in .= $all_tags;
        }

        $search = stripos( $search_in, $search_for );

        if ( $search !== false ) {

            $product_results[] = array(
                'id' => $product->get_id(),
                'name' => $product->get_name(),
                'short_desc' => $product->get_short_description(),
                'long_desc' => $product->get_description(),
                'on_sale' => $product->is_on_sale(),
                'cats' => $product->get_categories()
            );

        }

    }
    
    $product_results = array_slice( $product_results, 0, $wcz_results_amt );

    ob_start(); ?>

        <?php foreach ( $product_results as $product_result ) : ?>

            <a href="<?php echo esc_url( get_the_permalink( $product_result['id'] ) ); ?>" class="wcz-ajaxsearch-result" id="product-<?php echo esc_attr( $product_result['id'] ); ?>" <?php post_class( 'wcz-ajax-search-product product' ); ?>>

                <?php if ( !get_option( 'wcz-ajaxsearch-remove-img', woocustomizer_library_get_default( 'wcz-ajaxsearch-remove-img' ) ) ) : ?>
                    <div class="wcz-ajaxsearch-result-img">
                        <img src="<?php echo esc_url( get_the_post_thumbnail_url( $product_result['id'], 'thumbnail' ) ); ?>" alt="<?php echo esc_html( $product_result['name'] ); ?>"/>
                    </div>
                <?php endif; ?>

                <div class="wcz-ajaxsearch-result-cont">
                    
                    <h6 classs="wcz-ajaxsearch-result-title">
                        <?php echo esc_html( $product_result['name'] ); ?>
                    </h6>

                    <?php if ( !get_option( 'wcz-ajaxsearch-remove-desc', woocustomizer_library_get_default( 'wcz-ajaxsearch-remove-desc' ) ) ) : ?>
                        <div class="wcz-ajaxsearch-result-desc">
                            <?php echo htmlspecialchars_decode( $product_result['short_desc'] ); ?>
                        </div>
                    <?php endif; ?>

                </div>

                <?php if ( !get_option( 'wcz-ajaxsearch-remove-sale', woocustomizer_library_get_default( 'wcz-ajaxsearch-remove-sale' ) ) || !get_option( 'wcz-ajaxsearch-remove-cats', woocustomizer_library_get_default( 'wcz-ajaxsearch-remove-cats' ) ) ) : ?>
                    <div class="wcz-ajaxsearch-result-meta">
                        <?php
                        if ( !get_option( 'wcz-ajaxsearch-remove-sale', woocustomizer_library_get_default( 'wcz-ajaxsearch-remove-sale' ) ) ) :
                            if ( $product_result['on_sale'] ) : ?>
                                <span class="wcz-ajaxsearch-result-sale onsale">On Sale</span>
                            <?php
                            endif;
                        endif; ?>
                        <?php if ( !get_option( 'wcz-ajaxsearch-remove-cats', woocustomizer_library_get_default( 'wcz-ajaxsearch-remove-cats' ) ) ) : ?>
                            <div class="wcz-ajaxsearch-result-cats"><?php echo esc_html( wp_strip_all_tags( $product_result['cats'] ) ); ?></div>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>
                
            </a>

        <?php endforeach; ?>

    <?php
    echo ob_get_clean();
    
    die();
}

// Create Ajax Search Shortcode
function wcz_ajax_search_shortcode( $atts ) {
    extract( shortcode_atts( array(
        'min_chars' => get_option( 'wcz-as-min-chars', woocustomizer_library_get_default( 'wcz-as-min-chars' ) ),
        'placeholder' => get_option( 'wcz-ajaxsearch-ph', woocustomizer_library_get_default( 'wcz-ajaxsearch-ph' ) ),
        'button' => 1,
        'button_text' => get_option( 'wcz-ajaxsearch-btn-txt', woocustomizer_library_get_default( 'wcz-ajaxsearch-btn-txt' ) ),
    ), $atts ) );

    $wcz_btn = get_option( 'wcz-search-btn', woocustomizer_library_get_default( 'wcz-search-btn' ) );
    
    ob_start(); ?>
        <div class="wcz-ajax-search-block" data-minchars="<?php echo esc_attr( $min_chars ); ?>">
            <form role="search" method="get" class="wcz-search-form" action="<?php echo esc_url( home_url( '/'  ) ) ?>">
                <input type="search" value="<?php echo get_search_query(); ?>" name="s" class="wcz-s" placeholder="<?php echo esc_attr( $placeholder ); ?>" autocomplete="off" />
                <?php if ( 'wcz-as-btn-none' == $wcz_btn ) : ?>
                    <!-- No Button -->
                <?php elseif ( 'wcz-as-btn-icon' == $wcz_btn ) : ?>
                    <button class="wcz-s-submit fas <?php echo sanitize_html_class( get_option( 'wcz-search-btn-icon', woocustomizer_library_get_default( 'wcz-search-btn-icon' ) ) ); ?>"></button>
                <?php else : ?>
                    <?php if ( 0 != $button ) : ?>
                        <input type="submit" class="wcz-s-submit" value="<?php echo esc_attr( $button_text ); ?>">
                    <?php endif; ?>
                <?php endif; ?>
            </form>
        </div>
    <?php
    return ob_get_clean();
}
add_shortcode( 'woocustomizer_ajax_search', 'wcz_ajax_search_shortcode' );
