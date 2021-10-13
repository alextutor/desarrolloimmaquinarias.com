<?php
/**
 * Enqueue WCD Catalogue Mode scripts.
 */
function wcz_load_frontend_pb_scripts() {
    wp_enqueue_style( 'wcz-product-badges-css', WCD_PLUGIN_URL . "/assets/css/premium/product-badges.css", array(), WCD_PLUGIN_VERSION );
    
    if ( is_shop() || is_product_category() || is_product_tag() || is_product() ) {
        wp_enqueue_script( 'wcz-product-badges-js', WCD_PLUGIN_URL . "/assets/js/premium/product-badges.js", array( 'jquery' ), WCD_PLUGIN_VERSION );
    }
    if ( is_product() ) {
        wp_enqueue_script( 'wcz-product-page-badges-js', WCD_PLUGIN_URL . "/assets/js/premium/product-badges-single.js", array( 'jquery' ), WCD_PLUGIN_VERSION );
    }
}
add_action( 'wp_enqueue_scripts', 'wcz_load_frontend_pb_scripts' );
/**
 * Enqueue admin styling.
 */
function elation_admin_scripts() {
    global $post;
    global $pagenow;
    // var_dump( '--------------------------------- ' . $pagenow . ' -- ' . $post->post_type );
    if ( $pagenow == 'edit.php' && ( isset( $post->post_type ) && $post->post_type == 'wcz-badges' ) ) :
        wp_enqueue_style( 'wcz-product-badges-css', WCD_PLUGIN_URL . "/assets/css/premium/product-badges.css", array(), WCD_PLUGIN_VERSION );
        $wcz_badge_cols_css = 'th#wcz-badge-col, td.column-wcz-badge-col { width: 200px; text-align: center; }
                            .wcz-badge-col-inner { display: flex; align-items: center; justify-content: center; height: 80px; }
                            .wcz-badge-col-inner img { width: 70px; height: auto; }
                            th#date { width: 200px; }
                            .wcz-badge-col-inner.wcz-pbadge { position: relative; }';
        wp_register_style( 'wcz-pbadges-cols', false );
        wp_enqueue_style( 'wcz-pbadges-cols' );
        wp_add_inline_style( 'wcz-pbadges-cols', $wcz_badge_cols_css );
    endif;
    if ( ( $pagenow == 'post-new.php' || $pagenow == 'post.php' ) && ( isset( $post->post_type ) && $post->post_type == 'wcz-badges' ) ) :
        wp_enqueue_media();
		wp_enqueue_style( 'wp-color-picker');
        wp_enqueue_script( 'wp-color-picker');
        wp_enqueue_style( 'wcz-product-badges-css', WCD_PLUGIN_URL . "/assets/css/premium/product-badges.css", array(), WCD_PLUGIN_VERSION );
        wp_enqueue_style( 'wcz-product-badges-admin-css', WCD_PLUGIN_URL . '/assets/css/premium/admin/product-badges-admin.css', array( 'wp-color-picker' ), WCD_PLUGIN_VERSION );
        wp_enqueue_script( 'wcz-product-badges-admin-js', WCD_PLUGIN_URL . '/assets/css/premium/admin/product-badges-admin.js', array( 'jquery', 'wp-color-picker' ), WCD_PLUGIN_VERSION );
    endif;
}
add_action( 'admin_enqueue_scripts', 'elation_admin_scripts' );

/* -- Custom Post Types -- */
function create_post_type() {
    register_post_type( 'wcz-badges',
        array(
            'labels' => array(
                'name' => __( 'Product Badges', 'woocustomizer' ),
                'singular_name' => __( 'Product Badges', 'woocustomizer' )
            ),
            'public' => true,
            'show_in_menu' => 'edit.php?post_type=product',
            'menu_icon' => 'dashicons-editor-paste-text',
            'rewrite' => array( 'slug' => 'wcz-badges' ),
            'show_in_rest' => true,
            'supports' => array( 'title' ),
        )
    );
}
add_action( 'init', 'create_post_type' );

/*
 * Create Badges Post Meta Boxes
 */
function wcz_add_pbadge_metabox() {
    add_meta_box( 'wcz-pbadge-mbox', __( 'Product Badge Settings', 'woocustomizer' ), 'wcz_pbadge_settings', 'wcz-badges', 'normal', null );
    add_meta_box( 'wcz-pbadge-preview', __( 'Product Preview', 'woocustomizer' ), 'wcz_pbadge_preview', 'wcz-badges', 'side', null );
}
add_action( 'add_meta_boxes', 'wcz_add_pbadge_metabox' );

/*
 * Create the Settings box
 */
function wcz_pbadge_settings( $object ) {
    
    wp_nonce_field( basename( __FILE__ ), 'wcz-pbadges-nonce' );
    
    $wcz_pbadge_design = get_post_meta( $object->ID, 'wcz-pbadge-design', true );
    $wcz_pbadge_color = get_post_meta( $object->ID, 'wcz_pbadge_color', true );
    $wcz_pbadge_font_color = get_post_meta( $object->ID, 'wcz_pbadge_font_color', true );
    $wcz_pbadge_text = get_post_meta( $object->ID, 'wcz-pbadge-text', true );
    $wcz_pbadge_position = get_post_meta( $object->ID, 'wcz-pbadge-position', true );
    $wcz_pbadge_belement = get_post_meta( $object->ID, 'wcz-pbadge-belement', true );
    
    $wcz_pbadge_horizoffset = get_post_meta( $object->ID, 'wcz-pbadge-horizoffset', true ) ? get_post_meta( $object->ID, 'wcz-pbadge-horizoffset', true ) : 'right|0';
    $wcz_pbadge_horizoffset_arr = explode( '|', $wcz_pbadge_horizoffset );
    
    $wcz_pbadge_vertoffset = get_post_meta( $object->ID, 'wcz-pbadge-vertoffset', true ) ? get_post_meta( $object->ID, 'wcz-pbadge-vertoffset', true ) : 'top|0';
    $wcz_pbadge_vertoffset_arr = explode( '|', $wcz_pbadge_vertoffset );

    $wcz_pbadge_switch = get_post_meta( $object->ID, 'wcz-pbadge-switch', true );
    
    $wcz_uploaded_badge = get_post_meta( $object->ID, 'wcz-upmedia', true );
    $wcz_pbadge_mwidth = get_post_meta( $object->ID, 'wcz-pbadge-mwidth', true ); ?>

    <div class="wcz-pbadge-settings">

        <input type="hidden" id="wcz-saved-badge"
            data-design="<?php echo $wcz_pbadge_design ? esc_attr( $wcz_pbadge_design ) : 'one'; ?>"
            data-text="<?php echo esc_attr( $wcz_pbadge_text ); ?>"
            data-bcolor="<?php echo esc_attr( $wcz_pbadge_color ); ?>"
            data-fcolor="<?php echo esc_attr( $wcz_pbadge_font_color ); ?>"
            data-position="<?php echo esc_attr( $wcz_pbadge_position ); ?>"
            data-horizpos="<?php echo esc_attr( $wcz_pbadge_horizoffset_arr[0] ); ?>"
            data-horizno="<?php echo esc_attr( $wcz_pbadge_horizoffset_arr[1] ); ?>"
            data-vertpos="<?php echo esc_attr( $wcz_pbadge_vertoffset_arr[0] ); ?>"
            data-vertno="<?php echo esc_attr( $wcz_pbadge_vertoffset_arr[1] ); ?>"
            data-cimg="<?php echo $wcz_uploaded_badge ? esc_attr( $wcz_uploaded_badge ) : ''; ?>"
            data-mwidth="<?php echo $wcz_pbadge_mwidth ? esc_attr( $wcz_pbadge_mwidth ) : '120'; ?>" />

        <label><?php esc_html_e( "Choose a Badge Design:", 'woocustomizer' ); ?></label>
        <div class="pbadges-blocks">
            <div class="pbadges-block <?php echo ( 'one' == $wcz_pbadge_design || !$wcz_pbadge_design ) ? sanitize_html_class( 'active' ) : ''; ?>" data-badge="one">

                <div class="wczbadge bfc2 bbgc1 one"><div class="wczbadge-inner"><span>Discount!</span></div></div>

            </div>
            <div class="pbadges-block <?php echo 'two' == $wcz_pbadge_design ? sanitize_html_class( 'active' ) : ''; ?>" data-badge="two">
                
                <div class="wczbadge bcbc1 bfc2 two"><div class="wczbadge-inner"><span>On Sale!</span></div></div>

            </div>
            <div class="pbadges-block canswitch <?php echo 'three' == $wcz_pbadge_design ? sanitize_html_class( 'active' ) : ''; ?>" data-badge="three">
                
                <div class="wczbadge bfc2 three"><div class="wczbblk bbrc1 bblc1"></div><div class="wczbadge-inner"><span>NEW PRODUCT!</span></div></div>

            </div>
            <div class="pbadges-block <?php echo 'four' == $wcz_pbadge_design ? sanitize_html_class( 'active' ) : ''; ?>" data-badge="four">
                
                <div class="wczbadge bfc2 bbbc1 four"><div class="wczbadge-inner"><span>SALE !</span></div></div>

            </div>
            <div class="pbadges-block <?php echo 'five' == $wcz_pbadge_design ? sanitize_html_class( 'active' ) : ''; ?>" data-badge="five">
                
                <div class="wczbadge bfc2 bbgc1 five"><div class="wczbadge-inner"><span>New !</span></div></div>

            </div>
            <div class="pbadges-block canswitch <?php echo 'six' == $wcz_pbadge_design ? sanitize_html_class( 'active' ) : ''; ?>" data-badge="six">

                <div class="wczbadge bfc2 bbgc1 six"><div class="wczbadge-inner"><div class="wczbblk bbrc1 bblc1"></div><span>Banner!</span><div class="wczablk"></div></div></div>

            </div>
            <div class="pbadges-block <?php echo 'seven' == $wcz_pbadge_design ? sanitize_html_class( 'active' ) : ''; ?>" data-badge="seven">
                
                <div class="wczbadge bfc2 bbtc1 seven"><div class="wczbadge-inner"><span>SALE !</span></div></div>

            </div>
            <div class="pbadges-block <?php echo 'eight' == $wcz_pbadge_design ? sanitize_html_class( 'active' ) : ''; ?>" data-badge="eight">
                
                <div class="wczbadge bfc2 bbtc1 eight"><div class="wczbadge-inner"><span>FEATURED!</span></div></div>

            </div>
            <div class="pbadges-block <?php echo 'nine' == $wcz_pbadge_design ? sanitize_html_class( 'active' ) : ''; ?>" data-badge="nine">
                
                <div class="wczbadge bbc1 bfc2 bbgc1 nine"><div class="wczbadge-inner"><span>VIEW!</span></div></div>

            </div>
            <div class="pbadges-block <?php echo 'ten' == $wcz_pbadge_design ? sanitize_html_class( 'active' ) : ''; ?>" data-badge="ten">
                
                <div class="wczbadge bbc1 bfc2 bbgc1 ten"><div class="wczbadge-inner"><span>New!</span></div></div>

            </div>
            <div class="pbadges-block <?php echo 'eleven' == $wcz_pbadge_design ? sanitize_html_class( 'active' ) : ''; ?>" data-badge="eleven">
                
                <div class="wczbadge eleven"><div class="wczbblk bbgc1"></div><div class="wczbadge-inner"></div><div class="wczablk bbgc1"></div></div>

            </div>
            <div class="pbadges-block <?php echo 'twelve' == $wcz_pbadge_design ? sanitize_html_class( 'active' ) : ''; ?>" data-badge="twelve">
                
                <div class="wczbadge bfc2 bbgc1 twelve"><div class="wczbblk bbbc1"></div><div class="wczbadge-inner"><span>Now on Sale!</span></div><div class="wczablk bbbc1"></div></div>

            </div>
            <div class="pbadges-block <?php echo 'thirteen' == $wcz_pbadge_design ? sanitize_html_class( 'active' ) : ''; ?>" data-badge="thirteen">
                
                <div class="wczbadge bfc2 bbgc1 thirteen"><div class="wczbadge-inner"><span>View Product!</span></div></div>

            </div>
            <div class="pbadges-block <?php echo 'fourteen' == $wcz_pbadge_design ? sanitize_html_class( 'active' ) : ''; ?>" data-badge="fourteen">
                
                <div class="wczbadge bfc2 bbgc1 fourteen"><div class="wczbblk bbtc1"></div><div class="wczbadge-inner"><span>Featured Product</span></div></div>

            </div>
            <div class="pbadges-block canswitch <?php echo 'fiveteen' == $wcz_pbadge_design ? sanitize_html_class( 'active' ) : ''; ?>" data-badge="fiveteen">
                
                <div class="wczbadge bfc2 fiveteen"><div class="wczbadge-inner bbgc1"><span>NEW !</span></div></div>

            </div>
            <div class="pbadges-block canswitch <?php echo 'sixteen' == $wcz_pbadge_design ? sanitize_html_class( 'active' ) : ''; ?>" data-badge="sixteen">
                
                <div class="wczbadge bfc2 sixteen"><div class="wczbblk bbrc1 bblc1"></div><div class="wczbadge-inner bbgc1"><span>NEW !</span></div><div class="wczablk bbrc1 bblc1"></div></div>

            </div>
            <div class="pbadges-block canswitch <?php echo 'seventeen' == $wcz_pbadge_design ? sanitize_html_class( 'active' ) : ''; ?>" data-badge="seventeen">
                
                <div class="wczbadge bbrc1 bblc1 seventeen"><div class="wczbadge-inner"></div><div class="wczablk bbtc1 bbbc1"></div></div>

            </div>
            <div class="pbadges-block <?php echo 'eightteen' == $wcz_pbadge_design ? sanitize_html_class( 'active' ) : ''; ?>" data-badge="eightteen">
                
                <div class="wczbadge bfc2 eightteen"><div class="wczbblk bbbc1"></div><div class="wczbadge-inner"><span>BOOM !</span></div><div class="wczablk bbtc1"></div></div>

            </div>
            <div class="pbadges-block custom <?php echo 'custom' == $wcz_pbadge_design ? sanitize_html_class( 'active' ) : ''; ?>" data-badge="custom">
                
                <img src="<?php echo esc_url( WCD_PLUGIN_URL . '/assets/images/upload-icon.png' ); ?>" alt="Upload" />
                <div class="custom-badge-in">Custom Badge</div>

            </div>
        </div>
        <input type="hidden" name="wcz-pbadge-design" id="wcz-pbadge-design" value="<?php echo $wcz_pbadge_design ? $wcz_pbadge_design : 'one'; ?>" />


        <div class="wcz-meta-setting wcz-custom">
            <div class="wcz-meta-left">
                <?php esc_html_e( 'Upload a Custom Badge', 'woocustomizer' ); ?>
            </div>
            <div class="wcz-meta-right">
                <button type="button" class="button wcz-custom-upload <?php echo $wcz_uploaded_badge ? sanitize_html_class( 'hide' ) : ''; ?>" data-media-uploader-target="#wcz-upmedia"><?php esc_html_e( 'Upload Custom Badge', 'woocustomizer' )?></button>
                <div class="wcz-upload-img">
                    <?php if ( $wcz_uploaded_badge ) :
                        $img = wp_get_attachment_image_src( $wcz_uploaded_badge, 'full' ); ?>
                        <div class="wcz-upload-image"><img src="<?php echo esc_url( $img[0] ); ?>" /></div>
                    <?php else : ?>
                        <div class="wcz-upload-image"></div>
                    <?php endif; ?>
                    <input type="hidden" class="wcz-pbadge-custom" name="wcz-upmedia" id="wcz-upmedia" value="<?php echo esc_attr( $wcz_uploaded_badge ); ?>">
                    <a href="#" id="wcz-custom-rm" class="wcz-custom-rm <?php echo $wcz_uploaded_badge ? '' : sanitize_html_class( 'hide' ); ?>"><?php esc_html_e( 'Remove', 'woocustomizer' )?></a>
                </div>
            </div>
        </div>
        <div class="wcz-meta-setting wcz-custom">
            <div class="wcz-meta-left">
                <label><?php esc_html_e( 'Max Width', 'woocustomizer' ); ?></label>
            </div>
            <div class="wcz-meta-right">
                <input class="wcz-pbadge-mwidth" type="number" name="wcz-pbadge-mwidth" value="<?php echo $wcz_pbadge_mwidth ? esc_attr( $wcz_pbadge_mwidth ) : '120'; ?>"/>
            </div>
        </div>

        <div class="wcz-meta-setting wcz-normal">
            <div class="wcz-meta-left align">
                <label><?php esc_html_e( 'Badge Text', 'woocustomizer' ); ?></label>
            </div>
            <div class="wcz-meta-right">
                <input class="wcz-pbadge-text" type="text" name="wcz-pbadge-text" value="<?php echo esc_attr( $wcz_pbadge_text ); ?>"/>
                <p class="wcz-pbadge-desc"><?php esc_html_e( 'Use these shortcodes to display discount amounts:', 'woocustomizer' ); ?> <span>[percent]</span>, <span>[amount]</span><br /><?php esc_html_e( 'This will use 25% for [percent] and $15 for [amount] in this preview.', 'woocustomizer' ); ?></p>
            </div>
        </div>

        <div class="wcz-meta-setting wcz-normal">
            <div class="wcz-meta-left">
                <?php esc_html_e( 'Badge Color', 'woocustomizer' ); ?>
            </div>
            <div class="wcz-meta-right">
                <input class="wcz-pbadge-bcolor" type="text" name="wcz_pbadge_color" value="<?php esc_attr_e( $wcz_pbadge_color ); ?>" />
            </div>
        </div>

        <div class="wcz-meta-setting wcz-normal">
            <div class="wcz-meta-left">
                <?php esc_html_e( 'Text Color', 'woocustomizer' ); ?>
            </div>
            <div class="wcz-meta-right">
                <input class="wcz-pbadge-fcolor" type="text" name="wcz_pbadge_font_color" value="<?php esc_attr_e( $wcz_pbadge_font_color ); ?>"/>
            </div>
        </div>

        <div class="wcz-meta-setting wcz-switch">
            <div class="wcz-meta-left">
                <label for="wcz-pbadge-switch"><?php esc_html_e( 'Switch Badge Alignment', 'woocustomizer' ); ?></label>
            </div>
            <div class="wcz-meta-right">
                <?php if ( $wcz_pbadge_switch == '' ) : ?>
                    <input name="wcz-pbadge-switch" id="wcz-pbadge-switch" type="checkbox" value="true">
                <?php elseif ( $wcz_pbadge_switch == "true" ) : ?>
                    <input name="wcz-pbadge-switch" id="wcz-pbadge-switch" type="checkbox" value="true" checked>
                <?php endif; ?>
            </div>
        </div>

        <div class="wcz-meta-setting">
            <div class="wcz-meta-left">
                <label for="wcz-pbadge-position"><?php esc_html_e( 'Badge Position', 'woocustomizer' ); ?></label>
            </div>
            <div class="wcz-meta-right">
                <select name="wcz-pbadge-position" id="wcz-pbadge-position">
                    <option value="topright" <?php selected( $wcz_pbadge_position, 'topright' ); ?>><?php esc_html_e( 'Top Right', 'woocustomizer' ); ?></option>
                    <option value="topcenter" <?php selected( $wcz_pbadge_position, 'topcenter' ); ?>><?php esc_html_e( 'Top Center', 'woocustomizer' ); ?></option>
                    <option value="topleft" <?php selected( $wcz_pbadge_position, 'topleft' ); ?>><?php esc_html_e( 'Top Left', 'woocustomizer' ); ?></option>
                    <option value="middleright" <?php selected( $wcz_pbadge_position, 'middleright' ); ?>><?php esc_html_e( 'Middle Right', 'woocustomizer' ); ?></option>
                    <option value="middlecenter" <?php selected( $wcz_pbadge_position, 'middlecenter' ); ?>><?php esc_html_e( 'Middle Center', 'woocustomizer' ); ?></option>
                    <option value="middleleft" <?php selected( $wcz_pbadge_position, 'middleleft' ); ?>><?php esc_html_e( 'Middle Left', 'woocustomizer' ); ?></option>
                    <option value="bottomright" <?php selected( $wcz_pbadge_position, 'bottomright' ); ?>><?php esc_html_e( 'Bottom Right', 'woocustomizer' ); ?></option>
                    <option value="bottomcenter" <?php selected( $wcz_pbadge_position, 'bottomcenter' ); ?>><?php esc_html_e( 'Bottom Center', 'woocustomizer' ); ?></option>
                    <option value="bottomleft" <?php selected( $wcz_pbadge_position, 'bottomleft' ); ?>><?php esc_html_e( 'Bottom Left', 'woocustomizer' ); ?></option>
                </select>
            </div>
        </div>
        <div class="wcz-meta-setting">
            <div class="wcz-meta-left align">
                <label for="wcz-pbadge-horizoffset-pos"><?php esc_html_e( 'Position Horizontal Offset', 'woocustomizer' ); ?></label>
            </div>
            <div class="wcz-meta-right wcz-pbadge-offpos">
                <?php
                $wcz_pbadge_horizoffset_arr = explode( '|', $wcz_pbadge_horizoffset );
                $wcz_pbadge_horizoffset_pos = $wcz_pbadge_horizoffset_arr[0];
                $wcz_pbadge_horizoffset_no = $wcz_pbadge_horizoffset_arr[1]; ?>
                <select name="wcz-pbadge-horizoffset-pos" id="wcz-pbadge-horizoffset-pos">
                    <option value="left" <?php selected( $wcz_pbadge_horizoffset_pos, 'left' ); ?>><?php esc_html_e( 'Left', 'woocustomizer' ); ?></option>
                    <option value="right" <?php selected( $wcz_pbadge_horizoffset_pos, 'right' ); ?>><?php esc_html_e( 'Right', 'woocustomizer' ); ?></option>
                </select>:
                <input class="wcz-pbadge-horizoffset-no" type="number" name="wcz-pbadge-horizoffset-no" value="<?php echo $wcz_pbadge_horizoffset_no ? esc_attr( $wcz_pbadge_horizoffset_no ) : '0'; ?>"/>px
                <p class="wcz-pbadge-desc"><?php esc_html_e( 'You can also use negative numbers (-) to position the badge.', 'woocustomizer' ); ?></p>
            </div>
        </div>

        <div class="wcz-meta-setting">
            <div class="wcz-meta-left align">
                <label for="wcz-pbadge-vertoffset-pos"><?php esc_html_e( 'Position Vertical Offset', 'woocustomizer' ); ?></label>
            </div>
            <div class="wcz-meta-right wcz-pbadge-offpos">
                <?php
                $wcz_pbadge_vertoffset_arr = explode( '|', $wcz_pbadge_vertoffset );
                $wcz_pbadge_vertoffset_pos = $wcz_pbadge_vertoffset_arr[0];
                $wcz_pbadge_vertoffset_no = $wcz_pbadge_vertoffset_arr[1]; ?>
                <select name="wcz-pbadge-vertoffset-pos" id="wcz-pbadge-vertoffset-pos">
                    <option value="top" <?php selected( $wcz_pbadge_vertoffset_pos, 'top' ); ?>><?php esc_html_e( 'Top', 'woocustomizer' ); ?></option>
                    <option value="bottom" <?php selected( $wcz_pbadge_vertoffset_pos, 'bottom' ); ?>><?php esc_html_e( 'Bottom', 'woocustomizer' ); ?></option>
                </select>:
                <input class="wcz-pbadge-vertoffset-no" type="number" name="wcz-pbadge-vertoffset-no" value="<?php echo $wcz_pbadge_vertoffset_no ? esc_attr( $wcz_pbadge_vertoffset_no ) : '0'; ?>"/>px
                <p class="wcz-pbadge-desc"><?php esc_html_e( 'You can also use negative numbers (-) to position the badge.', 'woocustomizer' ); ?></p>
            </div>
        </div>

        <div class="wcz-meta-setting separate">
            <div class="wcz-meta-left align">
                <label><?php esc_html_e( 'Attach to Custom Element', 'woocustomizer' ); ?></label>
            </div>
            <div class="wcz-meta-right">
                <input class="wcz-pbadge-belement" type="text" name="wcz-pbadge-belement" value="<?php echo esc_attr( $wcz_pbadge_belement ); ?>"/>
                <p class="wcz-pbadge-desc">
                    <?php esc_html_e( 'This is used for if your theme is overiding the WooCommerce templates.', 'woocustomizer' ); ?><br />
                    <?php esc_html_e( 'Set the class of where you want the product badge to attach to.', 'woocustomizer' ); ?><br />
                    <a href="" target="_blank"><?php esc_html_e( 'Read More on using this feature', 'woocustomizer' ); ?></a>
                </p>
            </div>
        </div>

        <p class="wcz-pbadge-note">
            <?php
            /* translators: 1: 'Contact Us'. */
            printf( esc_html__( 'Edited the badge and something\'s not aligning correctly? Or want slight extra tweaks? %1$s for some extra CSS to make it look better.', 'woocustomizer' ), wp_kses( __( '<a href="https://storecustomizer.com/#anchor-contact" target="_blank">Contact Us</a>', 'woocustomizer' ), array( 'a' => array( 'href' => array(), 'target' => array() ) ) ) ); ?>
        </p>
    </div>
<?php
}

/*
 * Create the Badge Preview
 */
function wcz_pbadge_preview( $object ) {
    $wcz_pbadge_design = get_post_meta( $object->ID, 'wcz-pbadge-design', true );
    $wcz_pbadge_position = get_post_meta( $object->ID, 'wcz-pbadge-position', true ) ? get_post_meta( $object->ID, 'wcz-pbadge-position', true ) : 'topright';
    $wcz_pbadge_switch = get_post_meta( $object->ID, 'wcz-pbadge-switch', true ); ?>
    <div class="wcz-pbadge-preview">
        <div class="wcz-pbadge-product">
            <div class="wcz-pbadge-product-img">
                <div class="wcz-pbadge <?php echo sanitize_html_class( $wcz_pbadge_position ); ?> <?php echo 'true' == $wcz_pbadge_switch ? sanitize_html_class( 'switch' ) : ''; ?>">
                    <div class="wcz-pbadge-in" data-badge="<?php echo $wcz_pbadge_design ? esc_attr( $wcz_pbadge_design ) : 'one'; ?>"></div>
                </div>
                <img src="<?php echo esc_url( WCD_PLUGIN_URL . '/assets/css/premium/admin/images/storecustomizer-placeholder.jpg' ); ?>" alt="StoreCustomizer" />
            </div>
            <h3 class="title"><?php echo esc_html( 'StoreCustomizer' ); ?></h3>
            <div class="price"><?php echo esc_html( '$29.00' ); ?></div>
            <div class="fake-button"><?php echo esc_html( 'Add to cart' ); ?></div>
        </div>
    </div>
<?php
} 

/*
 * Save Page metabox data
 */
function elation_save_page_settings_metabox( $post_id, $post, $update ) {
	
    if ( !isset( $_POST['wcz-pbadges-nonce'] ) || !wp_verify_nonce( $_POST['wcz-pbadges-nonce'], basename( __FILE__ ) ) )
        return $post_id;

    if ( !current_user_can( "edit_post", $post_id ) )
        return $post_id;

    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE )
        return $post_id;

    $slug = 'wcz-badges';
    if ( $slug != $post->post_type )
        return $post_id;

    $wcz_pbadge_design = '';
    $wcz_pbadge_text = '';
    $wcz_pbadge_belement = '';
    $wcz_pbadge_switch = '';
    
    if ( isset( $_POST['wcz-pbadge-design'] ) ) {
        $wcz_pbadge_design = $_POST['wcz-pbadge-design'];
    }   
    update_post_meta( $post_id, 'wcz-pbadge-design', $wcz_pbadge_design );

    $wcz_pbadge_color = ( isset( $_POST['wcz_pbadge_color'] ) && $_POST['wcz_pbadge_color'] != '' ) ? $_POST['wcz_pbadge_color'] : '';
    update_post_meta( $post_id, 'wcz_pbadge_color', $wcz_pbadge_color );
    
    $wcz_pbadge_font_color = ( isset( $_POST['wcz_pbadge_font_color'] ) && $_POST['wcz_pbadge_font_color'] != '' ) ? $_POST['wcz_pbadge_font_color'] : '';
	update_post_meta( $post_id, 'wcz_pbadge_font_color', $wcz_pbadge_font_color );

    if ( isset( $_POST['wcz-pbadge-text'] ) ) {
        $wcz_pbadge_text = $_POST['wcz-pbadge-text'];
    }
    update_post_meta( $post_id, 'wcz-pbadge-text', $wcz_pbadge_text );

    if ( array_key_exists( 'wcz-pbadge-position', $_POST ) ) {
        update_post_meta( $post_id, 'wcz-pbadge-position', $_POST['wcz-pbadge-position'] );
    }

    if ( isset( $_POST['wcz-pbadge-belement'] ) ) {
        $wcz_pbadge_belement = $_POST['wcz-pbadge-belement'];
    }
    update_post_meta( $post_id, 'wcz-pbadge-belement', $wcz_pbadge_belement );

    if ( array_key_exists( 'wcz-pbadge-horizoffset-pos', $_POST ) && isset( $_POST['wcz-pbadge-horizoffset-no'] ) ) {
        $wcz_pbadge_horizoffset = $_POST['wcz-pbadge-horizoffset-pos'] . '|' . $_POST['wcz-pbadge-horizoffset-no'];
        update_post_meta( $post_id, 'wcz-pbadge-horizoffset', $wcz_pbadge_horizoffset );
    }

    if ( array_key_exists( 'wcz-pbadge-vertoffset-pos', $_POST ) && isset( $_POST['wcz-pbadge-vertoffset-no'] ) ) {
        $wcz_pbadge_vertoffset = $_POST['wcz-pbadge-vertoffset-pos'] . '|' . $_POST['wcz-pbadge-vertoffset-no'];
        update_post_meta( $post_id, 'wcz-pbadge-vertoffset', $wcz_pbadge_vertoffset );
    }

    if ( isset( $_POST['wcz-pbadge-switch'] ) ) {
        $wcz_pbadge_switch = $_POST['wcz-pbadge-switch'];
    }   
    update_post_meta( $post_id, 'wcz-pbadge-switch', $wcz_pbadge_switch );

    if ( isset( $_POST['wcz-upmedia'] ) ) {
        $wcz_uploaded_badge = $_POST['wcz-upmedia'];
    }
    update_post_meta( $post_id, 'wcz-upmedia', $wcz_uploaded_badge );

    if ( isset( $_POST['wcz-pbadge-mwidth'] ) ) {
        $wcz_pbadge_mwidth = $_POST['wcz-pbadge-mwidth'];
    }
    update_post_meta( $post_id, 'wcz-pbadge-mwidth', $wcz_pbadge_mwidth );

}
add_action( 'save_post', 'elation_save_page_settings_metabox', 10, 3 );

/**
 * Product Badgess Settings in Product.
 */
function wcz_add_pb_page_tab( $tabs ) {
 
    $tabs['wcz_pb_tab'] = array(
        'label'    => 'Product Badges',
        'target'   => 'wcz_pb_product_data',
        // 'class'    => array( 'show_if_simple' ),
        // 'priority' => 21,
    );

    return $tabs;
 
}
add_filter( 'woocommerce_product_data_tabs', 'wcz_add_pb_page_tab' );

/*
 * Product Badges Product Tab Settings.
 */
function wcz_pb_product_settings() {
    // Only continue IF Custom Thank You Pages is enabled on WCZ Settings Page
    if ( ! get_option( 'wcz_set_enable_product_badges', woocustomizer_library_get_default( 'wcz_set_enable_product_badges' ) ) )
        return;
 
    echo '<div id="wcz_pb_product_data" class="panel woocommerce_options_panel hidden">';
        
        // Multi-Select Badges Post Type
        $wcz_args = array(
            //'p' => $post,
            'post_type' => 'wcz-badges'
        );
        $wcz_pbquery = new WP_Query( $wcz_args );
        $posts = $wcz_pbquery->posts;

        $wcz_pboptions = array();
        if ( $posts ) :
            foreach( $posts as $post ) :
                $wcz_pboptions['pid-'.$post->ID] = $post->post_title;
            endforeach;
        endif;

        // Select Badges
        woocommerce_wp_select( array(
            'id' => 'wcz_pb_selected_badges',
            'name' => 'wcz_pb_selected_badges[]',
            'label' => __( 'Select Product Badge(s)', 'woocustomizer' ),
            'default' => '',
            'desc_tip' => true,
            'description' => 'Select the badge(s) you want to display on this Product',
            'class' => 'wc-enhanced-select select2',
            'options' => $wcz_pboptions,
            'custom_attributes' => array( 'multiple' => 'multiple' )
        ) );
        // Remove Default Sale Badge
        $product = wc_get_product( get_the_ID() );
        if ( $product->is_on_sale() ) {
            woocommerce_wp_checkbox( array( 
                'id'          => 'wcz_rem_wcsale',
                'label'       => __('Remove Sale Badge', 'woocommerce' ),
                'desc_tip'    => true,
                'description' => __( 'Remove the default WooCommerce Sale Badge from this product', 'woocommerce' )
            ) );
        }

        echo '<div style="border-top: 1px solid rgba(0, 0, 0, 0.08)"><h4 style="margin: 15px 0 10px 12px;">' . __( 'Schedule', 'woocustomizer' ) . '</h4>';

        // Start Date
        woocommerce_wp_text_input( array(
            'id'          => 'wcz_pb_start_date',
            'value'       => get_post_meta( get_the_ID(), 'wcz_pb_start_date', true ) ? get_post_meta( get_the_ID(), 'wcz_pb_start_date', true ) : 0,
            'type'        => 'date',
            'label'       => __( 'Start Date', 'woocustomizer' ),
            'desc_tip'    => false,
            'class' => 'short hasDatepicker',
            'placeholder' => 'From... MM-DD-YYYY'
            // 'description' => __( 'Select the start date of when you want the badge to show', 'woocustomizer' ),
        ) );

        // End Date
        woocommerce_wp_text_input( array(
            'id'          => 'wcz_pb_end_date',
            'value'       => get_post_meta( get_the_ID(), 'wcz_pb_end_date', true ) ? get_post_meta( get_the_ID(), 'wcz_pb_end_date', true ) : 0,
            'type'        => 'date',
            'label'       => __( 'End Date', 'woocustomizer' ),
            'desc_tip'    => false,
            'class' => 'short hasDatepicker',
            'placeholder' => 'To... MM-DD-YYYY'
            // 'description' => __( 'Select the end date of when you want the badge to stop showing', 'woocustomizer' ),
        ) );

    echo '</div></div>';

}
add_action( 'woocommerce_product_data_panels', 'wcz_pb_product_settings' );

/*
 * Save Product Tab Settings.
 */
function wcz_pb_save_data( $id, $post ) {
    // Selected badges
    update_post_meta( $id, 'wcz_pb_selected_badges', $_POST['wcz_pb_selected_badges'] );

    // Checkbox Option
	// $wcz_rempb_shop = isset( $_POST['wcz_rem_pb_shop'] ) ? 'yes' : '';
    // update_post_meta( $id, 'wcz_rem_pb_shop', $wcz_rempb_shop );
    
    // Add badge to pages
	update_post_meta( $id, 'wcz_pb_shop_addat', $_POST['wcz_pb_shop_addat'] );
	update_post_meta( $id, 'wcz_pb_product_addat', $_POST['wcz_pb_product_addat'] );

    // Schedule dates
    update_post_meta( $id, 'wcz_pb_start_date', $_POST['wcz_pb_start_date'] );
    update_post_meta( $id, 'wcz_pb_end_date', $_POST['wcz_pb_end_date'] );
}
add_action( 'woocommerce_process_product_meta', 'wcz_pb_save_data', 10, 2 );

/*
 * Add Product Badges to the WooCommmerce Products.
 */
function wcz_add_product_badges() {
    global $product;

    $wcz_badges = get_post_meta( get_the_ID(), 'wcz_pb_selected_badges', true );

    // Check & Get Product Sale discount in % or amount
    $discount_percent = '';
    $discount_amount = '';
    if ( $product->is_on_sale() ) {
        if ( $product->is_type( 'simple' ) ) {
            $discount_percent = ( ( $product->get_regular_price() - $product->get_sale_price() ) / $product->get_regular_price() ) * 100;
            $discount_amount = $product->get_regular_price() - $product->get_sale_price();
        } elseif ( $product->is_type( 'variable' ) ) {
            $percentage = '';
            $discount_percent = 0;
            $amount = '';
            $discount_amount = 0;

            foreach ( $product->get_children() as $child_id ) {
                $variation = wc_get_product( $child_id );
                $price = $variation->get_regular_price();
                $sale = $variation->get_sale_price();

                if ( $price != 0 && ! empty( $sale ) ) {
                    $percentage = ( $price - $sale ) / $price * 100;
                    $amount = $price - $sale;
                }

                if ( $percentage > $discount_percent ) {
                    $discount_percent = $percentage;
                }
                if ( $amount > $discount_amount ) {
                    $discount_amount = $amount;
                }
            }
        }
        // if ( $discount_percent > 0 ) echo "<div class='sale-perc'>-" . round( $discount_percent ) . "%</div>";
        // if ( $discount_amount > 0 ) echo "<div class='sale-doll'>-$" . round( $discount_amount ) . "</div>";
    }

    if ( $wcz_badges ) {
        foreach ( $wcz_badges as $wcz_badge ) {
            $badgeid = substr( $wcz_badge, 4 );

            if ( !get_post_status( $badgeid ) ) return;

            $wcz_pbadge_design = get_post_meta( $badgeid, 'wcz-pbadge-design', true );
            $wcz_pbadge_position = get_post_meta( $badgeid, 'wcz-pbadge-position', true );
            $wcz_pbadge_belement = get_post_meta( $badgeid, 'wcz-pbadge-belement', true );
            $wcz_pbadge_color = get_post_meta( $badgeid, 'wcz_pbadge_color', true );
            $wcz_pbadge_font_color = get_post_meta( $badgeid, 'wcz_pbadge_font_color', true );
            
            $wcz_pbadge_text = get_post_meta( $badgeid, 'wcz-pbadge-text', true );
            $wcz_pbadge_text2 = str_replace( '[percent]', $discount_percent . '%', $wcz_pbadge_text );
            $wcz_pbadge_text3 = str_replace( '[amount]', get_woocommerce_currency_symbol() . $discount_amount, $wcz_pbadge_text2 );
            
            $wcz_pbadge_horizoffset = get_post_meta( $badgeid, 'wcz-pbadge-horizoffset', true ) ? get_post_meta( $badgeid, 'wcz-pbadge-horizoffset', true ) : 'right|0';
            $wcz_pbadge_horizoffset_arr = explode( '|', $wcz_pbadge_horizoffset );
            
            $wcz_pbadge_vertoffset = get_post_meta( $badgeid, 'wcz-pbadge-vertoffset', true ) ? get_post_meta( $badgeid, 'wcz-pbadge-vertoffset', true ) : 'top|0';
            $wcz_pbadge_vertoffset_arr = explode( '|', $wcz_pbadge_vertoffset );

            $wcz_pbadge_switch = get_post_meta( $badgeid, 'wcz-pbadge-switch', true );
            
            $wcz_uploaded_badge = get_post_meta( $badgeid, 'wcz-upmedia', true );
            $img = wp_get_attachment_image_src( $wcz_uploaded_badge, 'full' );
            $wcz_pbadge_mwidth = get_post_meta( $badgeid, 'wcz-pbadge-mwidth', true );

            ob_start(); ?>
                <div class="wcz-pbadge badge-<?php echo sanitize_html_class( $badgeid ); ?> <?php echo sanitize_html_class( $wcz_pbadge_position ); ?> <?php echo 'true' == $wcz_pbadge_switch ? sanitize_html_class( 'switch' ) : ''; ?>" data-posval="<?php echo esc_attr( $wcz_pbadge_position ); ?>" data-belement="<?php echo esc_attr( $wcz_pbadge_belement ); ?>">
                    <?php if ( 'custom' == $wcz_pbadge_design ) : ?>
                        <div class="wcz-pbadge-in" data-badge="<?php echo esc_attr( $wcz_pbadge_design ); ?>" style="max-width: <?php echo esc_attr( $wcz_pbadge_mwidth ); ?>px; <?php echo esc_attr( $wcz_pbadge_horizoffset_arr[0] ); ?>: <?php echo esc_attr( $wcz_pbadge_horizoffset_arr[1] ); ?>px; <?php echo esc_attr( $wcz_pbadge_vertoffset_arr[0] ); ?>: <?php echo esc_attr( $wcz_pbadge_vertoffset_arr[1] ); ?>px;">
                            <img src="<?php echo esc_url( $img[0] ); ?>" alt="<?php echo esc_attr( $wcz_pbadge_text2 ); ?>"  />
                        </div>
                    <?php else : ?>
                    <div class="wcz-pbadge-in" data-badge="<?php echo esc_attr( $wcz_pbadge_design ); ?>" style="<?php echo esc_attr( $wcz_pbadge_horizoffset_arr[0] ); ?>: <?php echo esc_attr( $wcz_pbadge_horizoffset_arr[1] ); ?>px; <?php echo esc_attr( $wcz_pbadge_vertoffset_arr[0] ); ?>: <?php echo esc_attr( $wcz_pbadge_vertoffset_arr[1] ); ?>px;">
                        <?php wcz_get_badge( $wcz_pbadge_design, $wcz_pbadge_text3 ); ?>
                    </div>
                    <?php endif; ?>
                </div><?php
            echo ob_get_clean();
        }
    }
}
add_action( 'woocommerce_before_shop_loop_item_title', 'wcz_add_product_badges' );
add_action( 'woocommerce_single_product_summary', 'wcz_add_product_badges' );

function wcz_get_badge( $wcz_pbadge_design, $wcz_pbadge_text ) {
    switch ( $wcz_pbadge_design ) {
        case 'two': ?>
            <div class="wczbadge bcbc1 bfc2 two"><div class="wczbadge-inner"><span><?php echo esc_html( $wcz_pbadge_text ); ?></span></div></div><?php
            break;
        case 'three': ?>
            <div class="wczbadge bfc2 three"><div class="wczbblk bbrc1 bblc1"></div><div class="wczbadge-inner"><span><?php echo esc_html( $wcz_pbadge_text ); ?></span></div></div><?php
            break;
        case 'four': ?>
            <div class="wczbadge bfc2 bbbc1 four"><div class="wczbadge-inner"><span><?php echo esc_html( $wcz_pbadge_text ); ?></span></div></div><?php
            break;
        case 'five': ?>
            <div class="wczbadge bfc2 bbgc1 five"><div class="wczbadge-inner"><span><?php echo esc_html( $wcz_pbadge_text ); ?></span></div></div><?php
            break;
        case 'six': ?>
            <div class="wczbadge bfc2 bbgc1 six"><div class="wczbadge-inner"><div class="wczbblk bbrc1 bblc1"></div><span><?php echo esc_html( $wcz_pbadge_text ); ?></span><div class="wczablk"></div></div></div><?php
            break;
        case 'seven': ?>
            <div class="wczbadge bfc2 bbtc1 seven"><div class="wczbadge-inner"><span><?php echo esc_html( $wcz_pbadge_text ); ?></span></div></div><?php
            break;
        case 'eight': ?>
            <div class="wczbadge bfc2 bbtc1 eight"><div class="wczbadge-inner"><span><?php echo esc_html( $wcz_pbadge_text ); ?></span></div></div><?php
            break;
        case 'nine': ?>
            <div class="wczbadge bbc1 bfc2 bbgc1 nine"><div class="wczbadge-inner"><span><?php echo esc_html( $wcz_pbadge_text ); ?></span></div></div><?php
            break;
        case 'ten': ?>
            <div class="wczbadge bbc1 bfc2 bbgc1 ten"><div class="wczbadge-inner"><span><?php echo esc_html( $wcz_pbadge_text ); ?></span></div></div><?php
            break;
        case 'eleven': ?>
            <div class="wczbadge eleven"><div class="wczbblk bbgc1"></div><div class="wczbadge-inner"></div><div class="wczablk bbgc1"></div></div><?php
            break;
        case 'twelve': ?>
            <div class="wczbadge bfc2 bbgc1 twelve"><div class="wczbblk bbbc1"></div><div class="wczbadge-inner"><span><?php echo esc_html( $wcz_pbadge_text ); ?></span></div><div class="wczablk bbbc1"></div></div><?php
            break;
        case 'thirteen': ?>
            <div class="wczbadge bfc2 bbgc1 thirteen"><div class="wczbadge-inner"><span><?php echo esc_html( $wcz_pbadge_text ); ?></span></div></div><?php
            break;
        case 'fourteen': ?>
            <div class="wczbadge bfc2 bbgc1 fourteen"><div class="wczbblk bbtc1"></div><div class="wczbadge-inner"><span><?php echo esc_html( $wcz_pbadge_text ); ?></span></div></div><?php
            break;
        case 'fiveteen': ?>
            <div class="wczbadge bfc2 fiveteen"><div class="wczbadge-inner bbgc1"><span><?php echo esc_html( $wcz_pbadge_text ); ?></span></div></div><?php
            break;
        case 'sixteen': ?>
            <div class="wczbadge bfc2 sixteen"><div class="wczbblk bbrc1 bblc1"></div><div class="wczbadge-inner bbgc1"><span><?php echo esc_html( $wcz_pbadge_text ); ?></span></div><div class="wczablk bbrc1 bblc1"></div></div><?php
            break;
        case 'seventeen': ?>
            <div class="wczbadge bbrc1 bblc1 seventeen"><div class="wczbadge-inner"></div><div class="wczablk bbtc1 bbbc1"></div></div><?php
            break;
        case 'eightteen': ?>
            <div class="wczbadge bfc2 eightteen"><div class="wczbblk bbbc1"></div><div class="wczbadge-inner"><span><?php echo esc_html( $wcz_pbadge_text ); ?></span></div><div class="wczablk bbtc1"></div></div><?php
            break;
        default: ?>
            <div class="wczbadge bfc2 bbgc1 one"><div class="wczbadge-inner"><span><?php echo esc_html( $wcz_pbadge_text ); ?></span></div></div><?php
    }
}

/*
 * Add Product Badges CSS to footer.
 */
function wcz_product_badges_css() {
    // Get all product IDs
    $products = wc_get_products( array(
        'limit' => -1,
        'status' => 'publish',
        'return' => 'ids',
    ) );
    
    $wcz_badge_css = '';
    foreach( $products as $product ) {
        // Get Badge IDs from Products
        $pbadges = get_post_meta( $product, 'wcz_pb_selected_badges', true );

        if ( $pbadges ) {
            foreach( $pbadges as $badge ) {
                $badge_id = substr( $badge, 4 );
                $wcz_pbadge_bcolor = get_post_meta( $badge_id, 'wcz_pbadge_color', true );
                $wcz_pbadge_fcolor = get_post_meta( $badge_id, 'wcz_pbadge_font_color', true );

                if ( $wcz_pbadge_bcolor ) {
                    $wcz_badge_css .= '.wcz-pbadge.badge-' . esc_attr( $badge_id ) . ' .bbgc1 { background-color: ' . esc_attr( $wcz_pbadge_bcolor ) . ' !important; }
                    .wcz-pbadge.badge-' . esc_attr( $badge_id ) . ' .bbc1 { box-shadow: 0 0 0 1px ' . esc_attr( $wcz_pbadge_bcolor ) . ' !important; }
                    .wcz-pbadge.badge-' . esc_attr( $badge_id ) . ' .bblc1 { border-left-color: ' . esc_attr( $wcz_pbadge_bcolor ) . ' !important; }
                    .wcz-pbadge.badge-' . esc_attr( $badge_id ) . ' .bbrc1 { border-right-color: ' . esc_attr( $wcz_pbadge_bcolor ) . ' !important; }
                    .wcz-pbadge.badge-' . esc_attr( $badge_id ) . ' .bbtc1 { border-top-color: ' . esc_attr( $wcz_pbadge_bcolor ) . ' !important; }
                    .wcz-pbadge.badge-' . esc_attr( $badge_id ) . ' .bbbc1 { border-bottom-color: ' . esc_attr( $wcz_pbadge_bcolor ) . ' !important; }
                    .wcz-pbadge.badge-' . esc_attr( $badge_id ) . ' .bcbc1 { border-color: ' . esc_attr( $wcz_pbadge_bcolor ) . ' !important; color: ' . esc_attr( $wcz_pbadge_bcolor ) . ' !important; }';
                }
                if ( $wcz_pbadge_fcolor ) {
                    $wcz_badge_css .= '.wcz-pbadge.badge-' . esc_attr( $badge_id ) . ' .bfc2 {
                        color: ' . esc_attr( $wcz_pbadge_fcolor ) . ' !important;
                    }';
                }
            }
        }
    }

    if ( ( is_shop() || is_product_category() || is_product_tag() || is_product() ) && !empty( $wcz_badge_css ) ) {
        wp_register_style( 'wcz-pbadges', false );
        wp_enqueue_style( 'wcz-pbadges' );
        wp_add_inline_style( 'wcz-pbadges', $wcz_badge_css );
    }

}
add_action( 'wp_footer', 'wcz_product_badges_css' );

/*
 * Add Custom Admin Columns for Product Badges.
 */
function wcz_add_badge_preview_column( $columns ) {
    $columns = array(
        'cb' => $columns['cb'],
        'title' => __( 'Title', 'woocustomizer' ),
        'wcz-badge-col' => __( 'Badge Preview', 'woocustomizer' ),
        'date' => __( 'Date', 'woocustomizer' ),
      );
    return $columns;
}
add_filter( 'manage_wcz-badges_posts_columns', 'wcz_add_badge_preview_column' );

/*
 * Build Custom Column Content.
 */
function wcz_display_column_badge( $column, $post_id ) {
    switch ( $column ) {
        case 'wcz-badge-col' :
            $wcz_pbadge_design = get_post_meta( get_the_ID(), 'wcz-pbadge-design', true );
            $wcz_pbadge_switch = get_post_meta( get_the_ID(), 'wcz-pbadge-switch', true );

            $wcz_pbadge_text = get_post_meta( get_the_ID(), 'wcz-pbadge-text', true );
            $wcz_pbadge_text2 = str_replace( '[percent]', '#%', $wcz_pbadge_text );
            $wcz_pbadge_text3 = str_replace( '[amount]', get_woocommerce_currency_symbol().'#', $wcz_pbadge_text2 );
            
            $wcz_pbadge_bcolor = get_post_meta( get_the_ID(), 'wcz_pbadge_color', true );
            $wcz_pbadge_fcolor = get_post_meta( get_the_ID(), 'wcz_pbadge_font_color', true ); ?>
            <div class="wcz-badge-col-inner wcz-pbadge badge-<?php echo get_the_ID(); ?> <?php echo 'true' == $wcz_pbadge_switch ? sanitize_html_class( 'switch' ) : ''; ?>">
                <?php
                if ( 'custom' == $wcz_pbadge_design ) {
                    $wcz_uploaded_badge = get_post_meta( get_the_ID(), 'wcz-upmedia', true );
                    $img = wp_get_attachment_image_src( $wcz_uploaded_badge, 'full' );
                    if ( $img[0] ) {
                        echo '<img src="' . esc_url( $img[0] ) . '" />';
                    } else {
                        echo '<span class="dashicons dashicons-format-image"></span>';
                    }
                } else {
                    wcz_get_badge( $wcz_pbadge_design, $wcz_pbadge_text3 );
                } ?>
            </div>
            <?php
            $wcz_adbadge_css = '';
            if ( $wcz_pbadge_bcolor ) {
                $wcz_adbadge_css .= '.wcz-badge-col-inner.badge-' . esc_attr( get_the_ID() ) . ' .bbgc1 { background-color: ' . esc_attr( $wcz_pbadge_bcolor ) . ' !important; }
                .wcz-badge-col-inner.badge-' . esc_attr( get_the_ID() ) . ' .bbc1 { box-shadow: 0 0 0 1px ' . esc_attr( $wcz_pbadge_bcolor ) . ' !important; }
                .wcz-badge-col-inner.badge-' . esc_attr( get_the_ID() ) . ' .bblc1 { border-left-color: ' . esc_attr( $wcz_pbadge_bcolor ) . ' !important; }
                .wcz-badge-col-inner.badge-' . esc_attr( get_the_ID() ) . ' .bbrc1 { border-right-color: ' . esc_attr( $wcz_pbadge_bcolor ) . ' !important; }
                .wcz-badge-col-inner.badge-' . esc_attr( get_the_ID() ) . ' .bbtc1 { border-top-color: ' . esc_attr( $wcz_pbadge_bcolor ) . ' !important; }
                .wcz-badge-col-inner.badge-' . esc_attr( get_the_ID() ) . ' .bbbc1 { border-bottom-color: ' . esc_attr( $wcz_pbadge_bcolor ) . ' !important; }
                .wcz-badge-col-inner.badge-' . esc_attr( get_the_ID() ) . ' .bcbc1 { border-color: ' . esc_attr( $wcz_pbadge_bcolor ) . ' !important; color: ' . esc_attr( $wcz_pbadge_bcolor ) . ' !important; }';
            }
            if ( $wcz_pbadge_fcolor ) {
                $wcz_adbadge_css .= '.wcz-badge-col-inner.badge-' . esc_attr( get_the_ID() ) . ' .bfc2 { color: ' . esc_attr( $wcz_pbadge_fcolor ) . ' !important; }';
            }

            wp_register_style( 'wcz-adpbadges-' . get_the_ID() , false );
            wp_enqueue_style( 'wcz-adpbadges-' . get_the_ID() );
            wp_add_inline_style( 'wcz-adpbadges-' . get_the_ID(), $wcz_adbadge_css );
            break;
    }
}
add_action( 'manage_wcz-badges_posts_custom_column' , 'wcz_display_column_badge', 10, 2 );
