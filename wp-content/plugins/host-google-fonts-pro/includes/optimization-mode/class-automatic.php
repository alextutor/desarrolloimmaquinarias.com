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
class OmgfPro_OptimizationMode_Automatic
{
    const TRANSIENT       = 'omgf_pro_optimization_finished';
    const QUEUE           = 'omgf_pro_automatic_mode_queue';
    const QUEUE_PROCESSED = 'processed';
    const QUEUE_TOTAL     = 'total';
    const QUEUE_POSTS     = 'posts';
    const QUEUE_TERMS     = 'terms';

    /** @var string */
    private $plugin_text_domain = 'omgf-pro';

    /** @var OmgfPro_HtmlParser $parser */
    private $parser;

    /** @var int $queue_limit */
    private $queue_limit;

    /** @var array $terms All available terms */
    private $terms = [];

    /**
     * Build class
     * 
     * @return void 
     */
    public function __construct()
    {
        /**
         * If transient is present, there's no need to continue.
         */
        if (get_transient(self::TRANSIENT)) {
            return;
        }

        /**
         * Make sure HtmlParser processes the fetched document, even when 
         * Advanced Processing is 'off'.
         * 
         * @see OmgfPro_HtmlParser()
         */
        add_filter('omgf_pro_get_document', '__return_false');
        add_filter('omgf_pro_advanced_processing_setting_enabled', '__return_true');

        $this->queue_limit = ceil(OMGF_PRO_BATCH_SIZE / 2);
        $this->queue       = $this->get_queue();
        $this->parser      = new OmgfPro_HtmlParser();

        $this->init();
    }

    /**
     * 
     */
    private function get_queue()
    {
        static $queue;

        if ($queue == null) {
            $default = [
                self::QUEUE_PROCESSED => [
                    self::QUEUE_TERMS => 0,
                    self::QUEUE_POSTS => 0,
                ],
                self::QUEUE_TOTAL => [
                    self::QUEUE_TERMS => count($this->query_terms(false, false)),
                    self::QUEUE_POSTS => count($this->query_posts(false, false))
                ]
            ];

            $queue = get_option(self::QUEUE, $default);
        }

        return $queue;
    }

    /**
     * Collect all available archives, e.g. tags, categories, custom term types, etc.
     * 
     * Limit is can be set to not exhaust memory and terms are only collected when the
     * '_omgf_pro_handle' term meta key is not present.
     */
    private function query_terms($set_queue_limit = true, $set_meta_query = true, $compare = 'NOT EXISTS')
    {
        $term_args = [];

        if ($set_queue_limit) {
            $term_args['number'] = $this->queue_limit;
        }

        if ($set_meta_query) {
            $term_args['meta_query'] = [
                [
                    'key'     => OmgfPro::OMGF_PRO_HANDLE_META_KEY,
                    'compare' => $compare
                ]
            ];
        }

        $term_query = new WP_Term_Query($term_args);

        return $term_query->get_terms();
    }

    /**
     * Collect all available posts of any post type, e.g. posts, pages, custom post types, etc.
     * 
     * Limit can be set to not exhaust memory and posts are only collected when the '_omgf_pro_handle'
     * post meta key is not present and the post's status is set to 'publish'.
     */
    private function query_posts($set_queue_limit = true, $set_meta_query = true, $compare = 'NOT EXISTS')
    {
        $post_args['post_status'] = 'publish';

        if ($set_queue_limit) {
            $post_args['number'] = $this->queue_limit;
        }

        $post_args['post_type'] = get_post_types('', 'names') ?? ['post', 'page'];

        if ($set_meta_query) {
            $post_args['meta_query'] = [
                [
                    'key'     => OmgfPro::OMGF_PRO_HANDLE_META_KEY,
                    'compare' => $compare
                ]
            ];
        }

        $post_query = new WP_Query($post_args);

        return $post_query->get_posts();
    }

    /**
     * Initialize methods
     * 
     * @return void 
     */
    private function init()
    {
        if (OMGF_PRO_OPTIMIZATION_MODE !== 'auto') {
            return;
        }

        /**
         * At this point it's safe to assume that Optimizaton Mode is set to Automatic. So make sure Manual doesn't run.
         */
        add_filter('omgf_optimization_mode', function () {
            return OMGF_PRO_OPTIMIZATION_MODE;
        });

        $this->run();
    }

    /**
     * @return void 
     */
    private function run()
    {
        $terms       = $this->query_terms();
        $terms_count = count($terms);
        $urls        = [];

        foreach ($terms as $term) {
            $urls[$term->taxonomy][$term->term_id] = @get_term_link($term, $term->taxonomy);
        }

        /**
         * Save all found terms.
         */
        $this->terms = array_keys($urls);

        $posts       = $this->query_posts();
        $posts_count = count($posts);

        foreach ($posts as $post) {
            $urls[$post->post_type][$post->ID] = get_permalink($post);
        }

        /**
         * Queries returned zero results. Assume all posts/pages/archives are processed. No need to continue. Throw notice and bail!
         */
        if ($terms_count == 0 && $posts_count == 0) {
            OmgfPro_Admin_Notice::set_pro_notice(
                __('<strong>OMGF Pro has finished processing your homepage, all posts, pages and archives! All Google Fonts are now optimized; YAY!</strong>', $this->plugin_text_domain),
                'success',
                'omgf-pro-automatic-optimization-status',
                'all',
                300
            );

            OmgfPro_Admin_Notice::set_pro_notice(
                __('<strong>Flush Cache</strong> of any <strong>Page Cache</strong> (e.g. WP Super Cache, LS Cache, etc.) or <strong>CSS Optimization</strong> (e.g. Autoptimize) <strong>Plugins</strong> you might be using to properly display the optimizations in your site\'s frontend.', $this->plugin_text_domain),
                'info',
                'omgf-pro-automatic-optimization-hint'
            );

            /**
             * TODO: Maybe flush transient upon page/post publish and/or theme options change?
             */
            set_transient(self::TRANSIENT, true, WEEK_IN_SECONDS);

            return;
        }

        /**
         * Always update homepages, because that's where users will look first.
         */
        $urls['home'][get_current_blog_id()] = get_option('siteurl');

        if (is_multisite()) {
            $urls['home'][get_current_blog_id()] = get_blog_option(get_current_blog_id(), 'siteurl', 1);
        }

        /**
         * Start processing all collected URLs.
         * 
         * @since v3.0.0 Update handle with empty value when requests fail to indicate it's already processed.
         */
        foreach ($urls as $post_type => $ids) {
            foreach ($ids as $id => $url) {
                $response = $this->parser->remote_get($url);
                $html     = '';

                if (!is_wp_error($response) && wp_remote_retrieve_response_code($response) == 200) {
                    $html = wp_remote_retrieve_body($response);
                }

                if (!$html) {
                    $this->update_handle('', $post_type, $id);

                    continue;
                }

                $this->parse($html);

                $api_url = $this->prepare_api_url($post_type, $id);

                if (!$api_url) {
                    $this->update_handle('', $post_type, $id);

                    continue;
                }

                $api_params = parse_url($api_url);
                $request    = new WP_REST_Request('GET', $api_params['path']);

                parse_str($api_params['query'], $post_query);

                $request->set_query_params($post_query);

                // TODO: Find out proper WP way to add this param to request.
                $_REQUEST['_wpnonce'] = wp_create_nonce('wp_rest');

                rest_do_request($request);
            }
        }

        $this->update_queue_status('terms', count($this->query_terms(false, true, 'EXISTS')));
        $this->update_queue_status('posts', count($this->query_posts(false, true, 'EXISTS')), true);

        OmgfPro_Admin_Notice::set_pro_notice(
            sprintf(
                __('OMGF Pro has processed Google Fonts on <strong>%s/%s posts/pages</strong>, <strong>%s/%s archives</strong> and this site\'s homepage.', $this->plugin_text_domain),
                $this->queue[self::QUEUE_PROCESSED][self::QUEUE_POSTS],
                $this->queue[self::QUEUE_TOTAL][self::QUEUE_POSTS],
                $this->queue[self::QUEUE_PROCESSED][self::QUEUE_TERMS],
                $this->queue[self::QUEUE_TOTAL][self::QUEUE_TERMS]
            ),
            'success',
            'omgf-pro-automatic-optimization-status',
            'all'
        );
    }

    /**
     * Update queue status in memory, and in DB if $save is set to true.
     */
    private function update_queue_status($type, $amount, $save = false)
    {
        $this->queue['processed'][$type] = $amount;

        if ($save) {
            update_option(self::QUEUE, $this->queue);
        }
    }

    /**
     * Parse $html for Google Fonts and store them into the appropraite properties.
     * 
     * @param string $html 
     */
    private function parse($html)
    {
        $this->parser->get_document($html);
        $this->parser->capture_all();
    }

    /**
     * 
     * 
     * @return mixed 
     * @throws Exception 
     */
    private function prepare_api_url($type, $id)
    {
        $google_fonts = $this->parser->capture_google_fonts();

        /**
         * Empty API call breaks stuff.
         */
        if (empty($google_fonts)) {
            return '';
        }

        /**
         * Merge all found requests and generate URL.
         */
        $merged_url     = $this->parser->merge($google_fonts);
        $handle         = 'pro-merged-' . strlen($merged_url);
        $updated_handle = $handle;

        if ((omgf_init()::unloaded_fonts() && $cache_key = omgf_init()::get_cache_key($handle))
            || (OMGF_PRO_FALLBACK_FONT_STACK && $cache_key = omgf_init()::get_cache_key($handle))
        ) {
            $updated_handle = $cache_key;
        }

        $this->update_handle($updated_handle, $type, $id);

        return $this->parser->build_request_url($merged_url, $updated_handle, $handle);
    }

    /**
     * Store the updated handle for this post/term.
     * 
     * @since v2.2.2
     * @since v2.6.0 Added $type and $id params.
     */
    private function update_handle($handle, $type, $id)
    {
        // Terms e.g. categories, tags, or custom term types.
        if (in_array($type, $this->terms)) {
            return update_term_meta($id, OmgfPro::OMGF_PRO_HANDLE_META_KEY, $handle);
        }

        // Posts, pages, custom post types
        if (in_array($type, get_post_types())) {
            return update_post_meta($id, OmgfPro::OMGF_PRO_HANDLE_META_KEY, $handle);
        }

        // Homepages
        if ($type == 'home') {
            if (is_multisite()) {
                return update_blog_option(get_current_blog_id(), OmgfPro::OMGF_PRO_HANDLE_OPTION_NAME, $handle);
            }

            return update_option(OmgfPro::OMGF_PRO_HANDLE_OPTION_NAME, $handle);
        }
    }
}
