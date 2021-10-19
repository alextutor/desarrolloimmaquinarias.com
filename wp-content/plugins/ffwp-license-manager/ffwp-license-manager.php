<?php

/**
 * Plugin Name: FFW.Press License Manager
 * Description: License Manager for FFW.Press Premium Plugins.
 * Version: 1.6.1
 * Author: Daan from FFW.Press
 * Author URI: https://ffw.press
 * Text Domain: ffwp-license-manager
 * Github Plugin URI: Dan0sz/ffwp-license-manager
 */

defined('ABSPATH') || exit;

/**
 * Define constants.
 */
define('FFWP_LICENSE_MANAGER_PLUGIN_DIR', plugin_dir_path(__FILE__));
define('FFWP_LICENSE_MANAGER_PLUGIN_FILE', __FILE__);
define('FFWP_LICENSE_MANAGER_PLUGIN_URL', plugin_dir_url(__FILE__));
define('FFWP_LICENSE_MANAGER_STATIC_VERSION', '1.6.0');
define('FFWP_LICENSE_MANAGER_DB_VERSION', '1.6.0');
define('FFWP_LICENSE_MANAGER_API_URL', apply_filters('ffwp_license_manager_api_url', 'https://ffw.press'));

/**
 * Takes care of loading classes on demand.
 *
 * @param $class
 *
 * @return mixed|void
 */
function ffwp_license_manager_autoload($class)
{
    $path = explode('_', $class);

    if ($path[0] != 'FFWPLM') {
        return;
    }

    if (!class_exists('FFWP_Autoloader')) {
        require_once(FFWP_LICENSE_MANAGER_PLUGIN_DIR . 'ffwp-autoload.php');
    }

    $autoload = new FFWP_Autoloader($class);

    return include FFWP_LICENSE_MANAGER_PLUGIN_DIR . 'includes/' . $autoload->load();
}

spl_autoload_register('ffwp_license_manager_autoload');

/**
 * @return FFWPLM
 */
function ffwp_license_manager_init()
{
    static $wlm = null;

    if ($wlm === null) {
        $wlm = new FFWPLM();
    }

    return $wlm;
}

ffwp_license_manager_init();
