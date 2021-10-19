<?php

/**
 * @package   FFW.Press License Manager
 * @author    Daan van den Bergh
 *            https://ffw.press
 *            https://daan.dev
 * @copyright © 2021 Daan van den Bergh. All Rights Reserved.
 */

defined('ABSPATH') || exit;

class FFWPLM
{
    const FFW_PRESS_URL_API               = 'https://ffw.press';
    const FFW_PRESS_URL_WORDPRESS_PLUGINS = 'https://ffw.press/wordpress-plugins';
    const FFW_PRESS_URL_LICENSE_KEYS      = 'https://ffw.press/account/license-keys/';
    const FFW_PRESS_URL_RENEW_LICENSE     = 'https://ffw.press/checkout/?nocache=true&download_id=%s&edd_license_key=%s';
    const FFW_PRESS_URL_CONTACT           = 'https://ffw.press/contact';
    const FFWP_ENCRYPTION_METHOD          = 'AES-128-CTR';

    /**
     * FFWPLM constructor.
     */
    public function __construct()
    {
        if (!is_admin()) {
            return;
        }

        add_action('admin_init', [$this, 'do_updater']);

        $this->init();
    }

    /**
     * Initiate FFW.Press License Manager
     */
    private function init()
    {
        $this->generate_cypher();

        $db = get_option(FFWPLM_Admin::FFWP_LICENSE_MANAGER_OPTION_DB_VERSION);

        if (version_compare($db, FFWP_LICENSE_MANAGER_DB_VERSION) < 0) {
            $this->do_db_migration();
        }

        $this->do_admin();
        $this->do_ajax();
    }

    /**
     * 
     * 
     * @return array
     */
    public static function valid_licenses()
    {
        static $valid_licenses = [];

        if (empty($valid_licenses)) {
            $valid_licenses = get_option(FFWPLM_Admin::FFWP_LICENSE_MANAGER_OPTION_VALID_LICENSES, []) ?: [];
        }

        return $valid_licenses;
    }

    /**
     * Encrypt key for storage.
     * 
     * @param mixed $key 
     * @return string|false 
     */
    public static function encrypt($key)
    {
        return openssl_encrypt($key, FFWPLM::FFWP_ENCRYPTION_METHOD, AUTH_SALT, 0, FFWPLM_CYPHER);
    }

    /**
     * Decrypt key for processing.
     * 
     * @param mixed $key 
     * @return string|false 
     */
    public static function decrypt($key)
    {
        return openssl_decrypt($key, FFWPLM::FFWP_ENCRYPTION_METHOD, AUTH_SALT, 0, FFWPLM_CYPHER);
    }

    /**
     * @return FFWPLM_DB_Migration 
     */
    private function do_db_migration()
    {
        return new FFWPLM_DB_Migration();
    }

    /**
     * Generates cypher used for encryption.
     */
    private function generate_cypher()
    {
        $cypher = get_option(FFWPLM_Admin::FFWP_LICENSE_MANAGER_OPTION_CYPHER);

        if (!$cypher) {
            $cypher = bin2hex(random_bytes(8));

            update_option(FFWPLM_Admin::FFWP_LICENSE_MANAGER_OPTION_CYPHER, $cypher);
        }

        define('FFWPLM_CYPHER', $cypher);
    }

    /**
     * @return FFWPLM_Admin
     */
    private function do_admin()
    {
        return new FFWPLM_Admin();
    }

    /**
     * @return FFWPLM_Admin_AJAX 
     */
    private function do_ajax()
    {
        return new FFWPLM_Admin_AJAX;
    }

    /**
     * Check for updates for all installed plugins, incl. this (free) plugin.
     */
    public function do_updater()
    {
        foreach (self::valid_licenses() as $id => $license_data) {
            if ($license_data['license_status'] !== 'valid') {
                continue;
            }

            if (!file_exists($license_data['plugin_file'])) {
                continue;
            }

            $plugin_data = get_plugin_data($license_data['plugin_file'] ?? '');

            if (!$plugin_data['Version']) {
                continue;
            }

            new FFWPLM_Updater(
                FFWP_LICENSE_MANAGER_API_URL,
                $license_data['plugin_file'],
                [
                    'license'   => self::decrypt($license_data['license']),
                    'item_id'   => $id,
                    'version'   => $plugin_data['Version'],
                    'author'    => $plugin_data['AuthorName'] ?? 'Daan van den Bergh',
                    'url'       => home_url(),
                    'beta'      => false
                ]
            );
        }
    }
}
