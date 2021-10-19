<?php

/**
 * @package   FFW.Press License Manager
 * @author    Daan van den Bergh
 *            https://ffw.press
 *            https://daan.dev
 * @copyright © 2021 Daan van den Bergh. All Rights Reserved.
 */

defined('ABSPATH') || exit;

class FFWPLM_Admin_AJAX
{
    private $plugin_text_domain = 'ffwp-license-manager';

    public function __construct()
    {
        add_action('wp_ajax_ffwp_license_manager_deactivate', [$this, 'deactivate_license']);
    }

    public function deactivate_license()
    {
        if (!isset($_POST['item_id'])) {
            wp_send_json_error(__('Plugin ID not set.', $this->plugin_text_domain));
        }

        $valid_licenses = FFWPLM::valid_licenses();
        $license_keys   = get_option(FFWPLM_Admin::FFWP_LICENSE_MANAGER_SETTING_LICENSE_KEY);
        $item_id        = sanitize_text_field($_POST['item_id']);
        $key            = sanitize_text_field($_POST['key']);
        $params         = [
            'edd_action' => 'deactivate_license',
            'license'    => FFWPLM::decrypt($key),
            'item_id'    => $item_id,
            'url'        => home_url()
        ];
        $response       = wp_remote_post(
            FFWP_LICENSE_MANAGER_API_URL,
            [
                'timeout'   => 15,
                'sslverify' => false,
                'body'      => $params
            ]
        );

        if (is_wp_error($response) || 200 !== wp_remote_retrieve_response_code($response)) {
            $message = (is_wp_error($response) && !empty($response->get_error_message())) ? $response->get_error_message() : __('An error occurred, please try again.', $this->plugin_text_domain);
            FFWPLM_Admin_Notice::set_notice($message, false, 'error');

            wp_send_json_error();
        }

        $response_body = json_decode(wp_remote_retrieve_body($response));
        $item_name     = $response_body->item_name;

        unset($valid_licenses[$item_id]);
        update_option(FFWPLM_Admin::FFWP_LICENSE_MANAGER_OPTION_VALID_LICENSES, $valid_licenses);

        unset($license_keys[$item_id]);
        /**
         * To prevent double encryption, the 'encrypted' boolean needs to be set.
         */
        foreach ($license_keys as &$existing_key) {
            $existing_key['encrypted'] = true;
        }
        update_option(FFWPLM_Admin::FFWP_LICENSE_MANAGER_SETTING_LICENSE_KEY, $license_keys);

        if (!isset($response_body->success)) {
            FFWPLM_Admin_Notice::set_notice(sprintf(__('License for %s could not be deactivated. Maybe it already is deactivated?', $this->plugin_text_domain), $item_name), false, 'error');

            wp_send_json_error();
        }

        FFWPLM_Admin_Notice::set_notice(sprintf(__('License for %s successfully deactivated.', $this->plugin_text_domain), $item_name), false);

        delete_transient(FFWPLM_Admin::FFWP_LICENSE_MANAGER_NOTICE_COUNT);

        wp_send_json_success();
    }
}
