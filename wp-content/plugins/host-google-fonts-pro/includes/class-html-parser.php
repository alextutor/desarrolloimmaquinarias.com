<?php

/**
 * @package   OMGF Pro
 * @author    Daan van den Bergh
 *            https://ffw.press
 *            https://daan.dev
 * @copyright © 2021 Daan van den Bergh
 * @license   BY-NC-ND-4.0
 *            http://creativecommons.org/licenses/by-nc-nd/4.0/
 */
defined('ABSPATH') || exit;

require_once OMGF_PRO_PLUGIN_DIR . 'vendor/autoload.php';

class OmgfPro_HtmlParser
{
    /** @var string $html Must contain a valid HTML document as a string. */
    protected $html;

    /** @var IvoPetkov\HTML5DOMDocument $document */
    protected $document;

    /** @vart $is_amp bool */
    protected $is_amp = false;

    /** @var $external_stylesheets array */
    private $external_stylesheets = [];

    /** @var $local_stylesheets array */
    private $local_stylesheets = [];

    /** @var $stylesheet_imports array */
    private $stylesheet_imports = [];

    /** @var $stylesheet_font_faces array */
    private $stylesheet_font_faces = [];

    /** @var $inline_imports array */
    private $inline_imports = [];

    /** @var $inline_font_faces array */
    private $inline_font_faces = [];

    /** @var $webfont_loaders array */
    private $webfont_loaders = [];

    /** @var $early_access_fonts array */
    private $early_access_fonts = [];

    /** @var $preconnects array */
    private $preconnects = [];

    /**
     * A universal getter to return any property from this class.
     */
    public function get($property)
    {
        return $this->$property;
    }

    /**
     * @param $html
     *
     * @return string|void
     */
    public function get_document($html)
    {
        /**
         * This allows us to temporarily bypass fonts optimization done by OMGF Pro.
         * 
         * When Advanced Processing is disabled all of OMGF Pro's features remain active, except for its advanced detection 
         * of stylesheets.
         */
        if (apply_filters('omgf_pro_get_document', isset($_GET['nomgf']) || $this->is_excluded() || OMGF_PRO_ADVANCED_PROCESSING != 'on')) {
            return $html;
        }

        if (apply_filters('omgf_pro_get_document', wp_doing_ajax())) {
            return $html;
        }

        // Skip out early if it's not a valid HTML document.
        if (strtolower(substr(trim($html), 0, 14)) !== '<!doctype html') {
            return $html;
        }

        $document = new IvoPetkov\HTML5DOMDocument();
        $document->loadHTML($html, IvoPetkov\HTML5DOMDocument::ALLOW_DUPLICATE_IDS | IvoPetkov\HTML5DOMDocument::FIX_DUPLICATE_METATAGS | IvoPetkov\HTML5DOMDocument::FIX_MULTIPLE_BODIES | IvoPetkov\HTML5DOMDocument::FIX_MULTIPLE_HEADS | IvoPetkov\HTML5DOMDocument::FIX_MULTIPLE_TITLES | IvoPetkov\HTML5DOMDocument::OPTIMIZE_HEAD);

        $this->html     = $html;
        $this->document = $document;
        $this->is_amp   = $this->is_amp_request();
    }

    /**
     * Checks if current post/page ID is defined as excluded.
     * 
     * @return bool 
     */
    private function is_excluded()
    {
        global $post;

        if ($post == null) {
            return false;
        }

        $excluded_ids = explode(',', OMGF_PRO_EXCLUDED_IDS);
        $post_id      = $post->ID;

        return in_array($post_id, $excluded_ids);
    }

    /**
     * @since v2.4.0 Added AMPforWP support.
     *               Added support for "official" AMP plugin.
     * 
     * @return bool 
     */
    private function is_amp_request()
    {
        return (function_exists('is_amp_endpoint') && is_amp_endpoint())
            || (function_exists('ampforwp_is_amp_endpoint') && ampforwp_is_amp_endpoint());
    }

    /**
     * @return void 
     * @throws InvalidArgumentException 
     */
    public function capture_all()
    {
        /**
         * Process Stylesheets
         */
        if (apply_filters('omgf_pro_advanced_processing_setting_enabled', OMGF_PRO_PROCESS_STYLESHEETS)) {
            $this->external_stylesheets = $this->gather_external_stylesheets();
        }

        /**
         * If any fallback fonts are defined, we'll need to gather all stylesheets for processing later.
         */
        if (apply_filters('omgf_pro_advanced_processing_setting_enabled', OMGF_PRO_FALLBACK_FONT_STACK)) {
            $this->local_stylesheets = $this->gather_local_stylesheets();
        }

        /**
         * Process @import statements in local stylesheets.
         */
        if (apply_filters('omgf_pro_advanced_processing_setting_enabled', OMGF_PRO_PROCESS_STYLESHEET_IMPORTS)) {
            $this->stylesheet_imports = $this->filter_stylesheets_by_content();
        }

        /**
         * Process @font-face statements in local stylesheets.
         */
        if (apply_filters('omgf_pro_advanced_processing_setting_enabled', OMGF_PRO_PROCESS_STYLESHEET_FONT_FACES)) {
            $this->stylesheet_font_faces = $this->filter_stylesheets_by_content('fonts.gstatic.com');
        }

        /**
         * Process @import and @font-face rules from inline styles.
         */
        if (apply_filters('omgf_pro_advanced_processing_setting_enabled', OMGF_PRO_PROCESS_INLINE_STYLES)) {
            $this->inline_imports    = $this->filter_inline_styles_by_content('fonts.googleapis.com/css');
            $this->inline_font_faces = $this->filter_inline_styles_by_content();
        }

        /**
         * Process WebFont configs.
         */
        if (apply_filters('omgf_pro_advanced_processing_setting_enabled', OMGF_PRO_PROCESS_WEBFONT_LOADER)) {
            $this->webfont_loaders = $this->process_webfont_scripts();
        }

        /**
         * Process Early Access Stylesheets
         */
        if (apply_filters('omgf_pro_advanced_processing_setting_enabled', OMGF_PRO_PROCESS_EARLY_ACCESS)) {
            $this->early_access_fonts = $this->gather_external_stylesheets('fonts.googleapis.com/earlyaccess');
        }

        /**
         * Process Resource Hints
         */
        if (OMGF_PRO_PROCESS_RESOURCE_HINTS) {
            $this->preconnects = $this->process_preconnects();
        }
    }

    /**
     * 
     * Gets the stylesheet handle for the queried object: post, page, archive (author, category, tag, etc.) or home.
     * When it's a Multisite, the handle is retrieved for the specific site.
     * 
     * @return string|bool false if the cron hasn't reached this post/page yet.
     */
    public function get_cache_handle()
    {
        $id = get_queried_object_id();
        $handle = '';

        if (is_home()) {
            if (is_multisite()) {
                $handle = get_blog_option(get_current_blog_id(), OmgfPro::OMGF_PRO_HANDLE_OPTION_NAME);
            } else {
                $handle = get_option(OmgfPro::OMGF_PRO_HANDLE_OPTION_NAME);
            }
        } elseif (is_author() || is_archive()) {
            $handle = get_term_meta($id, OmgfPro::OMGF_PRO_HANDLE_META_KEY, true);
        } elseif (is_single() || is_page()) {
            $handle = get_post_meta($id, OmgfPro::OMGF_PRO_HANDLE_META_KEY, true);
        }

        return $handle;
    }

    /**
     * @param string $needles
     *
     * @return array
     */
    protected function gather_external_stylesheets($needles = 'fonts.googleapis.com/css')
    {
        $stylesheets = $this->gather_stylesheets();

        /** @var $stylesheet IvoPetkov\HTML5DOMElement */
        return array_filter($stylesheets, function ($stylesheet) use ($needles) {
            if (is_array($needles)) {
                foreach ($needles as $needle) {
                    return strpos($stylesheet->getAttribute('href'), $needle) !== false;
                }
            }

            return strpos($stylesheet->getAttribute('href'), $needles) !== false;
        });
    }

    /**
     * Returns all relevant stylesheets for the current document.
     */
    private function gather_stylesheets()
    {
        $links       = $this->document->querySelectorAll('link');
        $stylesheets = array_filter((array) $links, function ($link) {
            return $link->getAttribute('rel') == 'stylesheet'
                && strpos($link->getAttribute('href'), 'pro-merged') == false
                && strpos($link->getAttribute('href'), 'additional-fonts') == false;
        });

        return $stylesheets;
    }

    /**
     * Gather all locally hosted stylesheets present in the current document.
     * 
     * @return array 
     * @throws InvalidArgumentException 
     */
    protected function gather_local_stylesheets()
    {
        $stylesheets = $this->gather_stylesheets();

        return array_filter($stylesheets, function ($stylesheet) {
            return strpos($stylesheet->getAttribute('href'), content_url()) !== false;
        });
    }

    /**
     * Loop through every stylesheet and check its $contents for $needle.
     * 
     * @param string $needle 
     * @return array 
     * @throws InvalidArgumentException 
     */
    protected function filter_stylesheets_by_content($needle = 'fonts.googleapis.com')
    {
        $stylesheets = $this->gather_local_stylesheets();

        /** @var $stylesheet IvoPetkov\HTML5DOMElement */
        foreach ($stylesheets as $index => &$stylesheet) {
            $href     = $stylesheet->getAttribute('href');
            $fs       = OmgfPro::filesystem();
            $contents = $fs->get_contents($href);

            if (strpos($contents, $needle) !== false) {
                $stylesheet->nodeValue = $contents;
            } else {
                unset($stylesheets[$index]);
            }
        }

        return $stylesheets;
    }

    /**
     * @param string $needle
     *
     * @return array
     */
    public function filter_inline_styles_by_content($needle = 'fonts.gstatic.com')
    {
        $style_elements = $this->document->querySelectorAll('style');
        $contents  = [];

        foreach ($style_elements as $style) {
            /** @var $value \IvoPetkov\HTML5DOMElement */
            $value = $style->nodeValue;

            if (!$this->contains_google_fonts($value, $needle)) {
                continue;
            }

            $contents[] = $style;
        }

        return $contents;
    }

    /**
     * @param $src
     * @param $needle
     *
     * @return bool
     */
    private function contains_google_fonts($src, $needles)
    {
        if (!is_array($needles)) {
            // Checking for @font-face first is a minor performance improvement.
            return (strpos($src, '@font-face') !== false || strpos($src, '@import') !== false) && strpos($src, $needles) !== false;
        }

        // Returns at first match.
        foreach ($needles as $needle) {
            if ((strpos($src, '@font-face') !== false || strpos($src, '@import') !== false) && strpos($src, $needle) !== false) {
                return true;
            }
        }

        return false;
    }

    /**
     * @return array
     */
    protected function process_webfont_scripts()
    {
        $scripts         = $this->document->querySelectorAll('script');
        $webfont_scripts = [];

        $i = 0;

        foreach ($scripts as $script) {
            // Default implementation (asynchronous)
            if (strpos($script->nodeValue, 'WebFont') !== false) {
                $webfont_scripts[] = $script;

                continue;
            }

            // If we find webfont.js as src (synchronously), this means its config is lingering somewhere...
            if (
                strpos($script->getAttribute('src'), 'webfont.js') !== false
                || strpos($script->getAttribute('src'), 'webfont.min.js') !== false
                /**
                 * Compatibility for Smart Slider 3.
                 */
                || strpos($script->getAttribute('src'), 'nextend-webfontloader') !== false
            ) {
                $webfont_scripts[] = $script;

                if ($config = $this->parse_src($scripts, $i) != null) {
                    $webfont_scripts[] = $config;
                }
            }

            $i++;
        }

        return $webfont_scripts;
    }

    /**
     * @param $scripts
     *
     * @return array|mixed|WP_Error
     */
    private function parse_src($scripts, $start)
    {
        foreach ($scripts as $position => $script) {
            if ($position <= $start) {
                continue;
            }

            if (!$script->getAttribute('src')) {
                continue;
            }

            $src = $script->getAttribute('src');

            // You must be thinking: why is this here? Well, some 'developers' include JS as base64 encoded strings.
            if ($this->is_encoded($src)) {
                $decoded_src = $this->decode_src($src);

                if (strpos($decoded_src, 'WebFont') !== false) {
                    return $script;
                }
            }
        }
    }

    /**
     * @param $src
     *
     * @return bool
     */
    protected function is_encoded($src)
    {
        return strpos($src, 'base64') !== false;
    }

    /**
     * @param $src
     *
     * @return string
     */
    protected function decode_src($src)
    {
        return base64_decode(str_replace('data:text/javascript;base64,', '', $src));
    }

    /**
     * @param $script
     * @param $src
     *
     * @return bool
     */
    protected function decode_webfont_config($script, $src)
    {
        $decoded_src = $this->decode_src($src);

        if (strpos($decoded_src, 'WebFont') !== false) {
            return $script;
        }

        return false;
    }

    /**
     * @param IvoPetkov\HTML5DOMElement $node
     *
     * @return array
     */
    public function extract_web_font_config($node)
    {
        $node_value = $node->nodeValue;

        if ($this->is_encoded($src = $node->getAttribute('src'))) {
            $node_value = base64_decode(str_replace('data:text/javascript;base64,', '', $src));
        }

        /**
         * Captures everything between [ ].
         * This regex is much less prone to error and faster, compared to negative look back, etc.
         */
        preg_match_all('/\[[^\[\]]*\]/', $node_value, $matches);

        if (empty($matches)) {
            return [];
        }

        $matched_fonts = [];

        foreach (reset($matches) as $match) {
            // If $string contains alphabetic characters, we can assume it's a font-family request.
            $has_letters = preg_match("/[a-z]/i", $match);

            if ($has_letters !== 0 && $has_letters !== false) {
                $matched_fonts[] = $match;
            }
        }

        return $matched_fonts;
    }

    /**
     * @return array
     */
    protected function process_preconnects()
    {
        $links       = $this->document->querySelectorAll('link[rel="preconnect"], link[rel="preload"], link[rel="dns-prefetch"]');
        $preconnects = [];

        /** @var $link IvoPetkov\HTML5DOMElement */
        foreach ($links as $link) {
            $href = $link->getAttribute('href');

            if (strpos($href, 'fonts.googleapis.com') !== false || strpos($link->getAttribute('href'), 'fonts.gstatic.com') !== false) {
                $preconnects[] = $link;
            }
        }

        return $preconnects;
    }

    /**
     * Wrapper for wp_remote_get() with preset params.
     *
     * @param mixed $url
     * @return array|WP_Error
     */
    public function remote_get($url)
    {
        return wp_remote_get(
            $this->no_cache_optimize_url($url),
            [
                'timeout' => 30
            ]
        );
    }

    /**
     * @param $url
     *
     * @return string
     */
    private function no_cache_optimize_url($url)
    {
        return add_query_arg(['nomgf' => 1, 'nocache' => substr(md5(microtime()), rand(0, 26), 5)], $url);
    }


    /**
     * Capture Google Fonts URLs from HTML document.
     * 
     * @return $script 
     */
    public function capture_google_fonts()
    {
        $google_fonts = [];

        /**
         * Process Stylesheets
         */
        foreach ($this->external_stylesheets as $stylesheet) {
            /** @var $stylesheet IvoPetkov\HTML5DOMElement */
            $google_fonts[] = urldecode($stylesheet->getAttribute('href'));
        }

        /**
         * Process @import statements in local stylesheets.
         */
        foreach ($this->stylesheet_imports as $stylesheet) {
            $urls = $this->extract_urls($stylesheet->nodeValue, '/@import\s*url([\s\S]*?);/');

            foreach ($urls as $url) {
                $google_fonts[] = $url;
            }
        }

        foreach ($this->stylesheet_font_faces as $font_face) {
            $google_fonts[] = $this->generate_url_from_font_faces($font_face);
        }

        /**
         * Process @import and @font-face rules from inline styles.
         */
        foreach ($this->inline_imports as $import) {
            /** @var $import IvoPetkov\HTML5DOMElement */
            $urls = $this->extract_urls($import->nodeValue, '/@import\s*url([\s\S]*?);/');

            foreach ($urls as $url) {
                $google_fonts[] = $url;
            }
        }

        foreach ($this->inline_font_faces as $font_face) {
            /** @var $font_face IvoPetkov\HTML5DOMElement */
            $google_fonts[] = $this->generate_url_from_font_faces($font_face);
        }

        /**
         * Process WebFont configs.
         */
        foreach ($this->webfont_loaders as $script) {
            /** @var $script IvoPetkov\HTML5DOMElement */
            $google_fonts[] = $this->generate_url_from_webfonts($script);
        }

        /**
         * Process Early Access Stylesheets
         */
        foreach ($this->early_access_fonts as $ea_url) {
            $google_fonts[] = $ea_url->getAttribute('href');
        }

        return $google_fonts;
    }

    /**
     * Extract URLs from $source by $pattern.
     * 
     * @param string $source 
     * @param string $pattern 
     * @return array 
     */
    private function extract_urls(string $source, string $pattern)
    {
        $urls = [];

        preg_match_all($pattern, $source, $matches);

        if (!isset($matches[1]) || empty($matches[1])) {
            return $urls;
        }

        foreach ($matches[1] as $match) {
            $urls[] = trim($match, '()"\'');
        }

        return $urls;
    }


    /**
     * Generate Google Fonts URL from @font-face entries.
     *
     * @param $node
     *
     * @return string
     */
    private function generate_url_from_font_faces($node)
    {
        $url = '';

        $font_faces = $this->find_font_faces($node->nodeValue);

        if (isset($font_faces[1]) && empty($font_faces[1])) {
            return $url;
        }

        $fonts = $this->find_font_variants($font_faces[1]);

        $url = 'https://fonts.googleapis.com/css?family=';
        $i   = 0;

        foreach ($fonts as $family => $weights) {
            if ($i > 0) {
                $url .= '|';
            }

            $url .= $family . (isset($weights) ? ':' . implode(',', $weights) : '');
            $i++;
        }

        return $url;
    }

    /**
     * Use regular expressions to find font faces in given string.
     * 
     * @param string $stylesheet Contents of Stylesheet
     * @return array 
     */
    private function find_font_faces($stylesheet)
    {
        preg_match_all('/@font-face\s*{([\s\S]*?)}/', $stylesheet, $font_faces);

        if (!isset($font_faces[0])) {
            return [];
        }

        return $font_faces;
    }

    /**
     * @param array $font_faces 
     * @return array 
     */
    private function find_font_variants($font_faces)
    {
        $fonts = [];

        foreach ($font_faces as $font_face) {
            // No need to continue if the font-face does not load a Google Font.
            if (strpos($font_face, 'fonts.gstatic.com') === false) {
                continue;
            }

            preg_match('/font-family\s*:\s*([\s\S]*?);/', $font_face, $font_family);
            preg_match('/font-weight\s*:\s*([\s\S]*?);/', $font_face, $font_weight);
            preg_match('/font-style\s*:\s*([\s\S]*?);/', $font_face, $font_style);

            if (!isset($font_family[1])) {
                continue;
            }

            $fonts[trim($font_family[1], '\'"')][] = ($font_weight[1] ?? '') . (isset($font_style[1]) && $font_style[1] !== 'normal' ? $font_style[1] : '');
        }

        return $fonts;
    }

    /**
     * @param $node
     *
     * @return string
     */
    private function generate_url_from_webfonts($node)
    {
        $uri           = '';
        $matched_fonts = $this->extract_web_font_config($node);

        foreach ($matched_fonts as $fonts) {
            $fonts     = trim($fonts, ' []\'"');
            $formatted = preg_replace("/(?:\',\s*\'|\",\s*\")/", '|', $fonts);
            $uri      .= empty($uri) ? $formatted : '|' . $formatted;
        }

        return 'https://fonts.googleapis.com/css?family=' . $uri;
    }

    /**
     * Arrange all found Google Font URLs and filter out duplicate families, styles and subsets.
     *
     * Merges them into one stylesheet.
     *
     * @param $font_urls
     *
     * @return string
     */
    public function merge($font_urls)
    {
        foreach ($font_urls as $font_url) {
            $parts = parse_url($font_url);
            $query = [];

            /**
             * If CSS2 API is used, we need to extract the parameters in a different way.
             */
            if (isset($parts['path']) && $parts['path'] == '/css2') {
                $query = $this->convert_css2_query($parts['query']);
            } elseif (isset($parts['query'])) {
                parse_str($parts['query'], $query);
            }

            if (empty($query)) {
                continue;
            }

            if (!empty($query) && strpos($parts['path'], 'earlyaccess') === false) {
                $fonts[] = $query;
            } elseif (OMGF_PRO_PROCESS_EARLY_ACCESS && strpos($parts['path'], 'earlyaccess') != false) {
                $filename = pathinfo($parts['path'], PATHINFO_FILENAME);

                if (!isset(OmgfPro_EarlyAccessFonts::SUPPORTED_FONTS[$filename])) {
                    continue;
                }

                $fonts[] = [
                    'family' => $filename,
                    'subset' => OmgfPro_EarlyAccessFonts::SUPPORTED_FONTS[$filename]
                ];
            }
        }

        $base          = 'https://fonts.googleapis.com/css?';
        $font_families = [];
        $subsets       = OMGF_PRO_FORCE_SUBSETS ?: [];
        $force_subsets = !empty($subsets);

        // Arrange all available font families, style and subsets and remove duplicates.
        foreach ($fonts as $font) {
            if (!isset($font['family'])) {
                continue;
            }

            $font_family = explode('|', $font['family']);

            foreach ($font_family as $family) {
                $parts                        = explode(':', $family);
                $family_name                  = $parts[0];
                $family_key                   = strtolower(str_replace(' ', '-', $family_name));
                $family_styles                = isset($parts[1]) ? explode(',', $parts[1]) : [];

                /**
                 * combine array_unique() and array_merge() to only append new values to the current array.
                 */
                $font_families[$family_key]['family'] = $family_name;
                $font_families[$family_key]['styles'] = isset($font_families[$family_key]['styles']) ? array_unique(array_merge($font_families[$family_key]['styles'], $family_styles)) : $family_styles;
            }

            /**
             * $subsets array should only be filled with additional subsets if Force Subsets option isn't configured.
             */
            if ($force_subsets) {
                continue;
            }

            $font_subsets = isset($font['subset']) ? explode(',', $font['subset']) : [];

            foreach ($font_subsets as $subset) {
                if (!in_array($subset, $subsets)) {
                    $subsets[] = $subset;
                }
            }
        }

        foreach ($font_families as $id => &$font) {
            $font_families[$id] = $font['family'] . (!empty($font['styles']) ? ':' . implode(',', $font['styles']) : '');
        }

        // Subsets should have 1 default.
        if (empty($subsets)) {
            $subsets[] = 'latin-ext';
        }

        $query = [
            'family' => implode('|', $font_families),
            'subset' => implode(',', $subsets)
        ];

        return $base . http_build_query($query);
    }

    /**
     * Takes a CSS2 query string and formats it to a CSS(1) query array. 
     * 
     * @param mixed $params_array 
     * @return array 
     */
    private function convert_css2_query($params_string)
    {
        $params_array = explode('&', $params_string);
        $i            = 0;

        foreach ($params_array as $param) {
            // prevent notice on explode() if $param has no '='
            if (strpos($param, '=') === false) $param += '=';

            list($name, $value) = explode('=', $param, 2);
            // Replace e.g. :wght@ with :
            $query[$i++][urldecode($name)] = preg_replace('/\:[\s\S]+?\@/', ':', urldecode($value));
        }

        /**
         * Sanitize elements and format them to regular CSS(1) format.
         */
        foreach ($query as $index => &$query_part) {
            // Without the family parameter this query part is useless.
            if (!isset($query_part['family'])) {
                unset($query[$index]);

                continue;
            }

            // Prevent notice
            if (strpos($query_part['family'], ':') === false) $query_part['family'] .= ':';

            list($part_family_name, $part_styles) = explode(':', $query_part['family']);

            $part_styles_array = explode(';', $part_styles);

            foreach ($part_styles_array as &$style) {
                // Check if style is requested as italic.
                if (strpos($style, '1,') !== false) {
                    $style = str_replace('1,', '', $style) . 'italic';

                    continue;
                }

                $style = str_replace('0,', '', $style);
            }

            $query_part['family'] = $part_family_name . ':' . implode(',', $part_styles_array);
        }

        $css1_query['family'] = '';

        foreach ($query as $query_part) {
            $css1_query['family'] .= empty($css1_query['family']) ? $query_part['family'] : '|' . $query_part['family'];
        }

        return $css1_query;
    }

    /**
     * The generated request URL includes all required parameters for OMGF's Download API. 
     *
     * @param string $url            e.g. https://fonts.googleapis.com/css?family=Open+Sans
     * @param string $updated_handle e.g. pro-merged-xxx
     * @param string $handle         e.g. pro-merged
     *
     * @return string
     */
    public function build_request_url($url, $updated_handle, $handle)
    {
        $parsed_url = parse_url($url);
        $query      = $parsed_url['query'] ?? '';

        parse_str($query, $original_query);

        $params = http_build_query(
            array_merge(
                $original_query,
                [
                    'handle'          => $updated_handle,
                    'original_handle' => $handle,
                ]
            )
        );

        $request = str_replace('https://fonts.googleapis.com/', '/omgf/v1/download/', $url) . '?' . $params;

        return $request;
    }
}
