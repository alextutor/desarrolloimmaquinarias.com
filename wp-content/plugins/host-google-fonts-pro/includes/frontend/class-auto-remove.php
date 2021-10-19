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
class OmgfPro_Frontend_AutoRemove
{
	const IMPORT_REGEX    = '/@import\s*url\(\s*\S*fonts\.googleapis\.com\s*\S*\);/';
	const FONT_FACE_REGEX = '/@font-face\s*(\{(?:[^{]+fonts\.gstatic\.com[^}]+|(?1))*\})/';

	/** @var OmgfPro_Frontend_Optimize $frontend */
	private $frontend;

	/** @var string $html */
	private $html;

	/** @var IvoPetkov\HTML5DOMDocument $document */
	private $document;

	/** @var WP_Filesystem_Base $fs */
	private $fs;

	/**
	 * @param OmgfPro_Frontend_Optimize $frontend 
	 * @return void 
	 */
	public function __construct(
		OmgfPro_Frontend_Optimize $frontend
	) {
		$this->frontend = $frontend;
		$this->html     = $this->frontend->get('html');
		$this->document = $this->frontend->get('document');
	}

	/**
	 * Remove stylesheets, preloads and preconnects.
	 *
	 * @param $html
	 *
	 * @return string
	 */
	public function init()
	{
		/**
		 * Run all removal processes.
		 * 
		 * If method is not wrapped in a check, it uses inherited properties to run removal and checks have already been done.
		 * 
		 * @see OmgfPro_Frontend_Optimize::optimize()
		 */
		$this->remove_stylesheets();
		$this->remove_webfont_scripts();
		$this->remove_early_access_stylesheets();

		if (OMGF_PRO_PROCESS_STYLESHEET_IMPORTS) {
			$this->clean_stylesheet_by_pattern('stylesheet_imports', self::IMPORT_REGEX);
		}

		if (OMGF_PRO_PROCESS_STYLESHEET_FONT_FACES) {
			$this->clean_stylesheet_by_pattern('stylesheet_font_faces', self::FONT_FACE_REGEX);
		}

		if (OMGF_PRO_PROCESS_INLINE_STYLES) {
			$this->remove_inline_styles();
		}

		if (OMGF_PRO_PROCESS_RESOURCE_HINTS) {
			$this->remove_resource_hints();
		}

		if (OMGF_PRO_SAFE_MODE) {
			return $this->html;
		}

		return $this->document->saveHTML();
	}

	/**
	 * Remove all found stylesheets.
	 */
	private function remove_stylesheets()
	{
		$pattern = ['/<link.*?fonts.googleapis.com\/css.*?>/'];

		if (OMGF_PRO_SAFE_MODE) {
			$this->safe_remove($pattern);

			return;
		}

		$this->remove_nodes($this->frontend->get('external_stylesheets'));
	}

	/**
	 * 
	 */
	private function clean_stylesheet_by_pattern($type, $pattern)
	{
		$this->fs       = OmgfPro::filesystem();
		$wp_content_dir = $this->fs->wp_content_dir();

		// Strip first slash from OMGF_CACHE_PATH
		$cache_dir      = $wp_content_dir . substr(OMGF_CACHE_PATH, strlen('/'));
		$cache_url      = content_url(OMGF_CACHE_PATH);

		foreach ($this->frontend->get($type) as &$stylesheet) {
			$url           = $stylesheet->getAttribute('href');
			$parsed_url    = parse_url($url);
			$query         = isset($parsed_url['query']) ? '?' . $parsed_url['query'] : '';
			$orig_file_url = $parsed_url['scheme'] . '://' . $parsed_url['host'] . $parsed_url['path'];
			$new_file_path = '/cached' . str_replace(content_url(), '', $orig_file_url);
			$new_file_url  = $cache_url . $new_file_path . $query;

			/**
			 * If cached file already exists, skip out early.
			 */
			if (file_exists($cache_dir . $new_file_path)) {

				$this->modify_href_attr($stylesheet, $url, $new_file_url);

				continue;
			}

			$this->modify_nodes([$stylesheet], $pattern);

			$write = $this->cache_stylesheet($cache_dir . $new_file_path, $stylesheet->nodeValue);

			if (!$write) {
				continue;
			}

			$this->modify_href_attr($stylesheet, $url, $new_file_url);
		}
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
	 * Create $cache_dir if it doesn't exist, cache stylesheet and serve it (by pointing href attribute to new location)
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
	 * Remove Google Fonts from inline styles.
	 */
	private function remove_inline_styles()
	{
		if (OMGF_PRO_SAFE_MODE) {
			$this->safe_remove([self::IMPORT_REGEX, self::FONT_FACE_REGEX]);

			return;
		}

		$inline_styles = $this->frontend->filter_inline_styles_by_content(['fonts.googleapis.com/css', 'fonts.gstatic.com']);

		$this->modify_nodes($inline_styles, self::IMPORT_REGEX);
		$this->modify_nodes($inline_styles, self::FONT_FACE_REGEX);
	}

	/**
	 * Loop through nodes and remove $regex
	 *
	 * @param $nodes
	 */
	private function modify_nodes($nodes, $regex)
	{
		foreach ($nodes as &$node) {
			preg_match_all($regex, $node, $matches);

			if (!isset($matches[0])) {
				continue;
			}

			$nodeValue       = preg_replace($regex, '', $node->nodeValue);
			$node->nodeValue = $nodeValue;
		}
	}

	/**
	 * process_webfont_scripts() returns both webfont.js (or equivalents) and WebFontConfig scripts.
	 *
	 * Properly removes libraries and inline configs.
	 * 
	 * TODO: Remove WebFontConfig should be a separate option.
	 */
	private function remove_webfont_scripts()
	{
		if (OMGF_PRO_SAFE_MODE) {
			// Remove render-blocking
			$this->safe_remove(['/<script.*?webfont\..*?><\/script>/', '/WebFont\.load\([\s\S]*?{[\s\S]*?}[\s\S]*?\);/']);

			/** 
			 * Remove asynchronous
			 * 
			 * The first pattern removes WebFontConfig stated as arrays in two variations.
			 * The 2nd pattern removes the inline scripts to load webfont.js asynchronously.
			 */
			$this->safe_remove(['/(WebFontConfig)+?[\S\s]{0,10}(google)[\s\S]*?(};)+?/', '/(\(function\()+?[\s\S]*?{[\s\S]*?(webfont\.)+?[\s\S]*?(\(document\);|\(\);)+?/']);
		}

		foreach ($this->frontend->get('webfont_loaders') as $key => &$webfont_script) {
			if (strpos($webfont_script->getAttribute('src'), 'webfont') !== false) {
				$this->remove_nodes([$webfont_script]);

				continue;
			}

			$this->modify_nodes([$webfont_script], '/(WebFontConfig|WebFont\.)+?[\S\s]{0,10}(google)[\s\S]*?(};)+?/');
			$this->modify_nodes([$webfont_script], '/(\(function\()+?[\s\S]*?{[\s\S]*?(webfont\.)+?[\s\S]*?(\(document\);|\(\);)+?/');
		}
	}

	/**
	 * Remove all found Early Access stylesheets.
	 * 
	 * @return void 
	 * @throws InvalidArgumentException 
	 */
	private function remove_early_access_stylesheets()
	{
		if (OMGF_PRO_SAFE_MODE) {
			$this->safe_remove(['/<link.*?fonts.googleapis.com\/earlyaccess.*?>/']);

			return;
		}

		$this->remove_nodes($this->frontend->get('early_access_fonts'));
	}

	/**
	 * Remove all found preconnects, prefetches and preloads.
	 */
	private function remove_resource_hints()
	{
		if (OMGF_PRO_SAFE_MODE) {
			$this->safe_remove(['/<link.*?fonts.googleapis.com.*?>/', '/<link.*?fonts.gstatic.com.*?>/']);

			return;
		}

		$this->remove_nodes($this->frontend->get('preconnects'));
	}

	/**
	 * Remove nodes from DOM Document
	 *
	 * @param array $nodes
	 */
	private function remove_nodes($nodes)
	{
		foreach ($nodes as $node) {
			$node->parentNode->removeChild($node);
		}
	}

	/** 
	 * @param array $patterns Must be an array of regex patterns.
	 * @return void 
	 */
	private function safe_remove(array $patterns)
	{
		foreach ($patterns as $pattern) {
			$this->html = preg_replace($pattern, '', $this->html);
		}
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
