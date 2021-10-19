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
class OmgfPro_Frontend_FallbackFontStacks
{
    /** @var OmgfPro_Frontend_Optimize $frontend */
    private $frontend;

    /** @var IvoPetkov\HTML5DOMDocument $document */
    private $document;

    /** @var string $current_handle */
    private $current_handle;

    /** @var WP_Filesystem_Base $fs */
    private $fs;

    /** @var array $local_stylesheets */
    private $local_stylesheets;

    /** @var array $font_families */
    private $font_families = [];

    /** @var string $cached_stylesheets_dir */
    private $cached_stylesheets_dir;

    /** @var string $cached_stylesheets_url */
    private $cached_stylesheets_url;

    /**
     * Build class properties.
     */
    public function __construct(OmgfPro_Frontend_Optimize $frontend)
    {
        // These variables are only used when Advanced Processing is on.
        $this->frontend          = $frontend;
        $this->document          = $this->frontend->get('document');
        $this->local_stylesheets = $this->frontend->get('local_stylesheets');

        // If get_cache_handle() return false, this probably means that Optimization Mode is set to Manual.
        $this->current_handle = $this->frontend->get_cache_handle() ?: 'pro-merged';
        $this->cache_key      = str_replace('pro-merged-', '', $this->current_handle);
        $this->font_families  = $this->get_font_families();
        $this->fs             = OmgfPro::filesystem();

        // Strip first slash from OMGF_CACHE_PATH
        $this->cached_stylesheets_dir = $this->fs->wp_content_dir() . substr(OMGF_CACHE_PATH, strlen('/'));
        $this->cached_stylesheets_url = content_url(OMGF_CACHE_PATH);
    }

    /**
     * Builds an array of the current stylesheet's font families.
     * Used for mapping to configured fallbacks.
     * 
     * @see $this->maybe_serve_cached_version()
     * 
     * @return array 
     */
    private function get_font_families()
    {
        $array = [];

        foreach (OMGF::optimized_fonts() as $handle => $fonts) {
            foreach ($fonts as $font) {
                // Make sure only settings for current handle are added to the array.
                if (strpos($this->current_handle, $handle) !== false) {
                    $array[$font->id] = $font->family;
                }
            }
        }

        return $array;
    }

    /**
     * Parse WP's queued stylesheets to scan for files that need to be rewritten to
     * include the fallback font stacks. 
     * 
     * @return void 
     */
    public function insert()
    {
        global $wp_styles;

        $registered = $wp_styles->registered;

        foreach ($registered as $handle => $properties) {
            $src = $properties->src;

            if ($src == '' || strpos($src, home_url()) === false) {
                continue;
            }

            $wp_styles->registered[$handle]->src = $this->maybe_modify_src($src);
        }
    }

    /**
     * Performs a number of checks, before serving the URL of the cached and rewritten stylesheet.
     * 
     * @param mixed $url 
     * @return string original $url if failed | Cached file URL if successfull.
     */
    private function maybe_modify_src($url)
    {
        $cache = $this->build_cache_paths($url);

        /**
         * If cached file already exists, return $new_file_url.
         */
        if (file_exists($this->cached_stylesheets_dir . $cache['path'])) {
            return $cache['url'];
        }

        $contents = $this->rewrite_contents($url);

        if (!$contents) {
            return $url;
        }

        $write = $this->cache_stylesheet($this->cached_stylesheets_dir . $cache['path'], $contents);

        /**
         * If write failed, return $url;
         */
        if (!$write) {
            return $url;
        }

        /**
         * At this point we can assume the file was successfully rewritten and cached, return $new_file_url.
         */
        return $cache['url'];
    }

    /**
     * Parse the URL and build the query, absolute path to cached file and absolute URL to cached file.
     * 
     * @param string $url 
     * @return array 
     */
    private function build_cache_paths($url)
    {
        $parsed_url    = parse_url($url);
        $query         = isset($parsed_url['query']) ? '?' . $parsed_url['query'] : '';
        $orig_file_url = $parsed_url['scheme'] . '://' . $parsed_url['host'] . $parsed_url['path'];
        $new_file_path = '/cached/' . $this->cache_key . str_replace(content_url(), '', $orig_file_url);
        $new_file_url  = $this->cached_stylesheets_url . $new_file_path . $query;

        return [
            'path' => $new_file_path,
            'url'  => $new_file_url
        ];
    }

    /**
     * Check if URL's contents contain any font-family attributes and rewrite them to include the
     * configured Fallback Font Stacks.
     * 
     * @param string $url 
     * @return string|bool rewritten $contents if successfull, false if no font-familes were found 
     *                     or rewritten.
     */
    private function rewrite_contents(string $url)
    {
        $contents = $this->fs->get_contents($url);

        preg_match_all('/(?<=font\-family:)[\s]*(.+?)(?=;)/', $contents, $font_families);

        if (!isset($font_families[1]) || (isset($font_families[1]) && empty($font_families[1]))) {
            return false;
        }

        $font_families          = $font_families[1];
        $font_family_phrases    = [];
        $fallback_phrases       = [];
        $contains_font_families = false;

        foreach ($font_families as $font_family) {
            $font_family_phrase = $font_family;

            // If a fallback is already set, lose it.
            if (strpos($font_family, ',') !== false) {
                $font_family = explode(',', $font_family)[0];
            }

            $font_family = trim($font_family, '\'"');

            // Skip out if this font-family is not a (captured) Google Font.
            if (!in_array($font_family, $this->font_families)) {
                continue;
            }

            $font_id  = array_search($font_family, $this->font_families);
            $fallback = $this->load_fallback_font_stack($font_id, $font_family);

            // No fallback was found. Skip out.
            if (!$fallback) {
                continue;
            }

            // Build two arrays to be used with Search/Replace later.
            $font_family_phrases[$font_id] = $font_family_phrase;
            $fallback_phrases[$font_id]    = $fallback;
            $contains_font_families         = true;
        }

        if (!$contains_font_families) {
            return false;
        }

        return str_replace($font_family_phrases, $fallback_phrases, $contents);
    }

    /**
     * Map fallback font stack option to actual fallback font stack.
     * 
     * @since v2.5
     * 
     * @return bool|string 
     */
    public function load_fallback_font_stack($font_id, $font_family)
    {
        $fallbacks = OMGF_PRO_FALLBACK_FONT_STACK;
        $fallback  = '';

        foreach ($fallbacks as $font_families) {
            if (isset($font_families[$font_id])) {
                $fallback = OmgfPro_FallbackFontStacks::MAP[$font_families[$font_id]];

                break;
            }
        }

        if (!$fallback) {
            return false;
        }

        return $font_family . ', ' . $fallback;
    }

    /**
     * Create $cache_dir if it doesn't exist and cache stylesheet.
     * 
     * @param mixed $cache_dir 
     * @param mixed $filepath 
     * @param mixed $contents 
     * @return bool 
     */
    private function cache_stylesheet($filepath, $contents)
    {
        $cache_dir = str_replace(basename($filepath), '', $filepath);

        if (!file_exists($cache_dir)) {
            wp_mkdir_p($cache_dir);
        }

        if (!file_exists($filepath)) {
            $this->fs->touch($filepath);
        }

        return $this->fs->put_contents($filepath, $contents);
    }

    /**
     * @return string
     */
    public function insert_advanced()
    {
        foreach ($this->local_stylesheets as &$local_stylesheet) {
            $this->maybe_serve_cached_version($local_stylesheet);
        }

        return $this->document->saveHTML();
    }

    /**
     * @param mixed $stylesheet 
     * 
     * @return void
     */
    private function maybe_serve_cached_version(&$stylesheet)
    {
        $url   = $stylesheet->getAttribute('href');
        $cache = $this->build_cache_paths($url);

        /**
         * If cached file already exists, skip out early.
         */
        if (file_exists($this->cached_stylesheets_dir . $cache['path'])) {
            $this->modify_href_attr($stylesheet, $url, $cache['url']);

            return;
        }

        $contents = $this->rewrite_contents($url);

        if (!$contents) {
            return;
        }

        $write = $this->cache_stylesheet($this->cached_stylesheets_dir . $url['path'], $contents);

        if (!$write) {
            return;
        }

        $this->modify_href_attr($stylesheet, $url, $cache['url']);
    }

    /**
     * Modify href attribute
     * 
     * @param mixed $stylesheet 
     * @param mixed $origin 
     * @param mixed $new 
     * @return void 
     */
    private function modify_href_attr($stylesheet, $origin, $new)
    {
        if (OMGF_PRO_SAFE_MODE) {
            $this->safe_modify($origin, $new);

            return;
        }

        $stylesheet->setAttribute('href', $new);
    }

    /**
     * Modify HTML using strings or mapped arrays.
     * 
     * @param string|array $search 
     * @param string|array $replace 
     * @return void 
     */
    private function safe_modify($search, $replace)
    {
        $this->html = str_replace($search, $replace, $this->html);
    }
}
