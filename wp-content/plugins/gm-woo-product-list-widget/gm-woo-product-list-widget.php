<?php
/**
 * Plugin Name: GM Woo Product list Widget
 * Description: GM Woo Product list Widget to show product list in widget with verious option
 * Version:     1.0
 * Author:      Gravity Master
 * License:     GPLv2 or later
 * Text Domain: gmwplw
 */

/* Stop immediately if accessed directly. */
if ( ! defined( 'ABSPATH' ) ) {
	die();
}

/* All constants should be defined in this file. */
if ( ! defined( 'GMWPLW_PREFIX' ) ) {
	define( 'GMWPLW_PREFIX', 'gmwplw' );
}
if ( ! defined( 'GMWPLW_PLUGIN_DIR' ) ) {
	define( 'GMWPLW_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
}
if ( ! defined( 'GMWPLW_PLUGIN_BASENAME' ) ) {
	define( 'GMWPLW_PLUGIN_BASENAME', plugin_basename( __FILE__ ) );
}
if ( ! defined( 'GMWPLW_PLUGIN_URL' ) ) {
	define( 'GMWPLW_PLUGIN_URL', plugin_dir_url( __FILE__ ) );
}

/* Auto-load all the necessary classes. */
if( ! function_exists( 'gmwplw_class_auto_loader' ) ) {
	
	function gmwplw_class_auto_loader( $class ) {
		
		$includes = GMWPLW_PLUGIN_DIR . 'includes/' . $class . '.php';
		
		if( is_file( $includes ) && ! class_exists( $class ) ) {
			include_once( $includes );
			return;
		}
		
	}
}
spl_autoload_register('gmwplw_class_auto_loader');

/* Initialize all modules now. */
new GMWPLW_Admin();
include(GMWPLW_PLUGIN_DIR . 'includes/GMWPLW_Widget.php');

add_action( 'wp_enqueue_scripts',  'gmwplw_insta_scritps'  );
function gmwplw_insta_scritps () {
		wp_enqueue_style('gmwqp-style', GMWPLW_PLUGIN_URL . '/css/style.css', array(), '1.0.0', 'all');
	}
?>