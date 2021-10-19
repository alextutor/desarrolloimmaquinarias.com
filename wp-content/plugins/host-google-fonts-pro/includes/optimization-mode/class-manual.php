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
class OmgfPro_OptimizationMode_Manual
{
    /** @var string */
    private $plugin_text_domain = 'omgf-pro';

    /** @var string $home_url */
    private $home_url = '';

    /** @var string $handle */
    private $handle = 'pro-merged';

    /** @var OmgfPro_HtmlParser $parser */
    private $parser;

    /**
     * Build class
     * 
     * @return void 
     */
    public function __construct()
    {
        $this->parser   = new OmgfPro_HtmlParser();
        $this->home_url = esc_url_raw(OMGF_MANUAL_OPTIMIZE_URL);

        $this->init();
    }

    /**
     * Initialize methods
     * 
     * @return void 
     */
    private function init()
    {
        $this->run();
    }

    /**
     * @return void 
     */
    private function run()
    {
        $response = $this->parser->remote_get($this->home_url);
        $html     = '';

        if (!is_wp_error($response) && wp_remote_retrieve_response_code($response) == 200) {
            $html = wp_remote_retrieve_body($response);
        }

        if (!$html) {
            OmgfPro_Admin_Notice::set_pro_notice(
                sprintf(
                    __('OMGF Pro failed to fetch %s. Is your site\'s frontend publically accessible?', $this->plugin_text_domain),
                    $this->home_url
                )
            );

            return;
        }

        $this->parser->get_document($html);
        $this->parser->capture_all();

        $google_fonts = $this->parser->capture_google_fonts();

        if (empty($google_fonts)) {
            OmgfPro_Admin_Notice::set_pro_notice(
                sprintf(
                    __('No Google Fonts found on %s. Try a different URL?', $this->plugin_text_domain),
                    $this->home_url
                )
            );

            return;
        }

        $merged_url     = $this->parser->merge($google_fonts);
        $updated_handle = $this->handle;

        if ((omgf_init()::unloaded_fonts() && $cache_key = omgf_init()::get_cache_key($this->handle))
            || (OMGF_PRO_FALLBACK_FONT_STACK && $cache_key = omgf_init()::get_cache_key($this->handle))
        ) {
            $updated_handle = $cache_key;
        }

        $request_url = $this->parser->build_request_url($merged_url, $updated_handle, $this->handle);

        if (!$request_url) {
            OmgfPro_Admin_Notice::set_pro_notice(
                __('Something went wrong while building the request for OMGF\'s Download API.', $this->plugin_text_domain)
            );
        }

        $parsed_url = parse_url($request_url);
        $request    = new WP_REST_Request('GET', $parsed_url['path']);

        parse_str($parsed_url['query'], $query_params);

        $request->set_query_params($query_params);

        // TODO: Find out proper WP way to add this param to request.
        $_REQUEST['_wpnonce'] = wp_create_nonce('wp_rest');

        rest_do_request($request);
    }
}
