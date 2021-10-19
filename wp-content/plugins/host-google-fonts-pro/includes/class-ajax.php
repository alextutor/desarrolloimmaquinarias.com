<?php
defined('ABSPATH') || exit;

/**
 * @package   OMGF Pro
 * @author    Daan van den Bergh
 *            https://ffw.press
 *            https://daan.dev
 * @copyright © 2021 Daan van den Bergh
 * @license   BY-NC-ND-4.0
 *            http://creativecommons.org/licenses/by-nc-nd/4.0/
 */

class OmgfPro_Ajax
{
    private $plugin_text_domain = 'omgf-pro';

    /**
     * Build class.
     * 
     * @return void 
     */
    public function __construct()
    {
        $this->init();
    }

    /**
     * Init hooks and filters.
     * 
     * @return void 
     */
    private function init()
    {
        add_action('wp_ajax_omgf_ajax_empty_dir', [$this, 'clear_stored_handles']);
        add_action('wp_ajax_omgf_pro_run_cron', [$this, 'run_cron']);
    }

    /**
     * Clear all stored handles if OMGF is in Automatic mode.
     * 
     * @return void 
     */
    public function clear_stored_handles()
    {
        check_ajax_referer(OMGF_Admin_Settings::OMGF_ADMIN_PAGE, 'nonce');

        if (!current_user_can('manage_options')) {
            wp_die(__("Sorry, you're not allowed to do this.", $this->plugin_text_domain));
        }

        OmgfPro_Admin::clear_cache_handles();
    }

    /**
     * Triggers the cron action, forcing it to run.
     * 
     * @return void 
     */
    public function run_cron()
    {
        check_ajax_referer(OMGF_Admin_Settings::OMGF_ADMIN_PAGE, 'nonce');

        if (!current_user_can('manage_options')) {
            wp_die(__("Sorry, you're not allowed to do this.", $this->plugin_text_domain));
        }

        do_action(OmgfPro_Cron::HOOK);
    }
}
