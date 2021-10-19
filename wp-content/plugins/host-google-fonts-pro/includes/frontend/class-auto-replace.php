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
class OmgfPro_Frontend_AutoReplace
{
	const OMGF_PRO_LINK_ELEMENT     = "<link rel='stylesheet' id='omgf-pro-google-fonts-merged-css' href='%s' media='all' />\n";
	const OMGF_PRO_AMP_LINK_ELEMENT = "<link rel='stylesheet' href='%s' />\n";


	/** @var OmgfPro_Frontend_Optimize $frontend */
	private $frontend;

	/** @var $is_amp bool */
	private $is_amp;

	/** @var IvoPetkov\HTML5DOMDocument $document */
	private $document;

	/** @var string $fonts_cache_path */
	private $fonts_cache_path;

	/**
	 * @param OmgfPro_Frontend_Optimize $frontend 
	 * @return void 
	 */
	public function __construct(OmgfPro_Frontend_Optimize $frontend)
	{
		$this->frontend         = $frontend;
		$this->is_amp           = $this->frontend->get('is_amp');
		$this->document         = $this->frontend->get('document');
		$this->fonts_cache_path = OMGF_CACHE_PATH . '/%s/%s.css';
	}

	/**
	 * Process all the HTML to find CSS files
	 */
	public function init()
	{
		$handle       = 'pro-merged';
		$cache_handle = '';

		if (!$this->is_amp && !isset($_GET['omgf_optimize'])) {
			switch (OMGF_PRO_OPTIMIZATION_MODE) {
				case 'manual':
					// Optimization Mode: Manual
					$cache_handle = omgf_init()::get_cache_key($handle) ?: $handle;
					break;
				default:
					// Optimization Mode: Auto
					$cache_handle = $this->frontend->get_cache_handle();
					break;
			}
		}

		// Non-AMP
		if ($cache_handle) {
			$file = str_replace('%s', $cache_handle, $this->fonts_cache_path);
			$url  = '';

			if ($this->file_exists($file)) {
				$url = $this->get_stylesheet_url($file);
			}

			if ($url && OMGF_PRO_SAFE_MODE == 'on') {
				return $this->do_safe_mode($this->html, $url);
			}

			if ($url) {
				return $this->do_default_mode($url);
			}
		}

		// AMP
		if ($this->is_amp) {
			$google_fonts = $this->frontend->capture_google_fonts();
			$url          = $this->frontend->merge($google_fonts);

			return $this->do_amp($url);
		}

		// Optimization Mode: Auto (probably), but cron task hasn't processed this page yet.
		if (!isset($_GET['omgf_optimize'])) {
			return $this->frontend->get('html');
		}
	}

	/**
	 * Check if $file exists in WP_CONTENT_DIR.
	 * 
	 * @param mixed $file 
	 * @return bool 
	 */
	private function file_exists($file)
	{
		return file_exists(WP_CONTENT_DIR . $file);
	}

	/**
	 * Get wp-content URL to $file.
	 * 
	 * @param mixed $file 
	 * @return string 
	 */
	private function get_stylesheet_url($file)
	{
		$url = '';

		if ($this->file_exists($file)) {
			$url = content_url($file);
		}

		return $url;
	}

	/**
	 * Adds $link to $html in the appropriate place.
	 * 
	 * @param mixed string 
	 * @param mixed string
	 * @return string 
	 * 
	 * @since v2.2.0
	 * @since v2.2.2 Improved performance/efficiency by using preg_match_all() to find all stylesheets and simply insert it before the first match.
	 */
	private function do_safe_mode($html, $url)
	{
		preg_match_all('/<!--[\s\S]*?-->|<link(.*?)stylesheet(.*?)\/>/', $html, $stylesheets);
		$link = sprintf(self::OMGF_PRO_LINK_ELEMENT, $url);

		// Filter out matches inside commented code. array_values() resets the keys.
		$stylesheets = array_values(
			array_filter($stylesheets[0], function ($stylesheet) {
				return strpos($stylesheet, '<!--') === false && strpos($stylesheet, '<![') === false;
			})
		);

		// If anything went wrong during filter, get out now.
		if (empty($stylesheets) || !isset($stylesheets[0]) || !$stylesheets[0]) {
			return $html;
		}

		// Find the first stylesheet and insert $link after the first stylesheet.
		$html = str_replace($stylesheets[0], $link . $stylesheets[0], $html);

		return $html;
	}

	/**
	 * Add stylesheet before first stylesheet.
	 * 
	 * @param string $url 
	 * @return string 
	 * @throws Exception 
	 * @throws InvalidArgumentException 
	 */
	private function do_default_mode($url)
	{
		$this->document->insertHTML('<html><head>' . sprintf(self::OMGF_PRO_LINK_ELEMENT, $url) . '</head></html>');

		$head              = $this->document->querySelector('head');
		$merged_stylesheet = $this->find_merged_stylesheet($head, $url);
		$first_stylesheet  = $this->find_first_stylesheet($head);

		/**
		 * Prevents E_WARNING: Couldn't add newnode as the previous sibling of refnode.
		 * 
		 * @since v2.3.1
		 */
		if ($merged_stylesheet !== $first_stylesheet) {
			$head->insertBefore($merged_stylesheet, $first_stylesheet);
		}

		return $this->document->saveHTML();
	}

	/**
	 * Finds our stylesheet in $head
	 * 
	 * @param mixed $head 
	 * @return IvoPetkov\HTML5DOMElement
	 */
	private function find_merged_stylesheet($head, $url)
	{
		$merged_stylesheet = $head->lastChild;

		/** Because $head can be garbled with whitespaces (DOMText), we keep looping till we find the right node. */
		while (!$merged_stylesheet instanceof DOMElement || $merged_stylesheet->getAttribute('href') != $url) {
			$merged_stylesheet = $merged_stylesheet->previousSibling;
		}

		return $merged_stylesheet;
	}

	/**
	 * @param mixed $head 
	 * @return IvoPetkov\HTML5DOMElement
	 */
	private function find_first_stylesheet($head)
	{
		$first_stylesheet = $head->firstChild;

		/** Keep looping till $first_stylesheet is an actual stylesheet. */
		while ((!$first_stylesheet instanceof DOMElement) || $first_stylesheet->getAttribute('rel') != 'stylesheet') {
			$first_stylesheet = $first_stylesheet->nextSibling;
		}

		return $first_stylesheet;
	}

	/**
	 * AMP only allows custom fonts from certain sources. To still leverage OMGF's unload feature, the combined Google 
	 * Fonts source URL is added.
	 * 
	 * @see https://amp.dev/documentation/guides-and-tutorials/develop/style_and_layout/custom_fonts/?format=websites
	 * @since v2.4.0
	 * 
	 * @param mixed $url e.g. https://fonts.googleapis.com/...
	 * @return string 
	 * @throws Exception 
	 */
	private function do_amp($url)
	{
		/**
		 * At this point fonts have been already removed. If AMP handling is set to Disable, we don't have to add them back.
		 */
		if (OMGF_PRO_AMP_HANDLING == 'disable') {
			return $this->document->saveHTML();
		}

		$this->document->insertHTML('<html><head>' . sprintf(self::OMGF_PRO_AMP_LINK_ELEMENT, $url) . '</head></html>');

		return $this->document->saveHTML();
	}
}
