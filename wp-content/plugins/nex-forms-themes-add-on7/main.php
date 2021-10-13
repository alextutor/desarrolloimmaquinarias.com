<?php
/*
Plugin Name: NEX-Forms ADD ON - Form Themes
Plugin URI: http://codecanyon.net/item/nexforms-the-ultimate-wordpress-form-builder/7103891?ref=Basix
Description: Enables single click overall color scheme change to your form to adapt to your theme instantly. Includes 25 preset Bootstrap Themes and 19 preset Google Materail Design Themes. <strong>Requires at least: <a href="https://codecanyon.net/item/nexforms-the-ultimate-wordpress-form-builder/7103891?ref=Basix" target="_blank" style="display:block">NEX-Forms v7.5.x</a></strong>
Author: Basix
Version: 7.5.13
Author URI: http://codecanyon.net/user/Basix/portfolio?ref=Basix
License: GPL
*/

function enqueue_nf_form_themes_scripts($hook) {
wp_enqueue_script('jquery');
wp_enqueue_script('nex-forms-themes-add-on', plugins_url( '/js/themes.js',__FILE__));
}


function nf_form_themes_prefix_register_resources(){

wp_register_style('nex-forms-jq-ui-theme-black-tie', plugins_url( '/css/black-tie/jquery.ui.theme.css',__FILE__));
wp_register_style('nex-forms-jq-ui-theme-blitzer', plugins_url( '/css/blitzer/jquery.ui.theme.css',__FILE__));
wp_register_style('nex-forms-jq-ui-theme-cupertino', plugins_url( '/css/cupertino/jquery.ui.theme.css',__FILE__));
wp_register_style('nex-forms-jq-ui-theme-dark-hive', plugins_url( '/css/dark-hive/jquery.ui.theme.css',__FILE__));
wp_register_style('nex-forms-jq-ui-theme-default', plugins_url( '/css/default/jquery.ui.theme.css',__FILE__));
wp_register_style('nex-forms-jq-ui-theme-dot-luv', plugins_url( '/css/dot-luv/jquery.ui.theme.css',__FILE__));
wp_register_style('nex-forms-jq-ui-theme-eggplant', plugins_url( '/css/eggplant/jquery.ui.theme.css',__FILE__));
wp_register_style('nex-forms-jq-ui-theme-excite-bike', plugins_url( '/css/excite-bike/jquery.ui.theme.css',__FILE__));
wp_register_style('nex-forms-jq-ui-theme-flick', plugins_url( '/css/flick/jquery.ui.theme.css',__FILE__));
wp_register_style('nex-forms-jq-ui-theme-hot-sneaks', plugins_url( '/css/hot-sneaks/jquery.ui.theme.css',__FILE__));
wp_register_style('nex-forms-jq-ui-theme-humanity', plugins_url( '/css/humanity/jquery.ui.theme.css',__FILE__));
wp_register_style('nex-forms-jq-ui-theme-le-frog', plugins_url( '/css/le-frog/jquery.ui.theme.css',__FILE__));
wp_register_style('nex-forms-jq-ui-theme-mint-choc', plugins_url( '/css/mint-choc/jquery.ui.theme.css',__FILE__));
wp_register_style('nex-forms-jq-ui-theme-overcast', plugins_url( '/css/overcast/jquery.ui.theme.css',__FILE__));
wp_register_style('nex-forms-jq-ui-theme-pepper-grinder', plugins_url( '/css/pepper-grinder/jquery.ui.theme.css',__FILE__));
wp_register_style('nex-forms-jq-ui-theme-redmond', plugins_url( '/css/redmond/jquery.ui.theme.css',__FILE__));
wp_register_style('nex-forms-jq-ui-theme-smoothness', plugins_url( '/css/smoothness/jquery.ui.theme.css',__FILE__));
wp_register_style('nex-forms-jq-ui-theme-south-street', plugins_url( '/css/south-street/jquery.ui.theme.css',__FILE__));
wp_register_style('nex-forms-jq-ui-theme-start', plugins_url( '/css/start/jquery.ui.theme.css',__FILE__));
wp_register_style('nex-forms-jq-ui-theme-sunny', plugins_url( '/css/sunny/jquery.ui.theme.css',__FILE__));
wp_register_style('nex-forms-jq-ui-theme-swanky-purse', plugins_url( '/css/swanky-purse/jquery.ui.theme.css',__FILE__));
wp_register_style('nex-forms-jq-ui-theme-trontastic', plugins_url( '/css/trontastic/jquery.ui.theme.css',__FILE__));
wp_register_style('nex-forms-jq-ui-theme-ui-darkness', plugins_url( '/css/ui-darkness/jquery.ui.theme.css',__FILE__));
wp_register_style('nex-forms-jq-ui-theme-ui-lightness', plugins_url( '/css/ui-lightness/jquery.ui.theme.css',__FILE__));
wp_register_style('nex-forms-jq-ui-theme-vader', plugins_url( '/css/vader/jquery.ui.theme.css',__FILE__));
}
add_action( 'init', 'nf_form_themes_prefix_register_resources');
add_action( 'admin_enqueue_scripts', 'enqueue_nf_form_themes_scripts');


function nf_not_found_notice_ft() {
    
		if(!function_exists('NEXForms_ui_output'))
			{
			?>
			<div class="error notice">
				<p><?php _e( '<strong>NEX-Forms not installed!</strong> You just installed <strong>Form Themes Add-on for NEX-Forms</strong>. You need the NEX-Forms core plugin to run this add-on! Please get and install <a href="https://codecanyon.net/item/nexforms-the-ultimate-wordpress-form-builder/7103891?ref=Basix&ad=ft">NEX-Forms - The Ultimate WordPress Form Builder</a>  OR <a href="https://elements.envato.com/wordpress/nex-forms+lite">NEX-Forms - LITE from Envato Elements</a> to enable the features of this add-on.', 'my_plugin_textdomain' ); ?></p>
			</div>
			<?php
			}
		
}
add_action( 'admin_notices', 'nf_not_found_notice_ft' );